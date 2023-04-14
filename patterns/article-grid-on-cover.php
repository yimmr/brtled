<?php
/**
 * Title: 标题在封面上
 * Slug: brtled/article-grid-on-cover
 * Categories: query
 * Block Types: core/query
 */
?>

<!-- wp:query {"query":{"perPage":4,"pages":1,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":null,"parents":[]},"displayLayout":{"type":"flex","columns":4},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide">
    <!-- wp:post-template {"align":"wide","className":"is-style-title-in-cover"} -->
    <!-- wp:post-featured-image {"isLink":true} /-->

    <!-- wp:post-title {"isLink":true} /-->
    <!-- /wp:post-template -->

    <!-- wp:query-no-results -->
    <!-- wp:paragraph {"placeholder":"<?php _e('添加当查询返回无结果时所要显示的文本或区块。', 'brtled');?>"} -->
    <p></p>
    <!-- /wp:paragraph -->
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->