
<style>

</style>

</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="changeModalLabel">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="changeModalLabel">修改用户信息</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="changemsg"></div>
            <div class="modal-body container-fluid">
                <form id="change" class="form-inline" action="" method="post">
                    <input type="hidden" name="uidModal" id="uidModal">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="unameModal" class="control-label">名号</label>
                            <input type="text" name="unameModal" placeholder="请键入名号" class="form-control" id="unameModal">
                        </div>
                        <div class="col-md-6">
                            <label for="emailModal" class="control-label">邮箱</label>
                            <input type="email" name="emailModal" placeholder="请键入邮箱"  class="form-control" id="emailModal">
                        </div>
                        <div class="col-md-6">
                            <label for="telModal" class="control-label">电话</label>
                            <input type="tel" name="telModal" placeholder="请键入电话"  class="form-control" id="telModal">
                        </div>
                        <div class="col-md-6">
                            <label for="nicknameModal" class="control-label">昵称</label>
                            <input type="text" name="nicknameModal" placeholder="请键入昵称"  class="form-control" id="nicknameModal">
                        </div>
                        <div class="col-md-6">
                            <label for="assetsModal" class="control-label">资产</label>
                            <input type="number" name="assetsModal" placeholder="请键入资产" value="0" class="form-control" id="assetsModal">
                        </div>
                        <div class="col-md-6">
                            <label for="expModal" class="control-label">经验</label>
                            <input type="number" name="expModal" placeholder="请键入经验" value="0" class="form-control" id="expModal">
                        </div>
                        <div class="col-md-6">
                            <label for="sexModal" class="control-label">性别</label>
                            <select name="sexModal" class="form-select" id="sexModal">
                                <option value="0">女</option>
                                <option value="1">男</option>
                                <option value="2">保密</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="levelModal" class="control-label">用户级别</label>
                            <select name="levelModal" class="form-select" id="levelModal">
                                <option value="0">未激活用户</option>
                                <option value="1">普通用户</option>
                                <option value="2">超级用户</option>
                                <option value="3">反馈管理员</option>
                                <option value="4">资讯管理员</option>
                                <option value="5">高级管理员</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="birthdayModal" class="control-label">出生日期</label>
                            <input type="datetime-local" name="birthdayModal" class="form-control" id="birthdayModal">
                        </div>
                        <div class="col-md-6">
                            <label for="sloganModal" class="control-label">个性签名</label>
                            <textarea name="sloganModal" placeholder="请键入个性签名" class="form-control" rows="2" maxlength="100"  style="resize: none;" id="sloganModal"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="changeuser" class="btn btn-outline-success">修改</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="addModalLabel">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">添加用户</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addmsg"></div>
            <div class="modal-body container-fluid">
                <form id="add" class="form-inline" action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="unameAdd" class="control-label">名号</label>
                            <input type="text" name="unameAdd" placeholder="请键入用户名" class="form-control" id="unameAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="passwordAdd" class="control-label">密码</label>
                            <input type="password" name="passwordAdd" placeholder="请键入密码" class="form-control" id="passwordAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="emailAdd" class="control-label">邮箱</label>
                            <input type="email" name="emailAdd" placeholder="请键入邮箱"  class="form-control" id="emailAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="telAdd" class="control-label">手机</label>
                            <input type="tel" name="telAdd" placeholder="请键入手机号码" class="form-control" id="telAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="nicknameAdd" class="control-label">昵称</label>
                            <input type="text" name="nicknameAdd" placeholder="请键入昵称"  class="form-control" id="nicknameAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="assetsAdd" class="control-label">资产</label>
                            <input type="number" name="assetsAdd" placeholder="请键入资产" value="0" class="form-control" id="assetsAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="expAdd" class="control-label">经验</label>
                            <input type="number" name="expAdd" placeholder="请键入经验" value="0" class="form-control" id="expAdd">
                        </div>
                        <div class="col-md-6">
                            <label for="sexAdd" class="control-label">性别</label>
                            <select name="sexAdd" class="form-select" id="sexAdd">
                                <option value="0">女</option>
                                <option value="1">男</option>
                                <option value="2">保密</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="levelAdd" class="control-label">用户级别</label>
                            <select name="levelAdd" class="form-select" id="levelAdd">
                                <option value="0">未激活用户</option>
                                <option value="1">普通用户</option>
                                <option value="2">超级用户</option>
                                <option value="3">反馈管理员</option>
                                <option value="4">资讯管理员</option>
                                <option value="5">高级管理员</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="birthdayAdd" class="control-label">出生日期</label>
                            <input type="datetime-local" name="birthdayAdd" class="form-control" id="birthdayAdd">
                        </div>
                        <div class="col-md-12">
                            <label for="sloganAdd" class="control-label">个性签名</label>
                            <textarea name="sloganAdd" placeholder="请键入个性签名" class="form-control" rows="2" maxlength="100"  style="resize: none;" id="sloganAdd"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="adduser" class="btn btn-outline-success">添加</button>
            </div>
        </div>
    </div>
