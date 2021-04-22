    <link rel="stylesheet" type="text/css" href="/static/css/login.css">
</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>


<?php
if(isset($message))
    echo "<script>alert(\"$message\");</script>";
?>

<div class="loginbox">
    <div class="title">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>>>立即加入诗词会<<</p>
    </div>
    <br/>
    <form action="/user/register" method="post" autocomplete="on">
        <label for="uname">
            <div class="login"><input type="text" id="uname" name="uname" maxlength="20" placeholder="请键入名号" required></div>
        </label><br>
        <label for="email">
            <div class="login"><input type="email" id="email" name="email" maxlength="20" placeholder="请键入邮箱账号" required></div>
        </label><br>
        <label for="password">
            <div class="login"><input type="password" id="password" name="password" maxlength="20" placeholder="请键入令牌" required></div>
        </label><br>
        <label for="password1">
            <div class="login"><input type="password" id="password1" name="password1" maxlength="20" placeholder="请再次键入令牌" required></div>
        </label><br>
        <button type="submit" class="btn btn-success">注册</button>
        <p>已为会员？<a href="/user/login">点击此处</a>进入诗词会</p>
    </form>
</div>