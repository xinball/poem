
<style>
</style>

</head>
<body>
<?php include APP_PATH . "/app/views/header.php" ?>

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="changeModalLabel">修改朝代信息</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="changemsg"></div>
            <div class="modal-body container-fluid">
                <form id="change" action="" method="post">
                    <input type="hidden" name="didModal" id="didModal">
                    <div class="col-md-12">
                        <label for="dnameModal" class="control-label">朝代名称</label>
                        <input type="text" name="dnameModal" placeholder="请键入朝代名称" class="form-control" id="dnameModal">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="changedynasty" class="btn btn-outline-success">修改</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel">添加朝代</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addmsg"></div>
            <div class="modal-body container-fluid">
                <form id="add" action="" method="post">
                    <div class="col-md-12">
                        <label for="dnameAdd" class="control-label">朝代名称</label>
                        <input type="text" name="dnameAdd" placeholder="请键入朝代名称" class="form-control" id="dnameAdd">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" id="adddynasty" class="btn btn-outline-success">添加</button>
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
            <form id="find" action="/admin/dynastylist" method="get" autocomplete="on" class="row row-cols-lg-auto g-3 align-items-center justify-content-center" role="search">
                <div class="col-12">
                    <input class="form-control" type="text" id="dname" name="dname" maxlength="20" placeholder="键入朝代关键词">
                </div>
                <div class="col-12">
                    <select name="order" id="order" class="form-select">
                        <option value="poemcount">按诗词数量排序</option>
                        <option value="authorcount">按诗人/词人数量排序</option>
                    </select>
                </div>
                <div class="btn-group doBtn col-12" role="group" aria-label="...">
                    <button type="reset" class="btn btn-info findbutton">
                        <i class="bi bi-arrow-repeat" style="color:white;"></i>
                    </button>
                    <button type="button" class="btn btn-default findbutton" style="background:mediumpurple;" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-lg" style="color:white;"></i>
                    </button>
                    <button type="submit" class="btn btn-outline-danger btn-like findbutton">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <input name="pageNow" id="pageNow" type="hidden" value="1"/>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<?php echo $message;?>
<?php if(isset($dynastys)&&$dynastys!=null&&!empty($dynastys)){?>
    <div class="dynastylist table-responsive" id="dynastylist">
        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 25%;">名称</th>
                <th style="width: 25%;">诗人/词人数量</th>
                <th style="width: 25%;">诗词数量</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($dynastys as $dynasty){
                $color="style='background-color:#f2dede;'";
                if($dynasty['active']=='1'){
                    $color="";
                }
                echo
                    '<tr class="poemitem" '.$color.' >'.
                    "<th>".$dynasty['did']."</th>".
                    "<td><a href=\"/admin/authorlist?aid=".$dynasty['did']."\">".$dynasty['dname']."</a></td>".
                    "<td>".$dynasty['authorcount']."</td>".
                    "<td>".$dynasty['poemcount']."</td>".
                    '<td><div class="btn-group doBtn" role="group" aria-label="...">'.
                    ($dynasty['active']!='0'?'<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changeModal" data-did="'.$dynasty['did'].'"><i class="bi bi-gear-wide-connected" style="color: white;"></i></button> '.
                        '<button type="button" class="btn btn-danger" onclick="deldynasty(this);" value='.$dynasty['did'].'><i class="bi bi-trash"></i></button>'
                        :'<button type="button" class="btn btn-success" onclick="recoverdynasty(this);" value='.$dynasty['did'].'><i class="bi bi-arrow-clockwise"></i></button>').
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
        <?php if(isset($dname)){?>
        $("#dname").val("<?php echo trim($dname)?>");
        <?php } if(isset($order))
        if($order=="authorcount"){?>
        select_option_checked("order","authorcount");
        <?php }else{?>
        select_option_checked("order","poemcount");
        <?php }?>
    });
    $('#changeModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let did = button.data('did') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this)
        $.getJSON("/admin/jsondynasty?did="+did,function (data) {
            modal.find('#changeModalLabel').text('修改朝代 ' + data.dname+' 的信息');
            modal.find('#didModal').val(did);
            modal.find('#dnameModal').val(data.dname);
        });
    });

    $("#adddynasty").click(function(){
        let data={dname:$('#dnameAdd').val()};
        $.post("/admin/adddynasty",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#addmsg",json.status,json.result);
        });
    });
    $("#changedynasty").click(function(){
        let data={dname:$('#dnameModal').val(),did:$('#didModal').val()};
        $.post("/admin/changedynasty",data,function(result,status){
            let json=JSON.parse(result);
            echoMsg("#changemsg",json.status,json.result);
        });
    });
    function deldynasty(thisBtn){
        let data={did:$(thisBtn).val()};
        $.post("/admin/deldynasty",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
    function recoverdynasty(thisBtn){
        let data={did:$(thisBtn).val()};
        $.post("/admin/recoverdynasty",data,function(result,status){
            let json=JSON.parse(result);
            if(echoMsg("#msg",json.status,json.result)!==-1){
                window.location.reload();
            }
        });
    }
</script>
