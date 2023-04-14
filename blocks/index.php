<?php

use Brtled\BlockRender;
use Brtled\Main;

add_action('enqueue_block_editor_assets', function () {
    $assets = require __DIR__ . '/build/extend/index.asset.php';

    wp_enqueue_script(
        'brtled-extend',
        get_theme_file_uri('blocks/build/extend/index.js'),
        $assets['dependencies'],
        $assets['version']
    );

    wp_enqueue_style('brtled-extend', get_theme_file_uri('blocks/build/extend/style-index.css'), [], $assets['version']);
});

add_action('enqueue_block_assets', function () {
    $assets   = require __DIR__ . '/build/extend/index.asset.php';
    $jsassets = require __DIR__ . '/build/extend/script.asset.php';

    wp_enqueue_style('brtled-extend', get_theme_file_uri('blocks/build/extend/style-index.css'), [], $assets['version']);

    wp_enqueue_script(
        'brtled-extend',
        get_theme_file_uri('blocks/build/extend/script.js'),
        $jsassets['dependencies'],
        $jsassets['version'],
        true
    );

    wp_script_add_data('brtled-extend', 'defer', 'true');
});

function brtledAddRestRelatedQuery($args, \WP_REST_Request $request)
{
    if ($request->get_param('related')) {
        return Main::getInstance()->make('postService')->getRelatedQuery($args);
    }

    return $args;
}

function brtledAddIDQuery($args, \WP_REST_Request $request)
{
    if ($request->has_param('postIn')) {
        return Main::getInstance()->make('postService')->getIDQuery($args, $request->get_param('postIn'));
    }

    return $args;
}

add_filter('rest_post_query', 'brtledAddIDQuery', 10, 2);
add_filter('rest_post_query', 'brtledAddRestRelatedQuery', 10, 2);
add_filter('rest_product_query', 'brtledAddRestRelatedQuery', 10, 2);

add_action('init', function () {
    register_block_type(__DIR__ . '/build/swiper');
    register_block_type(__DIR__ . '/build/swiper-slide');
    register_block_type(__DIR__ . '/build/icon');
    register_block_type(__DIR__ . '/build/collapse');
    register_block_type(__DIR__ . '/build/collapse-header');
    register_block_type(__DIR__ . '/build/collapse-content');

    register_block_type(__DIR__ . '/build/post-views', ['render_callback' => [BlockRender::class, 'postViews']]);
    register_block_type(__DIR__ . '/build/product-meta', ['render_callback' => [BlockRender::class, 'productMeta']]);
    register_block_type(__DIR__ . '/build/term-title', ['render_callback' => [BlockRender::class, 'termTitle']]);
    register_block_type(__DIR__ . '/build/term-description', ['render_callback' => [BlockRender::class, 'termDescription']]);
    register_block_type(__DIR__ . '/build/term-featured-image', ['render_callback' => [BlockRender::class, 'termFeaturedImage']]);
    register_block_type(__DIR__ . '/build/term-query', ['render_callback' => [BlockRender::class, 'termQuery']]);
    register_block_type(__DIR__ . '/build/taxonomy-nav', ['render_callback' => [BlockRender::class, 'taxonomyNav']]);
    register_block_type(__DIR__ . '/build/product-filter', ['render_callback' => [BlockRender::class, 'productFilter']]);

    if (function_exists('pll_the_languages')) {
        register_block_type(__DIR__ . '/build/language-switcher', ['render_callback' => [BlockRender::class, 'languageSwitcher']]);
    }

    add_filter('pre_render_block', function ($content, $block) {
        if (!isset($block['attrs']['namespace'])) {
            return $content;
        }

        switch ($block['attrs']['namespace']) {
            case 'brtled/taxonomy-post-query':
                add_filter('query_loop_block_query_vars', [Main::getInstance()->make('postService'), 'getContextTaxonomyQuery']);
                break;
            case 'brtled/related-posts':
                add_filter('query_loop_block_query_vars', [Main::getInstance()->make('postService'), 'getRelatedQuery']);
                break;
            case 'brtled/query-by-id':
                add_filter('query_loop_block_query_vars', [Main::getInstance()->make('postService'), 'getIDQueryForBlock'], 10, 2);
                break;
            default:break;
        }

        return $content;
    }, 10, 2);
});