
<link href="/static/cropper/dist/cropper.min.css" rel="stylesheet">
<link href="/static/cropper/css/home.css" rel="stylesheet">
<style>
</style>
</head>
<body>
    
    
    
<?php include APP_PATH . "/app/views/header.php" ?>



<div class="container justify-content-center" style="max-width: 950px;">
<?php if(isset($userhome)){
    $likedusernumber=$userhome['likedusernumber'];
    $likeusernumber=$userhome['likeusernumber'];
    $commentnumber=$userhome['commentnumber'];
    $likepoemnumber=$userhome['likepoemnumber'];
    $likecommentnumber=$userhome['likecommentnumber'];
    /*if($likedusernumber<10000){
    }elseif($likedusernumber<100000000){
        $likedusernumber=($likedusernumber/10000).($likedusernumber/1000)."万";
    }*/
    ?>
    <div class="modal fade" tabindex="-1" id="sloganModal" tabindex="-1" aria-labelledby="sloganModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php echo $userhome['uname'];?> 的个性签名</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <?php if(isset($user)&&$userhome['uid']==$user['uid']){?>
                <div class="modal-body">
                    <textarea id="slogan" class="form-control" rows="6" style="resize: none;"><?php echo $userhome['slogan'];?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" onclick="return saveslogan();">保存</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">关闭</button>
                </div>
              <?php }else{?>
                <div class="modal-body">
                    <p><?php echo $userhome['slogan']==""?"还没有个性签名哟~":$userhome['slogan'];?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">关闭</button>
                </div>
              <?php }?>
        </div>
      </div>
    </div>
    <div class="modal fade" tabindex="-1" id="nicknameModal" tabindex="-1" aria-labelledby="nicknameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $userhome['uname'];?> 的个人信息</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>昵称：<?php echo $userhome['nickname']==""?"还没有设置昵称哟~":$userhome['nickname'];?></p>
                    <p>邮箱：<?php echo $userhome['email'];?></p>
                    <p>手机：<?php echo $userhome['tel'];?></p>
                    <p>资产：<?php echo $userhome['assets'];?></p>
                    <p>经验：<?php echo $userhome['exp'];?></p>
                    <p>性别：<?php echo $userhome['sex']=="0"?"女":($userhome['sex']=="1"?"男":"未知");?></p>
                    <p>出生日期：<?php echo $userhome['birthday'];?></p>
                    <p>注册日期：<?php echo $userhome['regtime'];?></p>
                    <p>用户级别：<?php echo $userhome['level'];?></p>
                    <?php if(isset($user)&&$user['uid']==$userhome['uid']){?>
                        <a href="/user/" target="_blank" class="btn btn-outline-danger btn-like">修改信息</a>
                    <?php }?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>

    <div class="crop-banner" id="crop-banner">
        <?php if(isset($user)&&$userhome['uid']==$user['uid']){?>
            <!-- Current avatar -->
            <div class="banner-view" title="更换横幅">
                <img src="<?php echo $userhome['banner']; ?>" style="width: 100%;">
            </div>
            <!-- Cropping modal -->
            <div class="modal fade" id="banner-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="avatar-form" action="/user/changebanner" enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <h4 class="modal-title" id="avatar-modal-label">横幅更换</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                        <label for="avatarInput">本地上传</label>
                                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="avatar-preview preview-banner-lg"></div>
                                            <div class="avatar-preview preview-banner-md"></div>
                                            <div class="avatar-preview preview-banner-sm"></div>
                                        </div>
                                    </div>

                                    <div class="row avatar-btns">
                                        <div class="col-md-9">
                                            <div class="btn-group">
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">-90°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-15" type="button">-15°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-30" type="button">-30°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-45" type="button">-45°</button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">+90°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="15" type="button">15°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="30" type="button">30°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="45" type="button">45°</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-outline-success btn-block avatar-save" type="submit">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                              <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->

                  <!-- Loading state -->
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
        <?php }else{?>
            <div class="banner-view" >
                <img src="<?php echo $userhome['banner']; ?>" style="width: 100%;">
            </div>
        <?php }?>

    </div>


    <div class="crop-avatar" id="crop-avatar" style="margin-top: -84px;padding: 0;">
        <div style="display: flex;background: #000000a0;padding: 5px;">
        <?php if(isset($user)&&$userhome['uid']==$user['uid']){?>
            <!-- Current avatar -->
            <div class="avatar-view" title="更换头像">
                <img src="<?php echo $userhome['avatar'] ?? ($basicConfig['default'] ?? "/img/favicon.png"); ?>" alt="Avatar">
            </div>
            <!-- Cropping modal -->
            <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="avatar-form" action="/user/changeavatar" enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <h4 class="modal-title" id="avatar-modal-label">头像更换</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                        <label for="avatarInput">本地上传</label>
                                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="avatar-preview preview-avatar-lg"></div>
                                            <div class="avatar-preview preview-avatar-md"></div>
                                            <div class="avatar-preview preview-avatar-sm"></div>
                                        </div>
                                    </div>

                                    <div class="row avatar-btns">
                                        <div class="col-md-9">
                                            <div class="btn-group">
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">-90°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-15" type="button">-15°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-30" type="button">-30°</button>
                                                <button class="btn btn-outline-danger btn-like" data-method="rotate" data-option="-45" type="button">-45°</button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">+90°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="15" type="button">15°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="30" type="button">30°</button>
                                                <button class="btn btn-outline-info" data-method="rotate" data-option="45" type="button">45°</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-outline-success btn-block avatar-save" type="submit">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                              <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div><!-- /.modal -->

                  <!-- Loading state -->
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
        <?php }else{?>
            <div class="avatar-view" >
                <img src="<?php echo $userhome['avatar'] ?? ($basicConfig['default'] ?? "/img/favicon.png"); ?>" alt="用户头像">
            </div>
        <?php }?>
            <div style="padding: 0 0 0 10px;text-align: left;display: flex;flex-direction: column;width: 75%;">
                <h1 class="homename" style="font-size:42px;margin-bottom: 0;color: white;" data-bs-toggle="modal" data-bs-target="#nicknameModal"><?php echo $userhome['uname'];?></h1>
                <h5 style="margin: 0;" data-bs-toggle="modal" data-bs-target="#sloganModal"><small class="homeslogan d-inline-block text-truncate" style="width: 75%;line-height:25px;color: #dddddd;" id="slogannow"><?php echo $userhome['slogan']==""?"还没有个性签名~":$userhome['slogan'];?></small></h5>
            </div>
        </div>
        <div style="margin-top: 8px;">
            <?php if(isset($user)&&$userhome['uid']==$user['uid']){?>
                <span class="badge rounded-pill bg-danger text-light"><?php echo $likedusernumber;?><br/>粉丝</span>
            <?php }else{?>
                <span style="display:<?php echo !isset($userhome['like'])||$userhome['like']==0?"inline-block":"none"; ?>;" id="addlikeuser<?php echo $userhome['uid'];?>" onclick="addlikeuser(this);" data-uid="<?php echo $userhome['uid'];?>" class="badge rounded-pill btn btn-outline-danger btn-like "><a id="addlikeusernumber<?php echo $userhome['uid'];?>"><?php echo $likedusernumber;?></a><br/><i class="bi bi-suit-heart"></i>未关注</span>
                <span style="display:<?php echo !isset($userhome['like'])||$userhome['like']==0?"none":"inline-block"; ?>;" id="dellikeuser<?php echo $userhome['uid'];?>" onclick="dellikeuser(this);" data-uid="<?php echo $userhome['uid'];?>" class="badge rounded-pill btn btn-outline-danger btn-like "><a id="dellikeusernumber<?php echo $userhome['uid'];?>"><?php echo $likedusernumber;?></a><br/><i class="bi bi-suit-heart-fill"></i>已关注</span>
            <?php }?>
            <span class="badge rounded-pill bg-info text-dark"><?php echo $likeusernumber;?><br/>关注</span>
            <span class="badge rounded-pill bg-primary text-light"><?php echo $commentnumber;?><br/>评论</span>
            <span class="badge rounded-pill bg-warning text-dark"><?php echo $likepoemnumber;?><br/>收藏诗词</span>
            <span class="badge rounded-pill bg-success text-light"><?php echo $likecommentnumber;?><br/>喜欢评论</span>
        </div>
    </div>

    <ul class="homeNavTab nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="likedtab" onclick="liked(null,'/user/likeduser?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');" data-bs-toggle="pill" data-bs-target="#pills-liked" type="button" role="tab" aria-controls="pills-liked" aria-selected="true">粉丝</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="liketab" onclick="like(null,'/user/likeuser?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');" data-bs-toggle="pill" data-bs-target="#pills-like" type="button" role="tab" aria-controls="pills-like" aria-selected="false">关注</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="commenttab" onclick="comment(null,'/user/commentlist?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');" data-bs-toggle="pill" data-bs-target="#pills-comment" type="button" role="tab" aria-controls="pills-comment" aria-selected="false">评论</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="likepoemtab" onclick="likepoem(null,'/user/likepoem?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');" data-bs-toggle="pill" data-bs-target="#pills-likepoem" type="button" role="tab" aria-controls="pills-likepoem" aria-selected="false">收藏诗词</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="likecommenttab" onclick="likecomment(null,'/user/likecomment?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');" data-bs-toggle="pill" data-bs-target="#pills-likecomment" type="button" role="tab" aria-controls="pills-likecomment" aria-selected="false">喜欢评论</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-liked" role="tabpanel" aria-labelledby="pills-liked-tab">
            <div class="row" style="width: 100%;margin: 0;" id="liked">
            </div>
            <div id="likedNavigation"></div>
        </div>
        <div class="tab-pane fade" id="pills-like" role="tabpanel" aria-labelledby="pills-like-tab">
            <div class="row" style="width: 100%;margin: 0;" id="like">
            </div>
            <div id="likeNavigation"></div>
        </div>
        <div class="tab-pane fade" id="pills-comment" role="tabpanel" aria-labelledby="pills-comment-tab">
            <div class="row" style="width: 100%;margin: 0;" id="comment">
            </div>
            <div id="commentNavigation"></div>
        </div>
        <div class="tab-pane fade" id="pills-likepoem" role="tabpanel" aria-labelledby="pills-likepoem-tab">
            <div class="row" style="width: 100%;margin: 0;" id="likepoem">
            </div>
            <div id="likepoemNavigation"></div>
        </div>
        <div class="tab-pane fade" id="pills-likecomment" role="tabpanel" aria-labelledby="pills-likecomment-tab">
            <div class="row" style="width: 100%;margin: 0;" id="likecomment">
            </div>
            <div id="likecommentNavigation"></div>
        </div>
    </div>

