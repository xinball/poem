
<style>
</style>

</head>
<body>

<?php include APP_PATH . "/app/views/header.php" ?>
<datalist id="anameList">
</datalist>
<nav class="find navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#footer"><i class="bi bi-arrow-down-circle-fill" style="font-size: 36px;color:deepskyblue;"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#list" aria-controls="list" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="list" aria-expanded="false">
            <form id="find" action="/poem/list" method="get" autocomplete="on" class="row row-cols-lg-auto g-3 align-items-center justify-content-center" role="search">
                <div class="col-12">
                    <select name="did" id="did" class="form-select">
                        <option value="">选择朝代</option>
                        <?php foreach ($dynastys as $dynasty){
                            if($dynasty['active']=='1'){?>
                                <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                            <?php }}?>
                    </select>
                </div>
                <div class="col-12">
                    <select name="aid" id="aid" class="form-select">
                        <option value="">-</option>
                    </select>
                </div>
                <div class="col-12">
                    <input class="form-control" type="text" id="aname" name="aname" maxlength="20" list="anameList" placeholder="键入诗人/词人">
                </div>
                <div class="col-12">
                    <input class="form-control" type="text" id="title" name="title" maxlength="20" placeholder="键入题目">
                </div>
                <div class="col-12">
                    <input class="form-control" type="text" id="content" name="content" maxlength="30" placeholder="键入诗词内容">
                </div>
                <div class="col-12">
                    <select name="order" id="order" class="form-select">
                        <option value="number">综合排序</option>
                        <option value="likepoemnumber">按收藏数量排序</option>
                        <option value="commentnumber">按评论数量排序</option>
                    </select>
                </div>
                <br/>
                <div class="btn-group doBtn col-12" role="group" aria-label="...">
                    <button type="reset" class="btn btn-info findbutton">
                        <i class="bi bi-arrow-repeat" style="color:white;"></i>
                    </button>
                    <button type="submit" class="btn btn-outline-danger btn-like findbutton" >
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <input name="pageNow" id="pageNow" type="hidden" value="1"/>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<?php echo $message;?>
<?php if(isset($poems)&&$poems!=null&&!empty($poems)){?>
<!--div class="poemlist" id="poemlist">
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
    /*$i=1;
    foreach ($poems as $poem){
        $poemTitle = $poem['title'];
        $poemContent=$poem['content'];
        if(mb_strlen($poemTitle)>$poemConfig['titlenum']){
            $poemTitle = mb_substr($poemTitle,0,$poemConfig['titlenum'])."……";
        }
        if(mb_strlen($poemContent)>$poemConfig['contentnum']){
            $poemContent = mb_substr($poemContent,0,$poemConfig['contentnum'])."……";
        }
        echo
            '<tr class="poemitem">'.
            "<th>".$i++."</th>".
            "<td><a target='_blank' href=\"/poem?pid=".$poem['pid']."\" >".$poemTitle."</a></td>".
            "<td><a href=\"/poem/list?did=".$poem['did']."\">".$poem['dname']."</a></td>".
            "<td><a href=\"/poem/list?aid=".$poem['aid']."\">".$poem['aname']."</a></td>".
            "<td>".$poemContent."</td>".
            "</tr>";
    }*/
    ?>
    </tbody>
</table>
</div-->
    <div class="row" style="width: 100%;margin: 0;">
        <?php
        $i=1;
        foreach ($poems as $poem){
            $poemContent=$poem['content'];
            if(mb_strlen($poemContent)>$poemConfig['contentnum']){
                $poemContent = mb_substr($poemContent,0,$poemConfig['contentnum'])."……";
            }
            echo '
            <div class="col-sm-6 col-md-4 col-lg-3 mb-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title poemtitle d-inline-block text-truncate" style="width:90%">#<small>'.$i++.'</small> <a target="_blank" href="/poem?pid='.$poem['pid'].'">'.$poem['title'].'</a></h4>
                        <h6 class="poemauthor">【<a href="/poem/list?did='.$poem['did'].'">'.$poem['dname'].'</a>】 <a href="/poem/list?aid='.$poem['aid'].'">'.$poem['aname'].'</a></h6>
                        <p class="card-text poemcontent d-block text-truncate" style="width:95%;">'.$poem['content'].'</p>
                        <div class="btn-group poemBtn" role="group" aria-label="...">
                            <button type="button" class="btn btn-outline-info" disabled>
                                <span id="commentnumber">'.$poem['commentnumber'].'</span> <i class="bi bi-chat-square-dots-fill"></i>
                            </button>
                            <button style="display:'.(!isset($poem['like'])||$poem['like']==0?"unset":"none").';" type="button" class="btn btn-outline-danger btn-like" value="'.$poem['pid'].'" onclick="addlikepoem(this)" id="addlikepoem'.$poem['pid'].'">
                                <span id="addlikenumber'.$poem['pid'].'">'.$poem['likepoemnumber'].'</span> <i class="bi bi-heart"></i>
                            </button>
                            <button style="display:'.(!isset($poem['like'])||$poem['like']==0?"none":"unset").';" type="button" class="btn btn-outline-danger btn-like" value="'.$poem['pid'].'" onclick="dellikepoem(this)" id="dellikepoem'.$poem['pid'].'">
                                <span id="dellikenumber'.$poem['pid'].'">'.$poem['likepoemnumber'].'</span> <i class="bi bi-heart-fill"></i>
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick=\'window.open("/poem?pid='.$poem['pid'].'");\' id="feedbackBtn">
                                <i class="bi bi-journal-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        ?>
        </tbody>
    </div>
    <?php echo $navigation;?>
<?php }?>
<script>
    $(function (){
        <?php if(isset($did)){?>
        select_option_checked("did","<?php echo trim($did);?>");
        changeAid();
        <?php }else if(isset($aname)){?>
        $("#aname").val("<?php echo trim($aname);?>");
        <?php }?>
        <?php if(isset($title)){?>
        $("#title").val("<?php echo trim($title);?>");
        <?php }?>
        <?php if(isset($content)){?>
        $("#content").val("<?php echo trim($content);?>");
        <?php }  if(isset($order)){?>
        if(!select_option_checked("order","<?php echo $order?>")){
            select_option_checked("order","number");
        }
        <?php }else{?>
        select_option_checked("order","number");
        <?php }?>
    });
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
    function changeAid(){
        var opt=$("#did").val();
        if(!opt){
            $("#aid").val("");
            document.getElementById("aid").innerHTML="<option value=\"\">-</option>";
        }else{
            let aid=document.getElementById("aid");
            let anameList=document.getElementById("anameList");
            aid.innerHTML="<option value=\"\">请选择诗人/词人</option>";
            anameList.innerHTML="";
            $.getJSON("/author/getByRedis?did="+opt,function (data) {
                $.each(data,function (i,item) {
                    let node=document.createElement("option");
                    node.value=item.aid;
                    node.innerHTML=item.aname;
                    let nodelist=document.createElement("option");
                    nodelist.value=item.aname;
                    aid.appendChild(node);
                    anameList.appendChild(nodelist);
                });
                <?php if(isset($aid)){?>
                select_option_checked("aid","<?php echo trim($aid);?>");
                <?php }else if(isset($aname)){?>
                $("#aname").val("<?php echo $aname?>");
                <?php }?>
            })
        }
    }

    function addlikepoem(obj){
        $.getJSON("/user/addLikePoem?pid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikepoem'+$(obj).val()).show();
                $('#addlikepoem'+$(obj).val()).hide();
                $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())+1);
                $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())+1);
            }
        });
    }
    function dellikepoem(obj){
        $.getJSON("/user/delLikePoem?pid="+$(obj).val(),function (data) {
            if(echoMsg("#msg",data.status,data.result)===1){
                $('#dellikepoem'+$(obj).val()).hide();
                $('#addlikepoem'+$(obj).val()).show();
                $('#addlikenumber'+$(obj).val()).text(parseInt($('#addlikenumber'+$(obj).val()).text())-1);
                $('#dellikenumber'+$(obj).val()).text(parseInt($('#dellikenumber'+$(obj).val()).text())-1);
            }
        });
    }
</script>
