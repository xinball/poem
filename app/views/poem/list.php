
<style>
#aid{
    display: unset;
}
#aname{
    display: unset;
}
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
.find{
    width: 100%;
    text-align: center;
    position: relative;
    margin: auto;
    font-size: 20px;
}
.find input,button, textarea, select , .btn-info{
    /*width:max-content;*/
    font-size: 20px;
}
</style>

</head>
<body>
<datalist id="anameList">
</datalist>
<div class="find">
<form id="find" action="/poem/list" method="get" autocomplete="on" class="form-inline">
    <div class="form-group">
        <label for="did">朝代：</label>
        <select name="did" id="did" class="form-control">
            <option value="">-</option>
            <?php foreach ($dynastys as $dynasty){
                if($dynasty['active']=='1'){?>
                    <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                <?php }}?>
        </select>
    </div>

    <div class="form-group">
        <label for="aname" id="anameLabel">作者：</label>
        <select name="aid" id="aid" class="form-control">
            <option value="">-</option>
        </select>
        <input class="form-control" type="text" id="aname" name="aname" list="anameList" placeholder="请键入诗人/词人">
    </div>

    <div class="form-group">
    <label for="title">题目：</label>
        <input class="form-control" type="text" id="title" name="title" placeholder="请键入题目">
    </div>

    <div class="form-group">
    <label for="content">内容：</label>
        <input class="form-control" type="text" id="content" name="content" placeholder="请键入诗词内容">
    </div>
    <button type="reset" class="btn btn-info">重置</button>
    <button type="submit" class="btn btn-info">查询</button>
    <input name="pageNow" id="pageNow" type="hidden" value="1"/>
</form>
</div>
<?php echo $message;?>
<?php if(isset($poems)&&$poems!=null&&!empty($poems)){?>
<div class="poemlist" id="poemlist">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th style="width: 1%;">#</th>
            <th style="width: 19%;">题目</th>
            <th style="width: 15%;">朝代</th>
            <th style="width: 15%;">作者</th>
            <th style="width: 50%;">诗词内容</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    foreach ($poems as $poem){
        $poemTitle = $poem['title'];
        $poemContent=$poem['content'];
        if(mb_strlen($poemTitle)>$poemConfig['titlenum']){
            $poemTitle = mb_substr($poemTitle,0,$poemConfig['titlenum']);
        }
        if(mb_strlen($poemContent)>$poemConfig['contentnum']){
            $poemContent = mb_substr($poemContent,0,$poemConfig['contentnum']);
        }
        echo
            '<tr class="poemitem">'.
            "<td>".$i++."</td>".
            "<td><a href=\"/poem?pid=".$poem['pid']."\">".$poemTitle."</a></td>".
            "<td><a href=\"/poem/list?did=".$poem['did']."\">".$poem['dname']."</a></td>".
            "<td><a href=\"/poem/list?aid=".$poem['aid']."\">".$poem['aname']."</a></td>".
            "<td>".$poemContent."</td>".
            "<tr/>";
    }
    ?>
    </tbody>
</table>
    <?php echo $navigation;?>
</div>
<?php }?>
<script>
    window.onload=function (){
        <?php if(isset($did)){?>
        select_option_checked("did","<?php echo trim($did);?>");
        changeAid();
        <?php }else if(isset($aname)){?>
        $("#aname").val("<?php echo $aname?>");
        <?php }?>
        <?php if(isset($title)){?>
        $("#title").val("<?php echo $title?>");
         <?php }?>
        <?php if(isset($content)){?>
        $("#content").val("<?php echo trim($content)?>");
         <?php }?>
    };
    $("#aname").keydown(function(e){
        if (e.which === 13&&$("#aname").val()) {
            $('#did').val('');
            $('#aid').val('');
            $("#find").submit();
        }
    });
    $('#aname').change(function(){
        if($('#aname').val()){
            $('#aid').val("");
        }
    });
    $('#aid').change(function(){
        if($('#aid').val())
            $('#aname').val("");
    });
    $('#did').change(function(){
        changeAid();
    });
    async function getData($url, $send = null) {
        const get = () => new Promise(resolve => {
            let request = new XMLHttpRequest();
            request.open("GET", $url);
            request.send($send);
            request.onload = function () {
                if (request.status === 200) {
                    const a = request.responseText;
                    resolve(a);
                }
            };
        });
        return await get();
    }
    function changeAid(){
        var opt=$("#did").val();
        if(!opt){
            $("#aid").val("");
            document.getElementById("aid").innerHTML="<option value=\"\">-</option>";
        }else{
            //const data = JSON.parse(getData("http://poem.xinball.top/author?did="+opt));
            let data='';
            let aid=document.getElementById("aid");
            let anameList=document.getElementById("anameList");
            aid.innerHTML="<option value=\"\">-</option>";
            anameList.innerHTML="";
            getData("https://poem.xinball.top/author/getByRedis?did="+opt).then(a => {
                data=JSON.parse(a);
                for(let i in data){
                    let node=document.createElement("option");
                    node.value=data[i].aid;
                    node.innerHTML=data[i].aname;
                    let nodelist=document.createElement("option");
                    nodelist.value=data[i].aname;
                    aid.appendChild(node);
                    anameList.appendChild(nodelist);
                }
                <?php if(isset($aid)){?>
                select_option_checked("aid","<?php echo trim($aid);?>");
                <?php }else if(isset($aname)){?>
                $("#aname").val("<?php echo $aname?>");
                <?php }?>
            });
        }
    }
    /**
     * 设置select控件选中
     * @param selectId select的id值
     * @param checkValue 选中option的值
     */
    function select_option_checked(selectId, checkValue){
        var select = document.getElementById(selectId);
        for (let i = 0; i < select.options.length; i++){
            if (select.options[i].value === checkValue){
                select.options[i].selected = true;
                break;
            }
        }
    }
</script>
