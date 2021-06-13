<style>
    .banner{
        padding: 5px;
        margin: 5px;
    }
    #settings .btn-group{
        margin:10px;
    }
</style>
</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>

    <div class="">
        <div class="nav nav-tabs userNavTab justify-content-center" id="userTab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" onclick="config();" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="true">网站配置</button>
            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#news" type="button" role="tab" aria-controls="news" aria-selected="false">推送</button>
            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#feedback" type="button" role="tab" aria-controls="feedback" aria-selected="false">反馈管理</button>
            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false">数据管理</button>
        </div>
        <div class="tab-content userNavTabContent" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings">

                <header class="text-center" id="basic">
                    <h3 class="title">基本配置</h3>
                </header>
                <div class="input-group">
                    <label for="status" class="input-group-text control-label">网站状态</label>
                    <select name="status" class="form-select" id="status">
                        <option value="1">正常</option>
                        <option value="0">已关闭</option>
                        <option value="2">调试中</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="title" class="input-group-text control-label">网站名称</label>
                    <input type="text" class="form-control" name="title" placeholder="请键入网站名称" id="title" >
                </div>
                <div class="input-group">
                    <label for="banner" class="input-group-text control-label">主页横幅图片</label>
                    <input type="text" class="form-control" name="banner" placeholder="请键入主页横幅图片上传路径" id="banner" >
                </div>
                <div class="input-group">
                    <label for="userbanner" class="input-group-text control-label">用户横幅图片</label>
                    <input type="text" class="form-control" name="userbanner" placeholder="请键入用户横幅图片上传路径" id="userbanner" >
                </div>
                <div class="input-group">
                    <label for="useravatar" class="input-group-text control-label">头像上传路径</label>
                    <input type="text" class="form-control" name="useravatar" placeholder="请键入头像上传路径" id="useravatar" >
                </div>
                <div class="input-group">
                    <label for="defaultbanner" class="input-group-text control-label">默认横幅</label>
                    <input type="text" class="form-control" name="defaultbanner" placeholder="请键入默认横幅" id="defaultbanner" >
                </div>
                <div class="input-group">
                    <label for="defaultavatar" class="input-group-text control-label">默认头像</label>
                    <input type="text" class="form-control" name="defaultavatar" placeholder="请键入默认头像" id="defaultavatar" >
                </div>
                <div class="input-group">
                    <label for="avatarwidth" class="input-group-text control-label">头像高度</label>
                    <input type="number" class="form-control" name="avatarwidth" placeholder="请键入头像高度" id="avatarwidth" >
                </div>
                <div class="input-group">
                    <label for="bannerwidth" class="input-group-text control-label">横幅宽度</label>
                    <input type="number" class="form-control" name="bannerwidth" placeholder="请键入横幅宽度" id="bannerwidth" >
                </div>
                <div class="input-group">
                    <label for="copyright" class="input-group-text control-label">版权信息</label>
                    <textarea class="form-control" rows="6" style="resize: none;" name="copyright" placeholder="请键入版权信息" id="copyright" ></textarea>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="configbasic();">提交</button>
                </div>

                <header class="text-center" id="banner">
                    <h3 class="title">横幅设置</h3>
                </header>
                <div id="banners">
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info" id="bannernumadd" onclick="addbanner();" value="0">增加</button>
                    <button type="button" class="btn btn-outline-danger" id="bannernumsub" onclick="subbanner();" value="0">删除</button>
                    <button type="button" class="btn btn-outline-success" id="bannernum" onclick="configbanners();" value="0">提交</button>
                </div>

                <header class="text-center" id="poem">
                    <h3 class="title">诗词配置</h3>
                </header>
                <div class="input-group">
                    <label for="poemtitlenum" class="input-group-text control-label">标题</label>
                    <input type="number" class="form-control" name="poemtitlenum" placeholder="请键入诗词标题文本字数限制" id="poemtitlenum" >
                </div>
                <div class="input-group">
                    <label for="poemcontentnum" class="input-group-text control-label">内容</label>
                    <input type="number" class="form-control" name="poemcontentnum" placeholder="请键入诗词内容文本字数限制" id="poemcontentnum" >
                </div>
                <div class="input-group">
                    <label for="poemlistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="poemlistnum" placeholder="请键入诗词列表数量限制" id="poemlistnum" >
                </div>
                <div class="input-group">
                    <label for="poempagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="poempagenum" placeholder="请键入诗词分页数量限制" id="poempagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="configpoem();">提交</button>
                </div>

                <header class="text-center" id="author">
                    <h3 class="title">诗人/词人配置</h3>
                </header>
                <div class="input-group">
                    <label for="authorlistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="authorlistnum" placeholder="请键入诗人/词人列表数量限制" id="authorlistnum" >
                </div>
                <div class="input-group">
                    <label for="authorpagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="authorpagenum" placeholder="请键入诗人/词人分页数量限制" id="authorpagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info" onclick="Sql2Redis('authorlist');">同步【数据库->Redis】</button>
                    <button type="button" class="btn btn-outline-success" onclick="configauthor();">提交</button>
                </div>

                <header class="text-center" id="dynasty">
                    <h3 class="title">朝代配置</h3>
                </header>
                <div class="input-group">
                    <label for="dynastylistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="dynastylistnum" placeholder="请键入朝代列表数量限制" id="dynastylistnum" >
                </div>
                <div class="input-group">
                    <label for="dynastypagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="dynastypagenum" placeholder="请键入朝代分页数量限制" id="dynastypagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info" onclick="Sql2Redis('dynastylist');">同步【数据库->Redis】</button>
                    <button type="button" class="btn btn-outline-success" onclick="configdynasty();">提交</button>
                </div>


                <header class="text-center" id="user">
                    <h3 class="title">用户配置</h3>
                </header>
                <div class="input-group">
                    <label for="activettl" class="input-group-text control-label">激活时限（天）</label>
                    <input type="number" class="form-control" name="activettl" placeholder="请键入注册激活时限" id="activettl" >
                </div>
                <div class="input-group">
                    <label for="userloginttl" class="input-group-text control-label">用户登录时限(s)</label>
                    <input type="number" class="form-control" name="userloginttl" placeholder="请键入用户登录时限" id="userloginttl" >
                </div>
                <div class="input-group">
                    <label for="adminloginttl" class="input-group-text control-label">管理员登录时限(s)</label>
                    <input type="number" class="form-control" name="adminloginttl" placeholder="请键入管理员登录时限" id="adminloginttl" >
                </div>
                <div class="input-group">
                    <label for="userttl" class="input-group-text control-label">用户操作时限(s)</label>
                    <input type="number" class="form-control" name="userttl" placeholder="请键入用户操作时限" id="userttl" >
                </div>
                <div class="input-group">
                    <label for="adminttl" class="input-group-text control-label">管理员操作时限(s)</label>
                    <input type="number" class="form-control" name="adminttl" placeholder="请键入管理员操作时限" id="adminttl" >
                </div>
                <div class="input-group">
                    <label for="userslogannum" class="input-group-text control-label">个签</label>
                    <input type="number" class="form-control" name="userslogannum" placeholder="请键入用户个性签名字数限制" id="userslogannum" >
                </div>
                <div class="input-group">
                    <label for="usernicknamenum" class="input-group-text control-label">昵称</label>
                    <input type="number" class="form-control" name="usernicknamenum" placeholder="请键入用户昵称文本字数限制" id="usernicknamenum" >
                </div>
                <div class="input-group">
                    <label for="userlistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="userlistnum" placeholder="请键入用户列表数量限制" id="userlistnum" >
                </div>
                <div class="input-group">
                    <label for="userpagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="userpagenum" placeholder="请键入用户分页数量限制" id="userpagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="configuser();">提交</button>
                </div>

                <header class="text-center" id="comment">
                    <h3 class="title">评论配置</h3>
                </header>
                <div class="input-group">
                    <label for="commenttitlenum" class="input-group-text control-label">标题</label>
                    <input type="number" class="form-control" name="commenttitlenum" placeholder="请键入评论标题文本字数限制" id="commenttitlenum" >
                </div>
                <div class="input-group">
                    <label for="commentcontentnum" class="input-group-text control-label">内容</label>
                    <input type="number" class="form-control" name="commentcontentnum" placeholder="请键入评论内容文本字数限制" id="commentcontentnum" >
                </div>
                <div class="input-group">
                    <label for="commentlistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="commentlistnum" placeholder="请键入评论列表数量限制" id="commentlistnum" >
                </div>
                <div class="input-group">
                    <label for="commentcommentnum" class="input-group-text control-label">回复</label>
                    <input type="number" class="form-control" name="commentcommentnum" placeholder="请键入评论的回复数量限制" id="commentcommentnum" >
                </div>
                <div class="input-group">
                    <label for="commentpagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="commentpagenum" placeholder="请键入评论分页数量限制" id="commentpagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="configcomment();">提交</button>
                </div>

                <header class="text-center" id="news">
                    <h3 class="title">推送配置</h3>
                </header>
                <div class="input-group">
                    <label for="newstitlenum" class="input-group-text control-label">标题</label>
                    <input type="number" class="form-control" name="newstitlenum" placeholder="请键入推送标题文本字数限制" id="newstitlenum" >
                </div>
                <div class="input-group">
                    <label for="newssubtitlenum" class="input-group-text control-label">副标题</label>
                    <input type="number" class="form-control" name="newssubtitlenum" placeholder="请键入推送副标题文本字数限制" id="newssubtitlenum" >
                </div>
                <div class="input-group">
                    <label for="newscontentnum" class="input-group-text control-label">内容</label>
                    <input type="number" class="form-control" name="newscontentnum" placeholder="请键入推送内容文本字数限制" id="newscontentnum" >
                </div>
                <div class="input-group">
                    <label for="newslistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="newslistnum" placeholder="请键入推送列表数量限制" id="newslistnum" >
                </div>
                <div class="input-group">
                    <label for="newspagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="newspagenum" placeholder="请键入推送分页数量限制" id="newspagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="confignews();">提交</button>
                </div>

                <header class="text-center" id="feedback">
                    <h3 class="title">反馈配置</h3>
                </header>
                <div class="input-group">
                    <label for="feedbacktitlenum" class="input-group-text control-label">标题</label>
                    <input type="number" class="form-control" name="feedbacktitlenum" placeholder="请键入标题文本字数限制" id="feedbacktitlenum" >
                </div>
                <div class="input-group">
                    <label for="feedbackcontentnum" class="input-group-text control-label">内容</label>
                    <input type="number" class="form-control" name="feedbackcontentnum" placeholder="请键入内容文本字数限制" id="feedbackcontentnum" >
                </div>
                <div class="input-group">
                    <label for="feedbacklistnum" class="input-group-text control-label">列表</label>
                    <input type="number" class="form-control" name="feedbacklistnum" placeholder="请键入反馈列表数量限制" id="feedbacklistnum" >
                </div>
                <div class="input-group">
                    <label for="feedbackpagenum" class="input-group-text control-label">分页</label>
                    <input type="number" class="form-control" name="feedbackpagenum" placeholder="请键入反馈分页数量限制" id="feedbackpagenum" >
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success" onclick="configfeedback();">提交</button>
                </div>

                <header class="text-center" id="other">
                    <h3 class="title">其它配置</h3>
                </header>
            </div>
            <div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news">
                <div class="newslist" id="newslist">

                </div>
                <div id="newsNavigation"></div>
            </div>
            <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback">
                <div class="feedbacklist" id="feedbacklist">
                    <table class="table table-striped table-hover">
                        <thead>
                        <th style="width: 5%;">反馈编号</th>
                        <th style="width: 14%;">反馈用户</th>
                        <th style="width: 10%;">数量</th>
                        <th style="width: 10%;">单价实付</th>
                        <th style="width: 10%;">总实付款</th>
                        <th style="width: 10%;">状态</th>
                        <th style="width: 10%;">最近操作</th>
                        <th style="width: 10%;">备注</th>
                        <th>操作</th>
                        </thead>
                        <tbody id="feedbackTable">
                        </tbody>
                    </table>
                </div>
                <div id="orderNavigation"></div>
            </div>
            <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data">
                <h4><a href="/admin/userlist">用户管理</a></h4>
                <h4><a href="/admin/poemlist">诗词管理</a></h4>
                <h4><a href="/admin/dynastylist">朝代管理</a></h4>
                <h4><a href="/admin/authorlist">诗人/词人管理</a></h4>
            </div>
        </div>
    </div>

