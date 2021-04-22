<style>
    .poem{
        position: relative;
        text-align: center;
        padding: 10px;
    }
    .recommend{
        position: relative;
        text-align: center;
    }
    .comment{
        text-align: center;
        position: relative;
    }
    .editor #title {
        text-align: center;
        font-size: 20px;
    }
    .editor #comment{
        font-size: 18px;
    }
    .editor .btn-success{
        font-size: 20px;
    }
</style>

</head>
<body>

<div class="poem col-md-8">
<?php
if(isset($poem)){
    echo "<h2 style='font-family: STXINGKA,serif; '>".$poem['title']."</h2>".
    "<h4 style='font-family: SIMLI ,serif; '>【<a href=\"/poem/list?did=".$poem['did']."\">".$poem['dname']."</a>】&nbsp;&nbsp;<a href=\"/poem/list?aid=".$poem['aid']."\">".$poem['aname']."</a></h4>".
    "<p style='font-family: SIMKAI ,serif; font-size: 18px;'>".$poem['content']."</p>";
}
?>
</div>
<div class="recommend col-md-4">
    <p>推荐</p>
</div>
<div class="comment  col-md-8">
    <p>评论</p>
    <div class="editor" class="form-horizontal">
        <form onsubmit="return comment();">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="请键入评论标题【选填】"/>
            </div>
            <div class="form-group">
                <textarea id="comment" class="form-control" style="resize: none;" rows="3" placeholder="请键入评论内容【必填】" required></textarea>
            </div>
            <button class="btn btn-success" type="submit">提交</button>
        </form>
    </div>
</div>


<?php if(is_file(APP_PATH."/static/music/".$poem['pid'].".js")){?>
<!--音乐播放器-->
<div class="alert alert-info alert-dismissible" style="position: fixed;width: 100%;" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>注意!</strong> 双击播放器区域可以切换模式哟(〃'▽'〃)
</div>
<div  class="music" style="opacity:0.9;z-index:1000;position:fixed;top:75%;left:-18px;"></div>
<script src="/static/xbmplayer/xbmplayer.min.js"></script>
<script src="/static/music/<?php echo $poem['pid'];?>.js"></script>
<?php }?>
<script>
    function comment(){
        if(!$('#comment').val()){
            return false;
        }

    }
</script>
