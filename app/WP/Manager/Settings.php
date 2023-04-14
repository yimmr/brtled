<?php

namespace Brtled\WP\Manager;

class Settings
{
    public static function register($config)
    {
        foreach ($config as $page => &$params) {
            foreach ($params['settings'] as $name => $args) {
                \register_setting($page, $page . '_' . $name, $args);
            }

            foreach ($params['sections'] as $sectionID => $section) {
                $sectionID = $page . '_' . $sectionID;

                if (isset($section['title'])) {
                    $callback = null;

                    if (isset($section['description'])) {
                        $callback = fn() => printf('<p>%s</p>', __($section['description']));
                    } else if (isset($section['callback'])) {
                        $callback = $section['callback'];
                    }

                    \add_settings_section($sectionID, $section['title'], $callback, $page);
                }

                foreach ($section['fields'] as $key => &$field) {
                    \add_settings_field($key, $field['title'], $field['callback'], $page, $sectionID, $field);
                }
            }
        }
    }

    public static function addFields($fields, $page, $sectionID = 'default')
    {
        foreach ($fields as $key => &$field) {
            \add_settings_field($key, $field['title'], $field['callback'], $page, $sectionID, $field);
        }
    }
}