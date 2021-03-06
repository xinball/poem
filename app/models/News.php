<?php


namespace app\models;

use xbphp\base\Model;
use xbphp\db\Db;


class News extends Model
{
    /**
     * 自定义当前模型操作的数据库表名称，
     * 如果不指定，默认为类名称的小写字符串，
     * 这里就是 news 表
     * @var string
     */
    protected $table = 'news';
    protected $primary = 'nid';


}