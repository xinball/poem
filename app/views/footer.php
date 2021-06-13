
<div class="footer" id="footer">
    <?php use library\RedisConnect;
    echo RedisConnect::getHashKey("basic","copyright");?>
</div>
<script>


    let handler=function(hash){
        let target = $(hash.slice(1));
        if(!target) return;
        let targetOffset=$(hash).offset().top-56;
        $('html,body').animate({scrollTop:targetOffset},300);
    }
    window.onload=function(){
        scroll();
        if(location.hash){
            handler(location.hash);
        }
    }
    $(function(){
        if(location.hash){
            handler(location.hash);
        }
    });

    function scroll(){
        /*$(window).hashchange(function(){
            let target=$(location.hash);
            if(target.length===1){
                let top=target.offset().top-56;
                if(top>0){
                    $('html,body').animate({scrollTop:top},1000);
                }
            }
        });*/
        $('a[href^="#"][href!="#"]').click(function(){
            handler(this.hash);
            return true;
        });
    }
    $('#commentModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) // Button that triggered the modal
        let type = button.data('type') // Extract info from data-* attributes
        let id = button.data(type+'id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        let modal = $(this);
        modal.find('#idModal').val(id);
        modal.find('#typeModal').val(type);
        if(type==='p'){
            $.getJSON("/user/jsonpoem?pid="+id,function (data) {
                let title=(data.title.length>9?data.title.substr(0,6)+'...':data.title);
                modal.find('#commentModalLabel').text('');
                modal.find('#commentModalLabel').append('为诗词 <strong>' + title + '</strong> 发表评论');
                modal.find('#titleModal').removeAttr("readonly");
                modal.find('#contentModal').removeAttr("readonly");
            }).fail(function(jqXHR, status, error){
                echoMsg("#commentmsg",4,'未<a href="/user/login/" target="_blank">登录</a>，暂时无法发表评论哟！');
                modal.find('#titleModal').attr("readonly","readonly");
                modal.find('#contentModal').attr("readonly","readonly");
            });
        }else if(type==='c'){
            $.getJSON("/user/jsoncomment?cid="+id,function (data) {
                let title;
                if(data.title===''){
                    title=data.content.substr(0,5)+'...';
                }else{
                    title=data.title;
                }
                modal.find('#commentModalLabel').text('');
                modal.find('#commentModalLabel').append('为评论 <strong>' + title + '</strong> 发表评论');
                modal.find('#titleModal').removeAttr("readonly");
                modal.find('#contentModal').removeAttr("readonly");
            }).fail(function(jqXHR, status, error){
                echoMsg("#commentmsg",4,'未<a href="/user/login/" target="_blank">登录</a>，暂时无法发表评论哟！');
                modal.find('#titleModal').attr("readonly","readonly");
                modal.find('#contentModal').attr("readonly","readonly");
            });
        }
    });

</script>

</body>
</html>