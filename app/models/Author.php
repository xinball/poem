<?php

namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;



class Author extends Model
{

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 author 表
     * @var string
     */
    protected $table = 'author';
    // 数据库主键
    protected $primary = 'aid';

    public function getDynastyAuthorCount(){
        $sql="select authorcount value,dname name from `getDynasty` where active='1' order by authorcount DESC";
        $sth = Db::pdo()->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function getAuthorCountByDid($did){
        $sql="select count(aid) value from `author` where author.active='1' and author.did=?";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$did]);
        $sth->execute();
        return $sth->fetch();
    }
    public function getDidByAid($aid){
        $sql="select did from `author` where aid=?";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$aid]);
        $sth->execute();
        return $sth->fetch()['did'];
    }

    public function getAuthorList($pager){
        $arrSql="select * from `getAuthor`";
        $countSql="select count(did) `count` from `getAuthor`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
    public function getAuthorCount(){
        $sql="select count(aid) value from `author` where active='1'";
        $sth = Db::pdo()->prepare($sql);
        $sth->execute();
        return $sth->fetch();
    }

}