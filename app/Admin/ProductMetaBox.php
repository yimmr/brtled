<?php

namespace Brtled\Admin;

use Brtled\Main;

class ProductMetaBox
{
    public function render($post)
    {
        $fileds = Main::getInstance()->make('postService')->getProductFields($post->ID);

        foreach ($fileds as $key => $item) {
            $name = Main::getInstance()->privKey($key);
            echo '<div class="components-base-control__field">';
            echo '<label class="components-base-control__label" for="' . $name . '">' . $item['label'] . '</label>';
            echo '<input type="text" class="components-text-control__input" name="' . $name . '" value="' . $item['value'] . '">';
            echo '</div>';
        }
    }

    public function save($postid)
    {
        Main::getInstance()->make('postService')->saveProductMetaBox($postid);
    }
}