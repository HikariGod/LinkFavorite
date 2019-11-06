<html>
<head>
    {include=header}
    <title>Hikari-网站收藏夹编辑</title>
</head>

<body>
<center><a class="title" href="{indexPage}"><h1>编辑{@ $t=='link'?'链接':'分类'}</h1></a></center>
<center><h4><a class="btn btn-default" href="{indexPage}?edit">返回</a></h4></center>
<br>
<div class="container">
    <div class="row">
        <form active="" method="post">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                {if $t=='link'}
                    <div class="form-group">
                        <label for="f_name">链接名称：</label>
                        <input name="f_name" type="f_name" value="{outData.f_name}" class="form-control" id="f_name" placeholder="请输入链接名称">
                    </div>
                    <div class="form-group">
                        <label for="f_url">链接地址：</label>
                        <input name="f_url" type="f_url" value="{outData.f_url}" class="form-control" id="f_url" placeholder="请输入链接地址">
                    </div>
                    <div class="form-group">
                        <label for="t_id">链接分类：</label>
                        <select name="t_id" id="t_id" class="form-control">
                            {foreach types:$v}
                                <option value="{v.t_id}" {@selected($outData['t_id'], $v['t_id'])}>{v.t_name}</option>
                            {/foreach}
                        </select>
                    </div>
                {elseif $t=='type'}
                    <div class="form-group">
                        <label for="t_name">分类名称：</label>
                        <input name="t_name" type="t_name" value="{outData.t_name}" class="form-control" id="t_name" placeholder="请输入分类名称">
                    </div>
                {/if}
                <button type="submit" class="btn btn-default">修改</button>
            </div>
        </form>
    </div>
    <br>
</div>

{include=footer}
</body>

</html>