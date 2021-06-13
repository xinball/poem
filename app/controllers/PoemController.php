<?php

namespace app\controllers;

use app\models\Author;
use app\models\Comment;
use app\models\Dynasty;
use app\models\User;
use library\Pager;
use library\RedisConnect;
use xbphp\base\Controller;
use app\models\Poem;
use xbphp\base\Model;


class PoemController extends Controller
{
    public function index(){
        $user=$this->navView("user");
        $pid = empty($_GET['pid']) ?  '':$_GET['pid'];
        $poem =(new Poem())->getPoem($pid);
        if($poem==null||$poem['active']=="0"||$poem['aactive']=="0"||$poem['dactive']=="0"){
            exit();
        }
        if($user)
            $poem['like'] = (new User())->getUidPid($user['uid'],$pid);
        $this->assign('poem', $poem);
        $this->assign('TITLE', ($poem['title']?$poem['title']."-":"").($poem['dname']?$poem['dname']."-":"").($poem['aname']?$poem['aname']."-":"")."诗词会");
        $this->getCommentList($user,'listnum','p',$pid,1,"/poem?pid=".$pid."&","这首古诗词还没有任何评论鸭！<br/>率先评论或可夺魁哦((^∀^*)) ","pagenum",0);
        $this->render();
        exit();
    }


    public function list(){//
        $user=$this->navView('user');
        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $poemConfig=RedisConnect::getHash('poem');
        $pager=new Pager($pageNow,$poemConfig['listnum'],$poemConfig['pagenum']);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        $where[$i]="active=?";
        $value[$i++]="1";
        $OrFlag=0;
        foreach ($params as $key=>$v){
            if($key=="pageNow"||$key=="order"||trim($v)=="")
                continue;
            elseif ($key=="keyword"){
                $OrFlag=1;
                break;
            }elseif($key=="title"||$key=="aname"||$key=="content"){
                $where[$i]="$key like ?";
                $value[$i++]="%".$v."%";
            }else{
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            if($key=="aid"){
                $this->assign("did",(new Author())->getDidByAid($v));
            }
            $this->assign($key,$v);
            $param.=$key."=".$v."&";
        }
        $orderPara = $params['order']??"number";
        if($orderPara=="commentnumber"||$orderPara=="likepoemnumber"){
            $order=["$orderPara DESC",'pid DESC'];
            $param.="order=$orderPara&";
        }
        else{
            $orderPara = "number";
            $order=['likepoemnumber DESC','commentnumber DESC','pid DESC'];
            $param.="order=number&";
        }
        $this->assign("order",$orderPara);
        if($OrFlag==1){
            $keyword="%".$_GET['keyword']."%";
            (new Poem())->where(["active=?"],["1"])->whereor(['dname like ?','aname like ?','title like ?'],[$keyword,$keyword,$keyword])->order($order)->getPoemList($pager);
        }else{
            (new Poem())->where($where,$value)->order($order)->getPoemList($pager);
        }
        $poems=$pager->arr;
        if($user){
            foreach ($poems as $i=>$poem){
                $poems[$i]['like']=(new User())->getUidPid($user['uid'],$poem['pid']);
            }
        }

        $this->assign('TITLE', '诗词查询-诗词会');
        $this->assign('poems', $poems);
        $this->assign('navigation', $pager->echoNavigation("/poem/list?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage("<strong>抱歉！</strong> 未查询到符合条件的诗词o(╥﹏╥)o",1,1));
        $this->assign('poemConfig', $poemConfig);
        $this->assign('dynastys', json_decode(RedisConnect::getKey("dynastylist"),JSON_UNESCAPED_UNICODE));
        $this->render();
        exit();
    }

    public function likepoem($params){
        $this->navView();
        $pid = $_GET['pid']??null;
        if ($pid) {
            $pageNow=$_GET['pageNow']??1;
            $pager=new Pager($pageNow,10);
            $param="";
            $i=0;
            $where=array();
            $value=array();
            foreach ($params as $v){
                $arr=explode('=',$v);
                if($arr[0]=="pageNow"||sizeof($arr)!=2||$arr[1]=="")
                    continue;
                $param.=$arr[0]."=".$_GET[$arr[0]]."&";
                $where[$i]="$arr[0]=?";
                $value[$i++]=$_GET[$arr[0]];
            }
            (new User())->where($where,$value)->getUserLikePoem($pager);
            $users=$pager->arr;
            echo json_encode($users,JSON_UNESCAPED_UNICODE);
            $navigation = $pager->echoNavigation("/user/likepoem?".$param."pageNow=");
        } else {
            $users = null;
            $navigation = null;
        }
        $this->assign('TITLE', '用户列表');
    }

    public function like(){
        $uid = $_GET['uid']??null;
        if ($uid) {
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow);

            $param="";
            $params=$_GET;
            $i=0;
            $where=array();
            $value=array();
            $where[$i]="active=?";
            $value[$i++]="1";
            foreach ($params as $key=>$v){
                if($key=="pageNow"||trim($v)=="")
                    continue;
                $param.=$key."=".$v."&";
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }

            (new Poem())->where($where,$value)->getPoemLikedUser($pager);
            $poems=$pager->arr;
            $navigation = $pager->echoNavigation("/poem/list?".$param."pageNow=");
        } else {
            $poems = null;
            $navigation = null;
        }
        $this->assign('TITLE', '诗词列表');
        $this->assign('uid', $uid);
        $this->assign('poems', $poems);
        $this->assign('navigation', $navigation);
        $this->render();
    }

    public function jsondpCount(){
        echo json_encode((new Poem())->getDynastyPoemCount(),JSON_UNESCAPED_UNICODE);
    }
    public function jsonpoemCount(){
        echo json_encode((new Poem())->getPoemCount(),JSON_UNESCAPED_UNICODE);
    }
}