</div>

<nav class="find navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#footer"><i class="bi bi-arrow-down-circle-fill" style="font-size: 36px;color:deepskyblue;"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#list" aria-controls="list" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="list" aria-expanded="false">
                <form id="find" action="/admin/userlist" method="get" autocomplete="on" class="row row-cols-lg-auto g-3 align-items-center justify-content-center" role="search">
                    <div class="col-12">
                        <input class="form-control" type="text" id="uname" name="uname" maxlength="20" placeholder="键入用户名关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="text" id="nickname" name="nickname" maxlength="20" placeholder="键入昵称关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="email" id="email" name="email" maxlength="255" placeholder="键入邮箱关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="tel" id="tel" name="tel" maxlength="20" placeholder="键入手机号码关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="text" id="regip" name="regip" maxlength="20" placeholder="键入IP关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="datetime-local" id="regtime1" name="regtime1" maxlength="20" placeholder="选择注册时间段起始时间">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="datetime-local" id="regtime2" name="regtime2" maxlength="20" placeholder="选择注册时间段终止时间">
                    </div>
                    <div class="col-12">
                        <select name="order" id="order" class="form-select">
                            <option value="likedusernumber">按粉丝数量排序</option>
                            <option value="assets">按资产排序</option>
                            <option value="exp">按经验排序</option>
                            <option value="commentnumber">按评论数量排序</option>
                            <option value="likepoemnumber">按收藏诗词数量排序</option>
                            <option value="likecommentnumber">按收藏评论数量排序</option>
                            <option value="likeusernumber">按关注用户数量排序</option>
                        </select>
                    </div>
                    <br/>
                    <div class="btn-group doBtn col-12" role="group" aria-label="...">
                        <button type="reset" class="btn btn-info findbutton">
                            <i class="bi bi-arrow-repeat" style="color:white;"></i>
                        </button>
                        <button type="button" class="btn btn-default findbutton" style="background:mediumpurple;" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-person-plus-fill" style="color:white;"></i>
                        </button>
                        <button type="submit" class="btn btn-outline-danger btn-like findbutton" >
                            <i class="bi bi-search" ></i>
                        </button>
                    </div>
                    <input name="pageNow" id="pageNow" type="hidden" value="1"/>
                </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<?php echo $message;?>
<?php if(isset($users)&&$users!=null&&!empty($users)){?>
<div class="userlist table-responsive" id="userlist">
<table class="table table-striped table-hover table-condensed table-bordered" style="min-width: 1400px;">
    <thead>
        <tr>
            <th style="width: 3%;">#</th>
            <th style="width: 5%;">名号</th>
            <th style="width: 5%;">昵称</th>
            <th style="width: 5%;">邮箱</th>
            <th style="width: 5%;">手机</th>
            <th style="width: 6%;">个性签名</th>
            <th style="width: 3%;">性别</th>
            <th style="width: 5%;">生日</th>
            <th style="width: 6%;">注册时间</th>
            <th style="width: 5%;">注册IP</th>
            <th style="width: 6%;">收藏诗词</th>
            <th style="width: 6%;">收藏评论</th>
            <th style="width: 6%;">评论数量</th>
            <th style="width: 6%;">关注用户</th>
            <th style="width: 6%;">粉丝数量</th>
            <th style="width: 6%;">资产</th>
            <th style="width: 6%;">经验</th>
            <th style="width: 3%;">级别</th>
            <th style="width: 7%;">操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user){
        $userSlogan=$user['slogan'];
        if(mb_strlen($userSlogan)>$userConfig['slogannum']){
            $userSlogan = mb_substr($userSlogan,0,$userConfig['slogannum'])."……";
        }
        $userNickname=$user['nickname'];
        if(mb_strlen($userNickname)>$userConfig['nicknamenum']){
            $userNickname = mb_substr($userNickname,0,$userConfig['nicknamenum'])."……";
        }
        $userBirthday=$user['birthday']?:"";
        if($userBirthday!=""){
            $userBirthday=date("Y.m.d",strtotime($userBirthday));
        }
        $color="style='background-color:";
        switch($user['level']){
            case '-':$color.="#f2dede;'";break;
            case '0':$color.="lightgoldenrodyellow;'";break;
            case '1':$color="";break;
            case '2':$color.="darkseagreen;'";break;
            case '3':$color.="darkseagreen;'";break;
            case '4':$color.="lightskyblue;'";break;
            case '5':$color.="lightskyblue;'";break;
        }
        echo
            '<tr class="useritem" '.$color.' >'.
            "<th>".$user['uid']."</th>".
            "<td><a href='/user/home/".$user['uid']."' target='_blank'>".$user['uname']."</a></td>".
            "<td>".$userNickname."</td>".
            "<td>".$user['email']."</td>".
            "<td>".$user['tel']."</td>".
            "<td>".$userSlogan."</td>".
            "<td>".($user['sex']==0?"女":($user['sex']==1?"男":"密"))."</td>".
            "<td>".$userBirthday."</td>".
            "<td>".$user['regtime']."</td>".
            "<td>".$user['regip']."</td>".
            "<td>".$user['likepoemnumber']."</td>".
            "<td>".$user['likecommentnumber']."</td>".
            "<td>".$user['commentnumber']."</td>".
            "<td>".$user['likeusernumber']."</td>".
            "<td>".$user['likedusernumber']."</td>".
            "<td>".$user['assets']."</td>".
            "<td>".$user['exp']."</td>".
            "<td>".$user['level']."</td>".
            '<td><div class="btn-group doBtn" role="group" aria-label="...">'.
            ($user['level']!='-'?'<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changeModal" data-uid="'.$user['uid'].'"><i class="bi bi-gear-wide-connected" style="color: white;"></i></button> '.
                '<button type="button" class="btn btn-danger" onclick="deluser(this);" value='.$user['uid'].'><i class="bi bi-trash"></i></button>'
                :'<button type="button" class="btn btn-success" onclick="recoveruser(this);" value='.$user['uid'].'><i class="bi bi-arrow-clockwise"></i></button>').
            '</div></td>'.
            "</tr>";
    }
    ?>
    </tbody>
