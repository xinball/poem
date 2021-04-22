<?php


namespace app\controllers;


use app\models\Author;
use app\models\Dynasty;
use xbphp\base\Controller;


class DynastyController extends Controller
{
    public function index(){
        echo json_encode((new Dynasty())->fetchAll(),JSON_UNESCAPED_UNICODE);
    }
    public function getDidByAid(){
        $aid = empty($_GET['aid']) ?  '':$_GET['aid'];
        $did = (new Author())->where(['aid=?'],[$aid])->fetch()['did'];
        echo $did;
    }

}