<?php

namespace Brtled;

use Brtled\Main;
use WP_Block;
use WP_Term;

class BlockRender
{

    protected static function getHeadingTagName($level = null)
    {
        return $level ? 'h' . $level : 'p';
    }

    public static function productFilter()
    {
        $filters    = Main::getInstance()->make('termService')->getCurrentPageFilters();
        $labels     = Main::getInstance()->make('postService')->getProductFieldLabels();
        $hasChecked = isset($_GET['fk'], $_GET['fv']);

        if (empty($filters)) {
            return '';
        }

        ob_start();
        ?>
<div class="wp-block-brtled-product-filter__header">
    <a href="javascript:;" class="btn-slide <?php echo $hasChecked ? 'is-expand' : 'is-collapse'; ?>">
        <?php _e('Unfold filter', 'brtled');?>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down"
             viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                  d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
        </svg>
    </a>
</div>
<div id="btnshow" class="btw" style="display: <?php echo $hasChecked ? 'block' : 'none'; ?>;">
    <div class="yith-wcan-filters no-title enhanced">
        <div class="filters-container">
            <?php foreach ($filters as $key => $list) {?>
            <div class="yith-wcan-filter filter-meta">
                <h4 class="filter-title"><?php _e($labels[$key] ?? $key, 'brtled');?></h4>
                <div class="filter-content">
                    <ul class="filter-items filter-label">
                        <?php foreach ($list as $item) {?>
                        <?php $isActie = $hasChecked && $_GET['fk'] == $key && $_GET['fv'] == $item;?>
                        <li class="filter-item label<?php echo $isActie ? ' active' : ''; ?>">
                            <a href="<?php echo $isActie ? 'javascript:;' : esc_attr(add_query_arg(['fk' => $key, 'fv' => $item]), 'brtled'); ?>"
                               role="button">
                                <span class="term-label"><?php _e($item, 'brtled');?></span>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<script>
document.querySelector('.btn-slide').addEventListener('click', function() {
    if (this.classList.contains('is-collapse')) {
        this.classList.remove('is-collapse')
        this.classList.add('is-expand')
        document.querySelector('#btnshow').style.display = 'block'
    } else {
        this.classList.remove('is-expand')
        this.classList.add('is-collapse')
        document.querySelector('#btnshow').style.display = 'none'
    }
})
</script>
<?php

        return '<div ' . \get_block_wrapper_attributes() . '>' . ob_get_clean() . '</div>';
    }

    public static function languageSwitcher($attributes)
    {
        $attributes['echo']         = false;
        $attributes['admin_render'] = 1;
        $tagName                    = $attributes['dropdown'] ? 'div' : 'ul';
        $content                    = \pll_the_languages($attributes);

        return '<' . $tagName . ' ' . \get_block_wrapper_attributes() . '>' . $content . '</' . $tagName . '>';
    }

    public static function postViews($attributes, $content, $block)
    {
        if (!isset($block->context['postId'])) {
            return '';
        }

        $views = Main::getInstance()->make('postService')->getViews($block->context['postId']);

        if ($attributes['hasLabel']) {
            $views .= ' ' . \__('阅读', 'brtled');
        }

        return '<div ' . \get_block_wrapper_attributes() . '>' . $views . '</div>';
    }

    public static function productMeta($attributes, $content, $block)
    {
        if (!isset($block->context['postId'])) {
            if (isset($_REQUEST['post_id'])) {
                $block->context['postId'] = $_REQUEST['post_id'];
            } else {
                return '';
            }
        }

        $fields  = Main::getInstance()->make('postService')->getProductFields($block->context['postId']);
        $content = '';

        foreach ($fields as $item) {
            $content .= '<div class="product-field">';
            $content .= '<span class="product-field-label">' . $item['label'] . '</span>' . '<span class="product-field-value">' . $item['value'] . '</span>';
            $content .= '</div>';
        }

        return '<div ' . \get_block_wrapper_attributes() . '>' . $content . '</div>';
    }

    public static function termQuery($attributes, $content, $block)
    {
        $terms = Main::getInstance()->make('termService')->get($attributes['query']);

        if ($attributes['query']['expand']) {
            $terms = Main::getInstance()->make('termService')->getExpandedTerms($terms);
        }

        $classnames = '';
        if (isset($block->context['displayLayout']) && isset($block->context['query'])) {
            if (isset($block->context['displayLayout']['type']) && 'flex' === $block->context['displayLayout']['type']) {
                $classnames = "is-flex-container columns-{$block->context['displayLayout']['columns']}";
            }
        }

        $attrs = ['class' => $classnames];

        $content = '';

        foreach ($terms as $term) {
            $term                       = $term instanceof WP_Term ? $term : \get_term($term);
            $blockInstance              = $block->parsed_block;
            $blockInstance['blockName'] = 'core/null';

            Main::getInstance()->make('termService')->setTermQueryBlockTarget($term);

            $blockInstance['available_context'] = [
                'termId'   => $term->term_id,
                'taxonomy' => $term->taxonomy,
                'name'     => $term->name,
            ];

            $blockContent = (
                new WP_Block(
                    $blockInstance,
                    [
                        'termId'   => $term->term_id,
                        'taxonomy' => $term->taxonomy,
                        'name'     => $term->name,
                    ]
                )
            )->render(['dynamic' => false]);

            $content .= '<div id="term-' . $term->term_id . '" class="' . \esc_attr(implode(' ', \get_post_class('wp-block-brtled-term'))) . '">' . $blockContent . '</div>';
        }

        Main::getInstance()->make('termService')->resetTermQueryBlockTarget();

        return '<div ' . \get_block_wrapper_attributes($attrs) . '>' . $content . '</div>';
    }

    public static function termDescription($attributes, $content, $block)
    {
        if (empty($block->context['termId'])) {
            if (isset($_REQUEST['termId'])) {
                $block->context['postId'] = $_REQUEST['termId'];
            } else {
                return '';
            }
        }

        return '<div ' . \get_block_wrapper_attributes() . '>' . \get_term_field('description', $block->context['termId']) . '</div>';
    }

    public static function termTitle($attributes, $content, $block)
    {
        if (empty($block->context['termId'])) {
            return '';
        }

        $termID  = $block->context['termId'];
        $name    = $block->context['name'] ?: \get_term($termID)->name;
        $content = $name;

        if ($attributes['isLink'] && !\is_wp_error($link = \get_term_link($termID))) {
            $content = '<a href="' . $link . '"';

            if ($attributes['rel']) {
                $content .= ' rel="' . $attributes['rel'] . '"';
            }

            if ($attributes['linkTarget']) {
                $content .= ' target="' . $attributes['linkTarget'] . '"';
            }

            $content .= '>' . $name . '</a>';
        }

        $tagName = static::getHeadingTagName($attributes['level'] ?? null);

        return "<{$tagName} " . \get_block_wrapper_attributes() . ">{$content}</{$tagName}>";
    }

    public static function termFeaturedImage($attributes, $content, $block)
    {
        if (empty($block->context['termId'])) {
            return '';
        }

        $termID  = $block->context['termId'];
        $image   = Main::getInstance()->make('termService')->getFeaturedImage($termID, $attributes['sizeSlug']);
        $content = $image;

        if ($attributes['isLink'] && !\is_wp_error($link = \get_term_link($termID))) {
            $content = '<a href="' . $link . '"';

            if ($attributes['rel']) {
                $content .= ' rel="' . $attributes['rel'] . '"';
            }

            if ($attributes['linkTarget']) {
                $content .= ' target="' . $attributes['linkTarget'] . '"';
            }

            $content .= '>' . $image . '</a>';
        }

        return '<figure ' . \get_block_wrapper_attributes() . ">{$content}</figure>";
    }

    public static function taxonomyNav($attributes, $content)
    {
        $level   = 0;
        $navList = Main::getInstance()->make('termService')->getQueriedTaxNavList($level);

        if (empty($navList)) {
            return '';
        }

        if ($level <= 1) {
            $navList = [['childen' => $navList]];
        }

        $content = '';

        foreach ($navList as $item) {
            if (!empty($item['title'])) {
                $content .= '<h2 class="wp-block-brtled-taxonomy-nav__title">' . $item['title'] . '</h2>';
            }

            $content .= '<ul class="wp-block-brtled-taxonomy-nav__list">';
            $content .= Helper::getTaxNaxListItemHTML($item['childen'], $attributes, true);
            $content .= '</ul>';
        }

        return '<nav ' . \get_block_wrapper_attributes() . '>' . $content . '</nav>';
    }
}