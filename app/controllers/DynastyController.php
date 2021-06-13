<?php


namespace app\controllers;


use app\models\Author;
use app\models\Dynasty;
use xbphp\base\Controller;


class DynastyController extends Controller
{
    public function index(){
        echo json_encode((new Dynasty())->where(['active=?'],[1])->fetchAll(),JSON_UNESCAPED_UNICODE);
    }
}