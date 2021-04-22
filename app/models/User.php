<?php
namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;
/**
 * 用户Model
 */
class User extends Model{
/*
    public $uid;//bigint 20
    public $uname;//string 20
    public $password;//string 255
    public $nickname;//string 255
    public $email;//string 255
    public $tel;//string 20
    public $slogan;//string 255
    public $sex;//bool
    public $birthday;//DateTime
    public $regtime;//DateTime
    public $regip;//string 20
    public $likepoemnumber;//bigint 20 =0
    public $likecommentnumber;//bigint 20 =0
    public $commentnumber;//bigint 20 =0
    public $likeusernumber;//bigint 20 =0
    public $likedusernumber;//bigint 20 =0
    public $sid;//bigint 20 =0
    public $avatar;//string 10 =".png"
    public $assets;//int =0
    public $exp;//int =0
    public $level;//char =1
*/
    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 user 表
     * @var string
     */
    protected $table = 'user';
    // 数据库主键
    protected $primary = 'uid';



    public function checkUser($uname,$password,&$uid): bool
    {
        $sql="select uid,password from `$this->table` where `uname`=:uname";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [':uname' => "$uname"]);
        $sth->execute();
        $user=$sth->fetch();
        $uid=$user['uid'];
        if(md5($password)==$user['password']){
            return true;
        }
        return false;
    }

    public function deleteUser(){

    }

    public function getLikeUser($pager){
        $arrSql="select * from `getLikeUser`";
        $countSql="select count(likeuid) `count` from `getLikeUser`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
    public function getLikedUser($pager){
        $arrSql="select * from `getLikedUser`";
        $countSql="select count(likeduid) `count` from `getLikedUser`";
        $this->execute_page($pager,$arrSql,$countSql);
    }

    public function getUserLikePoem($pager){
        $arrSql="select * from `getUserLikePoem`";
        $countSql="select count(uid) `count` from `getUserLikePoem`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
    public function getUserLikeComment($pager){
        $arrSql="select * from `getUserLikeComment`";
        $countSql="select count(uid) `count` from `getUserLikeComment`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
}
