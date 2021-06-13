<?php

namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;

class Comment extends Model
{
    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 user 表
     * @var string
     */
    protected $table = 'comment';
    // 数据库主键
    protected $primary = 'cid';

    public function getComment($cid){
        $sql="select * from `getComment` where `cid` = ?";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$cid]);
        $sth->execute();
        return $sth->fetch();
    }
    public function getCommentList($pager){
        $arrSql="select * from `getComment`";
        $countSql="select count(cid) `count` from `getComment`";
        $this->execute_page($pager,$arrSql,$countSql);
    }

    public function getCommentLikedUser($pager){
        $arrSql="select * from `getCommentLikedUser`";
        $countSql="select count(cid) `count` from `getCommentLikedUser`";
        $this->execute_page($pager,$arrSql,$countSql);
    }


}