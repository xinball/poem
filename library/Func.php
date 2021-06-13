<?php


namespace library;


class Func
{
    static public function sendMail($test="xinball@qq.com",$subject="测试",$body="<b>测试</b>",$file="")
    {
        $mail = new Smtp();

        $mail->setServer("smtp.exmail.qq.com", "zhouqing@xinball.top", "Zst000528,", 465, true); //参数1（qq邮箱使用smtp.qq.com，qq企业邮箱使用smtp.exmail.qq.com），参数2（邮箱登陆账号），参数3（邮箱登陆密码，也有可能是独立密码，就是开启pop3/smtp时的授权码），参数4（默认25，腾云服务器屏蔽25端口，所以用的465），参数5（是否开启ssl，用465就得开启）//$mail->setServer("XXXXX", "joffe@XXXXX", "XXXXX", 465, true);
        $mail->setFrom("zhouqing@xinball.top","信球网"); //发送者邮箱
        $mail->setReceiver($test); //接收者邮箱
        $mail->addAttachment($file); //Attachment 附件，不用可注释
        $mail->setMail($subject, $body); //标题和内容
        $mail->send();//可以var_dump一下，发送成功会返回true，失败false
    }
    static public function getAvatar($uid){
        $basicConfig=RedisConnect::getHash("basic");
        $default=($basicConfig['defaultavatar'] ?? "/img/favicon.png");
        if(isset($uid)){
            $href=($basicConfig['useravatar'] ?? "/img/user/").$uid.".png";
            if(is_file(APP_PATH.$href)){
                return $href."?".rand();
            }
        }
        return $default."?".rand();
    }
    static public function getBanner($uid){
        $basicConfig=RedisConnect::getHash("basic");
        $default=($basicConfig['defaultbanner'] ?? "/img/banner/redchina.png");
        if(isset($uid)){
            $href=($basicConfig['userbanner'] ?? "/img/banner/").$uid.".png";
            if(is_file(APP_PATH.$href)){
                return $href."?".rand();
            }
        }
        return $default."?".rand();
    }
    static public function getIp() {
        $ch = curl_init('http://www.ip138.com/ip2city.asp');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $a  = curl_exec($ch);
        preg_match('/[(.*)]/', $a, $ip);
        if($ip==null||$ip[1]==null||$ip[1]==''){
            $realIp="";
            if (isset($_SERVER)){
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    $realIp = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $realIp = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $realIp = $_SERVER["REMOTE_ADDR"];
                }
            } else {
                if (getenv("HTTP_X_FORWARDED_FOR")){
                    $realIp = getenv("HTTP_X_FORWARDED_FOR");
                } else if (getenv("HTTP_CLIENT_IP")) {
                    $realIp = getenv("HTTP_CLIENT_IP");
                } else {
                    $realIp = getenv("REMOTE_ADDR");
                }
            }
            return $realIp;
        }else{
            return $ip[1];
        }
    }
}