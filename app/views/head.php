
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="description" content="诗词会">
    <meta name="keywords" content="诗词会">
    <meta name="author" content="XinBall">

    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="/static/echarts-5.1.1/dist/echarts.min.js"></script>
    <script src="/static/js/main.js"></script>

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"-->

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <!--script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/static/xbmplayer/xbmplayer.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/main.css">

    <link rel="icon" href="/img/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon" />
    <title><?php echo $TITLE ?></title>

    <script>
        $(function (){
            $(".alert-dismissible").on("click",function () {
                $(this).remove();
            });
            $(document.body).on("click",".alert-dismissible",function () {
                $(this).remove();
            });
        });

        /*
        function echoMsg(objName,status,result,time=5000){
            let obj=$('body').find(objName);
            if(status==1){
                obj.append('<div class="alert alert-success alert-dismissible" role="alert"><i class="bi bi-check-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==2){
                obj.append('<div class="alert alert-info alert-dismissible" style="position: fixed;width: 100%;z-index: 1000;top: 0;" role="alert"><i class="bi bi-info-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==3){
                obj.append('<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }else if(status==4){
                obj.append('<div class="alert alert-danger alert-dismissible" role="alert" style="position: fixed;width: 100%;z-index: 1000;top: 0;" ><i class="bi bi-exclamation-triangle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==-1){
                window.location.href=result;
            }
            return status;
        }*/
        function echoMsg(objName,status,result,time=5000){
            let obj=$('body').find(objName);
            if(status==1){
                obj.append('<div class="alert alert-success alert-dismissible" role="alert"><i class="bi bi-check-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==2){
                obj.append('<div class="alert alert-info alert-dismissible" style="width: 100%;z-index: 1000;top: 0;" role="alert"><i class="bi bi-info-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==3){
                obj.append('<div class="alert alert-warning" role="alert"><i class="bi bi-exclamation-circle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }else if(status==4){
                obj.append('<div class="alert alert-danger alert-dismissible" role="alert" style="width: 100%;z-index: 1000;top: 0;" ><i class="bi bi-exclamation-triangle-fill"></i> '+result+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                window.setTimeout(function(){$(".alert-dismissible").children("button").alert("close");},time);
            }else if(status==-1){
                window.location.href=result;
            }
            return status;
        }
        /**
         * 设置select控件选中
         * @param selectId select的id值
         * @param checkValue 选中option的值
         */
        function select_option_checked(selectId, checkValue){
            let select = document.getElementById(selectId);
            for (let i = 0; i < select.options.length; i++){
                if (select.options[i].value === checkValue){
                    select.options[i].selected = true;
                    return true;
                }
            }
            return false;
        }


        function comment(){
            if(!$('#contentModal').val()||$('#contentModal').val()===""){
                echoMsg("#commentmsg",4,"评论内容不可为空！");
                return false;
            }
            $.getJSON("/user/comment?"+$('#typeModal').val()+"id="+$('#idModal').val()+"&type="+$('#typeModal').val()+"&title="+$('#titleModal').val()+"&content="+$('#contentModal').val(),function (data) {
                if(echoMsg("#commentmsg",data.status,data.result)==1){
                    if($('#typeModal').val()=='p'){
                        $('#commentnumber').text(parseInt($('#commentnumber').text())+1);
                    }else{
                        $('#commentnumber'+$('#idModal').val()).text(parseInt($('#commentnumber'+$('#idModal').val()).text())+1);
                    }
                }
            }).fail(function(jqXHR, status, error){
                echoMsg("#commentmsg",4,'未<a href="/user/login/" target="_blank">登录</a>，暂时无法发表评论哟！');
                modal.find('#titleModal').attr("readonly","readonly");
                modal.find('#contentModal').attr("readonly","readonly");
            });
        }
        function getcomment(obj){
            let uid="<?php echo (isset($user)?$user['uid']:"0");?>";
            let cid=$(obj).data('cid');
            let node=$('#ccomment'+cid);
            node.empty();
            let commentName=$('#commentName'+cid).text();
            let commentColor=$('#commentName'+cid).attr('value');
            if($(obj).val()==="close"){
                $(obj).val("open");
                $.getJSON("/comment/jsoncomment?cid="+cid+'&pageNow='+$(obj).data('pagenow'),function (data) {
                    let nextpage=data.nextpage;
                    let prepage=data.prepage;
                    $.each(data.comments,function(i, comment){
                        let commentContent=(comment.content===""?"什么评论都没有留下~":comment.content);
                        let userBtnColor=(comment.sex==='0'?"danger":(comment.sex==='1'?"info":"secondary"));
                        let commentTitle='<h5 class="card-title" style="text-align: left;font-weight: bold;"><a href="/comment?cid='+comment.cid+'" target="_blank"><span class="badge rounded-pill btn-'+userBtnColor+'">#'+comment.cid+"</span></a> "+(comment.title===""?"":comment.title)+'</h5>';

                        let time="";
                        let sec = ((new Date()).getTime()-(new Date(comment.sendtime.replace(/-/g,"/"))).getTime())/1000;
                        let min=sec/60;
                        let hour=min/60;
                        let day=hour/24;
                        if(sec<60){
                            time+=Math.floor(sec)+" 秒钟前";
                        }else if(min<60){
                            time+=Math.floor(min)+" 分钟前";
                        }else if(hour<24){
                            time+=Math.floor(hour)+" 小时前";
                        }else if(day<30){
                            time+=Math.floor(day)+" 天前";
                        }else{
                            time+=comment.sendtime;
                        }
                        let str='<div class="card" id="comment'+comment.cid+'">'+
                            '<div class="card-body">'+
                            '<div class="commentUser">'+
                            '<a tabindex="0" style="padding: 3px;width: 100%;" class="btn btn-lg btn-outline-'+userBtnColor+'" role="button" target="_blank" href="/user/home/'+comment.uname+'">'+
                            '<img src="'+comment.avatar+'" width="75%"><br/><span value="'+userBtnColor+'" id="commentName'+comment.cid+'">'+comment.uname+'</span></a><small>回复</small><br/><a href="#comment'+cid+'"><span class="badge btn-'+commentColor+'">'+commentName+'<br/>#'+cid+'</span></a>'+
                            '</div>'+
                            '<div class="commentContent">'+commentTitle+
                            '<div class="card-text" style="text-align: left;font-size: 18px;"><xmp style="white-space: normal;">'+commentContent+'</xmp></div>'+
                            '<div class="card-text">'+
                            '<div style="float: left;line-height: 34px;font-size: 14px;"><small class="text-muted">'+time+'</small></div>'+
                            '<div class="btn-group commentBtn" style="float: right;" role="group" aria-label="...">'+
                            '<button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#commentModal" data-type="c" data-cid="'+comment.cid+'">&nbsp;<i class="bi bi-reply-fill"></i>&nbsp;</button>'+
                            '<button type="button" class="btn btn-outline-primary" value="close" data-cid="'+comment.cid+'" data-pagenow="1" onclick="getcomment(this)" id="getcomment'+comment.cid+'"><span id="commentnumber'+comment.cid+'">'+comment.commentnumber+'</span> <i class="bi bi-chat-square-text"></i></button>'+
                            '<button style="display:'+(comment.like===null||comment.like===0?"unset":"none")+'" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="addlikecomment(this)" id="addlikecomment'+comment.cid+'"><span id="addlikenumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart"></i></button>'+
                            '<button style="display:'+(comment.like===null||comment.like===0?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="dellikecomment(this)" id="dellikecomment'+comment.cid+'"><span id="dellikenumber'+comment.cid+'">'+comment.likenumber+'</span> <i class="bi bi-heart-fill"></i></button>'+
                            (uid===comment.uid?
                                '<button style="display:'+(comment.public==='0'?"unset":"none")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="displaycomment(this)" id="displaycomment'+comment.cid+'">'+
                                '   <i class="bi bi-toggle-off"></i>'+
                                '</button>'+
                                '<button style="display:'+(comment.public==='0'?"none":"unset")+';" type="button" class="btn btn-outline-danger btn-like" value="'+comment.cid+'" onclick="hidecomment(this)" id="hidecomment'+comment.cid+'">'+
                                '   <i class="bi bi-toggle-on"></i>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-danger" onclick="delcomment(this);" value='+comment.cid+'><i class="bi bi-trash"></i></button>':'')+
                            '<button type="button" class="btn btn-outline-secondary" value="'+comment.cid+'"  onclick="feedbackComment(this)"><i class="bi bi-tools"></i></button>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div id="ccomment'+comment.cid+'"></div>'+
                            '</div>';
                        node.append(str);
                    });
                    let btn='<div class="btn-group" role="group" style="margin:10px;" aria-label="...">'+
                        '<button class="btn btn-outline-info" data-cid="'+cid+'" data-pagenow="'+prepage+'" value="close" onclick="getcomment(this);" '+(prepage!==''?"":"disabled")+'><i class="bi bi-chevron-left"></i></button>'+
                        '<button class="btn btn-outline-danger" data-cid="'+cid+'" data-pagenow="'+nextpage+'" value="close" onclick="getcomment(this);"'+(nextpage!==''?"":"disabled")+'><i class="bi bi-chevron-right"></i></button>'+
                        '</div>'
                    if(!(prepage===''&&nextpage===''))
                        node.append(btn);
                    scroll();
                });
            }else{
                $(obj).val("close");
            }
        }

        function hidecomment(thisBtn){
            let cid=$(thisBtn).val();
            $.post("/user/hidecomment",{cid:cid},function(result,status){
                let json=JSON.parse(result);
                if(echoMsg("#msg",json.status,json.result)===1){
                    $('#hidecomment'+cid).hide();
                    $('#displaycomment'+cid).show();
                }
            });
        }
        function displaycomment(thisBtn){
            let cid=$(thisBtn).val();
            $.post("/user/displaycomment",{cid:cid},function(result,status){
                let json=JSON.parse(result);
                if(echoMsg("#msg",json.status,json.result)===1){
                    $('#hidecomment'+cid).show();
                    $('#displaycomment'+cid).hide();
                }
            });
        }
        function delcomment(thisBtn){
            let cid=$(thisBtn).val();
            $.post("/user/delcomment",{cid:cid},function(result,status){
                let json=JSON.parse(result);
                if(echoMsg("#msg",json.status,json.result)===1){
                    $('#comment'+cid).remove();
                }
            });
        }

    </script>
    <style>
        body{
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            text-align: center;
            height: 100%;
            margin: 0;
            z-index: 0;
            background: #fffff8;
        }
        .header{
            width:100%;
        }

        .card{
            margin:2px;
            background: #f4fff8;
        }

        .bgImg {
            position: fixed;
            object-fit: cover;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            height: 100%;
            width: -webkit-fill-available;
            width: -moz-available;
            filter: brightness(0.5);
            z-index: -1;
        }
        .footer{
            font-size: 20px;
            position: relative;
            /*width: 100%;
            position: relative;
            float: left;*/
            background: #fffff4 url(/img/bg/footer.png) center center repeat scroll;
            text-align: center;
            border-radius: 5px;
            bottom: 0;
            height: fit-content;
            font-weight: 1000;
        }
        .loginbox{
            font-family: SIMKAI, serif;
            position: relative;
            padding: 10px;
            margin: 0 auto;
            border-radius: 10px;
            font-size: 20px;
            color: #f0f0f0;
            max-width: max-content;
            min-width: min-content;
            height: max-content;
        }
        form {
            display: block;
            margin-top: 0em;
            margin-block-end: 0;
        }
        a,a:hover,a:active,a:visited{
            text-decoration:none;
        }
        a {
            color: hotpink;
        }
        a:hover {
            color: pink;
        }
        a:active{
            color: deeppink;
        }
        .footer a{
            color: deeppink;
        }
        .footer a:hover {
            color: pink;
        }
        .footer a:active{
            color: deeppink;
        }
        .loginbox a{
            color: lightskyblue;
        }
        .loginbox a:hover{
            color: deepskyblue;
        }
        .loginbox a:active{
            color: skyblue;
        }
        .loginbox button{
            font-family: SIMKAI, serif;
            font-size: 20px;
            color: white;
            width: 80%;
            margin-top: 20px;
        }


        .loginbox input{
            border-radius: 5px;
            font-size: 20px;
            border: none;
            width: 80%;
            color: #FFFFFF;
        }

        .loginbox .login{
            background: url(/img/input1.png) left center no-repeat;
            box-sizing: border-box;
            width: auto;
            background-size: 100% 100%;
            padding: 10px 15px;
        }
        .loginbox .logintitle{
            font-family: STXINGKA, serif;
            box-sizing: border-box;
            width: auto;
            background-size: 100% 100%;
            padding: 10px 15px;
            font-size: 28px;
            max-width: 500px;
        }
        section {
            padding: 60px 0;
            position: relative;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            /*width: 60%;
            margin: 10% auto 0;
            background-color: #f0f0f0;
            padding: 2% 5%;
            border-radius: 10px;*/
        }
        .icon{
            font-size: 48px;
        }
        .title {
            display: inline-block;
            font-size: 48px;
            font-weight: 100;
            padding: 10px 0;
            margin-bottom: 44px;
            text-align: center;
            border-bottom: solid 1px #ccc;
            border-top: solid 1px #ccc;
            text-transform: uppercase;
            line-height: 1.2;
            color: #555;
            margin-top: 20px;
        }
        .bg-gradient {
            background: -webkit-gradient(linear, left top, left bottom, from(#ef5285), to(#f381a6)) !important;
            background: linear-gradient(to bottom, #ef5285, #f381a6) !important;
            color: #fff;
        }
        .bg-gradient * {
             color: inherit;
        }

        /*
        ul {
            padding-left: 20px;
        }

        ul li {
            line-height: 2.3
        }
        */

        input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
            color: #000000;
        }

        input:-moz-placeholder, textarea:-moz-placeholder {
            color: #000000;
        }

        input::-moz-placeholder, textarea::-moz-placeholder {
            color: #000000;
        }

        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            color: #000000;
        }
        #aid{
            display: unset;
        }
        #aname{
            display: unset;
        }
        .find{
            text-align: center;
            font-size: 20px;
            background: url(/img/bg/footer.png) center center repeat scroll;
            background-color: #fffff4 !important;
        }

        .modal .form-control,.modal .form-select{
            margin-bottom:20px;
        }
        .modal-content{
            background: url(/img/bg/footer.png) white;
        }
        @-moz-document url-prefix() {
            fieldset { display: table-cell; }
        }
        input, button, textarea, select {
            font: 14px/100% "Microsoft YaHei", Arial, Tahoma, Helvetica, sans-serif;
            outline: 0;
            border: 0;
            background: none;
            font-family: SIMKAI, serif;
        }
        .form-control , .form-select , .doBtn *{
            font-size: 20px;
        }
        select, .form-control{
            padding: 0 12px !important;
        }
        .find input,.find button, .find textarea,.find  .form-control ,.find .form-select , .find .findbutton{
            /*width:max-content;*/
            font-size: 20px;
        }

        /*修改bootstrap风格
        label {
            display: contents;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }*/
        /*分页*/
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: hotpink;
            border-color: lightpink;
        }
        .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #3f3f3f;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }


        .pagination-lg>li:last-child>a, .pagination-lg>li:last-child>span {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .pagination>li:last-child>a, .pagination>li:last-child>span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination>.active>span>label>input{
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: hotpink;
            font-size: 18px;
            border: 0 lightpink;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .dynastylist{
            max-width: 98%;
            min-width: 370px;
            margin: 1%;
        }
        .authorlist{
            max-width: 98%;
            min-width: 370px;
            margin: 1%;
        }
        .poemlist{
            max-width: 98%;
            min-width: 370px;
            margin: 1%;
        }
        .userlist{
            max-width: 98%;
            min-width: 370px;
            margin: 1%;
        }
        .userlist table th{
            font-size: 15px;
        }
        .userlist table td{
            font-size: 13px;
        }
        #navbar{
            z-index: 999;
            height: fit-content;
            padding: 4px;
        }
        .alert{
            z-index: 1000;
        }
        .navbar .dropdown .dropdown-menu{
            z-index: 1001 !important;
        }
        .navDiv{
            background: url(/img/bg/footer.png) center center repeat scroll;
            background-color: #fffff4 !important;
        }
        .navbar-dark{
            background: url(/img/bg/footer.png) center center repeat scroll;
        }
        .navbar-dark input{
            background: #22222200;
            border-color: #90b6ef;
            color: white;
        }
        .navbar-dark .navbar-nav>li>a {
            color: #dddddd !important;
        }
        .navbar-dark .navbar-nav>li>a:hover {
            color: white !important;
        }
        .navbar-dark .form-control:focus {
             color: #ffffff;
             background-color: #22222280;
         }
        .carousel-caption{
            width: 100%;
            left:0;
            right: 0;
            background: #00000080;
        }
        .carousel-caption h3{
            font-family: SIMKAI, serif;
        }
        .carousel-caption p{
            font-size: 20px;
            font-family: STXINGKA, serif;
        }
        .btn-like{
            color:hotpink !important;
        }
        .btn-like:hover{
            background: deeppink !important;
        }


        .userNavTab .nav-link{
            font-size: 22px;
            color: hotpink;
        }
        .userNavTab .nav-link:hover{
            color: hotpink;
            font-size: 24px;
        }
        .userNavTab .active{
            color: deeppink !important;
            font-size: 24px !important;
        }
        .userNavTabContent{
            margin: 10px;
            padding: 20px;
        }

        .homeNavTab{
            justify-content: center;
            margin-top: 20px;
        }
        .homeNavTab button {
            font-size: 24px;
        }
        .homeNavTab .nav-item .active {
            background: hotpink;
        }
        .homeNavTab .nav-link {
             color: deeppink;
         }
        
        .poemtitle{
            font-family: BRADHITC,STXINGKA,serif;
        }
        .poemauthor{
            font-family: SIMLI ,serif;
        }
        .poemcontent{
            font-family: BRADHITC,SIMKAI ,serif;
        }
        .homename{
            font-family: BRADHITC,STXINGKA,serif;
        }
        .homeslogan{
            font-family: BRADHITC,SIMLI ,serif;
        }
        .homenickname{
            font-family: BRADHITC,SIMKAI ,serif;
        }





    </style>