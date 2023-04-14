<?php

use Brtled\Label;

return [
    'product' => [
        'label'        => __('产品', 'brtled'),
        'labels'       => Label::posttype('产品'),
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => [
            'title', 'editor', 'thumbnail', 'excerpt',
            'custom-fields',
            // 'comments',
            'revisions',
            // 'trackbacks',
        ],
        'menu_icon'    => 'dashicons-lightbulb',
        'meta_boxes'   => [
            ['brtled-product-meta', __('产品元数据', 'brtled'), \Brtled\Admin\ProductMetaBox::class, null, 'side'],
        ],
        'taxonomies'   => [
            'product_category' => [
                'label'             => __('产品分类', 'brtled'),
                'hierarchical'      => true,
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'fields'            => [\Brtled\Admin\TermThumbnailField::class],
            ],
        ],
        'template'     => [
            [
                'core/group',
                [
                    'tagName'   => 'section',
                    'style'     => [
                        'border' => ['bottom' => ['color' => 'var:preset|color|gray-1', 'width' => '1px', 'style' => 'solid']],
                    ],
                    'className' => 'is-style-section-padding',
                    'layout'    => ['type' => 'constrained'],
                ],
                [
                    [
                        'core/columns',
                        ['align' => 'wide'],
                        [
                            ['core/column', [], [['brtled/swiper', ['navigation' => false]]]],
                            ['core/column', [], [
                                ['core/post-title', ['level' => 1, 'textColor' => 'primary', 'fontSize' => 'x-large']],
                                ['core/paragraph'],
                                ['core/list', ['style' => ['spacing' => ['padding' => ['left' => '14px', 'top' => '0', 'right' => '0', 'bottom' => '0']]]], [
                                    ['core/list-item'],
                                ]],
                                ['brtled/collapse', [], [['brtled/collapse-header'], ['brtled/collapse-content']]],
                                [
                                    'brtled/collapse',
                                    ['style' => ['spacing' => ['margin' => ['top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0']]]],
                                    [['brtled/collapse-header'], ['brtled/collapse-content']],
                                ],
                            ]],
                        ],
                    ],
                ],
            ],
            [
                'core/group',
                [
                    'tagName'   => 'section',
                    'style'     => [
                        'border'  => ['bottom' => ['color' => 'var:preset|color|gray-1', 'width' => '1px']],
                        'spacing' => ['margin' => ['top' => '0', 'bottom' => '0'], 'padding' => ['bottom' => 'var:preset|spacing|50']],
                    ],
                    'className' => 'is-style-section-padding',
                    'layout'    => ['type' => 'constrained'],
                ],
                [
                    [
                        'core/heading',
                        ['textAlign' => 'center', 'align' => 'wide', 'textColor' => 'primary', 'content' => __('Features', 'brtled')],

                    ],
                    ['core/paragraph', ['content' => '<strong>' . __('Easy &amp; Effective: ', 'brtled') . '</strong>']],
                    ['core/paragraph', ['content' => '<strong>' . __('Portable &amp; Rechargeable: ', 'brtled') . '</strong>']],
                    ['core/paragraph', ['content' => '<strong>' . __('Package Contents: ', 'brtled') . '</strong>']],
                ],

            ],
        ],

    ],
];