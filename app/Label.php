<?php

namespace Brtled;

class Label
{
    public static function posttype($label)
    {
        return [
            'name'                     => __($label, 'brtled'),
            'singular_name'            => __($label, 'brtled'),
            'add_new'                  => __('发布', 'brtled') . __($label, 'brtled'),
            'add_new_item'             => __('发布', 'brtled') . __($label, 'brtled'),
            'edit_item'                => __('编辑', 'brtled') . __($label, 'brtled'),
            'new_item'                 => __('发布', 'brtled') . __($label, 'brtled'),
            'view_item'                => __('查看', 'brtled') . __($label, 'brtled'),
            'view_items'               => __('查看', 'brtled') . __($label, 'brtled'),
            'search_items'             => __('搜索', 'brtled') . __($label, 'brtled'),
            'not_found'                => __('未找到数据', 'brtled'),
            'not_found_in_trash'       => __('回收站为空', 'brtled'),
            'parent_item_colon'        => null,
            'all_items'                => __('所有', 'brtled') . __($label, 'brtled'),
            'archives'                 => __('存档', 'brtled'),
            'insert_into_item'         => __('插入至', 'brtled') . __($label, 'brtled'),
            'uploaded_to_this_item'    => __('上传到本页面的', 'brtled'),
            'filter_items_list'        => __('过滤列表', 'brtled'),
            'items_list_navigation'    => __('列表导航', 'brtled'),
            'items_list'               => __('列表', 'brtled'),
            'item_published'           => __('已发布。', 'brtled'),
            'item_published_privately' => __('已私密发布。', 'brtled'),
            'item_reverted_to_draft'   => __('已恢复为草稿。', 'brtled'),
            'item_scheduled'           => __('已计划。', 'brtled'),
            'item_updated'             => __('已更新。', 'brtled'),
            'menu_name'                => __($label, 'brtled'),
            'name_admin_bar'           => __($label, 'brtled'),
        ];
    }
}