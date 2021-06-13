
<!--link href="/static/cropper/assets/css/bootstrap.min.css" rel="stylesheet"-->
<link href="/static/cropper/dist/cropper.min.css" rel="stylesheet">
<link href="/static/cropper/css/main.css" rel="stylesheet">
<style>
    #change .input-group .input-group-text,#change .input-group .form-control,#change .input-group .form-select{
        font-size: 20px;
    }
</style>

</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>


<div class="">
    <div class="nav nav-tabs userNavTab justify-content-center" id="userTab" role="tablist" aria-orientation="vertical">
        <button onclick="setting();" class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="true">用户信息</button>
        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#feedback" type="button" role="tab" aria-controls="feedback" aria-selected="false">反馈管理</button>
        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false">数据管理</button>
    </div>
    <div class="tab-content userNavTabContent" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings">
            <div style="width: 95%;margin:auto;padding: 10px;">
                    <input type="hidden" name="uid" id="uid">
                    <header class="text-center">
                        <h3 class="title">头像设置</h3>
                    </header>
                    <div class="container" id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="更换头像">
                            <img src="<?php echo $user['avatar'] ?? ($basicConfig['default'] ?? "/img/favicon.png"); ?>" alt="Avatar">
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
                                                        <div class="avatar-preview preview-lg"></div>
                                                        <div class="avatar-preview preview-md"></div>
                                                        <div class="avatar-preview preview-sm"></div>
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
                    </div>

                <form id="change" class="" action="" method="post">
                    <header class="text-center">
                        <h3 class="title">只读项目</h3>
                    </header>
                    <div class="input-group">
                        <label for="uname" class="input-group-text control-label">用户名号</label>
                        <input type="text" class="form-control" name="uname" placeholder="请键入用户名号" id="uname" readonly disabled>
                    </div>
                    <div class="input-group">
                        <label for="assets" class="input-group-text control-label">资产</label>
                        <input type="text" name="assets" value="0" class="form-control" id="assets" readonly disabled>
                    </div>
                    <div class="input-group">
                        <label for="exp" class="input-group-text control-label">经验</label>
                        <input type="text" name="exp"  value="0" class="form-control" id="exp" readonly disabled>
                    </div>
                    <div class="input-group">
                        <label for="regip" class="input-group-text control-label">注册IP地址</label>
                        <input type="text" name="regip"  value="0" class="form-control" id="regip" readonly disabled>
                    </div>
                    <div class="input-group">
                        <label for="regtime" class="input-group-text control-label">注册时间</label>
                        <input type="datetime-local" name="regtime"  class="form-control" id="regtime" readonly disabled>
                    </div>
                    <div class="input-group">
                        <label for="level" class="input-group-text control-label">用户级别</label>
                        <select name="level" class="form-select" id="level" disabled>
                            <option value="0">未激活用户</option>
                            <option value="1">普通用户</option>
                            <option value="2">超级用户</option>
                            <option value="3">反馈管理员</option>
                            <option value="4">资讯管理员</option>
                            <option value="5">高级管理员</option>
                        </select>
                    </div>
                    <header class="text-center">
                        <h3 class="title">必填项目</h3>
                    </header>
                    <div class="input-group">
                        <label for="email" class="input-group-text control-label">邮箱</label>
                        <input type="email" name="email" placeholder="请键入邮箱" class="form-control" id="email" required>
                    </div>
                    <div class="input-group">
                        <label for="sex" class="input-group-text control-label">性别</label>
                        <select name="sex" class="form-select" id="sex">
                            <option value="0">女</option>
                            <option value="1">男</option>
                            <option value="2">保密</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="password" class="input-group-text control-label">原令牌</label>
                        <input type="password" name="password" placeholder="键入原令牌才可修改信息" class="form-control" id="password" required>
                    </div>
                    <header class="text-center">
                        <h3 class="title">选填项目</h3>
                    </header>
                    <div class="input-group">
                        <label for="password1" class="input-group-text control-label">新令牌</label>
                        <input type="password" name="password1" placeholder="若需更改令牌，请在此输入" class="form-control" id="password1">
                    </div>
                    <div class="input-group">
                        <label for="nickname" class="input-group-text control-label">昵称</label>
                        <input type="text" name="nickname" placeholder="请键入昵称" class="form-control" id="nickname">
                    </div>
                    <div class="input-group">
                        <label for="tel" class="input-group-text control-label">手机</label>
                        <input type="tel" name="tel" placeholder="请键入手机" class="form-control" id="tel">
                    </div>
                    <div class="input-group">
                        <label for="birthday" class="input-group-text control-label">出生日期</label>
                        <input type="datetime-local" name="birthday" class="form-control" id="birthday">
                    </div>
                    <div class="input-group">
                        <label for="slogan" class="input-group-text control-label">个性签名</label>
                        <textarea name="slogan" placeholder="请键入个性签名" class="form-control" rows="6" maxlength="100"  style="resize: none;" id="slogan"></textarea>
                    </div>
                    <button type="button" id="changeuser" class="btn btn-success">修改</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback">
            <div class="feedbacklist" id="feedbacklist">
                <table class="table table-striped table-hover">
                    <thead>
                    <th style="width: 5%;">反馈编号</th>
                    <th style="width: 14%;">反馈用户</th>
                    <th style="width: 10%;">数量</th>
                    <th style="width: 10%;">单价实付</th>
                    <th style="width: 10%;">总实付款</th>
                    <th style="width: 10%;">状态</th>
                    <th style="width: 10%;">最近操作</th>
                    <th style="width: 10%;">备注</th>
                    <th>操作</th>
                    </thead>
                    <tbody id="feedbackTable">
                    </tbody>
                </table>
            </div>
            <div id="orderNavigation"></div>
        </div>
        <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data">

        </div>
    </div>
</div>



<script>

    function setting(){
        $.getJSON("/user/jsonuser/",function (data) {
            $('#uid').val(data.uid);
            $('#uname').val(data.uname);
            //$('#unameUrl').val(data.uname);
            //$('#userUrl').attr("href","https://poem.xinball.top/user/home/"+data.uname);
            $('#nickname').val(data.nickname);
            $('#email').val(data.email);
            $('#tel').val(data.tel);
            $('#asstes').val("￥"+data.asstes);
            $('#exp').val(data.exp);
            $('#regip').val(data.regip);
            $('#slogan').val(data.slogan);
            select_option_checked("sex",data.sex);
            select_option_checked("level",data.level);
            let birthday=data.birthday;
            if(birthday!=null){
                birthday=birthday.substr(0,10)+"T"+birthday.substr(11,16);
                $('#birthday').val(birthday);
            }else{
                $('#birthday').val("");
            }
            let regtime=data.regtime;
            if(regtime!=null){
                regtime=regtime.substr(0,10)+"T"+regtime.substr(11,16);
                $('#regtime').val(regtime);
            }else{
                $('#regtime').val("");
            }
        });
    }

    $(function () {
        setting();
    })
    
    $("#changeuser").click(function(){
        let data={nickname:$('#nickname').val(),password:$('#password').val(),password1:$('#password1').val(),email:$('#email').val(),tel:$('#tel').val(),slogan:$('#slogan').val(),sex:$('#sex').val(),birthday:$('#birthday').val()};
        $.post("/user/changeuser",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    });
</script>


<script src="/static/cropper/assets/js/jquery.min.js"></script>
<script src="/static/cropper/assets/js/bootstrap.min.js"></script>
<script src="/static/cropper/dist/cropper.min.js"></script>
<script src="/static/cropper/js/main.js"></script>
