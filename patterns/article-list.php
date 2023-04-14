<?php
/**
 * Title: 通用主查询列表
 * Slug: brtled/article-list
 * Categories: query
 * Block Types: core/query
 */
?>

<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide">
    <!-- wp:post-template {"align":"wide","className":"is-style-article-item"} -->
    <!-- wp:columns {"align":"wide"} -->
    <div class="wp-block-columns alignwide">
        <!-- wp:column {"width":"33%"} -->
        <div class="wp-block-column" style="flex-basis:33%">
            <!-- wp:post-featured-image {"isLink":true} /-->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:post-title {"isLink":true} /-->

            <!-- wp:post-excerpt {"showMoreOnNewLine":false} /-->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
    <!-- /wp:post-template -->

    <!-- wp:query-pagination {"paginationArrow":"chevron","align":"wide","layout":{"type":"flex","justifyContent":"center"}} -->
    <!-- wp:query-pagination-previous /-->

    <!-- wp:query-pagination-numbers /-->

    <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->

    <!-- wp:query-no-results -->
    <!-- wp:paragraph {"placeholder":"<?php _e('添加当查询返回无结果时所要显示的文本或区块。', 'brtled');?>"} -->
    <p></p>
    <!-- /wp:paragraph -->
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->