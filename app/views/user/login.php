    <!--link rel="stylesheet" type="text/css" href="/static/css/login.css"-->
</head>

<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>
<?php include APP_PATH . "/app/views/color/dark.php" ?>
<br/>
<div class="loginbox">
    <div class="logintitle">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>进入诗词会</p><p>奇文共欣赏，疑义相与析</p>
    </div>
    <br/>
    <form action="/user/login" method="post" autocomplete="on">
        <input type="hidden" name="prePage" value="<?php echo $prePage ?? ($_GET['prePage'] ?? ($_POST['prePage'] ??'')) ?>">
        <p><small><?php echo isset($LoginedUser)?"您当前登录的用户名号为：".$LoginedUser['uname']:"" ;?></small></p>
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
        <br/>
        <a href="/user/forget">忘记密码？</a>
        <a href="/user/active">激活用户</a>
        <button type="submit" class="btn btn-success">登录</button>
        <p>尚未成为会员？<a href="/user/register">点击此处</a>加入诗词会</p>
    </form>
</div>
<br/>