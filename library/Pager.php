<?php

namespace library;

class Pager
{
    public $arr;//显示数据
    public $rowCount;//数据库获取

    public $pageSize=8;
    public $pageCount;//计算所得

    public $pageNow;//用户指定

    /**
     * Pager constructor.
     * @param $pageNow
     * @param $navigation
     */
    public function __construct($pageNow,$pageSize=8)
    {
        $this->pageNow = $pageNow;
        $this->pageSize = $pageSize;
    }
    public function echoMessage():string
    {
        if($this->pageCount==0){
            return
                '<div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>抱歉！</strong> 未查询到符合条件的记录o(╥﹏╥)o
                </div>';
        }
        $ps="";
        if($this->pageCount>RedisConnect::getHash("poem")['pagenum'])
            $ps="<br/>页面太多了？底部页码处输入页数快速到达ლ(╹◡╹ლ)！";
        return
            '<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                我们为您找到了 <strong>'.$this->rowCount.'</strong> 条符合条件的记录ヾ(^∀^)ﾉ<br/>
                当前为第 '.$this->pageNow.' 页，共分为 '.$this->pageCount.' 页'.$ps.'
            </div>';
    }
    public function echoNavigation($navigation): string
    {
        if($this->pageCount==0){
            return "";
        }
        $this->pageNow=$this->pageNow>$this->pageCount?$this->pageCount:$this->pageNow;
        $pagination="";
        $pager="";
        $pagenum=RedisConnect::getHash("poem")['pagenum'];
        $pagenum1=(int)($pagenum/2);
        $preCount=$this->pageNow>$pagenum1?$this->pageNow-$pagenum1:1;
        $nextCount=$preCount+$pagenum-1<$this->pageCount?$preCount+$pagenum-1:$this->pageCount;
        if($preCount-$pagenum1-1>0)
            $pagination.='<li><a href="'.$navigation.($preCount-$pagenum1-1).'"><<</a></li>';
        else
            $pagination.='<li><a href="'.$navigation.'1"><<</a></li>';
        for($i=$preCount;$i<$this->pageNow;++$i){
            $pagination.='<li><a href="'.$navigation.$i.'">'.$i.'</a></li>';
        }
        $pagination.='<li class="active"><span style="height: 34px;"><label><input id="pageTo" type="number" value="'.$i.'" min="1" max="'.$this->pageCount.'" />/<span style="font-size:12px;">'.$this->pageCount.'</span></label><span></li>';
        for($i=$this->pageNow+1;$i<=$nextCount;++$i){
            $pagination.='<li><a href="'.$navigation.$i.'">'.$i.'</a></li>';
        }
        if($nextCount+$pagenum1+1<$this->pageCount)
            $pagination.='<li><a href="'.$navigation.($nextCount+$pagenum1+1).'">>></a></li>';
        else
            $pagination.='<li><a href="'.$navigation.$this->pageCount.'">>></a></li>';

        if($this->pageNow>1){
            $pager.='<li class="previous"><a href="'.$navigation.($this->pageNow-1).'">上一页</a></li>';
        }else{
            $pager.='<li class="previous disabled"><span>上一页</span></li>';
        }
        if($this->pageNow<$this->pageCount){
            $pager.='<li class="next"><a href="'.$navigation.($this->pageNow+1).'">下一页</a></li>';
        }else{
            $pager.='<li class="next disabled"><span>下一页</span></li>';
        }

        return
        '<nav aria-label="Page navigation">
              <ul class="pagination">
              '.$pagination.'
              </ul>
         </nav>
         <nav aria-label="Page navigation">
          <ul class="pager">
              '.$pager.'
          </ul>
         </nav>
         <script>
        $("#pageTo").keydown(function(e){
            if (e.which === 13) {
                window.location.href="'.$navigation.'"+$("#pageTo").val();
            }
        });
        </script>';
    }
}