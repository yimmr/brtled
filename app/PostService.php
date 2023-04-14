<?php

namespace Brtled;

class PostService
{
    public function getIDQuery($query, $ids = [])
    {
        if (empty($ids)) {
            return [];
        }

        $query['post_type']      = 'any';
        $query['post__in']       = $ids;
        $query['posts_per_page'] = count($ids);
        $query['orderby']        = 'post__in';
        $query['order']          = 'asc';

        return $query;
    }

    public function getIDQueryForBlock($query, \WP_Block $block)
    {
        return $this->getIDQuery($query, $block->context['query']['postIn'] ?? []);
    }

    public function getContextTaxonomyQuery($query, \WP_Block $block = null)
    {
        $targetTerm = Main::getInstance()->make('termService')->getTermQueryBlockTarget();

        if (!$targetTerm instanceof \WP_Term) {
            return [];
        }

        unset($query['post_type']);

        if (isset($_GET['fk'], $_GET['fv'])) {
            return array_merge($query, $this->getFilterQueryArgs([
                'key'      => $_GET['fk'],
                'value'    => $_GET['fv'],
                'taxonomy' => $targetTerm->taxonomy,
                'terms'    => [$targetTerm->term_id],
            ]));
        }

        $query['tax_query'][] = [
            'taxonomy' => $targetTerm->taxonomy,
            'terms'    => [$targetTerm->term_id],
            'field'    => 'term_id',
        ];

        return $query;
    }

    public function getFilterQueryArgs($params)
    {
        return [
            'meta_key'   => Main::getInstance()->privKey($params['key']),
            'meta_value' => $params['value'],
            'tax_query'  => [
                [
                    'taxonomy' => $params['taxonomy'],
                    'terms'    => $params['terms'],
                    'field'    => 'term_id',
                ],
            ],
        ];
    }

    public function filteredProductExists($key, $val, $termid)
    {
        $args = $this->getFilterQueryArgs([
            'key'      => $key,
            'value'    => $val,
            'taxonomy' => 'product_category',
            'terms'    => [$termid],
        ]);

        $args['post_type'] = 'product';

        return count(\get_posts($args)) > 0;
    }

    public function getRelatedQuery($query, \WP_Block $block = null)
    {
        if (!\is_single()) {
            return [];
        }

        $post = \get_post(null, OBJECT);

        if (!$post instanceof \WP_Post) {
            return [];
        }

        if ($post->post_type === 'post') {
            $taxonomy = 'category';
        } else if ($post->post_type === 'product') {
            $taxonomy = 'product_category';
        } else {
            return $query;
        }

        $terms = \wp_get_object_terms($post->ID, $taxonomy, ['fields' => 'ids']);

        if (\is_taxonomy_viewable($taxonomy) && !empty($terms)) {
            $query['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'terms'    => $terms,
                'field'    => 'term_id',
            ];
        } else {
            return [];
        }

        $query['post_type']    = $post->post_type;
        $query['post__not_in'] = [$post->ID];

        return $query;
    }

    public function updateViews($postid = null)
    {
        $postid = $postid ?? get_the_ID();
        $views  = $this->getViews($postid);

        return \update_post_meta($postid, '_views', $views += 1);
    }

    public function getViews($postid)
    {
        $views = \get_post_meta($postid, '_views', true);

        return $views ?: 0;
    }

    public function getProductFieldLabels()
    {
        return [
            'max_power'     => __('Max power: ', 'brtled'),
            'lm_m'          => __('LM/M: ', 'brtled'),
            'fpc_width'     => __('FPC Width(mm): ', 'brtled'),
            'input_valtage' => __('Input Valtage: ', 'brtled'),
        ];
    }

    public function getProductFields($postid)
    {
        $labels = $this->getProductFieldLabels();
        $result = [];

        foreach ($labels as $key => $label) {
            $result[$key] = [
                'value' => \get_post_meta($postid, Main::getInstance()->privKey($key), true) ?: '',
                'label' => $label,
            ];
        }

        return $result;
    }

    public function updateProductFields($postid, $values)
    {
        foreach ($values as $key => $value) {
            \update_post_meta($postid, Main::getInstance()->privKey($key), $value);
        }
    }

    public function saveProductMetaBox($postid)
    {
        $fileds = $this->getProductFields($postid);
        $keys   = array_keys($this->getProductFieldLabels());
        $values = [];

        $deleteFields = [];
        $canUpdate    = false;

        foreach ($keys as $key) {
            $name = Main::getInstance()->privKey($key);

            if (isset($_POST[$name])) {
                $value = $values[$key] = $_POST[$name];

                if (!isset($fileds[$key])) {
                    $canUpdate = true;
                } else if ($fileds[$key] != $value) {
                    $deleteFields[$key] = $fileds[$key];
                    $canUpdate          = true;
                }
            }
        }

        Main::getInstance()->make('postService')->updateProductFields($postid, $values);

        if ($canUpdate) {
            $this->updateFilters($postid, $values, $deleteFields);
        }
    }

    public function updateFilters($postid, array $newFields, array $deleteFields = [])
    {
        /**
         * @var TermService
         */
        $termService = Main::getInstance()->make('termService');
        $terms       = $termService->getObjectTopParents($postid, 'product_category');

        foreach ($terms as $term) {
            $filters = $termService->getPageFilters($term->term_id);

            foreach ($newFields as $key => $value) {
                if (isset($filters[$key])) {
                    if (
                        isset($deleteFields[$key])
                        && ($delidx = array_search($deleteFields[$key], $filters[$key])) !== false
                        && $this->filteredProductExists($key, $deleteFields[$key], $term->term_id)
                    ) {
                        array_splice($filters[$key], $delidx, 1);
                    }

                    if (!empty($value) && !in_array($value, $filters[$key])) {
                        $filters[$key][] = $value;
                        asort($filters[$key]);
                    }
                } else if (!empty($value)) {
                    $filters[$key] = [$value];
                }
            }

            $termService->setPageFilters($term->term_id, $filters);
        }
    }
}