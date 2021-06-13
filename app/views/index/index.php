<?php

?>
<style>
    body {
        position: relative;
        padding-top: 70px;
    }
</style>
</head>
<body data-bs-spy="scroll" data-target="#navbar" data-bs-offset="0" class="scrollspy-example" tabindex="0">
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light fixed-top navDiv">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img height="24px" alt="信球网 诗词会" src="/img/poem.webp"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav container-fluid justify-content-start">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">首页</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">资讯</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">关于</a></li>
                <!--li class="nav-item"><a class="nav-link" href="#feedback">反馈</a></li-->
                <li class="nav-item"><a class="nav-link" href="#sta">统计</a></li>
                <li class="nav-item"><a class="nav-link" target="_blank" href="/poem/list">诗词查询</a></li>
            </ul>
            <ul class="navbar-nav container-fluid justify-content-end">
                <form action="/poem/list" class="d-flex justify-content-center">
                    <div class="input-group">
                        <input name="keyword" class="form-control" type="search" aria-label="Search" placeholder="键入 朝代/作者/诗词题目 关键词">
                        <button type="submit" class="btn btn-outline-success">全站搜索</button>
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
<?php if(isset($banners)&&sizeof($banners)>0){?>
<div id="banner" class="carousel slide" data-bs-ride="carousel" style="background: #ffc0cb40;">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#banner" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 0"></button>
      <?php $len=sizeof($banners);for($i=1;$i<$len;$i++){
          echo '<button type="button" data-bs-target="#banner" data-bs-slide-to="'.$i.'" aria-label="Slide '.$i.'"></li>';
      }?>
  </div>
  <div class="carousel-inner" style="max-height:720px;max-width:1080px;margin: auto;" role="listbox">
      <?php foreach ($banners as $i=>$item){?>
    <div class="carousel-item <?php echo ($i==0)?"active":""?>" data-bs-interval="4000">
      <a href="<?php echo $item['link'];?>" target="_blank">
          <img src="<?php echo $item['img'];?>" class="d-block w-100" alt='<?php echo $item['alt'];?>'>
          <div class="carousel-caption">
             <p><?php echo $item['subtitle'];?></p>
             <h3><?php echo $item['title'];?></h3>
          </div>
      </a>
    </div>
      <?php }?>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
  </button>
</div>
<?php }?>

<section id="news">
    <div class="container">
        <header class="text-center">
            <h2 class="title">资讯</h2>
        </header>
        <p class="text-left"></p>
        <p></p>
        <p></p>
    </div>
</section>

<section id="about">
    <div class="container">
        <header class="text-center">
            <h2 class="title">关于我们</h2>
        </header>
        <p class="text-left"></p>
        <p></p>
        <p>五千年文化，三千年诗韵</p>
        <p></p>
        <p>我们的文化从未断流！</p>
        <p></p>
    </div>
</section>
<section id="service" class="bg-gradient">
    <div class="container">
        <header class="text-center">
            <h2 class="title">服务</h2>
        </header>
        <div class="row text-center">
            <div data-animate="fadeInUp" class="col-lg-4 animated fadeInUp">
                <div class="icon"><i class="bi bi-search"></i></div>
                <h3>诗词库</h3>
                <p>五千年文化、三千年诗韵，中华民族的文化瑰宝需要我们每一个人的守护。</p>
                <p>“诗词会”致力于组建更为完整的中华诗词库，并加强对诗词的质量管理。</p>
                <p>各种完备的查询功能将面向大众，所有人都能在此查询到自己最爱的诗词。</p>
            </div>
            <div data-animate="fadeInUp" class="col-lg-4 animated fadeInUp">
                <div class="icon"><i class="bi bi-star-fill"></i></div>
                <h3>收藏、评论与反馈</h3>
                <p>“诗词会”是人人可言的平台，人们可以收藏诗词或针对诗词与评论发表自己的感想与思考。</p>
                <p>“诗词会”亦是社区平台，所有人都可关注其他用户或收藏Ta的评论。</p>
                <p>“诗词会”将是一个长久延续与维护的网站，你们的反馈是诗词会未来的发展。</p>
            </div>
            <div data-animate="fadeInUp" class="col-lg-4 animated fadeInUp">
                <div class="icon"><i class="bi bi-cloud-download-fill"></i></div>
                <h3>活动与推送</h3>
                <p>“诗词会”将在平台中组织一些围绕诗词的活动，如“经典咏流传”，和诗以歌，传唱经典；如“诗词纠错”，每个人都能对错漏诗词进行纠正；如”诗词收录“，本着诗词收录中的完备原则，邀请各大用户向诗词会提供尚未收录的诗词</p>
                <p>“诗词会“官方团队将围绕诗词格律、意象、典故等与诗词相关的文化常识，制作精美的订阅消息，并为大众推送。</p>
            </div>
        </div>
        <hr data-animate="fadeInUp" class="animated fadeInUp">
        <div data-animate="fadeInUp" class="text-center animated fadeInUp">
            <p class="lead">你想要了解更多有关“诗词会”或加入我们吗?</p>
            <p><a href="#contact" class="btn btn-outline-light link-scroll">联系我们</a></p>
        </div>
    </div>
</section>


<!--section id="feedback">
    <div class="container">
        <header class="text-center">
            <h2 class="title">反馈</h2>
        </header>
    </div>
</section-->

<section id="sta">
    <div class="container">
        <header class="text-center">
            <h2 class="title">统计</h2>
        </header>
        <div class="row text-center">
            <div data-animate="fadeInUp" class="col-lg-3 animated fadeInUp">
                有效诗词收录总数量：853388
            </div>
            <div data-animate="fadeInUp" class="col-lg-3 animated fadeInUp">
                有效 诗人/词人 总数量：
            </div>
            <div data-animate="fadeInUp" class="col-lg-3 animated fadeInUp">
                有效用户总数量：18
            </div>
            <div data-animate="fadeInUp" class="col-lg-3 animated fadeInUp">
                有效评论总数量：0
            </div>
        </div>
        <p></p>
        <p></p>
        <h2>各朝代诗词数量</h2>
        <div id="dynastyPoem" style="height: 700px;"></div>
        <h2>各朝代诗人/词人数量</h2>
        <div id="dynastyAuthor" style="height: 700px;"></div>
        <script>
            let dynastyPoem = echarts.init(document.getElementById('dynastyPoem'));
            let dynastyAuthor = echarts.init(document.getElementById('dynastyAuthor'));
            dynastyPoem.showLoading();
            dynastyAuthor.showLoading();
            $.getJSON("/poem/jsondpCount").done(function (data) {
                dynastyPoem.hideLoading();
                dynastyPoem.setOption({
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        width:'80%',
                        height:400,
                        top: 0,
                        left: 'center'
                    },
                    series: [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius: ['40%', '70%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                borderRadius: 10,
                                borderColor: '#fff',
                                borderWidth: 2
                            },
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: '40',
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            data: data
                        }
                    ]
                });
            });
            $.getJSON("/author/jsondaCount").done(function (data) {
                dynastyAuthor.hideLoading();
                dynastyAuthor.setOption({
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        width:'80%',
                        height:400,
                        top: 0,
                        left: 'center'
                    },
                    series: [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius: ['40%', '70%'],
                            avoidLabelOverlap: false,
                            itemStyle: {
                                borderRadius: 10,
                                borderColor: '#fff',
                                borderWidth: 2
                            },
                            label: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    fontSize: '40',
                                    fontWeight: 'bold'
                                }
                            },
                            labelLine: {
                                show: false
                            },
                            data: data
                        }
                    ]
                });
            });

        </script>
    </div>
</section>


