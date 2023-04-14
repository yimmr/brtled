<?php

namespace Brtled;

class TermService
{
    protected $termQueryBlockTarget;

    /**
     * @param \WP_Term[]|int[] $args
     */
    public function get($args = [])
    {
        if ($args['inherit']) {
            $queryed = \get_queried_object();

            if ($queryed instanceof \WP_Term) {
                if (isset($args['expand']) && $args['expand']) {
                    $queryed             = $this->getTopParent($queryed->term_id, $queryed->taxonomy);
                    $args['hasChildren'] = true;
                }

                $args['parent']   = $queryed->term_id;
                $args['taxonomy'] = $queryed->taxonomy;
            }
        }

        unset($args['inherit']);

        if (isset($args['expand']) && $args['expand']) {
            $terms = \get_term_children($args['parent'], $args['taxonomy']);

            if ($args['orderby'] == 'count') {
                usort($terms, function ($a, $b) {
                    if ($a->count == $b->count) {
                        return 0;
                    }
                    return ($a->count < $b->count) ? -1 : 1;
                });
            }

            return $args['order'] == 'desc' ? array_reverse($terms) : $terms;
        }

        if (empty($args['parent'])) {
            unset($args['parent']);
        }

        if ($args['orderby'] == 'none') {
            unset($args['orderby']);
        }

        return \get_terms($args);
    }

    public function getCurrentPageFilters()
    {
        $term = \get_queried_object();

        if (!$term instanceof \WP_Term) {
            return [];
        }

        return $this->getPageFilters($this->getTopParent($term->term_id, $term->taxonomy)->term_id);
    }

    public function getPageFilters($termid)
    {
        $filters = \get_term_meta($termid, Main::getInstance()->privKey('page_filters'), true);

        return empty($filters) ? [] : $filters;
    }

    public function setPageFilters($termid, $value)
    {
        return \update_term_meta($termid, Main::getInstance()->privKey('page_filters'), $value);
    }

    /**
     * @param  int          $postid
     * @param  string       $taxonomy
     * @return \WP_Term[]
     */
    public function getObjectTopParents($postid, $taxonomy)
    {
        $terms  = \wp_get_object_terms($postid, $taxonomy, ['fields' => 'ids']);
        $result = [];

        foreach ($terms as $termid) {
            if (!isset($result[$termid])) {
                $term                   = $this->getTopParent($termid, $taxonomy);
                $result[$term->term_id] = $term;
            }
        }

        return $result;
    }

    public function getFeaturedImageId($termid)
    {
        $id = \get_term_meta($termid, '_featured_image_id', true);

        if ($id) {
            return $id;
        }

        return Main::getInstance()->config->get('common.settings.default_term_thumbnail_id');
    }

    public function setFeaturedImageId($termid, $imageid)
    {
        return \update_term_meta($termid, '_featured_image_id', $imageid);
    }

    public function getFeaturedImage($termid, $size = 'medium')
    {
        return \wp_get_attachment_image($this->getFeaturedImageId($termid), $size ?: 'medium') ?: Main::getInstance()->getDefaultImage('term');
    }

    public function getTopParent($termid, $taxonomy)
    {
        $parents = \get_ancestors($termid, $taxonomy, 'taxonomy');

        foreach (array_reverse($parents) as $termid) {
            $parent = get_term($termid);
            if (!$parent->parent) {
                return $parent;
            }
        }

        return $parent ?? \get_term($termid);
    }

    public function getExpandedTerms($termids)
    {
        return $this->expandTremTree($this->getTermTreeforIds($termids));
    }

    public function getTermTreeforIds($termids)
    {
        $parentChild = [];
        $topid       = null;

        foreach ($termids as $termid) {
            $term = \get_term($termid);
            $parentChild[$term->parent]??=[];
            $parentChild[$term->parent][$termid] = [
                'self'    => $term,
                'childen' => [],
            ];
            $parentChild[$termid] = &$parentChild[$term->parent][$termid]['childen'];

            if (is_null($topid) && !in_array($term->parent, $termids)) {
                $topid = $term->parent;
            }
        }

        return $parentChild[$topid];
    }

    public function expandTremTree($array)
    {
        $result = [];

        foreach ($array as $item) {
            $result[] = $item['self'];

            if (!empty($item['childen'])) {
                array_push($result, ...$this->expandTremTree($item['childen']));
            }
        }

        return $result;
    }

    public function getQueriedTaxNavList(&$lavel = 1)
    {
        $queryObject = \get_queried_object();

        if (!$queryObject instanceof \WP_Term) {
            return [];
        }

        if ($queryObject->parent) {
            $parent = $this->getTopParent($queryObject->term_id, $queryObject->taxonomy);
        } else {
            $parent = $queryObject;
        }

        $childen = \get_term_children($parent->term_id, $parent->taxonomy);

        if (empty($childen) || \is_wp_error($childen)) {
            return [];
        }

        $result      = [];
        $parentChild = [$parent->term_id => &$result];

        foreach ($childen as $termid) {
            $term = \get_term($termid);

            $parentChild[$term->parent]??=[];
            $parentChild[$term->parent][$termid] = [
                'id'       => $term->term_id,
                'title'    => $term->name,
                'slug'     => $term->slug,
                'link'     => \get_term_link($term),
                'childen'  => $parentChild[$termid] ?? [],
                'isActive' => $term->term_id == $queryObject->term_id,
            ];

            $parentChild[$termid] = &$parentChild[$term->parent][$termid]['childen'];
        }

        $lavel = count(array_filter($parentChild));

        if (isset($result[$queryObject->term_id]) && count($result[$queryObject->term_id]['childen']) > 0) {
            foreach ($result[$queryObject->term_id]['childen'] as &$value) {
                $value['isActive'] = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Get the value of termQueryBlockTarget
     *
     * @return \WP_Term
     */
    public function getTermQueryBlockTarget()
    {
        return $this->termQueryBlockTarget;
    }

    /**
     * Set the value of termQueryBlockTarget
     *
     * @return self
     */
    public function setTermQueryBlockTarget($termQueryBlockTarget)
    {
        $this->termQueryBlockTarget = $termQueryBlockTarget;

        return $this;
    }

    public function resetTermQueryBlockTarget()
    {
        $this->termQueryBlockTarget = null;
    }
}