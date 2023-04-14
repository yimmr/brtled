<?php
/**
 * Title: 产品网格
 * Slug: brtled/product-grid
 * Categories: query
 * Block Types: core/query/brtled/product-list
 */
?>

<!-- wp:query {"queryId":0,"query":{"perPage":5,"pages":0,"offset":0,"postType":"product","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{}},"displayLayout":{"type":"flex","columns":5},"namespace":"brtled/product-list","align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide">
    <!-- wp:post-template {"align":"wide","className":"is-style-product-grid-item"} -->
    <!-- wp:post-featured-image {"isLink":true} /-->

    <!-- wp:post-title {"isLink":true} /-->

    <!-- wp:brtled/product-meta /-->
    <!-- /wp:post-template -->

    <!-- wp:query-no-results -->
    <!-- wp:paragraph {"placeholder":"<?php _e('添加当查询返回无结果时所要显示的文本或区块。', 'brtled');?>"} -->
    <p></p>
    <!-- /wp:paragraph -->
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->