<?php


namespace app\controllers;

use app\models\Poem;
use library\Pager;
use xbphp\base\Controller;
use app\models\User;
use xbphp\base\Model;


class UserController extends Controller
{

    public function index()
    {
    }
    public function user()
    {
    }
    public function login(){
        //接收用户数据
        $uname=empty($_POST['uname'])?null:$_POST['uname'];
        $password=empty($_POST['password'])?null:$_POST['password'];
        if($uname&&$password){//登录
            $User=new User();
            if($User->checkUser($uname,$password,$uid)){
                $user=$User->where(['uid=?'],[$uid])->fetch();
                $this->assign('TITLE', '主页');
                $this->assign('user', $user);
                $this->assign('view', "");
            }else{
                $this->assign('TITLE', '登录');
                $this->assign('message', "用户不存在或密码错误！");
            }
        }else{//不登录
            $message = empty($_POST['message']) ?  '':$_POST['message'];
            $this->assign('TITLE', '登录');
            if($message){
                $this->assign('message', $message);
            }
        }
        $this->render();

        exit();
    }
    public function register()
    {
        //接收用户数据
        $uname=empty($_POST['uname'])?null:$_POST['uname'];
        $email=empty($_POST['email'])?null:$_POST['email'];
        $password=empty($_POST['password'])?null:$_POST['password'];
        if($uname&&$password&&$email){//注册
            $this->assign('TITLE', '注册');
            if($uname==""||strlen($uname)>20){
                $this->assign('message', "用户名格式不合规范！");
            }else if($email==""||strlen($email)>255){
                $this->assign('message', "邮箱格式不合规范！");
            }else if($password==""||strlen($password)>20){
                $this->assign('message', "密码格式不合规范！");
            }else if((new User())->where(['uname=?'],[$uname])->fetchAll()){
                $this->assign('message', "用户已经存在！");
            }else{
                $data['uname']=$uname;
                $data['email']=$email;
                $data['password']=$password;
                $count=(new User())->add($data);
                $this->assign('TITLE', '登录');
                $this->assign('viewpage', 'login');
                $this->assign('message', "恭喜，您已是诗词会的一员！".$count);
            }
        }else{//不注册
            $message = empty($_POST['message']) ?  '':$_POST['message'];
            $this->assign('TITLE', '注册');
            if($message){
                $this->assign('message', $message);
            }
        }
        $this->render();
        exit();
    }

    public function like($params){
        $uid = empty($_GET['uid']) ?  null:$_GET['uid'];
        if ($uid) {
            $pageNow=empty($_GET['pageNow'])?1:$_GET['pageNow'];
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

            (new User())->where($where,$value)->getLikeUser($pager);
            $users=$pager->arr;
            echo json_encode($users,JSON_UNESCAPED_UNICODE);
            $navigation = $pager->echoNavigation("/user/like?".$param."pageNow=");
        } else {
            $users = null;
            $navigation = null;
        }
        $this->assign('TITLE', '用户列表');
        $this->assign('uid', $uid);
        $this->assign('users', $users);
        $this->assign('navigation', $navigation);
        $this->render();
    }
    public function liked(){

    }

    public function likecomment(){

    }

    public function likepoem($params){
        $pid = empty($_GET['pid']) ?  null:$_GET['pid'];
        if ($pid) {
            $pageNow=empty($_GET['pageNow'])?1:$_GET['pageNow'];
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
}