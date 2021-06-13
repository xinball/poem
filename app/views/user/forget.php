    <!--link rel="stylesheet" type="text/css" href="/static/css/login.css"-->
</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>
<?php include APP_PATH . "/app/views/color/dark.php" ?>

<script>
    $('body').find('nav').addClass('navbar-inverse');
</script>
<div class="loginbox">
    <?php if(!isset($user)&&!isset($forget)){?>
    <div class="logintitle">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>诗词会令牌找回</p>
    </div>
    <br/>
    <form action="/user/forget" method="get" autocomplete="on">
        <p><small><?php echo isset($LoginedUser)?"您当前登录的用户名号为：".$LoginedUser['uname']:"" ;?></small></p>
        <p>请输入您要找回令牌的用户名号：</p>
        <br/>
        <div class="login">
            <label for="uname"></label>
            <input name="uname" id="uname" maxlength="20" placeholder="请键入名号" type="text">
        </div>
        <button type="submit" class="btn btn-success">找回令牌</button>
        <p>已找回令牌？<a href="/user/login">点击此处</a>进入诗词会</p>
    </form>
    <?php }else{?>
        <div class="logintitle">
            <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
            <p>诗词会令牌重置</p>
        </div>
        <br/>
        <form action="/user/forget" method="get" autocomplete="on">
            <p><small><?php echo isset($LoginedUser)?"您当前登录的用户名号为：".$LoginedUser['uname']:"" ;?></small></p>
            <p>您要重置令牌的用户名号为：<?php echo $user['uname']?></p>
            <p>不是此用户？请先 <a href="/user/logout">注销</a></p>
            <input type="hidden" name="uid" value="<?php echo $user['uid']?>"/>
            <input type="hidden" name="forget" value="<?php echo $forget?>"/>
            <br/>
            <div class="login">
                <label for="password"></label>
                <input type="password" id="password" name="password" maxlength="20" placeholder="请键入令牌" required>
            </div>
            <br>
            <button type="submit" class="btn btn-success">重置令牌</button>
            <p>已重置令牌？<a href="/user/login">点击此处</a>进入诗词会</p>
        </form>
    <?php }?>
</div>