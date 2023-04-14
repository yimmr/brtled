<?php

namespace Brtled\Admin;

use Brtled\Main;
use Brtled\WP\Components\Form;
use Brtled\WP\Components\TaxForm;

class TermThumbnailField
{
    public function addFields()
    {
        TaxForm::addField(__('特色图片', 'brtled'), Form::image('_featured_image_id', 0, '200-16:9'));
    }

    public function editFields($term)
    {
        TaxForm::editField(
            __('特色图片', 'brtled'),
            Form::image('_featured_image_id', Main::getInstance()->make('termService')->getFeaturedImageId($term->term_id), '200-16:9')
        );
    }

    public function save($termid)
    {
        if (!empty($_POST['_featured_image_id']) && is_numeric($_POST['_featured_image_id'])) {
            Main::getInstance()->make('termService')->setFeaturedImageId($termid, $_POST['_featured_image_id']);
        }
    }
}