
</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<?php include APP_PATH . "/app/views/user/header.php" ?>
<?php include APP_PATH . "/app/views/color/dark.php" ?>

<div class="loginbox">
    <div class="logintitle">
        <img width="20%" src="/img/svg/cloud_l.svg" alt=""/><img width="20%" src="/img/svg/cloud_r.svg" alt=""/>
        <p>诗词会用户反馈</p>
    </div>
    <br/>
    <form action="/user/feedback" method="get" autocomplete="on">
        <p><small><?php echo isset($LoginedUser)?"您当前登录的用户名号为：".$LoginedUser['uname']:"" ;?></small></p>
        <br/>
        <div class="login">
            <label for="type"></label>
            <select name="type" id="type" class="form-select">
                <option value="p">诗词反馈</option>
                <option value="c">评论反馈</option>
            </select>
        </div>
        <div class="login">
            <label for="title"></label>
            <input name="title" id="title" maxlength="20" placeholder="请键入反馈标题" type="text">
        </div>
        <div class="login">
            <label for="content"></label>
            <textarea name="content" id="content" rows="4" placeholder="请键入反馈的内容" style="resize: none;font-size: 20px;"></textarea>
        </div>
        <button type="submit" class="btn btn-success">提交反馈</button>
    </form>
</div>
