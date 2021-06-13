<?php
namespace xbphp\base;

use app\models\Author;
use app\models\Comment;
use app\models\Dynasty;
use app\models\User;
use library\Func;
use library\MessageBox;
use library\Pager;
use library\RedisConnect;

/**
 * 控制器基类
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    // 构造函数，初始化属性，并实例化对应模型
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    // 分配变量
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    // 渲染视图
    public function render()
    {
        $this->_view->render();
    }
    
    protected function isAuthor($aid,$did=null): bool
    {
        if($did)
            return ((new Author())->where(['did=?', 'aid=?', 'active=?'], [$did, $aid, '1'])->fetch() != null);
        else
            return ((new Author())->where(['aid=?', 'active=?'], [$aid, '1'])->fetch() != null);
    }
    protected function isDynasty($did): bool
    {
        return ((new Dynasty())->where(['did=?','active=?'], [$did, '1'])->fetch() != null);
    }
    public function authUser(): bool
    {
        $uid= $_COOKIE['uid'] ?? '';
        $key='token_'.$uid;
        $token=$_COOKIE[$key]??null;
        return $token&&$token===RedisConnect::getKey($key);
    }
    public function authAdmin(): bool
    {
        $uid= $_COOKIE['auid'] ?? '';
        $key='atoken_'.$uid;
        $token=$_COOKIE[$key]??null;
        return $token&&$token===RedisConnect::getKey($key);
    }
    public function navView($str="admin"){
        $user=null;
        $admin=null;
        $this->assign("basicConfig",RedisConnect::getHash("basic"));
        if($this->authAdmin()){
            $admin=(new User())->where(['uid=:uid'],['uid'=>($_COOKIE['auid'] ?? null)])->fetch();
            $admin['avatar']=Func::getAvatar($admin['uid']);
            $this->assign("admin",$admin);
        }
        if($this->authUser()){
            $user=(new User())->where(['uid=:uid'],['uid'=>($_COOKIE['uid'] ?? null)])->fetch();
            $user['avatar']=Func::getAvatar($user['uid']);
            $this->assign("user",$user);
        }
        if($str=="user"){
            return $user;
        }
        elseif($str=="admin"){
            return $admin;
        }
        return null;
    }
    public function authUserView()
    {
        $uid= $_COOKIE['uid'] ?? '';
        $key='token_'.$uid;
        $token=$_COOKIE[$key]??null;
        if($token&&$token===RedisConnect::getKey($key)){
            $userttl=RedisConnect::getHashKey("user","userttl")!=null?RedisConnect::getHashKey("user","userttl"):6000;
            $userloginttl=RedisConnect::getHashKey("user","userloginttl")!=null?RedisConnect::getHashKey("user","userloginttl"):7200;
            if(RedisConnect::ttl($key)<$userttl){
                $token=md5($uid.rand());
                $expire=RedisConnect::ttl($key)>$userloginttl?time()+RedisConnect::ttl($key):time()+$userloginttl;
                setcookie("uid",$uid,$expire,"/");
                setcookie("token_".$uid,$token,$expire,"/");
                RedisConnect::setKey("token_".$uid,$token,$expire);
            }
        }else{
            $this->assign('TITLE', '诗词会-登录');
            $this->assign('errMsg', MessageBox::echoDanger("您还没有登录，请重新登录！"));
            $this->assign("viewpage","login");
            $this->assign("prePage", $_SERVER['REQUEST_URI']);
            $this->render();
            exit();
        }
    }

    public function authAdminView()
    {
        $uid= $_COOKIE['auid'] ?? '';
        $key='atoken_'.$uid;
        $token=$_COOKIE[$key]??null;
        if($token&&$token===RedisConnect::getKey($key)){
            $adminttl=RedisConnect::getHashKey("user","adminttl")!=null?RedisConnect::getHashKey("user","adminttl"):10000;
            $adminloginttl=RedisConnect::getHashKey("user","adminloginttl")!=null?RedisConnect::getHashKey("user","adminloginttl"):10800;
            if(RedisConnect::ttl($key)<$adminttl){
                $token=md5($uid.rand());
                $expire=RedisConnect::ttl($key)>$adminloginttl?time()+RedisConnect::ttl($key):time()+$adminloginttl;
                setcookie("auid",$uid,$expire,"/");
                setcookie("atoken_".$uid,$token,$expire,"/");
                RedisConnect::setKey("atoken_".$uid,$token,$expire);
            }
        }else{
            $this->assign('TITLE', '诗词会-管理员后台登录');
            $this->assign('errMsg', MessageBox::echoDanger("您还没有登录，请重新登录！"));
            $this->assign("viewpage","login");
            $this->assign("prePage", $_SERVER['REQUEST_URI']);
            $this->render();
            exit();
        }
    }
    protected function getCommentList($user,$listnumKey,$type,$id,$assignFlag,$navPre,$error,$successFlag=1)
    {
        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $commentConfig=RedisConnect::getHash('comment');
        $pager=new Pager($pageNow,$commentConfig[$listnumKey]);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        $where[$i]="public=?";
        $value[$i++]="1";
        $where[$i]="active=?";
        $value[$i++]="1";
        foreach ($params as $key=>$v){
            if($key=="pageNow"||$key=="order"||$key==$type."id"||trim($v)=="")
                continue;
            if($key=="title"||$key=="content"){
                $where[$i]="$key like ?";
                $value[$i++]="%".$v."%";
            }else if($key=="sendtime1") {
                $where[$i]="sendtime >= ?";
                $value[$i++]=$v;
            }else if($key=="sendtime2"){
                $where[$i]="sendtime <= ?";
                $value[$i++]=$v;
            }else{
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            $this->assign($key,$v);
            $param.=$key."=".$v."&";
        }
        $orderPara = $params['order']??null;
        if($orderPara=="commentnumber"||$orderPara=="likenumber"){
            $order=["$orderPara DESC",'cid DESC'];
            $param.="order=$orderPara&";
        }else{
            $order=['likenumber DESC','commentnumber DESC','cid DESC'];
            $param.="order=number&";
        }
        $this->assign("order",$orderPara);
        $where[$i]="id=?";
        $value[$i++]=$id;
        $where[$i]="type=?";
        $value[$i++]=$type;
        (new Comment())->where($where,$value)->order($order)->getCommentList($pager);
        $comments=$pager->arr;
        foreach ($comments as $i=>$comment){
            $comments[$i]['avatar']=Func::getAvatar($comments[$i]['uid']);
        }
        if($user){
            foreach ($comments as $i=>$comment){
                $comments[$i]['like']=(new User())->getUidCid($user['uid'],$comment['cid']);
            }
        }
        $pager->arr=$comments;
        if($assignFlag){
            $this->assign('comments', $comments);
            $this->assign('navigation', $pager->echoNavigation($navPre.$param."pageNow="));
            $this->assign('message', $pager->echoMessage($error,$successFlag));
        }
        return $pager;
    }
}