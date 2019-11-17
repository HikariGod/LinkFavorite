
<html>
<head>
    {include=header}
    <title>Hikari-网站收藏夹</title>
</head>

<body>
<center><a class="title" href="{indexPage}"><h1>网站收藏夹<h1></a></center>
<center>
    <form action="" method="post" class="form-inline">
        {verifyHtml}
    </form>
</center>
{if $check}
<center><h4><a class="btn btn-default" href="{addPage}?t=link">添加链接</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="{addPage}?t=type">添加分类</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-info" href="{@getUrl('edit', 'del')}{@ $edit?'':'edit'}">{@ $edit?'取消编辑':'编辑模式'}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-danger" href="{@getUrl('del', 'edit')}{@ $del?'':'del'}">{@ $del?'取消删除':'删除模式'}</a></h4></center>
{/if}
<br>
<input type="hidden" id="linkid" linkid="0">
<input type="hidden" id="typeid" typeid="0">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <a href="{indexPage}" class="list-group-item active">快速导航分类</a>
            {foreach types:$v3}
                {if $del}
                    <!-- {@getUrl()}id={v3.t_id}&type=true -->
                    <a class="list-group-item list-group-item-danger" typeid="{v3.t_id}" onclick="setid('type', this);syalert.syopen('alert2')" href="#">{v3.t_name} --- 删除</a>
                {elseif $edit}
                    <a class="list-group-item list-group-item-info" href="{editPage}?id={v3.t_id}&t=type">{v3.t_name} --- 编辑</a>
                {elseif isset($_GET['type'])}
                    <a href="{@getUrl('type')}type={v3.t_id}" class="list-group-item">{v3.t_name}</a>
                {else}
                    <a href="{@getUrl('del')}#{v3.t_id}" class="list-group-item">{v3.t_name}</a>
                {/if}
            {/foreach}
        </div>
    </div>
    <br>
    {foreach types:$v1}
    {if isset($_GET['type'])}
        {if $v1['t_id']!=$_GET['type']}
            {:continue}
        {/if}
    {/if}
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <a id="{v1.t_id}" href="{@getUrl('type')}type={v1.t_id}" class="list-group-item active">{v1.t_name}</a>
            {foreach links:$v2}
                {if $v1['t_id']==$v2['t_id']}
                    {if $del}
                        <!-- {@getUrl()}id={v2.f_id} -->
                        <a class="list-group-item list-group-item-danger" linkid="{v2.f_id}" onclick="setid('link', this);syalert.syopen('alert1')" href="#">{v2.f_name} --- 删除</a>
                    {elseif $edit}
                        <a class="list-group-item list-group-item-info" href="{editPage}?id={v2.f_id}&t=link">{v2.f_name} --- 编辑</a>
                    {else}
                        <a class="list-group-item" {target} href="{v2.f_url}">{v2.f_name}</a>
                    {/if}
                {/if}
            {/foreach}
        </div>
    </div>
    <br>
    {/foreach}
</div>

<!-- 确认弹窗 -->
<div class="sy-alert animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="confirm" sy-mask="true" id="alert1">
    <div class="sy-title">提示</div>
    <div class="sy-content">你确定要删除吗？</div>
    <div class="sy-btn">
        <button onClick="syalert.syhide('alert1')">取消</button>
        <button onClick="delok('link')">确定</button>
    </div>
</div>
<!-- 确认弹窗 -->
<div class="sy-alert animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="confirm" sy-mask="true" id="alert2">
    <div class="sy-title">提示</div>
    <div class="sy-content">你确定要删除吗？</div>
    <div class="sy-btn">
        <button onClick="syalert.syhide('alert2')">取消</button>
        <button onClick="delok('type')">确定</button>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script src="static/js/popper.min.js"></script>
<script>
    $('.badge').click(function(){
        var linkid=$(this).attr('link');
        aletr('你要删除的链接ID是'+linkid+'没错吧？');
    });
    function setid(type, _this) {
        if(type == 'link'){
            var linkid = $(_this).attr('linkid');
            $('#linkid').attr('linkid', linkid);
        }else{
            var typeid = $(_this).attr('typeid');
            $('#typeid').attr('typeid', typeid);
        }
        //alert(linkid);
    }
    function delok(type) {
        if(type == 'link'){
            var id = $('#linkid').attr('linkid');
            location.href="{@getUrl()}id="+id;
        }else{
            var id = $('#typeid').attr('typeid');
            location.href="{@getUrl()}id="+id+"&type=true";
        }
        //alert(id);
    }
</script>
</body>

</html>