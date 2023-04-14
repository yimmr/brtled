<?php

namespace Brtled\WP\Components;

use Brtled\WP\Manager\Settings;

class MenuPage
{
    /**
     * 开始 `div.wrap`
     *
     * @param string $title
     */
    public static function startWrap($title = null)
    {
        echo '<div class="wrap">';
        echo '<h1>' . \esc_html($title ?? \get_admin_page_title()) . '</h1>';
    }

    /**
     * 结束 `div.wrap`
     */
    public static function endWrap()
    {
        echo '</div>';
    }

    /**
     * 表单开始
     *
     * @param string $action
     * @param array  $attrs
     */
    public static function startForm($action = 'options.php', $attrs = [])
    {
        $attribute = '';

        foreach (array_merge([
            'action'     => $action,
            'method'     => 'post',
            'novalidate' => 'novalidate',
        ], $attrs) as $key => $value) {
            if ($value) {
                $attribute .= " {$key}=\"{$value}\"";
            }
        }

        echo '<form' . $attribute . '>';
    }

    /**
     * 表单结束
     */
    public static function endForm()
    {
        echo '</form>';
    }

    /**
     * 一段描述
     *
     * @param string $content
     */
    public static function p($content)
    {
        echo '<p class="description">' . $content . '</p>';
    }

    /**
     * 基于 Settings API 呈现内置风格的表单
     *
     * @param string $page
     * @param string $domain
     * @param string $before    表单标签前的内容
     * @param string $after     表单标签后的内容
     */
    public static function settingsAPIPage($page, $domain = 'default', $before = '', $after = '')
    {
        if (!\current_user_can('manage_options')) {
            return;
        }

        if (isset($_GET['settings-updated'])) {
            \add_settings_error($page . '_messages', $page . '_message', __('Settings saved.', $domain), 'updated');
        }

        \settings_errors($page . '_messages');

        static::startWrap();
        echo $before;

        echo '<form method="post" action="options.php">';
        \settings_fields($page);
        \do_settings_sections($page);
        \submit_button();
        echo '</form>';

        echo $after;
        static::endWrap();
    }
}