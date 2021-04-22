<?php


namespace app\controllers;

use xbphp\base\Controller;


class IndexController extends Controller
{
    public function index(){
        $this->assign("TITLE","首页-诗词会");
        $this->render();
    }
}