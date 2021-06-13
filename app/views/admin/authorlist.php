
<style>
</style>

</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="changeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="changeModalLabel">修改诗人/词人信息</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="changemsg"></div>
            <div class="modal-body container-fluid">
                <form id="change" action="" method="post">
                    <input type="hidden" name="aidModal" id="aidModal">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="anameModal" class="control-label">诗人/词人名称</label>
                            <input type="text" name="anameModal" placeholder="请键入诗人/词人名称" class="form-control" id="anameModal">
                        </div>
                        <div class="col-md-12">
                            <label for="didModal" class="control-label">朝代</label>
                            <select name="didModal" id="didModal" class="form-select">
                                <option value="">选择朝代</option>
                                <?php foreach ($dynastys as $dynasty){
                                    if($dynasty['active']=='1'){?>
                                        <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                                    <?php }}?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="changeauthor" class="btn btn-outline-success">修改</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">添加诗人/词人</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addmsg"></div>
            <div class="modal-body container-fluid">
                <form id="add" action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="anameAdd" class="control-label">诗人/词人名称</label>
                            <input type="text" name="anameAdd" placeholder="请键入诗人/词人名称" class="form-control" id="anameAdd">
                        </div>
                        <div class="col-md-12">
                            <label for="didAdd" class="control-label">朝代</label>
                            <select name="didAdd" id="didAdd" class="form-select">
                                <option value="">选择朝代</option>
                                <?php foreach ($dynastys as $dynasty){
                                    if($dynasty['active']=='1'){?>
                                        <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                                    <?php }}?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="addauthor" class="btn btn-outline-success">添加</button>
            </div>
        </div>
    </div>
</div>

<nav class="find navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#footer"><i class="bi bi-arrow-down-circle-fill" style="font-size: 36px;color:deepskyblue;"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#list" aria-controls="list" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="list" aria-expanded="false">
            <form id="find" action="/admin/authorlist" method="get" autocomplete="on" class="row row-cols-lg-auto g-3 align-items-center justify-content-center" role="search">
                <div class="col-12">
                    <input class="form-control" type="text" id="aname" name="aname" maxlength="20" placeholder="键入诗人/词人关键词">
                </div>
                <div class="col-12">
                    <select name="did" id="did" class="form-select">
                        <option value="">选择朝代</option>
                        <?php foreach ($dynastys as $dynasty){
                            if($dynasty['active']=='1'){?>
                                <option value="<?php echo $dynasty['did'];?>"><?php echo $dynasty['dname'];?></option>
                            <?php }}?>
                    </select>
                </div>
                <div class="btn-group doBtn col-12" role="group" aria-label="...">
                    <button type="reset" class="btn btn-info findbutton">
                        <i class="bi bi-arrow-repeat" style="color:white;"></i>
                    </button>
                    <button type="button" class="btn btn-default findbutton" style="background:mediumpurple;" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-person-plus-fill" style="color:white;"></i>
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
<?php if(isset($authors)&&$authors!=null&&!empty($authors)){?>
    <div class="authorlist table-responsive" id="authorlist">
        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 25%;">名称</th>
                <th style="width: 25%;">朝代</th>
                <th style="width: 25%;">诗词数量</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($authors as $author){
                $color="style='background-color:#f2dede;'";
                if($author['active']=='1'&&$author['dactive']=='1'){
                    $color="";
                }
                echo
                    '<tr class="poemitem" '.$color.' >'.
                    "<th>".$author['aid']."</th>".
                    "<td><a href=\"/admin/poemlist?aid=".$author['aid']."\">".$author['aname']."</a></td>".
                    "<td><a href=\"/admin/authorlist?did=".$author['did']."\">".$author['dname']."</a></td>".
                    "<td>".$author['poemcount']."</td>".
                    '<td><div class="btn-group doBtn" role="group" aria-label="...">'.
                    ($author['active']!='0'?'<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changeModal" data-aid="'.$author['aid'].'"><i class="bi bi-gear-wide-connected" style="color: white;"></i></button> '.
                        '<button type="button" class="btn btn-danger" onclick="delauthor(this);" value='.$author['aid'].'><i class="bi bi-trash"></i></button>'
                        :'<button type="button" class="btn btn-success" onclick="recoverauthor(this);" value='.$author['aid'].'><i class="bi bi-arrow-clockwise"></i></button>').
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
        <?php }if(isset($aname)){?>
        $("#uname").val("<?php echo trim($aname)?>");
        <?php }?>
    });
    $('#changeModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let aid = button.data('aid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this)
        $.getJSON("/admin/jsonauthor?aid="+aid,function (data) {
            modal.find('#changeModalLabel').text('修改诗人/词人 ' + data.aname+' 的信息');
            modal.find('#aidModal').val(aid);
            modal.find('#anameModal').val(data.aname);
            select_option_checked("didModal",data.did);
        })
    });

    $("#addauthor").click(function(){
        let data={aname:$('#anameAdd').val(),did:$('#didAdd').val()};
        $.post("/admin/addauthor",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#addmsg",json.status,json.result);
        });
    });
    $("#changeauthor").click(function(){
        let data={aid:$('#aidModal').val(),aname:$('#anameModal').val(),did:$('#didModal').val()};
        $.post("/admin/changeauthor",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#changemsg",json.status,json.result);
        });
    });
    function delauthor(thisBtn){
        let data={aid:$(thisBtn).val()};
        $.post("/admin/delauthor",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
    function recoverauthor(thisBtn){
        let data={aid:$(thisBtn).val()};
        $.post("/admin/recoverauthor",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
</script>
