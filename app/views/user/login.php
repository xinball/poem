    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>

<div class="loginbox">
    <?php
        if(isset($message))
            echo "<script>alert(\"$message\");</script>";
    ?>
    <div class="title">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>进入诗词会</p><p>奇文共欣赏，疑义相与析</p>
    </div>
    <br/>
    <form action="/user/login" method="post" autocomplete="on">
        <label for="uname">
            <div class="login"><input type="text" id="uname" name="uname" maxlength="20" placeholder="请键入名号" required></div>
        </label><br>
        <label for="password">
             <div class="login"><input type="password" id="password" name="password" maxlength="20" placeholder="请键入令牌" required></div>
        </label><br>
        <label for="set_pwd">
            <input type="checkbox" id="set_pwd" class="set_pwd" style="width: 5%;">记住密码
        </label>
        <br>
        <button type="submit" class="btn btn-success">登录</button>
        <p>尚未成为会员？<a href="/user/register">点击此处</a>加入诗词会</p>
    </form>
</div>