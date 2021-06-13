
<style>

</style>

</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="changeModalLabel">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="changeModalLabel">修改诗词信息</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="changemsg"></div>
            <div class="modal-body">
                <form id="change" action="" method="post">
                    <input type="hidden" name="pidModal" id="pidModal">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="titleModal" class="control-label">诗词标题</label>
                            <input type="text" name="titleModal" class="form-control" id="titleModal" placeholder="请键入诗词标题">
                        </div>
                        <div class="col-md-6">
                            <label for="dynastyModal" class="control-label">朝代</label>
                            <select class="form-select" name="dynastyModal" id="dynastyModal">
                                <option value="">选择朝代</option>
                                <?php foreach ($dynastys as $dynasty){
                                    if($dynasty['active']=='1'){?>
                                        <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                                    <?php }}?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="anameModal" class="control-label">诗人/词人</label>
                            <select class="form-select" name="anameModal" id="anameModal">
                                <option>选择诗人/词人</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="contentModal" class="control-label">诗词内容</label>
                            <textarea name="contentModal" class="form-control" rows="8" style="resize: none;" id="contentModal"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="changepoem" class="btn btn-outline-success">修改</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="addModalLabel">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">添加诗词</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addmsg"></div>
            <div class="modal-body container-fluid">
                <form id="add" action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="titleAdd" class="control-label">诗词题目</label>
                            <input type="text" name="titleAdd" class="form-control" id="titleAdd" placeholder="请键入诗词标题">
                        </div>
                        <div class="col-md-6">
                            <label for="dynastyAdd" class="control-label">朝代</label>
                            <select class="form-select" name="dynastyAdd" id="dynastyAdd">
                                <option value="">选择朝代</option>
                                <?php foreach ($dynastys as $dynasty){
                                    if($dynasty['active']=='1'){?>
                                        <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                                    <?php }}?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="anameAdd" class="control-label">诗人/词人</label>
                            <select class="form-select" name="anameAdd" id="anameAdd">
                                <option>选择诗人/词人</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="contentAdd" class="control-label">诗词内容</label>
                            <textarea name="contentAdd" class="form-control" rows="8" style="resize: none;" id="contentAdd"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="addpoem" class="btn btn-outline-success">添加</button>
            </div>
        </div>
    </div>
</div>
<datalist id="anameList"></datalist>
<nav class="find navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#footer"><i class="bi bi-arrow-down-circle-fill" style="font-size: 36px;color:deepskyblue;"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#list" aria-controls="list" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="list" aria-expanded="false">
                <form id="find" action="/admin/poemlist" method="get" autocomplete="on" class="row row-cols-lg-auto g-3 align-items-center justify-content-center" role="search">
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
                        <select name="aid" id="aid" class="form-control">
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="text" id="aname" name="aname" maxlength="20" list="anameList" placeholder="键入诗人/词人关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="text" id="title" name="title" maxlength="20" placeholder="键入题目关键词">
                    </div>
                    <div class="col-12">
                        <input class="form-control" type="text" id="content" name="content" maxlength="30" placeholder="键入诗词内容关键词">
                    </div>
                    <div class="col-12">
                        <select name="order" id="order" class="form-select">
                            <option value="number">综合排序</option>
                            <option value="likepoemnumber">按收藏数量排序</option>
                            <option value="commentnumber">按评论数量排序</option>
                        </select>
                    </div>
                    <div class="btn-group doBtn col-12" role="group" aria-label="...">
                        <button type="reset" class="btn btn-info findbutton">
                            <i class="bi bi-arrow-repeat" style="color:white;"></i>
                        </button>
                        <button type="button" class="btn btn-default findbutton" style="background:mediumpurple;" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-lg" style="color:white;"></i>
                        </button>
                        <button type="submit" class="btn btn-outline-danger btn-like findbutton" >
                            <i class="bi bi-search" ></i>
                        </button>
                    </div>
                    <input name="pageNow" id="pageNow" type="hidden" value="1"/>
                </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<?php echo $message;?>
