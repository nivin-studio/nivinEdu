<?php

use xnkjdx\Edu;

class XnkjdxController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setVar('school', '西南科技大学');
    }

    public function indexAction()
    {
        // 用户是否登录过
        if ($this->cookies->has('auth:xnkjdx')) {
            return $this->response->redirect('xnkjdx/show');
        }

        $edu = new Edu();
        // 获取cookie
        $cookie = $edu->getCookie();
        // 获取验证码
        $vccode = $edu->getVcCode();
        // 序列化cookie
        $cookie = serialize($cookie);
        $uuid   = uuid();
        // 缓存cookie10分钟
        $this->redis->setex($uuid, 600, $cookie);

        $this->view->pick('index/index');
        $this->view->setVar('uuid', $uuid);
        $this->view->setVar('vccode', $vccode);
        $this->view->setVar('loginUrl', '/xnkjdx/login');
    }

    public function loginAction()
    {
        if ($this->request->isPost() && $this->security->checkToken()) {

            $xh   = $this->R('xh', 'trim', '');
            $mm   = $this->R('mm', 'trim', '');
            $vm   = $this->R('vm', 'trim', '');
            $uuid = $this->R('uuid', 'trim', '');

            // 获取缓存cookie
            $cookie = $this->redis->get($uuid);
            // 反序列化cookie
            $cookie = unserialize($cookie);
            // 使用缓存cookie登录教务系统
            $edu = new Edu();
            $edu->setCookie($cookie);
            $edu->login($xh, $mm, $vm);

            // 获取学生信息
            $persos = $edu->getPersosInfo($xh);
            // 获取成绩信息
            $grades = $edu->getGradesInfo($xh);
            // 获取课表信息
            $tables = $edu->getTablesInfo($xh);

            // /**
            //  *
            //  * 数据落库
            //  *
            //  */

            // 缓存学生信息
            $this->redis->setex('edu:xnkjdx:persos:' . $xh, 7 * 86400, json_encode($persos));
            // 缓存成绩信息
            $this->redis->setex('edu:xnkjdx:grades:' . $xh, 7 * 86400, json_encode($grades));
            // 缓存课表信息
            $this->redis->setex('edu:xnkjdx:tables:' . $xh, 7 * 86400, json_encode($tables));
            // 会话用户账号
            $this->cookies->set('auth:xnkjdx', json_encode(['xh' => $xh, 'mm' => $mm]), time() + 7 * 86400);
            $this->cookies->send();

            return $this->response->redirect('xnkjdx/show');
        } else {
            return $this->response->redirect('xnkjdx/index');
        }
    }

    public function showAction()
    {
        // 用户未登录跳转至首页
        if (!$this->cookies->has('auth:xnkjdx')) {
            return $this->response->redirect('xnkjdx/index');
        }

        $auth = json_decode($this->cookies->get('auth:xnkjdx'), true);
        // 获取缓存学生信息
        $persos = json_decode($this->redis->get('edu:xnkjdx:persos:' . $auth['xh']), true);
        // 获取缓存成绩信息
        $grades = json_decode($this->redis->get('edu:xnkjdx:grades:' . $auth['xh']), true);
        // 获取缓存课表信息
        $tables = json_decode($this->redis->get('edu:xnkjdx:tables:' . $auth['xh']), true);

        if (empty($persos) || empty($grades) || empty($tables)) {
            /**
             * 如果缓存里没有数据
             * 去数据库里查
             */
        }

        $this->view->pick('index/show');
        $this->view->setVar('persos', $persos);
        $this->view->setVar('grades', $grades);
        $this->view->setVar('tables', $tables);
    }
}
