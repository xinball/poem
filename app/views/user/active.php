<!--link rel="stylesheet" type="text/css" href="/static/css/login.css"-->

</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>
<?php include APP_PATH . "/app/views/color/dark.php" ?>

<div class="loginbox">
    <div class="logintitle">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>诗词会用户激活</p>
    </div>
    <br/>
    <form action="/user/active" method="get" autocomplete="on">
        <p><small><?php echo isset($LoginedUser)?"您当前登录的用户名号为：".$LoginedUser['uname']:"" ;?></small></p>
        <p>请输入您要激活的用户名：</p>
        <br/>
        <div class="login">
            <label for="uname"></label>
            <input name="uname" id="uname" maxlength="20" placeholder="请键入名号" type="text">
        </div>
        <button type="submit" class="btn btn-success">激活用户</button>
        <p>尚未注册会员？<a href="/user/register">点击此处</a>加入诗词会</p>
    </form>
</div>
