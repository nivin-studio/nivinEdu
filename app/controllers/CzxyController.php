<?php

use czxy\Edu;

class CzxyController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setVar('school', '池州学院');
    }

    public function indexAction()
    {
        // 用户是否登录过
        if ($this->cookies->has('auth')) {
            return $this->response->redirect('czxy/show');
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
        $this->view->setVar('loginUrl', '/czxy/login');
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
            $person = $edu->getStudentInfo($xh);
            // 获取成绩信息
            $grades = $edu->getGradesList($xh);
            // 获取课表信息
            $tables = $edu->getTimetable($xh);

            /**
             *
             * 数据落库
             *
             */

            // 缓存学生信息
            $this->redis->setex('edu:czxy:person:' . $xh, 7 * 86400, json_encode($person));
            // 缓存成绩信息
            $this->redis->setex('edu:czxy:grades:' . $xh, 7 * 86400, json_encode($grades));
            // 缓存课表信息
            $this->redis->setex('edu:czxy:tables:' . $xh, 7 * 86400, json_encode($tables));
            // cookies用户账号
            $this->cookies->set('auth', json_encode(['xh' => $xh, 'mm' => $mm]), time() + 7 * 86400);
            $this->cookies->send();

            return $this->response->redirect('czxy/show');
        } else {
            return $this->response->redirect('czxy/index');
        }
    }

    public function showAction()
    {
        // 用户未登录跳转至首页
        if (!$this->cookies->has('auth')) {
            return $this->response->redirect('czxy/index');
        }

        $auth = json_decode($this->cookies->get('auth'), true);
        // 获取缓存学生信息
        $person = json_decode($this->redis->get('edu:czxy:person:' . $auth['xh']), true);
        // 获取缓存成绩信息
        $grades = json_decode($this->redis->get('edu:czxy:grades:' . $auth['xh']), true);
        // 获取缓存课表信息
        $tables = json_decode($this->redis->get('edu:czxy:tables:' . $auth['xh']), true);

        if (empty($person) || empty($grades) || empty($tables)) {
            /**
             * 如果缓存里没有数据
             * 去数据库里查
             */
        }

        $this->view->pick('index/show');
        $this->view->setVar('person', $person);
        $this->view->setVar('grades', $grades);
        $this->view->setVar('tables', $tables);
    }
}
