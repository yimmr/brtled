<?php
/**
 * Title: 页脚版权信息
 * Slug: brtled/footer-copyright
 * Categories: text, site-footer, copyright
 * Block Types: core/template-part/footer
 */

$content = '&copy; ' . esc_html(gmdate('Y')) . ' Shenzhen Bright Lighting Co.,Ltd.All rights reserved.<br>Term&amp; Conditions | Privacy Policy | Accessibility Statement';
?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}},"className":"is-style-global-padding","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-global-padding" style="padding-top:1.25rem;padding-bottom:1.25rem">
    <!-- wp:paragraph {"align":"center","fontSize":"small"} -->
    <p class="has-text-align-center has-small-font-size"><?php echo $content; ?></p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->