<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	/**
	 * 获取请求参数
	 *
	 * @param string $name         参数名
	 * @param string $filters      过滤器
	 * @param        $defaultValue 默认值
	 */
    public function R($name, $filters = null, $defaultValue = null)
    {
        return $this->request->get($name, $filters, $defaultValue);
    }

    /**
     * 获取配置
     *
     * @param string $name 配置名
     */
    public function C($name)
    {
        return $this->config->get($name);
    }
}
