<?php

namespace Brtled\WP\Components;

class Form
{
    /**
     * 页内加载所需的脚本和样式
     */
    public static function enqueue()
    {
        \wp_enqueue_media();
        \wp_add_inline_style('mediaelement', file_get_contents(__DIR__ . '/assets/form.css'));
        \wp_add_inline_script('mediaelement', file_get_contents(__DIR__ . '/assets/form.js'));
    }

    /**
     * 如果 `name` 是数组则用作 `attrs`
     *
     * @param array $attrs
     * @param string|array $name
     */
    protected static function resetAttrsIf(&$attrs, &$name)
    {
        if (is_array($name)) {
            $attrs = $name;
            $name  = '';
        }
    }

    /**
     * 追加或设置指定属性值
     *
     * @param array $attrs
     * @param string $key
     * @param string $value
     * @param string $delimiter
     */
    protected static function appendAttr(&$attrs, $key, $value, $delimiter = ' ')
    {
        $attrs[$key] = isset($attrs[$key]) ? $attrs[$key] . $delimiter . $value : $value;
    }

    /**
     * 数组转标签属性
     *
     * @param array $attrs
     * @return string
     */
    protected static function mergeAttrs(array &$attrs)
    {
        $attribute = '';

        foreach ($attrs as $name => $value) {
            if (is_null($value) || $value === false) {
                continue;
            }

            $attribute .= ' ' . ($value === true ? $name : "{$name}=\"{$value}\"");
        }

        return $attribute;
    }

    /**
     * 多行文本域
     *
     * @param string|array $name
     * @param string $value
     * @param int $rows
     * @param int $cols
     * @param array $attrs
     * @return string
     */
    public static function textarea($name, $value = '', $rows = 5, $cols = 50, array $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        $attrs = array_merge(compact('name', 'rows', 'cols'), $attrs);

        return '<textarea' . self::mergeAttrs($attrs) . '>' . $value . '</textarea>';
    }

    /**
     * 输入框
     *
     * @param string|array $name
     * @param mixed $value
     * @param string $type
     * @param array $attrs
     * @return string
     */
    public static function input($name = '', $value = null, $type = 'text', array $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        $attrs = array_merge(compact('name', 'value', 'type'), $attrs);

        if ($attrs['type'] == 'number') {
            self::appendAttr($attrs, 'class', 'tiny-text', ' ');
        }

        return '<input' . self::mergeAttrs($attrs) . '>';
    }

    /**
     * 复选框
     *
     * @param string|array $name
     * @param mixed $value
     * @param bool|string|array $checked 提供数组则判断值是否在数组中
     * @param array $attrs
     * @return string
     */
    public static function checkbox($name, $value = null, $checked = false, array $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        return self::inputSelect('checkbox', array_merge(compact('name', 'value', 'checked'), $attrs));
    }

    /**
     * 单选框
     *
     * @param string|array $name
     * @param mixed $value
     * @param bool|string $checked
     * @param array $attrs
     * @return string
     */
    public static function radio($name, $value = null, $checked = false, array $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        return self::inputSelect('radio', array_merge(compact('name', 'value', 'checked'), $attrs));
    }

    /**
     * 组装可选择的 `input` 类型
     *
     * @param string $type
     * @param array $attrs
     * @return string
     */
    protected static function inputSelect($type, array $attrs)
    {
        $attrs['checked'] = is_array($attrs['checked']) ? in_array($attrs['value'], $attrs['checked']) : $attrs['value'] == $attrs['checked'];
        $attrs['type']    = $type;
        $label            = $attrs['label'] ?? '';

        unset($attrs['label']);

        $attr  = self::mergeAttrs($attrs);
        $label = $label ? sprintf('<label%s>%s</label>', isset($attrs['id']) ? " for=\"{$attrs['id']}\"" : '', $label) : '';

        return '<span class="' . $type . '"><input' . $attr . '>' . $label . '</span>';
    }

    /**
     * 下拉框
     *
     * @param string|array $name
     * @param string $value
     * @param array $options
     * @param array $attrs
     * @return string
     */
    public static function select($name, $value = '', array $options = [], array $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        $attrs   = array_merge(compact('name', 'value', 'options'), $attrs);
        $options = $attrs['options'];
        $value   = $attrs['value'];

        unset($attrs['options']);

        $html = '<select' . self::mergeAttrs($attrs) . '>' . "\n";

        foreach ($options as $option) {
            $option = is_array($option) ? $option : [$option, $option];
            $html .= sprintf('<option value="%s"%s>%s</option>%s', $option[0], $option[0] == $value ? ' selected' : '', $option[1], "\n");
        }

        return $html . '</select>';
    }

    /**
     * 图片上传
     *
     * @param string|array $name
     * @param int|array $value 单个或一组图片ID
     * @param string $size 宽|宽-高|宽-宽高比，如 `100-16:9`
     * @param int $count 限制上传个数，提供此项则支持多图上传
     * @param array $attrs
     * @return string
     */
    public static function image($name, $value = 0, $size = '100', $count = null, $attrs = [])
    {
        self::resetAttrsIf($attrs, $name);
        $attrs = array_merge(compact('name', 'value', 'size', 'count'), $attrs);
        $name  = $attrs['name'];
        $value = $attrs['value'];
        $count = $attrs['count'];
        $size  = explode('-', $attrs['size']);

        if (count($size) == 2) {
            $height = explode(':', $size[1]);
            $height = count($height) == 2 ? $size[0] / ($height[0] / $height[1]) : $size[1];
        } else {
            $height = $size[0];
        }

        self::appendAttr($attrs, 'class', 'image-field', ' ');
        self::appendAttr($attrs, 'style', "width: {$size[0]}px;height: {$height}px", ';');

        unset($attrs['name'], $attrs['value'], $attrs['size'], $attrs['count']);

        $attribute = self::mergeAttrs($attrs);

        if ($count) {
            $html = '<div class="image-field-group" data-count="' . $count . '">';
            $attrs['class'] .= ' empty';
            $attrs['style'] .= ';display:none';

            $html .= self::getImageHTML("{$name}[]", 0, self::mergeAttrs($attrs));

            foreach ($value as $id) {
                $html .= self::getImageHTML("{$name}[]", $id, $attribute);
            }

            return $html . '</div>';
        }

        return self::getImageHTML($name, $value, $attribute);
    }

    /**
     * 返回图片上传HTML
     *
     * @param string $name
     * @param int $value
     * @param string $attribute
     * @return string
     */
    protected static function getImageHTML($name, $value, $attribute = '')
    {
        $imageURL = \wp_get_attachment_image_URL($value, 'full');
        $html     = '<span ' . $attribute . '>';
        $html .= $imageURL ? '<img src="' . $imageURL . '">' : '';
        $html .= '<span class="cancel" onclick="imwp.formImage.cancel(this)"></span>';
        $html .= '<span class="tips" onclick="imwp.formImage.upload(this)">上传</span>';
        $html .= self::input($name, $value, 'hidden');
        $html .= '</span>';

        return $html;
    }
}