<script>

    $(function () {
       config();
    });
    function addbanner(){
        let bannernum=$('#bannernum').val();
        let bannerObj=
            '<div class="card banner" id="banner'+bannernum+'">'+
            '    <p><span class="badge bg-secondary text-light">#'+bannernum+'</span></p>'+
            '    <div class="input-group">'+
            '       <label for="bannertitle'+bannernum+'" class="input-group-text control-label">标题</label>'+
            '       <input type="text" class="form-control" name="bannertitle'+bannernum+'" placeholder="请键入标题" id="bannertitle'+bannernum+'" >'+
            '    </div>'+
            '    <div class="input-group">'+
            '        <label for="bannertitle'+bannernum+'" class="input-group-text control-label">副标题</label>'+
            '        <input type="text" class="form-control" name="bannersubtitle'+bannernum+'"  placeholder="请键入副标题" id="bannersubtitle'+bannernum+'" >'+
            '    </div>'+
            '    <div class="input-group">'+
            '        <label for="bannertitle'+bannernum+'" class="input-group-text control-label">图片链接</label>'+
            '        <input type="text" class="form-control" name="bannerimg'+bannernum+'"  placeholder="请键入图片链接" id="bannerimg'+bannernum+'" >'+
            '    </div>'+
            '    <div class="input-group">'+
            '        <label for="bannertitle'+bannernum+'" class="input-group-text control-label">图片提示</label>'+
            '        <input type="text" class="form-control" name="banneralt'+bannernum+'"  placeholder="请键入图片提示" id="banneralt'+bannernum+'" >'+
            '    </div>'+
            '    <div class="input-group">'+
            '        <label for="bannertitle'+bannernum+'" class="input-group-text control-label">链接</label>'+
            '        <input type="text" class="form-control" name="bannerlink'+bannernum+'"  placeholder="请键入链接" id="bannerlink'+bannernum+'" >'+
            '    </div>'+
            '</div>';
        $('#banners').append(bannerObj);
        bannernum++;
        $('#bannernum').val(bannernum);
        $('#bannernumadd').val(bannernum);
        $('#bannernumsub').val(bannernum);
    }
    function subbanner(){
        let bannernum=$('#bannernum').val()-1;
        if(bannernum>=0){
            $('#banner'+bannernum).remove();
            $('#bannernum').val(bannernum);
            $('#bannernumadd').val(bannernum);
            $('#bannernumsub').val(bannernum);
        }
    }
    function configbanners(){
        let bannernum=$('#bannernum').val();
        let banners=[];
        for(let i=0;i<bannernum;i++){
            if(document.getElementById('banner'+i)){
                let banner={};
                banner.title=$('#bannertitle'+i).val();
                banner.subtitle=$('#bannersubtitle'+i).val();
                banner.img=$('#bannerimg'+i).val();
                banner.alt=$('#banneralt'+i).val();
                banner.link=$('#bannerlink'+i).val();
                banners.push(banner);
            }
        }
        let bannersStr=JSON.stringify(banners);
        $.post("/admin/configbanners",{banners:bannersStr},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function Sql2Redis(key){
        $.post("/admin/Sql2Redis",{key:key},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configbasic(){
        let data={};
        data.title=$('#title').val();
        data.copyright=$('#copyright').val();
        data.status=$('#status').val();
        data.useravatar=$('#useravatar').val();
        data.userbanner=$('#userbanner').val();
        data.defaultbanner=$('#defaultbanner').val();
        data.defaultavatar=$('#defaultavatar').val();
        data.avatarwidth=$('#avatarwidth').val();
        data.bannerwidth=$('#bannerwidth').val();
        data.banner=$('#banner').val();
        $.post("/admin/confighash",{key:"basic",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configpoem(){
        let data={};
        data.titlenum=$('#poemtitlenum').val();
        data.contentnum=$('#poemcontentnum').val();
        data.listnum=$('#poemlistnum').val();
        data.pagenum=$('#poempagenum').val();
        $.post("/admin/confighash",{key:"poem",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configauthor(){
        let data={};
        data.listnum=$('#authorlistnum').val();
        data.pagenum=$('#authorpagenum').val();
        $.post("/admin/confighash",{key:"author",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configdynasty(){
        let data={};
        data.listnum=$('#dynastylistnum').val();
        data.pagenum=$('#dynastypagenum').val();
        $.post("/admin/confighash",{key:"dynasty",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configuser(){
        let data={};
        data.activettl=$('#activettl').val();
        data.userttl=$('#userttl').val();
        data.adminttl=$('#adminttl').val();
        data.userloginttl=$('#userloginttl').val();
        data.adminloginttl=$('#adminloginttl').val();
        data.slogannum=$('#userslogannum').val();
        data.nicknamenum=$('#usernicknamenum').val();
        data.listnum=$('#userlistnum').val();
        data.pagenum=$('#userpagenum').val();
        $.post("/admin/confighash",{key:"user",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configcomment(){
        let data={};
        data.titlenum=$('#commenttitlenum').val();
        data.contentnum=$('#commentcontentnum').val();
        data.listnum=$('#commentlistnum').val();
        data.commentnum=$('#commentcommentnum').val();
        data.pagenum=$('#commentpagenum').val();
        $.post("/admin/confighash",{key:"comment",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function confignews(){
        let data={};
        data.titlenum=$('#newstitlenum').val();
        data.subtitlenum=$('#newssubtitlenum').val();
        data.contentnum=$('#newscontentnum').val();
        data.listnum=$('#newslistnum').val();
        data.pagenum=$('#newspagenum').val();
        $.post("/admin/confighash",{key:"news",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function configfeedback(){
        let data={};
        data.titlenum=$('#feedbacktitlenum').val();
        data.contentnum=$('#feedbackcontentnum').val();
        data.listnum=$('#feedbacklistnum').val();
        data.pagenum=$('#feedbackpagenum').val();
        $.post("/admin/confighash",{key:"feedback",data:JSON.stringify(data)},function (result) {
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    }
    function config(){
        $.getJSON("/admin/jsonconfig",function (data) {
            $('#title').val(data.basic.title);
            $('#copyright').val(data.basic.copyright);
            $('#useravatar').val(data.basic.useravatar);
            $('#userbanner').val(data.basic.userbanner);
            $('#avatarwidth').val(data.basic.avatarwidth);
            $('#bannerwidth').val(data.basic.bannerwidth);
            $('#defaultavatar').val(data.basic.defaultavatar);
            $('#defaultbanner').val(data.basic.defaultbanner);
            $('#banner').val(data.basic.banner);
            select_option_checked("status",data.basic.status);

            let bannersStr=JSON.parse(data.banners,true);
            $('#bannernum').val(bannersStr.length);
            $('#bannernumadd').val(bannersStr.length);
            $('#bannernumsub').val(bannersStr.length);
            let bannersObj=$('#banners');
            bannersObj.empty();
            $.each(bannersStr,function (i,banner) {
                let bannerObj=
                    '<div class="card banner" id="banner'+i+'">'+
                    '    <p><span class="badge bg-secondary text-light">#'+i+'</span></p>'+
                    '    <div class="input-group">'+
                    '       <label for="bannertitle'+i+'" class="input-group-text control-label">标题</label>'+
                    '       <input type="text" class="form-control" name="bannertitle'+i+'" placeholder="请键入标题" id="bannertitle'+i+'" >'+
                    '    </div>'+
                    '    <div class="input-group">'+
                    '        <label for="bannertitle'+i+'" class="input-group-text control-label">副标题</label>'+
                    '        <input type="text" class="form-control" name="bannersubtitle'+i+'" placeholder="请键入副标题" id="bannersubtitle'+i+'" >'+
                    '    </div>'+
                    '    <div class="input-group">'+
                    '        <label for="bannertitle'+i+'" class="input-group-text control-label">图片链接</label>'+
                    '        <input type="text" class="form-control" name="bannerimg'+i+'" placeholder="请键入图片链接" id="bannerimg'+i+'" >'+
                    '    </div>'+
                    '    <div class="input-group">'+
                    '        <label for="bannertitle'+i+'" class="input-group-text control-label">图片提示</label>'+
                    '        <input type="text" class="form-control" name="banneralt'+i+'" placeholder="请键入图片提示" id="banneralt'+i+'" >'+
                    '    </div>'+
                    '    <div class="input-group">'+
                    '        <label for="bannertitle'+i+'" class="input-group-text control-label">链接</label>'+
                    '        <input type="text" class="form-control" name="bannerlink'+i+'" placeholder="请键入链接" id="bannerlink'+i+'" >'+
                    '    </div>'+
                    '</div>';
                bannersObj.append(bannerObj);
                $('#bannertitle'+i).val(banner.title);
                $('#bannersubtitle'+i).val(banner.subtitle);
                $('#bannerimg'+i).val(banner.img);
                $('#banneralt'+i).val(banner.alt);
                $('#bannerlink'+i).val(banner.link);
            });

            $('#poemtitlenum').val(data.poem.titlenum);
            $('#poemcontentnum').val(data.poem.contentnum);
            $('#poemlistnum').val(data.poem.listnum);
            $('#poempagenum').val(data.poem.pagenum);

            $('#authorlistnum').val(data.author.listnum);
            $('#authorpagenum').val(data.author.pagenum);

            $('#dynastylistnum').val(data.dynasty.listnum);
            $('#dynastypagenum').val(data.dynasty.pagenum);

            $('#activettl').val(data.user.activettl);
            $('#userttl').val(data.user.userttl);
            $('#adminttl').val(data.user.adminttl);
            $('#userloginttl').val(data.user.userloginttl);
            $('#adminloginttl').val(data.user.adminloginttl);
            $('#userslogannum').val(data.user.slogannum);
            $('#usernicknamenum').val(data.user.nicknamenum);
            $('#userlistnum').val(data.user.listnum);
            $('#userpagenum').val(data.user.pagenum);

            $('#commenttitlenum').val(data.comment.titlenum);
            $('#commentcontentnum').val(data.comment.contentnum);
            $('#commentlistnum').val(data.comment.listnum);
            $('#commentcommentnum').val(data.comment.commentnum);
            $('#commentpagenum').val(data.comment.pagenum);

            $('#newstitlenum').val(data.news.titlenum);
            $('#newssubtitlenum').val(data.news.subtitlenum);
            $('#newscontentnum').val(data.news.contentnum);
            $('#newslistnum').val(data.news.listnum);
            $('#newspagenum').val(data.news.pagenum);

            $('#feedbacktitlenum').val(data.feedback.titlenum);
            $('#feedbackcontentnum').val(data.feedback.contentnum);
            $('#feedbacklistnum').val(data.feedback.listnum);
            $('#feedbackpagenum').val(data.feedback.pagenum);
        });
    }

    
    $('a[href="#del"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab$('#likeTable').empty();
        del(null,"/admin/del?pageNow=1");
    });
    $('a[href="#order"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab$('#likeTable').empty();
        order(null,"/admin/order?pageNow=1");
    });
    function order(obj,link="href"){
        $('#orderNavigation').empty();
        $('#msg').empty();
        $('#orderTable').empty();
        let linkStr="";
        if(obj==null){
            linkStr=link;
        }else{
            linkStr=obj.getAttribute(link)
        }
        $.getJSON(linkStr,function (data) {
            $('#orderNavigation').append(data.navPage);
            $('#orderNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {order(null,"/admin/order?pageNow="+this.getAttribute("value"));}});\<\/script\>');
            $('#msg').append(data.messages);
            $.each(data.orders, function(i, order){
                if(order.type!=="d"){
                    let orderName=order.pname;
                    if(orderName.length>0<?php //echo $productConfig['pnamenum']?>){
                        orderName=orderName.substr(0,0<?php //echo $productConfig['pnamenum']?>)+"...";
                    }
                    let btn="",type="";
                    btn+='<button type="button" class="btn btn-info" data-toggle="modal" data-target="#orderDetailModal" data-oid="'+order.oid+'">详情</button>';
                    let str='<tr class="poemitem">'+
                        '<td><a target="_blank" href="/product?pid='+order.pid+'">'+orderName+'</a></td>'+
                        "<td>"+order.pprice+"</td>"+
                        "<td>"+order.number+"</td>"+
                        "<td>"+order.price+"</td>"+
                        "<td>"+order.total+"</td>"+
                        "<td>"+type+"</td>"+
                        "<td>"+order.time+"</td>"+
                        "<td>"+order.tip+"</td>"+
                        "<td>"+btn+"</td>"+
                        "<tr/>";
                    $('#orderTable').append(str);
                }
            });
        });
        return false;
    }
    

    function del(obj,link="href"){
        $('#delNavigation').empty();
        $('#msg').empty();
        $('#delTable').empty();
        let linkStr="";
        if(obj==null){
            linkStr=link;
        }else{
            linkStr=obj.getAttribute(link)
        }
        $.getJSON(linkStr,function (data) {
            $('#delNavigation').append(data.navPage);
            $('#delNavigation').append('\<script\>$("#pageTo").keydown(function(e){if (e.which === 13) {del(null,"/admin/del?pageNow="+this.getAttribute("value"));}});\<\/script\>');
            $('#msg').append(data.messages);
            $.each(data.orders, function(i, order){
                if(order.type==="d"){
                    let orderName=order.pname;
                    if(orderName.length>0<?php //echo $productConfig['pnamenum']?>){
                        orderName=orderName.substr(0,0<?php //echo $productConfig['pnamenum']?>)+"...";
                    }
                    let btn='<button type="button" class="btn btn-info" data-toggle="modal" data-target="#orderDetailModal" data-oid="'+order.oid+'">详情</button>';
                    let str='<tr class="poemitem">'+
                        '<td><a target="_blank" href="/product?pid='+order.pid+'">'+orderName+'</a></td>'+
                        "<td>"+order.pprice+"</td>"+
                        "<td>"+order.number+"</td>"+
                        "<td>"+order.price+"</td>"+
                        "<td>"+order.total+"</td>"+
                        "<td>"+order.time+"</td>"+
                        "<td>"+order.tip+"</td>"+
                        "<td>"+btn+"</td>"+
                        "<tr/>";
                    $('#delTable').append(str);
                }
            });
        });
        return false;
    }
    function send(obj){
        $.getJSON("/admin/send?oid="+$(obj).val(),function(data){
            echoMsg("#msg",data.status,data.result);
        });
    }
    function f(obj){
        $.getJSON("/admin/f?oid="+$(obj).val()+"&tip="+$('#fContent').val(),function(data){
            echoMsg("#msg",data.status,data.result);
        });
    }
    function returned(obj){
        $.getJSON("/admin/returned?oid="+$(obj).val(),function(data){
            echoMsg("#msg",data.status,data.result);
        });
    }
    function notreturn(obj){
        $.getJSON("/admin/notreturn?oid="+$(obj).val()+"&tip="+$('#notreturnContent').val(),function(data){
            echoMsg("#msg",data.status,data.result);
        });
    }
    $("#changeadmin").click(function(){
        let data={email:$('#email').val(),tel:$('#tel').val(),password:$('#password').val(),password1:$('#password1').val()};
        $.post("/admin/changeadmin",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#msg",json.status,json.result);
        });
    });

    $('#orderDetailModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let oid = button.data('oid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this)

        $('#orderdetailTable').empty();
        $.getJSON("/admin/orderdetail?oid="+oid,function (data) {
            if(data.status!==1){
                echoMsg("#orderdetail",data.status,data.result);
            }else{
                let orders=JSON.parse(data.result);
                $.each(orders, function(i, order){
                    let type="";
                    if(order.rtype==="p"){
                        type="待付款";
                    }else if(order.rtype==="b"){
                        type="待发货";
                    }else if(order.rtype==="f"){
                        type="不发货";
                    }else if(order.rtype==="s"){
                        type="待收货";
                    }else if(order.rtype==="g"){
                        type="待评价";
                    }else if(order.rtype==="j"){
                        type="拒绝收货";
                    }else if(order.rtype==="e"){
                        type="已评价";
                    }else if(order.rtype==="t"){
                        type="发起退货等待处理";
                    }else if(order.rtype==="r"){
                        type="已退货";
                    }else if(order.rtype==="n"){
                        type="拒绝退货";
                    }else if(order.rtype==="d"){
                        type="已废弃";
                    }
                    let str='<tr class="poemitem">'+
                        "<td>"+type+"</td>"+
                        "<td>"+order.time+"</td>"+
                        "<td>"+(order.tip===""?"":order.tip)+"</td>"+
                        "<td>"+(order.auid==='null'||order.auid===''||order.auid===null?"":order.auid)+"</td>"+
                        "<tr/>";
                    $('#orderdetailTable').append(str);
                });
            }
        }).fail(function(jqXHR, status, error){
            echoMsg("#orderdetailmsg",4,'未<a href="/admin/login/" target="_blank">登录</a>，暂时无法查看哟！');
        });
    });
</script>