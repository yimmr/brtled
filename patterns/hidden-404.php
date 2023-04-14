<?php
/**
 * Title: Hidden 404
 * Slug: brtled/hidden-404
 * Inserter: no
 */
?>
<!-- wp:spacer {"height":"var(--wp--preset--spacing--30)"} -->
<div style="height:var(--wp--preset--spacing--30)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":1,"align":"wide"} -->
<h1 class="alignwide has-text-align-center">
    <?php echo esc_html_x('404', '找不到页面的错误码。', 'brtled'); ?></h1>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"5px"}}}} -->
<div class="wp-block-group alignwide has-text-align-center" style="margin-top:5px">
    <!-- wp:paragraph -->
    <p class="has-text-align-center"><?php echo esc_html_x('找不到此页面。', '无法找到网页的消息', 'brtled'); ?>
    </p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"var(--wp--preset--spacing--70)"} -->
<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->