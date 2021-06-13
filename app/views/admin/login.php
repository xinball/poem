    <!--link rel="stylesheet" type="text/css" href="/static/css/login.css"-->
    <style>
    </style>
</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>
<?php include APP_PATH . "/app/views/color/dark.php" ?>


<div class="loginbox">
    <div class="logintitle">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>诗词会后台管理</p><p>奇文共欣赏，疑义相与析</p>
    </div>
    <br/>
    <form action="/admin/login" method="post" autocomplete="on">
        <input type="hidden" name="prePage" value="<?php echo $prePage ?? ($_GET['prePage'] ?? ($_POST['prePage'] ??'')) ?>">
        <p><small><?php echo isset($status)?($status=="0"?"网站前台已关闭":($status=="2"?"网站正在调试中！":"")):"" ;?></small></p>
        <div class="login">
            <label for="uname"></label>
            <input type="text" value="<?php echo $uname??''?>" id="uname" name="uname" maxlength="20" placeholder="请键入名号" required>
        </div>
        <br>
        <div class="login">
            <label for="password"></label>
             <input type="password" id="password" name="password" maxlength="20" placeholder="请键入令牌" required>
        </div>
        <br>
        <input type="checkbox" name="keep" id="keep" style="width: 5%;">
        <label for="keep">30天内免登录</label>
        <br>
        <a href="/user/forget">忘记密码？</a>
        <a href="/user/active">激活用户</a>
        <button type="submit" class="btn btn-success">登录</button>
    </form>
</div>
<br/>