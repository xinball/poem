<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">

    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"-->

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="/static/js/main.js"></script>

    <link rel="stylesheet" href="/static/xbmplayer/xbmplayer.min.css">
    <!--link rel="stylesheet" type="text/css" href="/static/css/main.css"-->

    <link rel="icon" href="/img/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/img/favicon.png" type="image/x-icon" />
    <title><?php echo $TITLE ?></title>

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
        }
        @font-face {
            font-family: SIMLI;
            src:url("/static/ttf/SIMLI.TTF");
            /*隶书*/
        }
        @font-face {
            font-family: STXINGKA;
            src:url("/static/ttf/STXINGKA.TTF");
            /*行楷*/
        }
        @font-face {
            font-family: SIMKAI;
            src:url("/static/ttf/SIMKAI.TTF");
            /*楷体*/
        }
        @font-face {
            font-family: BRADHITC;
            src:url("/static/ttf/BRADHITC.TTF");
            /*BRADHITC*/
        }
        @font-face {
            font-family: CURLZ___;
            src:url("/static/ttf/CURLZ___.TTF");
            /*CURLZ___*/
        }
        .header{
            width:100%;
        }

        a {
            color: hotpink;
            text-decoration:none;
        }

        a:hover {
            color: pink;
            text-decoration:none;
        }
        a:active{
            color: deeppink;
            text-decoration:none;
        }
        a:visited{
            color: hotpink;
            text-decoration:none;
        }

        .footer{
            font-size: 20px;
            position: relative;
            /*width: 100%;
            float: left;*/
            background: #f0f0f0;
            text-align: center;
            border-radius: 5px;
            bottom: 0;
            height: fit-content;
            font-weight: 1000;
        }
        .footer a{
            color: deeppink;
        }
        .loginbox{
            font-family: SIMKAI, serif;
            position: relative;
            padding: 5%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 0;
            margin-bottom: 0;
            border-radius: 10px;
            font-size: 20px;
            color: #f0f0f0;
            max-width: max-content;
            min-width: min-content;
            height: max-content;
        }
        .loginbox a{
            color: lightskyblue;
        }
        .loginbox a:hover{
            color: deepskyblue;
            font-size: 22px;
        }
        .loginbox a:active{
            color: skyblue;
            font-size: 22px;
        }
        .loginbox a:visited{
            color: lightskyblue;
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
        .loginbox .title{
            font-family: STXINGKA, serif;
            box-sizing: border-box;
            width: auto;
            background-size: 100% 100%;
            padding: 10px 15px;
            font-size: 28px;
            max-width: 500px;
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
            filter: brightness(0.5);
            z-index: -1;
        }
        .container {
            width: 60%;
            margin: 10% auto 0;
            background-color: #f0f0f0;
            padding: 2% 5%;
            border-radius: 10px
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            line-height: 2.3
        }


        input, button, textarea, select {
            font: 14px/100% "Microsoft YaHei", Arial, Tahoma, Helvetica, sans-serif;
            outline: 0;
            border: 0;
            background: none;
            font-family: SIMKAI, serif;
        }
        input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
            color: #FFFFFF;
        }

        input:-moz-placeholder, textarea:-moz-placeholder {
            color: #FFFFFF;
        }

        input::-moz-placeholder, textarea::-moz-placeholder {
            color: #FFFFFF;
        }

        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            color: #FFFFFF;
        }


        /*修改bootstrap风格*/
        label {
            display: contents;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 700;
        }
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
            color: 3f3f3f;
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
        .poemlist{
            max-width: 98%;
            min-width: 370px;
            margin: 1%;
        }
    </style>