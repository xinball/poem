<?php


namespace app\controllers;

use app\models\Author;
use app\models\Comment;
use app\models\Dynasty;
use library\Pager;
use library\RedisConnect;
use xbphp\base\Controller;
use app\models\Poem;


class PoemController extends Controller
{
    public function index($params){
        $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
        $pid = empty($_GET['pid']) ?  '':$_GET['pid'];
        $poem =(new Poem())->getPoem($pid);
        if($poem['active']=="0"){
            exit();
        }
        $commentConfig=RedisConnect::getHash('comment');
        $pager=new Pager($pageNow,$commentConfig['listnum']);
        $param="";
        $where=array();
        $value=array();
        $i=0;
        $where[$i]="public=?";
        $value[$i++]="1";
        $where[$i]="active=?";
        $value[$i++]="1";
        foreach ($params as $v){
            $arr=explode('=',$v);
            if($arr[0]=="pageNow"||sizeof($arr)!=2||$arr[1]=="")
                continue;
            if($arr[0]=="title"||$arr[0]=="content"){
                $where[$i]="$arr[0] like ?";
                $value[$i++]="%".$_GET[$arr[0]]."%";
            }else if($arr[0]=="sendtime1") {
                $where[$i]="sendtime > ?";
                $value[$i++]=$_GET["sendtime1"];
            }else if($arr[0]=="sendtime2"){
                $where[$i]="sendtime < ?";
                $value[$i++]=$_GET["sendtime2"];
            }else{
                $where[$i]="$arr[0]=?";
                $value[$i++]=$_GET[$arr[0]];
            }
            $this->assign($arr[0],$_GET[$arr[0]]);
            $param.=$arr[0]."=".$_GET[$arr[0]]."&";
        }
        (new Comment())->where($where,$value)->getCommentList($pager);
        $comments=$pager->arr;
        $this->assign('poem', $poem);
        $this->assign('comments', $comments);
        $this->assign('TITLE', ($poem['title']?$poem['title']."-":"").($poem['dname']?$poem['dname']."-":"").($poem['aname']?$poem['aname']."-":"")."诗词会");
        $this->assign('navigation', $pager->echoNavigation("/poem/list?".$param."pageNow="));
        $this->render();
        exit();
    }

    public function list($params){//
        $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
        $poemConfig=RedisConnect::getHash('poem');
        $pager=new Pager($pageNow,$poemConfig['listnum']);
        $param="";
        $where=array();
        $value=array();
        $i=0;
        $where[$i]="active=?";
        $value[$i++]="1";
        foreach ($params as $v){
            $arr=explode('=',$v);
            if($arr[0]=="pageNow"||sizeof($arr)!=2||$arr[1]=="")
                continue;
            if($arr[0]=="title"||$arr[0]=="aname"||$arr[0]=="content"){
                $where[$i]="$arr[0] like ?";
                $value[$i++]="%".$_GET[$arr[0]]."%";
            }else{
                $where[$i]="$arr[0]=?";
                $value[$i++]=$_GET[$arr[0]];
            }
            if($arr[0]=="aid")
                $this->assign("did",file_get_contents("http://poem.xinball.top/dynasty/getDidByAid?aid=".$arr[1]));
            $this->assign($arr[0],$_GET[$arr[0]]);
            $param.=$arr[0]."=".$_GET[$arr[0]]."&";
        }
        (new Poem())->where($where,$value)->getPoemList($pager);
        $poems=$pager->arr;

        $this->assign('TITLE', '诗词查询');
        $this->assign('poems', $poems);
        $this->assign('navigation', $pager->echoNavigation("/poem/list?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage());
        $this->assign('poemConfig', $poemConfig);
        $this->assign('dynastys', json_decode(RedisConnect::getKey("dynastylist"),JSON_UNESCAPED_UNICODE));
        $this->render();
        exit();
    }
    public function like($params){
        $uid = empty($_GET['uid']) ?  null:$_GET['uid'];
        if ($uid) {
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow);

            $param="";
            $i=0;
            $where=array();
            $value=array();
            $where[$i]="active=?";
            $value[$i++]="1";
            foreach ($params as $v){
                $arr=explode('=',$v);
                if($arr[0]=="pageNow"||sizeof($arr)!=2||$arr[1]=="")
                    continue;
                $param.=$arr[0]."=".$_GET[$arr[0]]."&";
                $where[$i]="$arr[0]=?";
                $value[$i++]=$_GET[$arr[0]];
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
}