<?php }else{?>

<p>无效用户</p>

<?php }?>

</div>
<script>

function saveslogan(){
    let slogan=$('#slogan').val();
    if(slogan!=null){
        $.post("/user/changeslogan",{slogan:slogan},function (result) {
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)===1){
                $('#slogannow').text(slogan);
            }
        });
    }
}

function savenickname(){
    let nickname=$('#nickname').val();
    if(nickname!=null){
        $.post("/user/changenickname",{nickname:nickname},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
}

function addlikeuser(obj){
    let id=$(obj).data('uid')===null?"":$(obj).data('uid');
    $.getJSON("/user/addLikeUser?uid="+id,function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikeuser'+id).show();
            $('#addlikeuser'+id).hide();
            $('#addlikeusernumber'+id).text(parseInt($('#addlikeusernumber'+id).text())+1);
            $('#dellikeusernumber'+id).text(parseInt($('#dellikeusernumber'+id).text())+1);
        }
    });
}
function dellikeuser(obj){
    let id=$(obj).data('uid')===null?"":$(obj).data('uid');
    $.getJSON("/user/delLikeUser?uid="+id,function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikeuser'+id).hide();
            $('#addlikeuser'+id).show();
            $('#addlikeusernumber'+id).text(parseInt($('#addlikeusernumber'+id).text())-1);
            $('#dellikeusernumber'+id).text(parseInt($('#dellikeusernumber'+id).text())-1);
        }
    });
}
function addlikepoem(obj){
    $.getJSON("/user/addLikePoem?pid="+$(obj).val(),function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikepoem'+$(obj).val()).show();
            $('#addlikepoem'+$(obj).val()).hide();
            $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())+1);
            $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())+1);
        }
    });
}
function dellikepoem(obj){
    $.getJSON("/user/delLikePoem?pid="+$(obj).val(),function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikepoem'+$(obj).val()).hide();
            $('#addlikepoem'+$(obj).val()).show();
            $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())-1);
            $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())-1);
        }
    });
}

