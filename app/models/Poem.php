<?php
namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;

class Poem extends Model
{
/*
    public $pid;//bigint 20
    public $did;//bigint 20
    public $title;//string 255
    public $content;//string
    public $likenumber;//bigint 20 =0
    public $commentnumber;//bigint 20 =0
    public $active;//bool =1
*/

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 poem 表
     * @var string
     */
    protected $table = 'Poem';
    // 数据库主键
    protected $primary = 'pid';

    public function getPoem($pid){
        $sql="select * from `getPoem` where `pid` = ?";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$pid]);
        $sth->execute();
        return $sth->fetch();
    }

    public function getPoemLikedUser($pager){
        $arrSql="select * from `getPoemLikedUser`";
        $countSql="select count(pid) `count` from `getPoemLikedUser`";
        $this->execute_page($pager,$arrSql,$countSql);
    }

    public function getPoemList($pager){
        $arrSql="select * from `getPoem`";
        $countSql="select count(pid) `count` from `getPoem`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
}
