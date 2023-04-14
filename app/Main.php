<?php

namespace Brtled;

use Brtled\WP\Base\Config;
use Brtled\WP\Base\ContainerTrait;
use Brtled\WP\Base\PrefixTrait;
use Brtled\WP\Base\SingletonTrait;
use Brtled\WP\Components\Form;
use Brtled\WP\Manager\PostRegister;

class Main
{
    use ContainerTrait, SingletonTrait, PrefixTrait;

    public $config;

    public function __construct()
    {
        $this->setInstance($this);
        $this->instance('config', $this->config = new Config(\get_theme_file_path('config')));
    }

    public function boot()
    {
        $this->singleton('postService', PostService::class);
        $this->singleton('termService', TermService::class);

        \add_action('init', [$this, 'init']);
        \add_action('after_setup_theme', [$this, 'after_setup_theme']);
        \add_action('wp', [$this, 'wp']);

        \register_block_pattern_category(
            'theme',
            ['label' => __('主题', 'brtled')]
        );

        if (\is_admin()) {
            \add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        }
    }

    public function getDefaultImage($type = 'post', $size = 'full')
    {
        $default = $this->config->get('common.default_image.' . $type, false);
        $img     = '';

        if (!$default) {
            return $img;
        }

        if (is_numeric($default)) {
            $img = \wp_get_attachment_image($default, $size);
        }

        if (!$img) {
            $img = sprintf('<img src="%s">', \get_theme_file_uri('assets/images/' . $type . '-cover-default.png'));
        }

        return $img;
    }

    public function after_setup_theme()
    {
        \add_theme_support('post-thumbnails', ['post', 'page']);

        \add_theme_support('custom-logo', [
            'width'       => 140,
            'height'      => 40,
            'flex-width'  => true,
            'flex-height' => true,
        ]);

        foreach ($this->config->get('common.menus', []) as $key => $params) {
            \register_nav_menu($key, $params['name']);
        }
    }

    public function init()
    {
        PostRegister::posttype($this->config->get('posttype'));

        $viewsArgs = [
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'default'      => '0',
        ];

        \register_post_meta('post', '_views', $viewsArgs);
        \register_post_meta('product', '_views', $viewsArgs);

        \register_term_meta('product_category', '_featured_image_id', $viewsArgs);

        if (!\is_admin()) {
            \add_filter('post_thumbnail_html', function ($html, $postid) {
                if ($html) {
                    return $html;
                }

                $type = \get_post_type($postid);

                return $this->getDefaultImage($type == 'page' || $type == 'product' ? $type : 'post');
            }, 10, 2);
        }

        \add_filter('excerpt_length', fn() => 60);
        \add_filter('excerpt_more', fn($more) => '...');
    }

    public function wp()
    {
        if (!\is_admin() && \is_single(\get_the_ID())) {
            $this->make('postService')->updateViews();
        }
    }

    public function admin_enqueue_scripts($hook)
    {
        global $taxnow;

        if ($taxnow == 'product_category') {
            Form::enqueue();
        }
    }
}