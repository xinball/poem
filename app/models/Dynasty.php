<?php

namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;



class Dynasty extends Model
{

    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 dynasty 表
     * @var string
     */
    protected $table = 'dynasty';
    // 数据库主键
    protected $primary = 'did';

    public function getDynastyList($pager){
        $arrSql="select * from `getDynasty`";
        $countSql="select count(did) `count` from `getDynasty`";
        $this->execute_page($pager,$arrSql,$countSql);
    }
}