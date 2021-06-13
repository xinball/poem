<style>
</style>

<link href="/static/css/comment.css" rel="stylesheet">
</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="commentModalLabel">发布评论</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="commentmsg"></div>
            <div class="modal-body">
                <form id="comment" action="" method="post">
                    <input type="hidden" name="idModal" id="idModal">
                    <input type="hidden" name="typeModal" id="typeModal">
                    <div class="form-group">
                        <label for="titleModal" class="control-label">评论标题</label>
                        <input type="text" class="form-control" id="titleModal" name="titleModal" placeholder="请键入评论标题【选填】"/>
                    </div>
                    <div class="form-group">
                        <label for="contentModal" class="control-label">评论内容</label>
                        <textarea id="contentModal" name="contentModal" class="form-control" style="resize: none;" rows="3" placeholder="请键入评论内容【必填】" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" onclick="comment()" id="commentBtn" name="commentBtn">发布</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>
<?php
use library\MessageBox;
use app\models\User;

?>
<div class="row" style="width: 100%;margin: 0;">
    <div class="col-sm-8" style="padding: 0;">
        <div class="poem">
            <?php
            if(isset($comment)){
                $pre='<div class="card" style="width: 100%;">';
                if($comment['type']=='p'){
                    $pre .= '<h5>被评论的内容为 诗词</h5>';
                    if(isset($preObj)){
                        $pre.= '<p style="font-family: STXINGKA,serif;font-size: 24px; "><a href="/poem?pid='.$preObj['pid'].'" target="_blank">#'.$preObj['pid'].' '.$preObj['title'].'</a></p>'.
                            "<p style='font-family: SIMLI ,serif; font-size: 20px;'>【<a href=\"/poem/list?did=".$preObj['did']."\" target='_blank'>".$preObj['dname']."</a>】&nbsp;&nbsp;<a href=\"/poem/list?aid=".$preObj['aid']."\" target='_blank'>".$preObj['aname']."</a></p>".
                            "<div style='font-family: SIMKAI ,serif; font-size: 16px;'>".mb_substr($preObj['content'],0,15)."</div>";
                    }else{
                        $pre.='诗词可能被隐藏或删除';
                    }
                }elseif($comment['type']=='c'){
                    $pre .= '<h5>被评论的内容为 评论</h5>';
                    if(isset($preObj)){
                        $pre.= '<p style="font-family: STXINGKA,serif;font-size: 24px; "><a href="/comment?cid='.$preObj['cid'].'" target="_blank">'.$preObj['title'].'</a></p>'.
                            '<p style="font-family: SIMLI ,serif; font-size: 20px;"><a href="/user/home/'.$preObj['uid'].'" target="_blank">'.$preObj['uname'].'</a><span class="badge bg-secondary text-light">'.$preObj['nickname'].'</span></p>'.
                            '<div style="font-family: SIMKAI ,serif; font-size: 16px;"><a href="/comment?cid='.$preObj['cid'].'" target="_blank">'.mb_substr($preObj['content'],0,15).'</a></div>';
                    }else{
                        $pre.='评论可能被隐藏或删除';
                    }
                }elseif($comment['type']=='f'){
                    $pre .= '<h5>被评论的内容为 反馈</h5>';
                }elseif($comment['type']=='n'){
                    $pre .= '<h5>被评论的内容为 推送</h5>';
                    if(isset($preObj)){
                        $pre.= '<p style="font-family: STXINGKA,serif;font-size: 24px; ">'.$preObj['title'].'  <small>'.$preObj['subtitle'].'</small></p>'.
                            '<p style="font-family: SIMLI ,serif; font-size: 20px;"><a href="/user/home/'.$preObj['uid'].'" target="_blank">'.$preObj['uname'].'</a><span class="badge bg-secondary text-light">'.$preObj['nickname'].'</span></p>'.
                            '<div style="font-family: SIMKAI ,serif; font-size: 16px;"><a href="/comment?cid='.$preObj['nid'].'" target="_blank">'.mb_substr($preObj['content'],0,15).'</a></div>';
                    }else{
                        $pre.='推送可能被隐藏或删除';
                    }
                }
                $pre.='</div>';
                echo $pre;
                echo '<p class="poemtitle" style="font-size: 36px;">'.$comment['title'].'</p>'.
                    '<p class="poemauthor" style="font-size: 20px;"><a href="/user/home/'.$comment['uid'].'" target="_blank">'.$comment['uname'].'</a><span class="badge bg-secondary text-light">'.$comment['nickname'].'</span></p>'.
                    '<p class="poemcontent" style="font-size: 18px;">'.$comment['content'].'</p>'.
                '<h6><small>'.$comment['sendtime'].'</small></h6>
                <div class="btn-group poemBtn" role="group" aria-label="...">
                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#commentModal" data-type="c" data-cid="'.$comment['cid'].'">
                        <span id="commentnumber">'.$comment['commentnumber'].'</span> <i class="bi bi-reply-fill"></i></i>
                    </button>
                    <button style="display:'.(!isset($comment['like'])||$comment['like']==0?"unset":"none").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="addlikepoem(this)" id="addlikepoem">
                        <span id="addlikenumber">'.$comment['likenumber'].'</span> <i class="bi bi-heart"></i>
                    </button>
                    <button style="display:'.(!isset($comment['like'])||$comment['like']==0?"none":"unset").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="dellikepoem(this)" id="dellikepoem">
                        <span id="dellikenumber">'.$comment['likenumber'].'</span> <i class="bi bi-heart-fill"></i>
                    </button>'.
                    (isset($user)&&$user['uid']==$comment['uid']?
                '<button style="display:'.($comment['public']=='0'?"unset":"none").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="displaycomment(this)" id="displaycomment'.$comment['cid'].'">'.
                '   <i class="bi bi-toggle-off"></i>'.
                '</button>'.
                '<button style="display:'.($comment['public']=='0'?"none":"unset").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="hidecomment(this)" id="hidecomment'.$comment['cid'].'">'.
                '   <i class="bi bi-toggle-on"></i>'.
                '</button>'.
                '<button type="button" class="btn btn-outline-danger" onclick="delcomment(this);" value='.$comment['cid'].'><i class="bi bi-trash"></i></button>':'').
                    '<button type="button" class="btn btn-outline-secondary" id="feedbackBtn">
                        <i class="bi bi-tools"></i>
                    </button>
                </div>';
            }else{

            }
            ?>
        </div>
        <div class="comment">
            <?php echo $message ?? "";?>
            <?php if(isset($comments)){foreach ($comments as $i=>$comment){
                $commentContent=($comment['content']==""?"什么评论都没有留下~":$comment['content']);
                $userBtnColor=($comment['sex']=='0'?"danger":($comment['sex']=='1'?"info":"secondary"));
                $commentTitle='<h5 class="card-title" style="text-align: left;font-weight: bold;"><a href="/comment?cid='.$comment['cid'].'" target="_blank"><span class="badge rounded-pill btn-'.$userBtnColor.'">#'.$comment['cid']."</span></a> ".($comment['title']==""?"":$comment['title']).'</h5>';

                $time="";
                $sec = strtotime(date("Y-m-d H:i:s",time()))-(strtotime($comment['sendtime']));
                $min=$sec/60;$hour=$min/60;$day=$hour/24;
                if($sec<60){
                    $time.=((int)$sec)." 秒钟前";
                }elseif ($min<60){
                    $time.=(int)$min." 分钟前";
                }elseif ($hour<24){
                    $time.=(int)$hour." 小时前";
                }elseif ($day<30){
                    $time.=(int)$day." 天前";
                }else{
                    $time.=$comment['sendtime'];
                }
                ?>

                <div class="card commentcard" id="comment<?php echo $comment['cid'];?>">
                    <div class="card-body">
                        <div class="commentUser">
                            <a tabindex="0" style="padding: 3px;width: 100%;" class="btn btn-lg btn-outline-<?php echo $userBtnColor;?>" role="button" target="_blank" href="/user/home/<?php echo $comment['uname'];?>">
                                <img src="<?php echo $comment['avatar']; ?>" width="75%"><br/>
                                <span value="<?php echo $userBtnColor;?>" id="commentName<?php echo $comment['cid'];?>"><?php echo $comment['uname'];?></span>
                            </a>
                        </div>
                        <div class="commentContent">
                            <?php echo $commentTitle;?>
                            <div class="card-text" style="text-align: left;font-size: 18px;"><xmp style="white-space: normal;"><?php echo $commentContent;?></xmp></div>
                            <div class="card-text">
                                <div style="float: left;line-height: 34px;font-size: 14px;"><small class="text-muted"><?php echo $time;?></small></div>
                                <div class="btn-group commentBtn" style="float: right;" role="group" aria-label="...">
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#commentModal" data-type="c" data-cid="<?php echo $comment['cid'] ?>">
                                        &nbsp;<i class="bi bi-reply-fill"></i>&nbsp;
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" value="close" data-cid="<?php echo $comment['cid'] ?>" data-pagenow="1" onclick="getcomment(this)" id="getcomment<?php echo $comment['cid']; ?>">
                                        <span id="commentnumber<?php echo $comment['cid']; ?>"><?php echo $comment['commentnumber'];?></span> <i class="bi bi-chat-square-text"></i>
                                    </button>
                                    <button style="display:<?php echo !isset($comment['like'])||$comment['like']==0?"unset":"none"; ?>;" type="button" class="btn btn-outline-danger btn-like" value="<?php echo $comment['cid'] ?>" onclick="addlikecomment(this)" id="addlikecomment<?php echo $comment['cid']; ?>">
                                        <span id="addlikenumber<?php echo $comment['cid']; ?>"><?php echo $comment['likenumber'];?></span> <i class="bi bi-heart"></i>
                                    </button>
                                    <button style="display:<?php echo !isset($comment['like'])||$comment['like']==0?"none":"unset"; ?>;" type="button" class="btn btn-outline-danger btn-like" value="<?php echo $comment['cid'] ?>" onclick="dellikecomment(this)" id="dellikecomment<?php echo $comment['cid']; ?>">
                                        <span id="dellikenumber<?php echo $comment['cid']; ?>"><?php echo $comment['likenumber'];?></span> <i class="bi bi-heart-fill"></i>
                                    </button>
                <?php if(isset($user)&&$user['uid']==$comment['uid']){
                    echo '<button style="display:'.($comment['public']=='0'?"unset":"none").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="displaycomment(this)" id="displaycomment'.$comment['cid'].'">'.
                        '   <i class="bi bi-toggle-off"></i>'.
                        '</button>'.
                        '<button style="display:'.($comment['public']=='0'?"none":"unset").';" type="button" class="btn btn-outline-danger btn-like" value="'.$comment['cid'].'" onclick="hidecomment(this)" id="hidecomment'.$comment['cid'].'">'.
                        '   <i class="bi bi-toggle-on"></i>'.
                        '</button>'.
                        '<button type="button" class="btn btn-outline-danger" onclick="delcomment(this);" value='.$comment['cid'].'><i class="bi bi-trash"></i></button>';
                }?>
                                    <button type="button" class="btn btn-outline-secondary" value="<?php echo $comment['cid'] ?>"  onclick="feedbackComment(this)">
                                        <i class="bi bi-tools"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ccomment<?php echo $comment['cid'];?>"></div>
                </div>
            <?php }}?>
            <?php echo $navigation ?? "";?>
        </div>
    </div>
    <div class="col-sm-4" style="padding: 0;">
        <div class="recommend">
            <p>推荐</p>
        </div>
    </div>
</div>


<script>

    function addlikepoem(obj){
        $.getJSON("/user/addLikeComment?cid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikepoem').show();
                $('#addlikepoem').hide();
                $('#addlikenumber').text(parseInt($('#addlikenumber').text())+1);
                $('#dellikenumber').text(parseInt($('#dellikenumber').text())+1);
            }
        });
    }
    function dellikepoem(obj){
        $.getJSON("/user/delLikeComment?cid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikepoem').hide();
                $('#addlikepoem').show();
                $('#addlikenumber').text(parseInt($('#addlikenumber').text())-1);
                $('#dellikenumber').text(parseInt($('#dellikenumber').text())-1);
            }
        });
    }
    function addlikecomment(obj){
        $.getJSON("/user/addLikeComment?cid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikecomment'+$(obj).val()).show();
                $('#addlikecomment'+$(obj).val()).hide();
                $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())+1);
                $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())+1);
            }
        });
    }
    function dellikecomment(obj){
        $.getJSON("/user/delLikeComment?cid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikecomment'+$(obj).val()).hide();
                $('#addlikecomment'+$(obj).val()).show();
                $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())-1);
                $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())-1);
            }
        });
    }

</script>
