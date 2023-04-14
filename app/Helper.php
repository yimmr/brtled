<?php

namespace Brtled;

class Helper
{
    public static function getTaxNaxListItemHTML($items, $linkArgs, $expand = true)
    {
        $content = '';

        foreach ($items as $item) {
            $content .= sprintf(
                '<li%5$s><a href="#term-%1$s" %3$s%4$s>%2$s</a></li>',
                $item['id'],
                $item['title'],
                empty($linkArgs['linkTarget']) ? '' : ' target="' . $linkArgs['linkTarget'] . '"',
                empty($linkArgs['rel']) ? '' : ' rel="' . $linkArgs['rel'] . '"',
                $item['isActive'] ? ' class="active"' : ''
            );

            if (!empty($item['childen'])) {
                $content .= static::getTaxNaxListItemHTML($item['childen'], $linkArgs, $expand);
            }
        }

        return $content;
    }
}