function addlikecomment(obj){
    $.getJSON("/user/addLikeComment?cid="+$(obj).val(),function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikecomment'+$(obj).val()).show();
            $('#addlikecomment'+$(obj).val()).hide();
            $('#addlikecommentnumber'+$(obj).val()).text(parseInt($('#addlikecommentnumber'+$(obj).val()).text())+1);
            $('#dellikecommentnumber'+$(obj).val()).text(parseInt($('#dellikecommentnumber'+$(obj).val()).text())+1);
        }
    });
}
function dellikecomment(obj){
    $.getJSON("/user/delLikeComment?cid="+$(obj).val(),function (data) {
        if(echoMsg("#msg",data.status,data.result)===1){
            $('#dellikecomment'+$(obj).val()).hide();
            $('#addlikecomment'+$(obj).val()).show();
            $('#addlikecommentnumber'+$(obj).val()).text(parseInt($('#addlikecommentnumber'+$(obj).val()).text())-1);
            $('#dellikecommentnumber'+$(obj).val()).text(parseInt($('#dellikecommentnumber'+$(obj).val()).text())-1);
        }
    });
}

$(function () {
    liked(null,'/user/likeduser?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow=1');
});
function likepoem(obj,link="href-"){
    clear();
    let linkStr="";
    if(obj==null){
        linkStr=link;
    }else{
        linkStr=obj.getAttribute(link)
    }
    $.getJSON(linkStr,function (data) {
        $('#likepoemNavigation').append(data.navPage);
        $('#likepoemNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {likepoem(null,"/user/likepoem?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow="+this.getAttribute("value"));}});\<\/script\>');
        $('#msg').append(data.messages);
        $.each(data.poems, function(i, poem){
            let str=
                '<div class="col-sm-6 col-md-6 col-lg-4 mb-6">'+
                '   <div class="card">'+
                '       <div class="card-body">'+
                '           <h4 class="card-title poemtitle d-inline-block text-truncate" style="width:90%">#<small>'+poem.pid+'</small> <a target="_blank" href="/poem?pid='+poem.pid+'">'+poem.title+'</a></h4>'+
                '          <h6 class="poemauthor">【<a target="_blank" href="/poem/list?did='+poem.did+'">'+poem.dname+'</a>】 <a target="_blank" href="/poem/list?aid='+poem.aid+'">'+poem.aname+'</a></h6>'+
                '          <p class="card-text poemcontent d-block text-truncate" style="width:95%;">'+poem.content+'</p>'+
                '          <div class="btn-group poemBtn" role="group" aria-label="...">'+
                '              <button type="button" class="btn btn-outline-info" disabled>'+
                '                   <span id="commentnumber">'+poem.commentnumber+'</span> <i class="bi bi-chat-square-dots-fill"></i>'+
                '               </button>'+
                '              <button style="display:'+(poem.like===null||poem.like===""||poem.like===0?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+poem.pid+'" onclick="addlikepoem(this)" id="addlikepoem'+poem.pid+'">'+
                '                   <span id="addlikenumber'+poem.pid+'">'+poem.likepoemnumber+'</span> <i class="bi bi-heart"></i>'+
                '               </button>'+
                '              <button style="display:'+(poem.like===null||poem.like===""||poem.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+poem.pid+'" onclick="dellikepoem(this)" id="dellikepoem'+poem.pid+'">'+
                '                   <span id="dellikenumber'+poem.pid+'">'+poem.likepoemnumber+'</span> <i class="bi bi-heart-fill"></i>'+
                '               </button>'+
                '               <button type="button" class="btn btn-outline-success" onclick=\'window.open("/poem?pid='+poem.pid+'");\'>'+
                '                   <i class="bi bi-journal-bookmark"></i>'+
                '              </button>'+
                '           </div>'+
                '      </div>'+
                '   </div>'+
                '</div>';
            $('#likepoem').append(str);
        });
    });
    return false;
}
function like(obj,link="href"){
    clear();
    let linkStr="";
    if(obj==null){
        linkStr=link;
    }else{
        linkStr=obj.getAttribute(link)
    }
    $.getJSON(linkStr,function (data) {
        $('#likeNavigation').append(data.navPage);
        $('#likeNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {like(null,"/user/likeuser?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow="+this.getAttribute("value"));}});\<\/script\>');
        $('#msg').append(data.messages);
        $.each(data.users, function(i, user){
            let str=
                '<div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-6">'+
                '   <div class="card">'+
                '       <div class="card-body">'+
                '<a style="width:90%;" class="btn btn-outline-danger btn-like" target="_blank" href="/user/home/'+user.likeuid+'"><img src="'+user.avatar+'" style="width:100%;"></a>'+
                '          <h6 class="card-title d-inline-block text-truncate" style="width:100%;">#'+user.likeuid+' '+user.uname+'</h4>'+
                '          <h6 class="card-text poemauthor d-block text-truncate" style="width:100%;">'+(user.slogan===""?"还没有个性签名~":user.slogan)+'</h5>'+
                '          <div class="btn-group commentBtn" role="group" aria-label="..." id="addlikeuser'+user.likeuid+'">'+
                '              <button style="display:'+(user.like===null||user.like===""||user.like===0?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" data-uid="'+user.likeuid+'" onclick="addlikeuser(this)">'+
                '                   <span id="addlikeusernumber'+user.likeuid+'">'+user.likedusernumber+'</span> <i class="bi bi-suit-heart"></i>'+
                '               </button>'+
                '          </div>'+
                '          <div class="btn-group likeuserBtn" role="group" aria-label="..." id="dellikeuser'+user.likeuid+'">'+
                '              <button style="display:'+(user.like===null||user.like===""||user.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" data-uid="'+user.likeuid+'" onclick="dellikeuser(this)">'+
                '                   <span id="dellikeusernumber'+user.likeuid+'">'+user.likedusernumber+'</span> <i class="bi bi-suit-heart-fill"></i>'+
                '              </button>'+
                '          </div>'+
                '      </div>'+
                '   </div>'+
                '</div>';
            $('#like').append(str);
        });
    });
    return false;
}
function liked(obj,link="href"){
    clear();
    let linkStr="";
    if(obj==null){
        linkStr=link;
    }else{
        linkStr=obj.getAttribute(link)
    }
    $.getJSON(linkStr,function (data) {
        $('#likedNavigation').append(data.navPage);
        $('#likedNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {liked(null,"/user/likeduser?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow="+this.getAttribute("value"));}});\<\/script\>');
        $('#msg').append(data.messages);
        $.each(data.users, function(i, user){
            let str=
                '<div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-6">'+
                '   <div class="card">'+
                '       <div class="card-body">'+
                '<a style="width:90%;" class="btn btn-outline-danger btn-like" target="_blank" href="/user/home/'+user.likeduid+'"><img src="'+user.avatar+'" style="width:100%;"></a>'+
                '          <h6 class="card-title d-inline-block text-truncate" style="width:100%;">#'+user.likeduid+' '+user.uname+'</h4>'+
                '          <h6 class="card-text poemauthor d-block text-truncate" style="width:100%;">'+(user.slogan===""?"还没有个性签名~":user.slogan)+'</h5>'+
                '          <div class="btn-group likeuserBtn" role="group" aria-label="..." id="addlikeuser'+user.likeduid+'">'+
                '              <button style="display:'+(user.like===null||user.like===""||user.like===0?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" data-uid="'+user.likeduid+'" onclick="addlikeuser(this)">'+
                '                   <span id="addlikeusernumber'+user.likeduid+'">'+user.likedusernumber+'</span> <i class="bi bi-suit-heart"></i>'+
                '               </button>'+
                '          </div>'+
                '          <div class="btn-group commentBtn" role="group" aria-label="..." id="dellikeuser'+user.likeduid+'">'+
                '              <button style="display:'+(user.like===null||user.like===""||user.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" data-uid="'+user.likeduid+'" onclick="dellikeuser(this)">'+
                '                   <span id="dellikeusernumber'+user.likeduid+'">'+user.likedusernumber+'</span> <i class="bi bi-suit-heart-fill"></i>'+
                '              </button>'+
                '          </div>'+
                '      </div>'+
                '   </div>'+
                '</div>';
            $('#liked').append(str);
        });
    });
    return false;
}
function likecomment(obj,link="href"){
    let uid="<?php echo (isset($user)?$user['uid']:"0");?>";
    clear();
    let linkStr="";
    if(obj==null){
        linkStr=link;
    }else{
        linkStr=obj.getAttribute(link)
    }
    $.getJSON(linkStr,function (data) {
        $('#likecommentNavigation').append(data.navPage);
        $('#likecommentNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {likecomment(null,"/user/likecomment?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow="+this.getAttribute("value"));}});\<\/script\>');
        $('#msg').append(data.messages);
        $.each(data.comments, function(i, comment){
            let str=
                '<div class="col-sm-6 col-md-6 col-lg-4 mb-6">'+
                '   <div class="card">'+
                '       <div class="card-body">'+
                '          <h4 class="card-title"><a style="max-width:90%;" class="rounded-pill btn btn-outline-danger btn-like d-inline-block text-truncate" target="_blank" href="/comment?cid='+comment.cid+'">#'+comment.cid+' '+comment.title+'</a></h4>'+
                '          <h5 class="card-text poemauthor d-block text-truncate" style="width:100%;"><a target="_blank" href="/user/home/'+comment.cuid+'">'+comment.uname+'</a></h5>'+
                '          <p class="card-text poemcontent d-block text-truncate" style="width:95%;">'+comment.content+'</p>'+
                '          <h6>'+comment.sendtime+'</h6>'+
                '          <div class="btn-group poemBtn" role="group" aria-label="...">'+
                '              <button type="button" class="btn btn-outline-info" disabled>'+
                '                   <span id="commentnumber">'+comment.commentnumber+'</span> <i class="bi bi-chat-square-dots-fill"></i>'+
                '               </button>'+
                '              <button style="display:'+(comment.like===null||comment.like===""||comment.like===0?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="addlikecomment(this)" id="addlikecomment'+comment.cid+'">'+
                '                   <span id="addlikecommentnumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart"></i>'+
                '               </button>'+
                '              <button style="display:'+(comment.like===null||comment.like===""||comment.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="dellikecomment(this)" id="dellikecomment'+comment.cid+'">'+
                '                   <span id="dellikecommentnumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart-fill"></i>'+
                '              </button>'+
                (uid===comment.cuid?
                '<button style="display:'+(comment.public==='0'?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="displaycomment(this)" id="displaycomment'+comment.cid+'">'+
                '   <i class="bi bi-toggle-off"></i>'+
                '</button>'+
                '<button style="display:'+(comment.public==='0'?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="hidecomment(this)" id="hidecomment'+comment.cid+'">'+
                '   <i class="bi bi-toggle-on"></i>'+
                '</button>'+
                '<button type="button" class="btn btn-outline-danger" onclick="delcomment(this);" value='+comment.cid+'><i class="bi bi-trash"></i></button>':'')+
                '          </div>'+
                '      </div>'+
                '   </div>'+
                '</div>';
            $('#likecomment').append(str);
        });
    });
    return false;
}
function comment(obj,link="href"){
    let uid="<?php echo (isset($user)?$user['uid']:"0");?>";
    clear();
    let linkStr="";
    if(obj==null){
        linkStr=link;
    }else{
        linkStr=obj.getAttribute(link)
    }
    $.getJSON(linkStr,function (data) {
        $('#commentNavigation').append(data.navPage);
        $('#commentNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {comment(null,"/user/commentlist?uid=<?php echo $userhome['uid'] ?? "";?>&pageNow="+this.getAttribute("value"));}});\<\/script\>');
        $('#msg').append(data.messages);
        $.each(data.comments, function(i, comment){
            let str=
                '<div class="col-sm-6 col-md-6 col-lg-4 mb-6" id="comment'+comment.cid+'">'+
                '   <div class="card">'+
                '       <div class="card-body">'+
                '          <h4 class="card-title"><a style="max-width:90%;" class="rounded-pill btn btn-outline-danger btn-like d-inline-block text-truncate" target="_blank" href="/comment?cid='+comment.cid+'">#'+comment.cid+' '+comment.title+'</a></h4>'+
                '          <p class="card-text poemcontent d-block text-truncate" style="width:95%;">'+comment.content+'</p>'+
                '          <h6>'+comment.sendtime+'</h6>'+
                '          <div class="btn-group poemBtn" role="group" aria-label="...">'+
                '              <button type="button" class="btn btn-outline-info" disabled>'+
                '                   <span id="commentnumber">'+comment.commentnumber+'</span> <i class="bi bi-chat-square-dots-fill"></i>'+
                '               </button>'+
                '              <button style="display:'+(comment.like===null||comment.like===""||comment.like===0?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="addlikecomment(this)" id="addlikecomment'+comment.cid+'">'+
                '                   <span id="addlikecommentnumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart"></i>'+
                '               </button>'+
                '              <button style="display:'+(comment.like===null||comment.like===""||comment.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="dellikecomment(this)" id="dellikecomment'+comment.cid+'">'+
                '                   <span id="dellikecommentnumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart-fill"></i>'+
                '               </button>'+
                (uid===comment.uid?
                    '<button style="display:'+(comment.public==='0'?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="displaycomment(this)" id="displaycomment'+comment.cid+'">'+
                    '   <i class="bi bi-toggle-off"></i>'+
                    '</button>'+
                    '<button style="display:'+(comment.public==='0'?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="hidecomment(this)" id="hidecomment'+comment.cid+'">'+
                    '   <i class="bi bi-toggle-on"></i>'+
                    '</button>'+
                    '<button type="button" class="btn btn-outline-danger" onclick="delcomment(this);" value='+comment.cid+'><i class="bi bi-trash"></i></button>':'')+
                '          </div>'+
                '      </div>'+
                '   </div>'+
                '</div>';
            $('#comment').append(str);
        });
    });
    return false;
}

function clear(){
    $('#msg').empty();

    $('#like').empty();
    $('#liked').empty();
    $('#comment').empty();
    $('#likepoem').empty();
    $('#likecomment').empty();

    $('#likeNavigation').empty();
    $('#likedNavigation').empty();
    $('#commentNavigation').empty();
    $('#likepoemNavigation').empty();
    $('#likecommentNavigation').empty();
}
</script>
<script src="/static/cropper/assets/js/jquery.min.js"></script>
<script src="/static/cropper/assets/js/bootstrap.min.js"></script>
<script src="/static/cropper/dist/cropper.min.js"></script>
<script src="/static/cropper/js/main.js"></script>