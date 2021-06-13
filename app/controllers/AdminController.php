<?php

namespace app\controllers;

use app\models\Author;
use app\models\Comment;
use app\models\Dynasty;
use app\models\Poem;
use app\models\User;
use library\Func;
use library\MessageBox;
use library\Pager;
use library\RedisConnect;
use xbphp\base\Controller;
use xbphp\base\Model;


class AdminController extends Controller
{
    public function index(){
        $this->navView();
        $this->authAdminView();
        $this->assign('TITLE', '诗词会-后台管理中心');
        $this->assign("navType","adminsetting");
        $this->render();
        exit();
    }
    public function jsonconfig(){
        $this->authAdminView();
        $config['basic']=RedisConnect::getHash("basic");
        $config['banners']=RedisConnect::getKey("banners");
        $config['poem']=RedisConnect::getHash("poem");
        $config['author']=RedisConnect::getHash("author");
        $config['dynasty']=RedisConnect::getHash("dynasty");
        $config['user']=RedisConnect::getHash("user");
        $config['comment']=RedisConnect::getHash("comment");
        $config['news']=RedisConnect::getHash("news");
        $config['feedback']=RedisConnect::getHash("feedback");
        echo json_encode($config,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsonpoem(){
        $this->authAdminView();
        $pid = empty($_GET['pid']) ?  '':$_GET['pid'];
        $poem =(new Poem())->getPoem($pid);
        if(!$poem||$poem['active']=="0"){
            echo '{"pid":"","title":"","did":"","aid":"","content":"","likepoemnumber":"0","commentnumber":"0","active":"0","dname":"","dactive":"0","aname":"","aactive":"0"}';
            exit();
        }
        echo json_encode($poem,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsonuser(){
        $this->authAdminView();
        $uid = empty($_GET['uid']) ?  '':$_GET['uid'];
        $user =(new User())->where(['uid=?'],[$uid])->fetch();
        if(!$user||$user['level']=='-'){
            echo '{"uid":"","uname":"","password":"","nickname":"","email":"","tel":"","slogan":"","sex":"2","birthday":"","regtime":"","regip":"","likepoemnumber":"0","likecommentnumber":"0","commentnumber":"0","likeusernumber":"0","likedusernumber":"0","sid":"0","avatar":"","assets":"0","exp":"0","level":"0"}';
            exit();
        }
        echo json_encode($user,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsonauthor(){
        $this->authAdminView();
        $aid = empty($_GET['aid']) ?  '':$_GET['aid'];
        $author =(new Author())->where(['aid=?'],[$aid])->fetch();
        if(!$author||$author['active']=='0'){
            echo '{"aid":"0","aname":"","did":"0","active":"0"}';
            exit();
        }
        echo json_encode($author,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsondynasty(){
        $this->authAdminView();
        $did = empty($_GET['did']) ?  '':$_GET['did'];
        $dynasty =(new Dynasty())->where(['did=?'],[$did])->fetch();
        if(!$dynasty||$dynasty['active']=='0'){
            echo '{"did":"0","dname":"","active":"0"}';
            exit();
        }
        echo json_encode($dynasty,JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function jsonadmin(){
        $user=$this->navView();
        $this->authAdminView();
        if(!$user||$user['level']=='-'){
            echo '{"uid":"","uname":"","password":"","nickname":"","email":"","tel":"","slogan":"","sex":"2","birthday":"","regtime":"","regip":"","likepoemnumber":"0","likecommentnumber":"0","commentnumber":"0","likeusernumber":"0","likedusernumber":"0","sid":"0","avatar":"","assets":"0","exp":"0","level":"0"}';
            exit();
        }
        echo json_encode($user,JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function poemlist(){
        $this->navView();
        $this->authAdminView();

        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $poemConfig=RedisConnect::getHash('poem');
        $pager=new Pager($pageNow,$poemConfig['listnum'],$poemConfig['pagenum']);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        foreach ($params as $key=>$v){
            if($key=="pageNow"||$key=="order"||trim($v)=="")
                continue;
            if($key=="title"||$key=="aname"||$key=="content"){
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
        $orderPara = $params['order']??null;
        if($orderPara=="commentnumber"||$orderPara=="likepoemnumber"){
            $order=["$orderPara DESC",'pid DESC'];
            $param.="order=$orderPara&";
        }
        else{
            $order=['likepoemnumber DESC','commentnumber DESC','pid DESC'];
            $param.="order=number&";
        }
        $this->assign("order",$orderPara);
        (new Poem())->where($where,$value)->order($order)->getPoemList($pager);
        $poems=$pager->arr;

        $this->assign('TITLE', '诗词管理-诗词会');
        $this->assign('poems', $poems);
        $this->assign('navigation', $pager->echoNavigation("/admin/poemlist?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage("<strong>抱歉！</strong> 未查询到符合条件的诗词o(╥﹏╥)o",1,1));
        $this->assign('poemConfig', $poemConfig);
        $this->assign('dynastys', json_decode(RedisConnect::getKey("dynastylist"),JSON_UNESCAPED_UNICODE));
        $this->render();
        exit();
    }

    public function userlist(){
        $this->navView();
        $this->authAdminView();

        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $userConfig=RedisConnect::getHash('user');
        $pager=new Pager($pageNow,$userConfig['listnum'],$userConfig['pagenum']);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        foreach ($params as $key=>$v){
            if($key=="pageNow"||$key=="order"||trim($v)=="")
                continue;
            if($key=="uname"||$key=="nickname"||$key=="regip"||$key=="email"||$key=="tel"){
                $where[$i]="$key like ?";
                $value[$i++]="%".$v."%";
            }else if($key=="regtime1") {
                $where[$i]="regtime >= ?";
                $value[$i++]=$v;
            }else if($key=="regtime2"){
                $where[$i]="regtime <= ?";
                $value[$i++]=$v;
            }else{
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            $this->assign($key,$v);
            $param.=$key."=".$v."&";
        }
        $orderPara = $params['order']??null;
        if($orderPara&&($orderPara=="likepoemnumber"||$orderPara=="likecommentnumber"||$orderPara=="commentnumber"||$orderPara=="likeusernumber"||$orderPara=="likedusernumber"||$orderPara=="assets"||$orderPara=="exp")){
            $order=[$orderPara.' DESC','uid DESC'];
            $param.="order=$orderPara&";
        }else{
            $order=['likedusernumber DESC','uid DESC'];
            $param.="order=likedusernumber&";
        }
        $this->assign("order",$orderPara);
        (new User())->where($where,$value)->order($order)->getUserList($pager);
        $users=$pager->arr;

        $this->assign('TITLE', '用户管理-诗词会');
        $this->assign('users', $users);
        $this->assign('navigation', $pager->echoNavigation("/admin/userlist?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage("<strong>抱歉！</strong> 未查询到符合条件的用户o(╥﹏╥)o",1,1));
        $this->assign('userConfig', $userConfig);
        $this->render();
        exit();
    }
    public function dynastylist(){
        $this->navView();
        $this->authAdminView();

        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $dynastyConfig=RedisConnect::getHash('dynasty');
        $pager=new Pager($pageNow,$dynastyConfig['listnum'],$dynastyConfig['pagenum']);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        foreach ($params as $key=>$v){
            if($key=="pageNow"||$key=="order"||trim($v)=="")
                continue;
            if($key=="dname"){
                $where[$i]="$key like ?";
                $value[$i++]="%".$v."%";
            }else{
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            $this->assign($key,$v);
            $param.=$key."=".$v."&";
        }
        $orderPara = $params['order']??null;
        if($orderPara&&($orderPara=="poemcount"||$orderPara=="authorcount")){
            $order=[$orderPara.' DESC'];
            $param.="order=$orderPara&";
        }else{
            $order=['poemcount DESC'];
            $param.="order=poemcount&";
        }
        $this->assign("order",$orderPara);
        (new Dynasty())->where($where,$value)->order($order)->getDynastyList($pager);
        $dynastys=$pager->arr;
        $this->assign('TITLE', '朝代管理-诗词会');
        $this->assign('dynastys', $dynastys);
        $this->assign('navigation', $pager->echoNavigation("/admin/dynastylist?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage("<strong>抱歉！</strong> 未查询到符合条件的朝代o(╥﹏╥)o",1,1));
        $this->assign('dynastyConfig', $dynastyConfig);
        $this->render();
        exit();
    }
    public function authorlist(){
        $this->navView();
        $this->authAdminView();

        $pageNow=$_GET['pageNow']??1;
        $pageNow=is_numeric($pageNow)?$pageNow:1;
        $authorConfig=RedisConnect::getHash('author');
        $pager=new Pager($pageNow,$authorConfig['listnum'],$authorConfig['pagenum']);
        $param="";
        $params=$_GET;
        $where=array();
        $value=array();
        $i=0;
        foreach ($params as $key=>$v){
            if($key=="pageNow"||trim($v)=="")
                continue;
            if($key=="aname"){
                $where[$i]="$key like ?";
                $value[$i++]="%".$v."%";
            }else{
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            $this->assign($key,$v);
            $param.=$key."=".$v."&";
        }
        (new Author())->where($where,$value)->getAuthorList($pager);
        $authors=$pager->arr;
        $this->assign('TITLE', '诗人/词人管理-诗词会');
        $this->assign('authors', $authors);
        $this->assign('navigation', $pager->echoNavigation("/admin/authorlist?".$param."pageNow="));
        $this->assign('message', $pager->echoMessage("<strong>抱歉！</strong> 未查询到符合条件的诗人/词人o(╥﹏╥)o",1,1));
        $this->assign('authorConfig', $authorConfig);
        $this->assign('dynastys', json_decode(RedisConnect::getKey("dynastylist"),JSON_UNESCAPED_UNICODE));
        $this->render();
        exit();
    }
    public function login(){
        //接收用户数据
        $this->navView();
        $this->assign("status",RedisConnect::getHashKey("basic","status"));
        $uname= $_POST['uname'] ?? null;
        $password= $_POST['password'] ?? null;
        $prePage= $_POST['prePage'] ?? null;
        $keep= isset($_POST['keep']);
        $this->assign('TITLE', '诗词会-管理员后台登录');
        if($uname&&$password){//登录
            $this->assign("uname",$uname);
            $flag = (new User())->checkUser($uname,$password,$uid);
            if($flag) {
                if(RedisConnect::getKey("left_" . $uid) && RedisConnect::getKey("left_" . $uid) <= 1) {
                    $this->assign('errMsg', MessageBox::echoDanger("您的账户已被锁定，请更改密码或等待解锁后重新登录！"));
                }else{
                    $user = (new User())->where(['uid=?'], [$uid])->fetch();
                    if($user['level'] < 2||$user['level'] == '-') {
                        $this->assign('errMsg', MessageBox::echoDanger("<strong>权限不足！</strong>您还不是管理员哦！"));
                    }else{
                        $token = md5($uid . rand());
                        if ($keep)
                            $expire = time() + 3600 * 24 * 30;
                        else{
                            $adminloginttl=RedisConnect::getHashKey("user","adminloginttl")!=null?RedisConnect::getHashKey("user","adminloginttl"):10800;
                            $expire=time()+$adminloginttl;
                        }
                        setcookie("auid", $uid, $expire, "/");
                        setcookie("atoken_" . $uid, $token, $expire, "/");
                        RedisConnect::setKey("atoken_" . $uid, $token, $expire);
                        RedisConnect::del("left_" . $uid);
                        if ($prePage)
                            header("location:$prePage");
                        else
                            header("location:index");
                        exit();
                    }
                }
            }else{
                if($uid==''){
                    $this->assign('errMsg', MessageBox::echoDanger("用户名号不存在！"));
                }else {
                    $left = RedisConnect::getKey("left_" . $uid) ?: 6;
                    RedisConnect::setKey("left_" . $uid, $left - 1, time() + 3600);
                    $this->assign('errMsg', MessageBox::echoDanger("密码错误，您还有" . ($left - 1) . "次机会！"));
                }
            }
        }else{//不登录
            $errMsg = $_POST['errMsg']??'';
            $successMsg = $_POST['successMsg']??'';
            if($errMsg){
                $this->assign('errMsg', $errMsg);
            }else if($successMsg){
                $this->assign('successMsg', $successMsg);
            }
        }
        $this->render();
        exit();
    }

    public function authDoView(){///status:1 success,2 info,3 warning,4 error,-1 herf
        if(!$this->authAdmin()){
            echo '{"status":-1,"result":"/admin/login?prePage='.$_SERVER['HTTP_REFERER'].'"}';
            exit();
        }
    }

    public function configbanners(){
        $this->authDoView();
        $banners= $_POST['banners'] ?? null;
        $status=4;
        if($banners!=null&&$banners!=""){
            $bannersStr=json_decode($banners,JSON_UNESCAPED_UNICODE);
            if($bannersStr!=null){
                if($banners!=RedisConnect::getKey("banners")){
                    RedisConnect::setKey("banners",$banners);
                    $status=1;
                    $result="横幅修改成功！";
                }else{
                    $status=2;
                    $result="横幅信息无修改！";
                }
            }else{
                $result="数据格式有误！";
            }
        }else{
            $result="数据不能为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function confighash(){
        $this->authDoView();
        $key=$_POST['key'];
        $status=4;
        $data0=RedisConnect::getHash($key);
        $data=json_decode($_POST['data'],JSON_UNESCAPED_UNICODE);
        if($data!=null){
            $same=1;
            foreach ($data as $index=>$datum){
                if($data0==null||$data0[$index]==null||$datum!=$data0[$index])
                    $same=0;
            }
            if($same==0){
                foreach ($data as $index=>$datum){
                    RedisConnect::setHash($key,$index,$datum);
                }
                $status=1;
                $result="信息修改成功！";
            }else{
                $status=2;
                $result="信息无修改！";
            }
        }else{
            $result="数据格式有误！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function Sql2Redis(){
        $this->authDoView();
        $key=$_POST['key'];
        $status=4;
        if($key=="dynastylist"){
            $dynastylist=json_encode((new Dynasty())->where(['active=?'],["1"])->fetchAll(),JSON_UNESCAPED_UNICODE);
            $dynastylist0=RedisConnect::getKey("dynastylist");
            if($dynastylist!=$dynastylist0){
                RedisConnect::setKey("dynastylist",$dynastylist);
                $status=1;
                $result="数据同步成功！";
            }else{
                $status=2;
                $result="数据无修改！";
            }
        }elseif ($key=="authorlist"){
            $authorlist0=RedisConnect::getList("authorlist");
            $same=1;
            foreach($authorlist0 as $i=>$author0){
                $author=json_encode((new Author())->where(['did=?','active=?'],[$i,"1"])->fetchAll(),JSON_UNESCAPED_UNICODE);
                if($author0!=$author){
                    RedisConnect::setListIndex("authorlist",$i,$author);
                    $same=0;
                }
            }
            if($same==0){
                $status=1;
                $result="数据同步成功！";
            }else{
                $status=2;
                $result="数据无修改！";
            }
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function addpoem(){
        $this->authDoView();
        $title= $_POST['title'] ?? null;
        $did= $_POST['did'] ?? null;
        $aid= $_POST['aid'] ?? null;
        $content= $_POST['content'] ?? null;
        $status=4;
        if($title!=null && $did!=null && $aid!=null && $content!=null && $title!="" && $did!="" && $aid!="" && $content!=""){
            $this->assign("title",$title);
            if(!$this->isAuthor($aid,$did)){
                $result="朝代与诗人信息有误！";
            }elseif($content==""||$title==""||strlen($title)>255){
                $result="诗词标题或内容的格式不合规范！";
            }else{
                $data['title']=$title;
                $data['did']=$did;
                $data['aid']=$aid;
                $data['content']=$content;
                $count=(new Poem())->add($data);
                if($count>0){
                    $status=1;
                    $result="创建诗词成功！";
                }else{
                    $result="创建诗词失败！";
                }
            }
        }else{
            $result="添加诗词失败！";//.$uname." ".$email." ".$money." ".$level." ".$password;
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function changepoem(){
        $this->authDoView();
        $pid= $_POST['pid'] ?? null;
        $title= $_POST['title'] ?? null;
        $did= $_POST['did'] ?? null;
        $aid= $_POST['aid'] ?? null;
        $content= $_POST['content'] ?? null;
        $status=4;
        if($pid!=null&&$title!=null&&$did!=null&&$aid!=null&&$content!=null&&$pid!=""&&$title!=""&&$did!=""&&$aid!=""&&$content!=""){
            $poem=(new Poem())->getPoem($pid);
            if($poem){
                if($title!=$poem['title']||$did!=$poem['did']||$aid!=$poem['aid']||$content!=$poem['content']){
                    if(!$this->isAuthor($aid,$did)){
                        $result="朝代与诗人信息有误！";
                    }elseif($content==""||$title==""||strlen($title)>255){
                        $result="诗词标题或内容的格式不合规范！";
                    }else{
                        if ((new Poem())->where(['pid=:pid'], [':pid' => $pid])->update(['title' => $title, 'did' => $did, 'aid' => $aid, 'content' => $content]) > 0) {
                            $status = 1;
                            $result = "修改诗词信息成功！";
                        } else {
                            $result = "修改诗词信息失败！";
                        }
                    }
                }else{
                    $status=2;
                    $result="信息无修改！";
                }
            }else{
                $result="无法找到诗词！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function addauthor(){
        $this->authDoView();
        $aname= $_POST['aname'] ?? null;
        $did= $_POST['did'] ?? null;
        $status=4;
        if($aname!=null && $did!=null && $aname!="" && $did!=""){
            $aname=trim($aname);
            $this->assign("aname",$aname);
            if(!$this->isDynasty($did)){
                $result="朝代信息有误！";
            }elseif($aname==""||strlen($aname)>255){
                $result="诗人/词人的格式不合规范！";
            }else{
                $data['aname']=$aname;
                $data['did']=$did;
                $count=(new Author())->add($data);
                if($count>0){
                    $status=1;
                    $result="创建诗人/词人成功！";
                }else{
                    $result="创建诗人/词人失败！";
                }
            }
        }else{
            $result="信息不可为空！";//.$uname." ".$email." ".$money." ".$level." ".$password;
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function changeauthor(){
        $this->authDoView();
        $aid= $_POST['aid'] ?? null;
        $aname= $_POST['aname'] ?? null;
        $did= $_POST['did'] ?? null;
        $status=4;
        if($aid!=null && $aname!=null && $did!=null && $aid!="" && $aname!="" && $did!=""){
            $aname=trim($aname);
            $author=(new Author())->where(['aid=?'],[$aid])->fetch();
            if($author){
                if($aname!=$author['aname']||$did!=$author['did']){
                    if(!$this->isDynasty($did)){
                        $result="朝代信息有误！";
                    }elseif($aname==""||strlen($aname)>255){
                        $result="诗人/词人的格式不合规范！";
                    }else{
                        if((new Author())->where(['aid=:aid'],[':aid'=>$aid])->update(['aname' => $aname, 'did' => $did])>0){
                            $status = 1;
                            $result = "修改诗人/词人信息成功！";
                        } else {
                            $result = "修改诗人/词人信息失败！";
                        }
                    }
                }else{
                    $status=2;
                    $result="信息无修改！";
                }
            }else{
                $result="无法找到诗人/词人！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function adddynasty(){
        $this->authDoView();
        $dname= $_POST['dname'] ?? null;
        $status=4;
        if($dname!=null && $dname!=""){
            $dname=trim($dname);
            $this->assign("dname",$dname);
            if($dname==""||strlen($dname)>255){
                $result="朝代的格式不合规范！";
            }else{
                $data['dname']=$dname;
                $count=(new Dynasty())->add($data);
                if($count>0){
                    $status=1;
                    $result="创建朝代成功！";
                }else{
                    $result="创建朝代失败！";
                }
            }
        }else{
            $result="信息不可为空！";//.$uname." ".$email." ".$money." ".$level." ".$password;
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function changedynasty(){
        $this->authDoView();
        $dname= $_POST['dname'] ?? null;
        $did= $_POST['did'] ?? null;
        $status=4;
        if($dname!=null && $did!=null && $dname!="" && $did!=""){
            $dname=trim($dname);
            $dynasty=(new Dynasty())->where(['did=?'],[$did])->fetch();
            if($dynasty){
                if($dname!=$dynasty['dname']){
                    if($dname==""||strlen($dname)>255){
                        $result="诗人/词人的格式不合规范！";
                    }else{
                        if((new Dynasty())->where(['did=:did'],[':did'=>$did])->update(['dname' => $dname])>0){
                            $status = 1;
                            $result = "修改朝代信息成功！";
                        } else {
                            $result = "修改朝代信息失败！";
                        }
                    }
                }else{
                    $status=2;
                    $result="信息无修改！";
                }
            }else{
                $result="无法找到朝代！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delpoem(){
        $this->authDoView();
        $pid= $_POST['pid'] ?? null;
        $status=4;
        if($pid){
            $poem=(new Poem())->getPoem($pid);
            if($poem){
                if((new Poem())->where(['pid=:pid'],[':pid'=>$pid])->update(['active'=>0])>0){
                    $status=1;
                    $result="诗词删除成功！";
                }else{
                    $result="诗词删除失败！";
                }
            }else{
                $result="无法找到诗词！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function recoverpoem(){
        $this->authDoView();
        $pid= $_POST['pid'] ?? null;
        $status=4;
        if($pid){
            $poem=(new Poem())->getPoem($pid);
            if($poem){
                if((new Poem())->where(['pid=:pid'],[':pid'=>$pid])->update(['active'=>1])>0){
                    $status=1;
                    $result="诗词恢复成功！";
                }else{
                    $result="诗词恢复失败！";
                }
            }else{
                $result="无法找到诗词！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delauthor(){
        $this->authDoView();
        $aid= $_POST['aid'] ?? null;
        $status=4;
        if($aid){
            $author=(new Author())->where(['aid=?'],[$aid])->fetch();
            if($author){
                if((new Author())->where(['aid=:aid'],[':aid'=>$aid])->update(['active'=>0])>0){
                    $status=1;
                    $result="诗人/词人删除成功！";
                }else{
                    $result="诗人/词人删除失败！";
                }
            }else{
                $result="无法找到诗人/词人！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function recoverauthor(){
        $this->authDoView();
        $aid= $_POST['aid'] ?? null;
        $status=4;
        if($aid){
            $author=(new Author())->where(['aid=?'],[$aid])->fetch();
            if($author){
                if((new Author())->where(['aid=:aid'],[':aid'=>$aid])->update(['active'=>1])>0){
                    $status=1;
                    $result="诗人/词人恢复成功！";
                }else{
                    $result="诗人/词人恢复失败！";
                }
            }else{
                $result="无法找到诗人/词人！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function deldynasty(){
        $this->authDoView();
        $did= $_POST['did'] ?? null;
        $status=4;
        if($did){
            $dynasty=(new Dynasty())->where(['did=?'],[$did])->fetch();
            if($dynasty){
                if((new Dynasty())->where(['did=:did'],[':did'=>$did])->update(['active'=>0])>0){
                    $status=1;
                    $result="朝代删除成功！";
                }else{
                    $result="朝代删除失败！";
                }
            }else{
                $result="无法找到朝代！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function recoverdynasty(){
        $this->authDoView();
        $did= $_POST['did'] ?? null;
        $status=4;
        if($did){
            $dynasty=(new Dynasty())->where(['did=?'],[$did])->fetch();
            if($dynasty){
                if((new Dynasty())->where(['did=:did'],[':did'=>$did])->update(['active'=>1])>0){
                    $status=1;
                    $result="朝代恢复成功！";
                }else{
                    $result="朝代恢复失败！";
                }
            }else{
                $result="无法找到朝代！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function adduser(){
        $this->authDoView();
        $uname= $_POST['uname'] ?? null;
        $nickname= $_POST['nickname'] ?? null;
        $password= $_POST['password'] ?? null;
        $email= $_POST['email'] ?? null;
        $tel= $_POST['tel'] ?? null;
        $slogan= $_POST['slogan'] ?? null;
        $sex= $_POST['sex'] ?? null;
        $birthday= $_POST['birthday'] ?? null;
        if($birthday&&$birthday!="")
            $birthday=substr($birthday,0,10)." ".substr($birthday,11);
        else
            $birthday=null;
        $assets= $_POST['assets'] ?? null;
        $exp= $_POST['exp'] ?? null;
        $level= $_POST['level'] ?? null;
        $status=4;
        //if($uid!=null&&$uname!=null&&$nickname!=null&&$email!=null&&$tel!=null&&$slogan!=null&&$sex!=null&&$birthday!=null&&$assets!=null&&$exp!=null&&$level!=null){
        if($uname!=null&&$email!=null&&$sex!=null&&$assets!=null&&$exp!=null&&$level!=null){
            $this->assign("uname",$uname);
            $this->assign("email",$email);
            if(!is_float($assets+0.0)||!is_int($exp+0)||$exp<0||($level!='-'&&$level!='0'&&$level!='1'&&$level!='2'&&$level!='3'&&$level!='4'&&$level!='5')){
                $result="数据格式不合规范！";
            }elseif($email==""||strlen($email)>255){
                $result="邮箱格式不合规范！";
            }elseif($password==""||strlen($password)>20){
                $result="密码格式不合规范！";
            }elseif((new User())->where(['uname = ?'],[$uname])->fetch()){
                $result="名号 ".$uname." 已经存在！请重新起一个吧";
            }else{
                $data['uname']=$uname;
                $data['nickname']=$nickname;
                $data['password']=md5($password);
                $data['email']=$email;
                $data['tel']=$tel;
                $data['slogan']=$slogan;
                $data['sex']=$sex;
                $data['birthday']=$birthday;
                $data['assets']=$assets;
                $data['exp']=$exp;
                $data['level']=$level;
                $count=(new User())->add($data);
                if($count>0){
                    $status=1;
                    $result="创建用户成功！";
                }else{
                    $result="创建用户失败！";
                }
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function deluser(){
        $admin=$this->navView();
        $this->authDoView();
        $uid= $_POST['uid'] ?? null;
        $status=4;
        if($uid){
            $user=(new User())->where(['uid=:uid'],[':uid'=>$uid])->fetch();
            if($user){
                if($user['level']!='-'){
                    if($admin['uid']!=$user['uid']&&$admin['level']>$user['level']) {
                        if ((new User())->where(['uid=:uid'], [':uid' => $uid])->update(['level' => '-']) > 0) {
                            $status = 1;
                            $result = "用户封禁成功！";
                        } else {
                            $result = "用户封禁失败！";
                        }
                    }else{
                        $result = "权限不足，无法封禁用户！";
                    }
                }else{
                    $result = "该用户已被封禁！";
                }
            }else{
                $result="无法找到用户！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function recoveruser(){
        $admin=$this->navView();
        $this->authDoView();
        $uid= $_POST['uid'] ?? null;
        $status=4;
        if($uid){
            $user=(new User())->where(['uid=:uid'],[':uid'=>$uid])->fetch();
            if($user){
                if($user['level']=='-'){
                    if($admin['uid']!=$user['uid']&&$admin['level']>$user['level']) {
                        if((new User())->where(['uid=:uid'],[':uid'=>$uid])->update(['level'=>'0'])>0){
                            $status=1;
                            $result="用户恢复成功！";
                        }else{
                            $result="用户恢复失败！";
                        }
                    }else{
                        $result = "权限不足，无法恢复用户！";
                    }
                }else{
                    $result = "该用户无需恢复！";
                }
            }else{
                $result="无法找到用户！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function changeuser(){
        $admin=$this->navView();
        $this->authDoView();
        $uid= $_POST['uid'] ?? null;
        $uname= $_POST['uname'] ?? null;
        $nickname= $_POST['nickname'] ?? null;
        $email= $_POST['email'] ?? null;
        $tel= $_POST['tel'] ?? null;
        $slogan= $_POST['slogan'] ?? null;
        $sex= $_POST['sex'] ?? null;
        $birthday= $_POST['birthday'] ?? null;
        if($birthday&&$birthday!=""){
            $birthday=substr($birthday,0,10)." ".substr($birthday,11);
            if(!preg_match("/[0-9]{4}[-,\/][0-9]{1,2}[-,\/][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}(:[0-9]{1,2})?/",$birthday)){
                $birthday=null;
            }
        }else{
            $birthday=null;
        }
        $assets= $_POST['assets'] ?? null;
        $exp= $_POST['exp'] ?? null;
        $level= $_POST['level'] ?? null;
        $status=4;
        if($uid!=null&&$uname!=null&&$email!=null&&$sex!=null&&$assets!=null&&$exp!=null&&$level!=null){
            $user=(new User())->where(['uid=:uid'],[':uid'=>$uid])->fetch();
            if($user){
                if($user['level']=='-'||($admin['level']>=$user['level'])){
                    if($uname!=$user['uname']||$nickname!=$user['nickname']||$email!=$user['email']||$tel!=$user['tel']||$slogan!=$user['slogan']||$sex!=$user['sex']||$birthday!=$user['birthday']||$assets!=$user['assets']||$exp!=$user['exp']||$level!=$user['level']){
                        if(!is_float($assets+0.0)||!is_int($exp+0)||$exp<0||($level!='-'&&$level!='0'&&$level!='1'&&$level!='2'&&$level!='3'&&$level!='4'&&$level!='5')){
                            $result="数据格式不合规范！";
                        }elseif($email==""||strlen($email)>255){
                            $result="邮箱格式不合规范！";
                        }elseif((new User())->where(['uname = ?','uid != ?'],[$uname,$uid])->fetch()){
                            $result="名号 ".$uname." 已经存在！请重新起一个吧";
                        }else{
                            if ((new User())->where(['uid=:uid'], [':uid' => $uid])->update(['uname' => $uname, 'nickname' => $nickname, 'email' => $email, 'tel' => $tel, 'slogan' => $slogan, 'sex' => $sex, 'birthday' => $birthday, 'assets' => $assets, 'exp' => $exp, 'level' => $level]) > 0) {
                                $status = 1;
                                $result = "修改用户信息成功！";
                            } else {
                                $result = "修改用户信息失败！";
                            }
                        }
                    }else{
                        $status=2;
                        $result="信息无修改！";
                    }
                }else{
                    $result="权限不足，无法修改！！";
                }
            }else{
                $result="无法找到用户！";
            }
        }else{
            $result="用户信息提交失败！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function hidecomment(){
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if((new Comment())->where(['cid=:cid'],[':cid'=>$cid])->update(['public'=>0])>0){
                    $status=1;
                    $result="评论已设置为私密！";
                }else{
                    $result="评论设置私密失败！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function displaycomment(){
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if((new Comment())->where(['cid=:cid'],[':cid'=>$cid])->update(['public'=>1])>0){
                    $status=1;
                    $result="评论公开成功！";
                }else{
                    $result="评论设置公开失败！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delcomment(){
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if((new Comment())->where(['cid=:cid'],[':cid'=>$cid])->update(['active'=>0])>0){
                    $status=1;
                    $result="评论已删除！";
                }else{
                    $result="评论删除失败！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function recovercomment(){
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if((new Comment())->where(['cid=:cid'],[':cid'=>$cid])->update(['active'=>1])>0){
                    $status=1;
                    $result="评论恢复成功！";
                }else{
                    $result="评论恢复失败！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function logout(){
        $uid= $_COOKIE['auid'] ?? '';
        $key='atoken_'.$uid;
        $token=$_COOKIE[$key]??null;
        if($token&&$token===RedisConnect::getKey($key)){
            $_COOKIE['auid']="";
            $_COOKIE[$key]="";
            RedisConnect::del($key);
        }
        header("location:".$_SERVER['HTTP_REFERER']);
    }
}