<?php


namespace app\controllers;

use library\Func;
use library\RedisConnect;
use xbphp\base\Controller;


class IndexController extends Controller
{
    public function index(){
        $this->assign("TITLE","首页-诗词会");
        $this->assign("banners",json_decode(RedisConnect::getKey("banners"),JSON_UNESCAPED_UNICODE));
        $this->navView();
        $this->render();
    }
}