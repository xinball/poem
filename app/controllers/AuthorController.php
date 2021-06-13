<?php


namespace app\controllers;


use app\models\Author;
use library\RedisConnect;
use xbphp\base\Controller;

class AuthorController extends Controller
{
    public function index(){
        $aid = empty($_GET['aid']) ?  '':$_GET['aid'];
    }
    public function list(){
    }
    public function getByDb(){
        $did = empty($_GET['did']) ?  '':$_GET['did'];
        $authors =(new Author())->where(['did=?'],[$did])->fetchAll();
        echo json_encode($authors,JSON_UNESCAPED_UNICODE);
    }
    public function getByRedis(){
        $did=empty($_GET['did'])?null:$_GET['did'];
        if($did)
            echo RedisConnect::getListIndex("authorlist",$did);
    }

    public function jsondaCount(){
        echo json_encode((new Author())->getDynastyAuthorCount(),JSON_UNESCAPED_UNICODE);
    }
}