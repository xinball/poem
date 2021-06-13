<?php


namespace app\controllers;

use app\models\Feedback;
use app\models\News;
use app\models\Poem;
use app\models\User;
use library\Pager;
use library\RedisConnect;
use xbphp\base\Controller;
use app\models\Comment;
use xbphp\base\Model;


class CommentController extends Controller
{
    public function index(){
        $user=$this->navView("user");
        $cid = empty($_GET['cid']) ?  '':$_GET['cid'];
        $comment =(new Comment())->getComment($cid);
        if($user)
            $comment['like'] = (new User())->getUidCid($user['uid'],$cid);
        if($comment['type']=='p'){
            $preObj=(new Poem())->getPoem($comment['id']);
        }elseif($comment['type']=='c'){
            $preObj=(new Comment())->getComment($comment['id']);
        }elseif($comment['type']=='f'){
            $preObj=(new Feedback())->where(['fid=?'],[$comment['id']])->fetch();
        }elseif($comment['type']=='n'){
            $preObj=(new News())->where(['nid=?'],[$comment['id']])->fetch();
        }

        $this->assign("preObj",$preObj);
        if($comment==null||$comment['active']=="0"||($user['uid']!=$comment['uid']&&$comment['public']=="0")){
            $this->assign('TITLE', "评论已被删除或被设置为私密状态-诗词会");
            $this->render();
            exit();
        }
        $this->assign('comment', $comment);
        $this->assign('TITLE', ($comment['title']?mb_substr($comment['title'],0,5)."-":"").($comment['uname']?$comment['uname']."-":"")."评论-诗词会");

        $this->getCommentList($user,"listnum",'c',$cid,1,"/comment?cid=".$cid."&","这条评论还没有任何评论鸭！<br/>率先评论或可夺魁哦((^∀^*)) ","pagrnum",0);
        $this->render();
        exit();
    }

    public function jsoncomment(){
        $user=$this->navView("user");
        $cid = empty($_GET['cid']) ?  '':$_GET['cid'];
        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $pager=$this->getCommentList($user,"commentnum",'c',$cid,0,"/comment?cid=".$cid."&","","pagenum",0);
        $data['comments']=$pager->arr;
        if($pageNow>=$pager->pageCount)
            $data['nextpage']='';
        else
            $data['nextpage']=$pageNow+1;
        if($pageNow<=1)
            $data['prepage']='';
        else
            $data['prepage']=$pageNow-1;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function add(){

    }
    public function like(){

    }
}