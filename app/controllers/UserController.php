<?php


namespace app\controllers;

use app\models\Author;
use app\models\Comment;
use app\models\Feedback;
use app\models\News;
use app\models\Poem;
use library\CropAvatar;
use library\Func;
use library\MessageBox;
use library\Pager;
use library\RedisConnect;
use xbphp\base\Controller;
use app\models\User;
use xbphp\base\Model;


class UserController extends Controller
{
    public function index()
    {
        $user=$this->navView("user");
        $this->authUserView();

        $this->assign('TITLE', '诗词会-用户中心');
        $this->render();
    }

    public function home($para=null){
        $user=$this->navView("user");
        $userhome=null;
        if($para!=null){
            $userhome=(new User())->where(['uid=?'],[$para])->fetch();
            if($userhome==null){
                $userhome=(new User())->where(['uname=?'],[$para])->fetch();
            }
        }
        if($userhome==null){
            $this->assign("TITLE","无效用户");
            $this->render();
            exit();
        }else{
            $userhome['avatar']=Func::getAvatar($userhome['uid']);
            $userhome['banner']=Func::getBanner($userhome['uid']);
            if($user==null)
                $userhome['like']=0;
            else
                $userhome['like']=(new User())->getUidUid($user['uid'],$userhome['uid']);
            $this->assign("userhome",$userhome);
        }
        $this->assign("TITLE",$userhome['uname'].($userhome['nickname']==null||$userhome['nickname']==''?"":"-".$userhome['nickname'])." 的个人空间");
        $this->render();
        exit();
    }

