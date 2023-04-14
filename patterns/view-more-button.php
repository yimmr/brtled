<?php
/**
 * Title: 浏览更多按钮
 * Slug: brtled/view-more-button
 * Categories: theme
 */
?>

<!-- wp:buttons {"align":"wide"} -->
<div class="wp-block-buttons alignwide">
    <!-- wp:button {"textColor":"primary","align":"center","style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"className":"is-style-outline","fontSize":"small"} -->
    <div class="wp-block-button aligncenter has-custom-font-size is-style-outline has-small-font-size"><a
           class="wp-block-button__link has-primary-color has-text-color wp-element-button"
           style="padding-right:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><?php echo __('View more', 'brtled') . ' '; ?>&gt;&gt;</a>
    </div>
    <!-- /wp:button -->
</div>
<!-- /wp:buttons -->