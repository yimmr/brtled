<?php

namespace Brtled\WP\Base;

trait OptionTrait
{
    /**
     * 添加选项
     *
     * @param  string $option
     * @param  string $value
     * @param  string $deprecated 已弃用选项
     * @param  string $autoload   WordPress启动时是否加载选项
     * @return bool
     */
    public function addOption($option, $value = '', $deprecated = '', $autoload = 'yes')
    {
        return \add_option($this->prefix($option), $value, $deprecated, $autoload);
    }

    /**
     * 获取选项值
     *
     * @param  string  $option
     * @param  mixed   $default
     * @return mixed
     */
    public function getOption($option, $default = false)
    {
        return \get_option($this->prefix($option), $default);
    }

    /**
     * 更新选项值
     *
     * @param  string      $option
     * @param  mixed       $value
     * @param  bool|string $autoload WordPress启动时是否加载选项。新增的选项默认开启
     * @return bool
     */
    public function updateOption($option, $value, $autoload = null)
    {
        return \update_option($this->prefix($option), $value, $autoload);
    }

    /**
     * 删除选项
     *
     * @param  string $option
     * @return bool
     */
    public function deleteOption($option)
    {
        return \delete_option($this->prefix($option));
    }
}