    public function jsonpoem(){
        $this->authUserView();
        $pid = empty($_GET['pid']) ?  '':$_GET['pid'];
        $poem =(new Poem())->getPoem($pid);
        if(!$poem||$poem['active']=="0"){
            echo '{"pid":"","title":"","did":"","aid":"","content":"","likepoemnumber":"0","commentnumber":"0","active":"0","dname":"","dactive":"0","aname":"","aactive":"0"}';
            exit();
        }
        echo json_encode($poem,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsoncomment(){
        $this->authUserView();
        $cid = empty($_GET['cid']) ?  '':$_GET['cid'];
        $comment =(new Comment())->getComment($cid);
        if(!$comment||$comment['active']=="0"||$comment['public']=="0"){
            echo
            '{"cid": "0",
            "uid": "0",
            "type": "0",
            "id": "0",
            "title": "",
            "content": "",
            "sendtime": "1971-01-01 00:00:00",
            "public": "0",
            "active": "0",
            "uname": "",
            "nickname": "",
            "email": "",
            "tel": "",
            "slogan": "",
            "sex": "2",
            "birthday": "1971-01-01 00:00:00",
            "regtime": "1971-01-01 00:00:00",
            "likepoemnumber": "0",
            "likecommentnumber": "0",
            "commentnumber": "0",
            "likeusernumber": "0",
            "likedusernumber": "0",
            "assets": "0",
            "exp": "0",
            "level": "0"
            }';
            exit();
        }
        echo json_encode($comment,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function jsonuser(){
        $user=$this->navView("user");
        $this->authUserView();
        if(!$user||$user['level']=='-'){
            echo '{"uid":"","uname":"","nickname":"","email":"","tel":"","slogan":"","sex":"2","regtime":"","regip":"","likepoemnumber":"0","likecommentnumber":"0","commentnumber":"0","likeusernumber":"0","likedusernumber":"0","sid":"0","avatar":"","assets":"0","exp":"0","level":"0"}';
            exit();
        }
        echo json_encode($user,JSON_UNESCAPED_UNICODE);
        exit();
    }
    public function login(){
        $LoginedUser=$this->navView("user");
        //接收用户数据
        $uname= $_POST['uname'] ?? null;
        $password= $_POST['password'] ?? null;
        $prePage= $_POST['prePage'] ?? null;
        $keep= isset($_POST['keep']);
        $this->assign('TITLE', '诗词会-登录');
        if($uname&&$password){//登录
            $this->assign("uname",$uname);
            $flag = (new User())->checkUser($uname,$password,$uid);
            if($flag){
                if(RedisConnect::getKey("left_".$uid)&&RedisConnect::getKey("left_".$uid)<=1) {
                    $this->assign('errMsg', MessageBox::echoDanger("您的名号已被锁定，请更改令牌或等待解锁后重新登录！"));
                }else{
                    $user=(new User())->where(['uid=?'],[$uid])->fetch();
                    if($user['level']==0) {
                        $this->assign('errMsg', MessageBox::echoDanger("用户尚未激活，请激活后登录！"));
                    }elseif($user['level']=='-'){
                        $this->assign('errMsg', MessageBox::echoDanger("用户已被封禁！无法登录！"));
                    }else{
                        $token=md5($uid.rand());
                        if($keep)
                            $expire=time()+3600*24*30;
                        else{
                            $userloginttl=RedisConnect::getHashKey("user","userloginttl")!=null?RedisConnect::getHashKey("user","userloginttl"):7200;
                            $expire=time()+$userloginttl;
                        }
                        setcookie("uid",$uid,$expire,"/");
                        setcookie("token_".$uid,$token,$expire,"/");
                        RedisConnect::setKey("token_".$uid,$token,$expire);
                        RedisConnect::del("left_".$uid);
                        if($prePage)
                            header("location:$prePage");
                        else
                            header("location:index");
                        exit();
                    }
                }
            }else{
                if($uid==''){
                    $this->assign('errMsg', MessageBox::echoDanger("用户名号不存在！"));
                }else{
                    $left=RedisConnect::getKey("left_".$uid)?:6;
                    RedisConnect::setKey("left_".$uid,$left-1,time()+3600);
                    $this->assign('errMsg', MessageBox::echoDanger("密码错误，您还有".($left-1)."次机会！"));
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
            if($LoginedUser)
                $this->assign("LoginedUser",$LoginedUser);
        }
        $this->render();
        exit();
    }
    public function register()
    {
        $LoginedUser=$this->navView("user");
        //接收用户数据
        $uname= trim($_POST['uname'] ?? '');
        $email= $_POST['email'] ?? null;
        $password= $_POST['password'] ?? null;
        $this->assign('TITLE', '诗词会-注册');
        if($uname&&$password&&$email){//注册
            $this->assign("uname",$uname);
            $this->assign("email",$email);
            if($uname==""||mb_strlen($uname)>8){
                $this->assign('errMsg', MessageBox::echoDanger("名号格式不合规范【名号不得大于8位】！"));
            }elseif($email==""||mb_strlen($email)>255){
                $this->assign('errMsg', MessageBox::echoDanger("邮箱格式不合规范！"));
            }elseif($password==""||strlen($password)>20){
                $this->assign('errMsg', MessageBox::echoDanger("令牌格式不合规范！"));
            }elseif((new User())->where(['uname = ?'],[$uname])->fetch()){
                $this->assign('errMsg', MessageBox::echoDanger("名号 ".$uname." 已经存在！请重新起一个名号吧"));
            }elseif((new User())->where(['email = ?'],[$email])->fetch()){
                $this->assign('errMsg', MessageBox::echoDanger("该邮箱已注册！"));
            }elseif((new Author())->where(["aname like ?"],["%".$uname."%"])->fetch()){
                $this->assign('errMsg', MessageBox::echoDanger("名号已经存在！请重新起一个名号吧"));
            }else{
                $this->assign('TITLE', '诗词会-登录');
                $data['uname']=$uname;
                $data['email']=$email;
                $data['password']=md5($password);
                $data['regip']=Func::getIp();
                $count=(new User())->add($data);
                if($count>0){
                    $uid=(new User())->where(['uname=?'],[$uname])->fetch()['uid'];
                    $this->assign("viewpage","login");
                    $activettl=RedisConnect::getHashKey("user","activettl")!=null?RedisConnect::getHashKey("user","activettl"):2;
                    $this->assign('successMsg', MessageBox::echoSuccess("恭喜您注册成功，请进入您的<strong>邮箱激活账号</strong>吧！<br/>注意！链接将于".$activettl."日后过期，请及时激活！",15000));
                    $code=rand();
                    $activeExpire=time()+3600*24*$activettl;
                    RedisConnect::setKey("active_".$uid,$code,$activeExpire);
                    Func::sendMail($email,"诗词会-用户激活",
                        "激活链接：<a href='https://poem.xinball.top/user/active?uid=$uid&code=$code'>激活</a>"
                        ."<br/>过期时间：".date("Y-m-d H:i:s",$activeExpire));
                }
                else{
                    $this->assign('successMsg', MessageBox::echoDanger("注册用户失败！"));
                }
            }
        }else{//不注册
            $errMsg = $_POST['errMsg']??'';
            $successMsg = $_POST['successMsg']??'';
            if($errMsg){
                $this->assign('errMsg', $errMsg);
            }else if($successMsg){
                $this->assign('successMsg', $successMsg);
            }
            if($LoginedUser)
                $this->assign("LoginedUser",$LoginedUser);
        }
        $this->render();
        exit();
    }

    public function active(){
        $LoginedUser=$this->navView("user");
        if($LoginedUser)
            $this->assign("LoginedUser",$LoginedUser);
        $code= $_GET['code'] ?? null;
        $uid= $_GET['uid'] ?? null;
        $uname= $_GET['uname'] ?? null;
        $this->assign("TITLE","诗词会-用户激活");
        $flag=true;
        if ($uname){
            $user=(new User())->where(['uname=?'],[$uname])->fetch();
            if($user){
                $uid=$user['uid'];
                $this->assign("TITLE", "诗词会-登录");
                if($user['level']>0) {
                    $this->assign('warnMsg', MessageBox::echoWarning($user['uname'] . "，您已成为正式用户，无需激活！"));
                    $this->assign("viewpage", "login");
                }elseif($user['level']=='-') {
                    $this->assign('errMsg', MessageBox::echoDanger($user['uname'] . "，您的账号已被封禁，无法激活！"));
                    $this->assign("viewpage", "login");
                }else{
                    $this->assign('successMsg', MessageBox::echoSuccess("请进入您的邮箱 <strong>".$user['email']."</strong> 激活账号吧！<br/>注意！链接将于2日后过期，请及时激活！",15000));
                    $this->assign("viewpage", "login");
                    $code=rand();
                    $activeExpire=time()+3600*24*2;
                    RedisConnect::setKey("active_".$uid,$code,$activeExpire);
                    Func::sendMail($user['email'],"诗词会-用户激活",
                        "激活链接：<a href='https://poem.xinball.top/user/active?uid=$uid&code=$code'>激活</a>"
                        ."<br/>过期时间：".date("Y-m-d H:i:s",$activeExpire));
                }
            }else{
                $this->assign('errMsg', MessageBox::echoDanger("该用户名号不存在！"));
            }
        }elseif($uid){
            $user = (new User())->where(['uid=?'],[$uid])->fetch();
            if($user){
                if($user['level']>0) {
                    $this->assign('warnMsg', MessageBox::echoWarning($user['uname'] . "，您已成为正式用户，无需激活！"));
                    $this->assign("viewpage", "login");
                    $this->assign("TITLE", "诗词会-登录");
                }elseif($user['level']=='-'){
                    $this->assign('errMsg', MessageBox::echoDanger($user['uname']."，您的账号已被封禁，无法激活！"));
                    $this->assign("viewpage","login");
                    $this->assign("TITLE","诗词会-登录");
                }elseif(is_numeric($code)&&$user['level']==0){
                    if(empty(RedisConnect::getKey("active_".$uid))){
                        $this->assign('errMsg', MessageBox::echoDanger("抱歉！您的激活链接已过期<br/>请重新申请激活！",15000));
                    }else if($code===RedisConnect::getKey("active_".$uid)){
                        if((new User())->where(['uid=:uid'],['uid'=>$uid])->update(['level'=>'1'])>0){
                            RedisConnect::del("active_".$uid);
                            $this->assign("viewpage","login");
                            $this->assign("TITLE","诗词会-登录");
                            $this->assign('successMsg', MessageBox::echoSuccess("<strong>恭喜您！</strong>您已成为诗词会正式用户！"));
                        }else{
                            $this->assign('errMsg', MessageBox::echoDanger("用户激活失败！"));
                        }
                    }else{
                        $flag=false;
                    }
                }else{
                    $flag=false;
                }
            }else{
                $flag=false;
            }
        }
        if(!$flag)
            $this->assign('errMsg', MessageBox::echoDanger("抱歉！您的激活链接不正确<br/>请重新打开邮件内的链接进行激活！"));
        $this->render();
        exit();
    }

    public function forget(){
        $LoginedUser=$this->navView("user");
        $forget= $_GET['forget'] ?? null;
        $uid= $_GET['uid'] ?? null;
        $uname= $_GET['uname'] ?? null;
        $password= $_GET['password'] ?? null;
        $this->assign("TITLE","诗词会-找回令牌");
        if($LoginedUser)
            $this->assign("LoginedUser",$LoginedUser);
        $flag=true;
        if ($uname){
            $user=(new User())->where(['uname=?'],[$uname])->fetch();
            if($user['level']==0) {
                $this->assign('errMsg', MessageBox::echoDanger("用户尚未激活！"));
            }elseif($user['level']=='-'){
                $this->assign('errMsg', MessageBox::echoDanger("用户已被封禁！"));
            }elseif($user){
                $uid=$user['uid'];
                $this->assign('successMsg', MessageBox::echoSuccess("请进入您的邮箱： <strong>".$user['email']."</strong> 重置令牌吧！<br/>注意！重置链接将于2日后过期，请及时重置令牌！",15000));
                $forget=rand();
                $forgetExpire=time()+3600*24*2;
                RedisConnect::setKey("forget_".$uid,$forget,$forgetExpire);
                Func::sendMail($user['email'],"诗词会-找回令牌",
                    "令牌重置链接：<a href='https://poem.xinball.top/user/forget?uid=$uid&forget=$forget'>重置令牌</a>"
                    ."<br/>过期时间：".date("Y-m-d H:i:s",$forgetExpire));
            }else{
                $flag=false;
            }
        }elseif($uid){
            $this->assign("TITLE","诗词会-令牌重置");
            $user = (new User())->where(['uid=?'],[$uid])->fetch();
            if($user){
                if(is_numeric($forget)){
                    if(empty(RedisConnect::getKey("forget_".$uid))){
                        $this->assign('errMsg', MessageBox::echoDanger("抱歉！您的令牌重置链接已过期<br/>请重新申请重置令牌！",15000));
                    }else if($forget===RedisConnect::getKey("forget_".$uid)){
                        $this->assign("user",$user);
                        $this->assign("forget",$forget);
                        if($password){
                            if(strlen($password)>20){
                                $this->assign('errMsg', MessageBox::echoDanger("令牌格式不合规范！"));
                            }else{
                                if((new User())->where(['uid=:uid'],[':uid'=>$uid])->update(['password'=>md5($password)])>0){
                                    RedisConnect::del("forget_".$uid);
                                    RedisConnect::del("token_".$uid);
                                    RedisConnect::del("atoken_".$uid);
                                    $this->assign("viewpage","login");
                                    $this->assign("TITLE","诗词会-登录");
                                    $this->assign('successMsg', MessageBox::echoSuccess("<strong>恭喜！</strong>您的令牌已重置，请重新登录！"));
                                }else{
                                    $this->assign('errMsg', MessageBox::echoDanger("重置失败！与原令牌相同！"));
                                }
                            }
                        }
                    }else{
                        $flag=false;
                    }
                }else{
                    $flag=false;
                }
            }else{
                $flag=false;
            }
        }
        if(!$flag)
            $this->assign('errMsg', MessageBox::echoDanger("抱歉！您的令牌重置链接不正确<br/>请重新打开邮件内的链接！"));
        $this->render();
        exit();
    }

    public function authDoView(){///status:1 success,2 info,3 warning,4 error,-1 herf
        if(!$this->authUser()){
            echo '{"status":-1,"result":"/user/login?prePage='.$_SERVER['HTTP_REFERER'].'"}';
            exit();
        }
    }

    public function changeavatar(){
        $user=$this->navView("user");
        $this->authDoView();
        $dstwidth=(RedisConnect::getHashKey("basic", "avatarwidth") !== null)?RedisConnect::getHashKey("basic","avatarwidth"):128;
        $crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file'], RedisConnect::getHashKey("basic","useravatar").$user['uid'],$dstwidth,$dstwidth);
        $response = array(
            'state'  => 200,
            'status' => $crop -> getResult()!=null?1:4,
            'imgurl' => $crop -> getResult()."?".rand(),
            'result' => $crop -> getMsg()
        );
        //'result' => $crop -> getMsg()
        echo json_encode($response);
    }

    public function changebanner(){
        $user=$this->navView("user");
        $this->authDoView();
        $dstwidth=(RedisConnect::getHashKey("basic", "bannerwidth") !== null)?RedisConnect::getHashKey("basic","bannerwidth"):800;
        $crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file'], RedisConnect::getHashKey("basic","userbanner").$user['uid'],$dstwidth,$dstwidth/2);
        $response = array(
            'state'  => 200,
            'status' => $crop -> getResult()!=null?1:4,
            'imgurl' => $crop -> getResult()."?".rand(),
            'result' => $crop -> getMsg()
        );
        //'result' => $crop -> getMsg()
        echo json_encode($response);
    }

    public function changeslogan(){
        $user=$this->navView("user");
        $this->authDoView();
        $slogan= trim($_POST['slogan'] ?? '');
        $status=4;
        if($user!=null){
            if($slogan!=$user['slogan']){
                if($user['level']!="-"&&$user['level']!="0"){
                    if(mb_strlen($slogan)>255){
                        $result="个性签名格式不合规范！";
                    }else{
                        if((new User())->where(['uid=:uid'],[':uid'=>$user['uid']])->update(['slogan'=>$slogan])>0){
                            $status=1;
                            $result="用户信息修改成功！";
                        }else{
                            $result="修改用户信息失败！";
                        }
                    }
                }else{
                    $result="用户权限不足，无法修改！";
                }
            }else{
                $status=2;
                $result="信息无修改！";
            }
        }else{
            $result="用户信息提交失败！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function changenickname(){
        $user=$this->navView("user");
        $this->authDoView();
        $nickname= trim($_POST['nickname'] ?? '');
        $status=4;
        if($user!=null){
            if($nickname!=$user['nickname']){
                if($user['level']!="-"&&$user['level']!="0"){
                    if(mb_strlen($nickname)>8){
                        $result="昵称格式不合规范【昵称不得大于8位】！";
                    }else{
                        if((new User())->where(['uid=:uid'],[':uid'=>$user['uid']])->update(['nickname'=>$nickname])>0){
                            $status=1;
                            $result="用户昵称修改成功！";
                        }else{
                            $result="修改用户昵称失败！";
                        }
                    }
                }else{
                    $result="用户权限不足，无法修改！";
                }
            }else{
                $status=2;
                $result="信息无修改！";
            }
        }else{
            $result="用户信息提交失败！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function changeuser(){
        $user=$this->navView("user");
        $this->authDoView();
        $nickname= trim($_POST['nickname'] ?? '');
        $tel= $_POST['tel'] ?? null;
        $email= $_POST['email'] ?? null;
        $password= $_POST['password'] ?? null;
        $password1= $_POST['password1'] ?? null;
        $slogan= trim($_POST['slogan'] ?? '');
        $sex= $_POST['sex'] ?? null;
        $birthday= $_POST['birthday'] ?? null;
        $data['birthday']=null;
        if($birthday&&$birthday!=""){
            $birthday=substr($birthday,0,10)." ".substr($birthday,11);
            if(preg_match("/[0-9]{4}[-,\/][0-9]{1,2}[-,\/][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}(:[0-9]{1,2})?/",$birthday)){
                $data['birthday']=$birthday;
            }
        }
        $status=4;
        if($user!=null&&$email!=null&&$password!=null&&$password!=""&&$sex!=null){
            if($nickname!=$user['nickname']||$tel!=$user['tel']||$email!=$user['email']||($password1!="")||$slogan!=$user['slogan']||$sex!=$user['sex']||$birthday!=$user['birthday']){
                if($user['level']!="-"&&$user['level']!="0"){
                    if($email==""||strlen($email)>255){
                        $result="邮箱格式不合规范！";
                    }elseif(mb_strlen($slogan)>255){
                        $result="个性签名格式不合规范！";
                    }elseif($sex!="0"&&$sex!="1"&&$sex!="2"){
                        $result="性别格式不合规范！";
                    }elseif(md5($password)==$user['password']){
                        $data['sex']=$sex;
                        $data['slogan']=$slogan;
                        $data['nickname']=$nickname;
                        $data['tel']=$tel;
                        $data['email']=$email;
                        if($password1==""||($password1!=""&&$password!=$password1)){
                            if($password1!="")
                                $data['password']=md5($password1);
                            if((new User())->where(['uid=:uid'],[':uid'=>$user['uid']])->update($data)>0){
                                $status=1;
                                $result="用户信息修改成功！";
                            }else{
                                $result="修改用户信息失败！";
                            }
                        }else{
                            $result="修改密码失败，原密码和新密码不能相同！";
                        }
                    }else{
                        $result="原密码错误，用户信息修改失败！";
                    }
                }else{
                    $result="用户权限不足，无法修改！";
                }
            }else{
                $status=2;
                $result="信息无修改！";
            }
        }else{
            $result="用户信息提交失败！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function addLikePoem(){
        $user=$this->navView("user");
        $this->authDoView();
        $pid= $_GET['pid'] ?? null;
        $status=4;
        if($pid&&$user){
            $poem=(new Poem())->where(['pid=:pid','active=:active'],[':pid'=>$pid,':active'=>'1'])->fetch();
            if($poem){
                if($user['level']!="-"&&$user['level']!="0"){
                    if((new User())->addUidPid($user['uid'],$pid)>0){
                        $status=1;
                        $result="收藏诗词成功！";
                    }else{
                        $result="收藏诗词失败！";
                    }
                }else{
                    $result="用户权限不足，无法收藏诗词！";
                }
            }else{
                $result="无法找到诗词！";
            }
        }else{
            $result="诗词编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delLikePoem(){
        $user=$this->navView("user");
        $this->authDoView();
        $pid= $_GET['pid'] ?? null;
        $status=4;
        if($pid&&$user){
            $poem=(new Poem())->where(['pid=:pid','active=:active'],[':pid'=>$pid,':active'=>'1'])->fetch();
            if($poem){
                if($user['level']!="-"&&$user['level']!="0"){
                    if((new User())->delUidPid($user['uid'],$pid)>0){
                        $status=1;
                        $result="诗词移出收藏成功！";
                    }else{
                        $result="诗词移出收藏失败！";
                    }
                }else{
                    $result="用户权限不足，无法将诗词移出收藏！";
                }
            }else{
                $result="无法找到诗词！";
            }
        }else{
            $result="诗词编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function addLikeComment(){
        $user=$this->navView("user");
        $this->authDoView();
        $cid= $_GET['cid'] ?? null;
        $status=4;
        if($cid&&$user){
            $comment=(new Comment())->where(['cid=:cid','active=:active','public=:public'],[':cid'=>$cid,':active'=>'1',':public'=>'1'])->fetch();
            if($comment){
                if($user['level']!="-"&&$user['level']!="0"){
                    if((new User())->addUidCid($user['uid'],$cid)>0){
                        $status=1;
                        $result="收藏评论成功！";
                    }else{
                        $result="收藏评论失败！";
                    }
                }else{
                    $result="用户权限不足，无法收藏评论！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="评论编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delLikeComment(){
        $user=$this->navView("user");
        $this->authDoView();
        $cid= $_GET['cid'] ?? null;
        $status=4;
        if($cid&&$user){
            $comment=(new Comment())->where(['cid=:cid'],[':cid'=>$cid])->fetch();
            if($comment){
                if($user['level']!="-"&&$user['level']!="0"){
                    if((new User())->delUidCid($user['uid'],$cid)>0){
                        $status=1;
                        $result="评论移出收藏成功！";
                    }else{
                        $result="评论移出收藏失败！";
                    }
                }else{
                    $result="用户权限不足，无法将评论移出收藏！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="评论编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function comment(){
        $user=$this->navView("user");
        $this->authDoView();
        $type= $_GET['type'] ?? '';
        $id= $_GET[$type.'id'] ?? null;
        $title= trim($_GET['title'] ?? "");
        $content= $_GET['content'] ?? null;
        $status=4;
        if($id){
            if(trim($content)==""||$content==null){
                $result="评论内容不可为空！";
            }else{
                $obj=null;
                $objName="";
                if($type=='p'){
                    $objName="诗词";
                    $obj=(new Poem())->where(['pid=:pid'],[':pid'=>$id])->fetch();
                }elseif ($type=='c'){
                    $objName="评论";
                    $obj=(new Comment())->where(['cid=:cid'],[':cid'=>$id])->fetch();
                }elseif ($type=='f'){
                    $objName="反馈";
                    $obj=(new Feedback())->where(['fid=:fid'],[':fid'=>$id])->fetch();
                }elseif ($type=='n'){
                    $objName="推送";
                    $obj=(new News())->where(['nid=:nid'],[':nid'=>$id])->fetch();
                }
                if($obj){
                    if($user['level']!="-"&&$user['level']!="0"){
                        $cid=(new Comment())->add(['uid'=>$user['uid'],'type'=>$type,'id'=>$id,'title'=>$title,'content'=>$content]);
                        if($cid>0){
                            if($type=='c')
                                (new Comment())->where(['cid=:cid'],[':cid'=>$id])->update(['commentnumber'=>$obj['commentnumber']+1]);
                            $status=1;
                            $result="恭喜您，评论成功！";
                        }else{
                            $result="评论失败！";
                        }
                    }else{
                        $result="用户权限不足，无法评论！";
                    }
                }else{
                    $result="无法找到待评论的".$objName."！";
                }
            }
        }else{
            $result="编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function feedback(){
        $user=$this->navView("user");
        if($user)
            $this->assign("LoginedUser",$user);
        $type= $_GET['type'] ?? '';
        $id= $_GET['id'] ?? null;
        $title= trim($_GET['title'] ?? "");
        $content= $_GET['content'] ?? null;
        $this->assign("TITLE","诗词会-用户反馈");
        $status=4;
        if($content){
            if($id){
                if(trim($content)==""||$content==null){
                    $result="评论内容不可为空！";
                }else{
                    $obj=null;
                    $objName="";
                    if($type=='p'){
                        $objName="诗词";
                        $obj=(new Poem())->where(['pid=:pid'],[':pid'=>$id])->fetch();
                    }elseif ($type=='c'){
                        $objName="评论";
                        $obj=(new Comment())->where(['cid=:cid'],[':cid'=>$id])->fetch();
                    }elseif ($type=='f'){
                        $objName="反馈";
                        $obj=(new Feedback())->where(['fid=:fid'],[':fid'=>$id])->fetch();
                    }elseif ($type=='n'){
                        $objName="推送";
                        $obj=(new News())->where(['nid=:nid'],[':nid'=>$id])->fetch();
                    }
                    if($obj){
                        if($user['level']!="-"&&$user['level']!="0"){
                            $cid=(new Comment())->add(['uid'=>$user['uid'],'type'=>$type,'id'=>$id,'title'=>$title,'content'=>$content]);
                            if($cid>0){
                                if($type=='c')
                                    (new Comment())->where(['cid=:cid'],[':cid'=>$id])->update(['commentnumber'=>$obj['commentnumber']+1]);
                                $status=1;
                                $result="恭喜您，评论成功！";
                            }else{
                                $result="评论失败！";
                            }
                        }else{
                            $result="用户权限不足，无法评论！";
                        }
                    }else{
                        $result="无法找到待评论的".$objName."！";
                    }
                }
            }else{
                $result="编号错误（数据传输错误）！";
            }
        }else{

        }
        $this->render();
        exit();
    }

    public function hidecomment(){
        $user=$this->navView("user");
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if($comment['uid']==$user['uid']) {
                    if ((new Comment())->where(['cid=:cid'], [':cid' => $cid])->update(['public' => 0]) > 0) {
                        $status = 1;
                        $result = "评论已设置为私密！";
                    } else {
                        $result = "评论设置私密失败！";
                    }
                }else{
                    $result="这不是您的评论，无法设置哦！";
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
        $user=$this->navView("user");
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if($comment['uid']==$user['uid']) {
                    if ((new Comment())->where(['cid=:cid'], [':cid' => $cid])->update(['active' => 0]) > 0) {
                        $status = 1;
                        $result = "评论已删除！";
                    } else {
                        $result = "评论删除失败！";
                    }
                }else{
                    $result="这不是您的评论，无法设置哦！";
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
        $user=$this->navView("user");
        $this->authDoView();
        $cid= $_POST['cid'] ?? null;
        $status=4;
        if($cid){
            $comment=(new Comment())->where(['cid=?'],[$cid])->fetch();
            if($comment){
                if($comment['uid']==$user['uid']){
                    if((new Comment())->where(['cid=:cid'],[':cid'=>$cid])->update(['public'=>1])>0){
                        $status=1;
                        $result="评论公开成功！";
                    }else{
                        $result="评论设置公开失败！";
                    }
                }else{
                    $result="这不是您的评论，无法设置哦！";
                }
            }else{
                $result="无法找到评论！";
            }
        }else{
            $result="信息不可为空！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function addLikeUser(){
        $user=$this->navView("user");
        $this->authDoView();
        $uid= $_GET['uid'] ?? null;
        $status=4;
        if($uid&&$user){
            if($uid!=$user['uid']){
                $likeUser=(new User())->where(['uid=:uid'],[':uid'=>$uid])->fetch();
                if($likeUser){
                    if($likeUser['level']!='-'){
                        if($user['level']!="-"&&$user['level']!="0"){
                            if((new User())->addUidUid($user['uid'],$uid)>0){
                                $status=1;
                                $result="用户关注成功！";
                            }else{
                                $result="用户关注失败！";
                            }
                        }else{
                            $result="用户权限不足，无法关注用户！";
                        }
                    }else{
                        $result="要关注的用户已被封禁，关注失败！";
                    }
                }else{
                    $result="用户不存在，关注失败！";
                }
            }else{
                $status=2;
                $result="不能关注自己哟！";
            }
        }else{
            $result="用户编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }
    public function delLikeUser(){
        $user=$this->navView("user");
        $this->authDoView();
        $uid= $_GET['uid'] ?? null;
        $status=4;
        if($uid&&$user){
            $likeUser=(new User())->where(['uid=:uid'],[':uid'=>$uid])->fetch();
            if($likeUser){
                if($user['level']!="-"&&$user['level']!="0"){
                    if((new User())->delUidUid($user['uid'],$uid)>0){
                        $status=1;
                        $result="用户取关成功！";
                    }else{
                        $result="用户取关失败！";
                    }
                }else{
                    $result="用户权限不足，无法取关用户！";
                }
            }else{
                $result="无法找到用户！";
            }
        }else{
            $result="诗词编号错误（数据传输错误）！";
        }
        echo '{"status":'.$status.',"result":"'.$result.'"}';
    }

    public function likepoem(){
        $user=$this->navView("user");
        $userhome=(new User())->where(['uid=?'],[$_GET['uid']??"0"])->fetch();
        if ($user&&$userhome) {
            $poemConfig=RedisConnect::getHash('poem');
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow,$poemConfig['listnum'],$poemConfig['pagenum']);

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
            foreach ($poems as $i=>$poem){
                $poems[$i]['like']=(new User())->getUidPid($user['uid'],$poem['pid']);
            }
            $navigation = $pager->echoNavPage("/user/likepoem?".$param."pageNow=","likepoem");
            $data['messages']=$pager->echoMessage("<strong>抱歉！</strong> 未查询到收藏的诗词o(╥﹏╥)o",1,1);
        } else {
            $poems = "[]";
            $navigation = "";
            $data['messages']=MessageBox::echoWarning("<strong>抱歉！</strong> 登录有误或此用户不存在！");
        }
        $data['navPage']=$navigation;
        $data['poems']=$poems;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function likecomment(){
        $user=$this->navView("user");
        $userhome=(new User())->where(['uid=?'],[$_GET['uid']??"0"])->fetch();
        if ($user&&$userhome) {
            $commentConfig=RedisConnect::getHash('comment');
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow,$commentConfig['listnum'],$commentConfig['pagenum']);

            $param="";
            $params=$_GET;
            $i=0;
            $where=array();
            $value=array();
            if($user['uid']!=$userhome['uid']){
                $where[$i]="public=?";
                $value[$i++]="1";
            }
            $where[$i]="active=?";
            $value[$i++]="1";
            foreach ($params as $key=>$v){
                if($key=="pageNow"||trim($v)=="")
                    continue;
                $param.=$key."=".$v."&";
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            (new Comment())->where($where,$value)->getCommentLikedUser($pager);
            $comments=$pager->arr;
            foreach ($comments as $i=>$comment){
                $comments[$i]['like']=(new User())->getUidCid($user['uid'],$comment['cid']);
            }
            $navigation = $pager->echoNavPage("/user/likecomment?".$param."pageNow=","likecomment");
            $data['messages']=$pager->echoMessage("<strong>抱歉！</strong> 未查询到收藏的评论o(╥﹏╥)o",1,1);
        } else {
            $comments = "[]";
            $navigation = "";
            $data['messages']=MessageBox::echoWarning("<strong>抱歉！</strong> 登录有误或此用户不存在！");
        }
        $data['navPage']=$navigation;
        $data['comments']=$comments;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function commentlist(){
        $user=$this->navView("user");
        $userhome=(new User())->where(['uid=?'],[$_GET['uid']??"0"])->fetch();
        if ($user&&$userhome) {
            $commentConfig=RedisConnect::getHash('comment');
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow,$commentConfig['listnum'],$commentConfig['pagenum']);

            $param="";
            $params=$_GET;
            $i=0;
            $where=array();
            $value=array();
            if($user['uid']!=$userhome['uid']){
                $where[$i]="public=?";
                $value[$i++]="1";
            }
            $where[$i]="active=?";
            $value[$i++]="1";
            foreach ($params as $key=>$v){
                if($key=="pageNow"||trim($v)=="")
                    continue;
                $param.=$key."=".$v."&";
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            (new Comment())->where($where,$value)->getCommentList($pager);
            $comments=$pager->arr;
            foreach ($comments as $i=>$comment){
                $comments[$i]['like']=(new User())->getUidCid($user['uid'],$comment['cid']);
            }
            $navigation = $pager->echoNavPage("/user/commentlist?".$param."pageNow=","commentlist");
            $data['messages']=$pager->echoMessage("<strong>抱歉！</strong> 未查询到评论o(╥﹏╥)o",1,1);
        } else {
            $comments = "[]";
            $navigation = "";
            $data['messages']=MessageBox::echoWarning("<strong>抱歉！</strong> 登录有误或此用户不存在！");
        }
        $data['navPage']=$navigation;
        $data['comments']=$comments;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function likeuser(){
        $user=$this->navView("user");
        $userhome=(new User())->where(['uid=?'],[$_GET['uid']??"0"])->fetch();
        if ($user&&$userhome) {
            $userConfig=RedisConnect::getHash('user');
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow,$userConfig['listnum'],$userConfig['pagenum']);

            $param="";
            $params=$_GET;
            $i=0;
            $where=array();
            $value=array();
            $where[$i]="level!=?";
            $value[$i++]="-";
            foreach ($params as $key=>$v){
                if($key=="pageNow"||trim($v)=="")
                    continue;
                $param.=$key."=".$v."&";
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            (new User())->where($where,$value)->getLikeUser($pager);
            $users=$pager->arr;
            foreach ($users as $i=>$useritem){
                $users[$i]['like']=(new User())->getUidUid($user['uid'],$useritem['likeuid']);
                $users[$i]['avatar']=Func::getAvatar($useritem['likeuid']);
            }
            $navigation = $pager->echoNavPage("/user/likeuser?".$param."pageNow=","like");
            $data['messages']=$pager->echoMessage("<strong>抱歉！</strong> 未查询到关注的用户o(╥﹏╥)o",1,1);
        } else {
            $users = "[]";
            $navigation = "";
            $data['messages']=MessageBox::echoWarning("<strong>抱歉！</strong> 用户登录有误！");
        }
        $data['navPage']=$navigation;
        $data['users']=$users;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    public function likeduser(){
        $user=$this->navView("user");
        $userhome=(new User())->where(['uid=?'],[$_GET['uid']??"0"])->fetch();
        if ($user&&$userhome) {
            $userConfig=RedisConnect::getHash('user');
            $pageNow=empty($_GET['pageNow'])||!is_numeric($_GET['pageNow'])?1:$_GET['pageNow'];
            $pager=new Pager($pageNow,$userConfig['listnum'],$userConfig['pagenum']);

            $param="";
            $params=$_GET;
            $i=0;
            $where=array();
            $value=array();
            $where[$i]="level!=?";
            $value[$i++]="-";
            foreach ($params as $key=>$v){
                if($key=="pageNow"||trim($v)=="")
                    continue;
                $param.=$key."=".$v."&";
                $where[$i]="$key=?";
                $value[$i++]=$v;
            }
            (new User())->where($where,$value)->getLikedUser($pager);
            $users=$pager->arr;
            foreach ($users as $i=>$useritem){
                $users[$i]['like']=(new User())->getUidUid($user['uid'],$useritem['likeduid']);
                $users[$i]['avatar']=Func::getAvatar($useritem['likeduid']);
            }
            $navigation = $pager->echoNavPage("/user/likeduser?".$param."pageNow=","liked");
            $data['messages']=$pager->echoMessage("<strong>抱歉！</strong> 未查询到您的粉丝o(╥﹏╥)o",1,1);
        } else {
            $users = "[]";
            $navigation = "";
            $data['messages']=MessageBox::echoWarning("<strong>抱歉！</strong> 用户登录有误！");
        }
        $data['navPage']=$navigation;
        $data['users']=$users;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function logout(){
        $uid= $_COOKIE['uid'] ?? '';
        $key='token_'.$uid;
        $token=$_COOKIE[$key]??null;
        if($token&&$token===RedisConnect::getKey($key)){
            $_COOKIE['uid']="";
            $_COOKIE[$key]="";
            RedisConnect::del($key);
        }
        header("location:".$_SERVER['HTTP_REFERER']);
    }
}