<?php if(isset($poems)&&$poems!=null&&!empty($poems)){?>
<div class="poemlist table-responsive" id="poemlist">
<table class="table table-striped table-hover table-condensed " style="min-width: 1400px;">
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 16%;">题目</th>
            <th style="width: 5%;">朝代</th>
            <th style="width: 8%;">作者</th>
            <th style="width: 40%;">诗词内容</th>
            <th style="width: 10%;">收藏数量</th>
            <th style="width: 10%;">评论数量</th>
            <th >操作</th>
        </tr>
    </thead>
    <tbody>
    <?php
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
            '<tr class="poemitem"'.($poem['active']==1&&$poem['dactive']==1&&$poem['aactive']==1?"":"style='background-color: #f2dede;'").'>'.
            "<th>".$poem['pid']."</th>".
            "<td><a target='_blank' href=\"/poem?pid=".$poem['pid']."\">".$poemTitle."</a></td>".
            "<td><a href=\"/admin/poemlist?did=".$poem['did']."\">".$poem['dname']."</a></td>".
            "<td><a href=\"/admin/poemlist?aid=".$poem['aid']."\">".$poem['aname']."</a></td>".
            "<td>".$poemContent."</td>".
            "<td>".$poem['likepoemnumber']."</td>".
            "<td>".$poem['commentnumber']."</td>".
            '<td><div class="btn-group doBtn" role="group" aria-label="...">'.
            ($poem['active']==1?'<button type="button" 
            class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changeModal" data-pid="'.$poem['pid'].'"><i class="bi bi-gear-wide-connected" style="color: white;"></i></button> '.
                '<button type="button" class="btn btn-danger" onclick="delpoem(this);" value='.$poem['pid'].'><i class="bi bi-trash"></i></button>'
                :'<button type="button" class="btn btn-success" onclick="recoverpoem(this);" value='.$poem['pid'].'><i class="bi bi-arrow-clockwise"></i></button>').
            '</div></td>'.
            "</tr>";
    }
    ?>
    </tbody>
</table>
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
        let opt=$("#did").val();
        let aid=document.getElementById("aid");
        if(!opt){
            aid.innerHTML="<option value=\"\">-</option>";
        }else{
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
    $('#dynastyModal').change(function(){
        let opt=$("#dynastyModal").val();
        let anameModal=document.getElementById("anameModal");
        if(!opt){
            anameModal.innerHTML="<option value=\"\">-</option>";
        }else{
            anameModal.innerHTML="<option value=\"\">请选择诗人/词人</option>";
            $.getJSON("/author/getByRedis?did="+opt,function (data) {
                $.each(data,function (i,item) {
                    let node=document.createElement("option");
                    node.value=item.aid;
                    node.innerHTML=item.aname;
                    anameModal.appendChild(node);
                });
            })
        }
    });
    $('#dynastyAdd').change(function(){
        let opt=$("#dynastyAdd").val();
        let anameAdd=document.getElementById("anameAdd");
        if(!opt){
            anameAdd.innerHTML="<option value=\"\">-</option>";
        }else{
            anameAdd.innerHTML="<option value=\"\">请选择诗人/词人</option>";
            $.getJSON("/author/getByRedis?did="+opt,function (data) {
                $.each(data,function (i,item) {
                    let node=document.createElement("option");
                    node.value=item.aid;
                    node.innerHTML=item.aname;
                    anameAdd.appendChild(node);
                });
            })
        }
    });
    $('#changeModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let pid = button.data('pid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this)
        $.getJSON("/admin/jsonpoem?pid="+pid,function (data) {
            modal.find('#changeModalLabel').text('修改诗词 ' + data.title+' 的信息');
            modal.find('#pidModal').val(data.pid);
            modal.find('#titleModal').val(data.title);
            modal.find('#anameModal').val(data.aname);
            modal.find('#contentModal').val(data.content);
            select_option_checked("dynastyModal",data.did);
            $.getJSON("/author/getByRedis?did="+data.did,function (anames) {
                $.each(anames,function (i,item) {
                    let aid=document.getElementById("anameModal");
                    let node=document.createElement("option");
                    node.value=item.aid;
                    node.innerHTML=item.aname;
                    aid.appendChild(node);
                });
                select_option_checked("anameModal",data.aid);
            })
        })
    });
    $("#addpoem").click(function(){
        let data={title:$('#titleAdd').val(),did:$('#dynastyAdd').val(),aid:$('#anameAdd').val(),content:$('#contentAdd').val()};
        $.post("/admin/addpoem",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#addmsg",json.status,json.result);
        });
    });
    $("#changepoem").click(function(){
        let data={pid:$('#pidModal').val(),title:$('#titleModal').val(),did:$('#dynastyModal').val(),aid:$('#anameModal').val(),content:$('#contentModal').val()};
        $.post("/admin/changepoem",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#changemsg",json.status,json.result);
        });
    });
    function delpoem(thisBtn){
        let data={pid:$(thisBtn).val()};
        $.post("/admin/delpoem",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
   function recoverpoem(thisBtn){
        let data={pid:$(thisBtn).val()};
        $.post("/admin/recoverpoem",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
</script>