</table>
</div>
    <?php echo $navigation;?>
<?php }?>
<script>
    $(function (){
        <?php if(isset($did)){?>
        select_option_checked("did","<?php echo trim($did);?>");
        changeAid();
        <?php }else if(isset($uname)){?>
        $("#uname").val("<?php echo trim($uname)?>");
        <?php }?>
        <?php if(isset($nickname)){?>
        $("#nickname").val("<?php echo trim($nickname)?>");
         <?php }?>
        <?php if(isset($email)){?>
        $("#email").val("<?php echo trim($email)?>");
         <?php }?>
        <?php if(isset($tel)){?>
        $("#tel").val("<?php echo trim($tel)?>");
         <?php }?>
        <?php if(isset($regip)){?>
        $("#regip").val("<?php echo trim($regip)?>");
         <?php }?>
        <?php if(isset($regtime1)){?>
        $("#regtime1").val("<?php echo trim($regtime1)?>");
         <?php }?>
        <?php if(isset($regtime2)){?>
        $("#regtime2").val("<?php echo trim($regtime2)?>");
         <?php }?>
        <?php if(isset($order)){?>
        if(!select_option_checked("order","<?php echo $order?>")){
            select_option_checked("order","likedusernumber");
        }
        <?php }else{?>
        select_option_checked("order","likedusernumber");
        <?php }?>
    });
    $('#changeModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let uid = button.data('uid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this)
        $.getJSON("/admin/jsonuser?uid="+uid,function (data) {
            modal.find('#changeModalLabel').text('修改用户 ' + data.uname+' 的信息');
            modal.find('#uidModal').val(data.uid);
            modal.find('#unameModal').val(data.uname);
            modal.find('#nicknameModal').val(data.nickname);
            modal.find('#emailModal').val(data.email);
            modal.find('#telModal').val(data.tel);
            modal.find('#sloganModal').val(data.slogan);
            modal.find('#assetsModal').val(data.assets);
            modal.find('#expModal').val(data.exp);
            select_option_checked("sexModal",data.sex);
            select_option_checked("levelModal",data.level);
            let dateStr=data.birthday;
            if(dateStr!=null){
                dateStr=dateStr.substr(0,10)+"T"+dateStr.substr(11,16);
                modal.find('#birthdayModal').val(dateStr);
            }else{
                modal.find('#birthdayModal').val("");
            }
        })
    });

    $("#adduser").click(function(){
        let data={uname:$('#unameAdd').val(),nickname:$('#nicknameAdd').val(),password:$('#passwordAdd').val(),email:$('#emailAdd').val(),tel:$('#telAdd').val(),slogan:$('#sloganAdd').val(),sex:$('#sexAdd').val(),birthday:$('#birthdayAdd').val(),assets:$('#assetsAdd').val(),exp:$('#expAdd').val(),level:$('#levelAdd').val()};
        $.post("/admin/adduser",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#addmsg",json.status,json.result);
        });
    });
    $("#changeuser").click(function(){
        let data={uid:$('#uidModal').val(),uname:$('#unameModal').val(),nickname:$('#nicknameModal').val(),email:$('#emailModal').val(),tel:$('#telModal').val(),slogan:$('#sloganModal').val(),sex:$('#sexModal').val(),birthday:$('#birthdayModal').val(),assets:$('#assetsModal').val(),exp:$('#expModal').val(),level:$('#levelModal').val()};
        $.post("/admin/changeuser",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#changemsg",json.status,json.result);
        });
    });
    function deluser(thisBtn){
        let data={uid:$(thisBtn).val()};
        $.post("/admin/deluser",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
    function recoveruser(thisBtn){
        let data={uid:$(thisBtn).val()};
        $.post("/admin/recoveruser",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
</script>
