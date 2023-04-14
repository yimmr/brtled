<?php

return [
    'menus'         => [
        'primary' => [
            'theme_location'  => 'primary',
            'name'            => __('主菜单', 'brtled'),
            'container'       => 'nav',
            'container_id'    => '',
            'container_class' => '',
            'menu_class'      => '',
            'fallback_cb'     => false,
        ],
    ],
    'default_image' => [
        'post'    => true,
        'page'    => true,
        'product' => true,
        'term'    => true,
    ],
];