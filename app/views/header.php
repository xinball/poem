
<style>
    body {
        position: relative;
        padding-top: 70px;
    }
</style>
<div id="msg" style="z-index:1001;position: fixed;width: 100%;top:0;">
    <?php
    echo "<script>" . ($errMsg ?? ($_GET['errMsg'] ?? ($_POST['errMsg'] ?? ''))) . "</script>";
    echo "<script>" . ($infoMsg ?? ($_GET['infoMsg'] ?? ($_POST['infoMsg'] ?? ''))) . "</script>";
    echo ($warnMsg ?? ($_GET['warnMsg'] ?? ($_POST['warnMsg'] ?? '')));
    echo ($successMsg ?? ($_GET['successMsg'] ?? ($_POST['successMsg'] ?? '')));
    ?>
</div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light fixed-top navDiv">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img height="24px" alt="信球网 诗词会" src="/img/poem.webp"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav container-fluid justify-content-start">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">首页</a></li>
                <?php if(isset($navType)&&$navType=='adminsetting'){?>
                    <li class="nav-item"><a class="nav-link" href="#basic">基本</a></li>
                    <li class="nav-item"><a class="nav-link" href="#banner">横幅</a></li>
                    <li class="nav-item"><a class="nav-link" href="#poem">诗词、诗/词人、朝代</a></li>
                    <li class="nav-item"><a class="nav-link" href="#user">用户</a></li>
                    <li class="nav-item"><a class="nav-link" href="#comment">评论、推送、反馈</a></li>
                    <li class="nav-item"><a class="nav-link" href="#other">其它</a></li>

                <?php }else{?>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="/poem/list">诗词查询</a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="/comment/new">发表评论</a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="/news/list">推送</a></li>
                <?php }?>
            </ul>
            <ul class="navbar-nav container-fluid justify-content-end">
                <form action="/poem/list" class="d-flex justify-content-center">
                    <div class="input-group">
                        <input name="keyword" class="form-control" type="search" aria-label="Search" placeholder="键入 朝代/作者/诗词题目 关键词">
                        <button id="search" type="submit" class="btn btn-outline-success">全站搜索<i class="bi bi-search"></i></button>
                    </div>
                </form>
                <?php
                $flag1=0;$flag2=0;
                if(isset($admin)){
                    echo '
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="navbarDropdown"  role="button" style="color: hotpink !important;" aria-expanded="false">' .
                        ($admin['nickname']!=null?$admin['nickname']:$admin['uname']). ' <span class="glyphicon glyphicon-user" aria-hidden="true" style="color: hotpink !important;"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" target="_blank" href="/admin/">网站管理中心</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/admin/userlist">管理用户</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/admin/poemlist">管理诗词</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/admin/dynastylist">管理朝代</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/admin/authorlist">管理诗人/词人</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/admin/logout">注销</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/home/'.$admin['uname'].'">个人空间</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/new?uid=0">关于</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/admin/login">登录其他管理员</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/register">注册新用户</a></li>
                    </ul>
                </li>
                    ';
                    $flag1=1;
                }
                if(isset($user)){
                    echo '
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" style="color: deepskyblue !important;" aria-expanded="false">' .
                        ($user['nickname']!=null?$user['nickname']:$user['uname']). ' <span class="glyphicon glyphicon-user" aria-hidden="true" style="color: deepskyblue !important;"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" target="_blank" href="/user/">用户管理中心</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/dynasty">朝代查询</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/author">诗人/词人查询</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/feedback">反馈</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/user/logout">注销</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/home/'.$user['uname'].'">个人空间</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/new?uid=0">关于</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/login">登录其他用户</a></li>
                        <li><a class="dropdown-item" target="_blank" href="/user/register">注册新用户</a></li>
                    </ul>
                </li>
                    ';
                    $flag2=1;
                }
                if($flag1==0&&$flag2==0){
                    echo '
                <li class="nav-item"><a class="nav-link" href="/user/login">用户登录</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/login">后台登录</a></li>
                <li class="nav-item"><a class="nav-link" href="/user/register">注册</a></li>
                    ';
                }else if($flag1==0){
                    echo '
                <li class="nav-item"><a class="nav-link" href="/admin/login">后台登录</a></li>
                <li class="nav-item"><a class="nav-link" href="/user/register">注册</a></li>
                    ';
                }else if($flag2==0){
                    echo '
                <li class="nav-item"><a class="nav-link" href="/user/login">用户登录</a></li>
                <li class="nav-item"><a class="nav-link" href="/user/register">注册</a></li>
                    ';
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div style="z-index:2000;position: fixed;top: 75%;right: 0;opacity: 0.7;">
    <a href="#top">
        <button type="reset" class="btn btn-default findbutton" style="padding: 0;">
            <i class="bi-arrow-up-circle-fill" style="font-size: 36px;color:hotpink;"></i>
        </button>
    </a>
</div>