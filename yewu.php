<?php
/**
 * Created by PhpStorm.
 * User: Plumes
 * Date: 2016/2/17
 * Time: 20:01
 */
require_once 'meekrodb.2.3.class.php';
$result = DB::query("SELECT * FROM yewu ORDER BY id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>推荐业务管理</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style>
        #yewu-list td{
            height: 50px;
            line-height: 50px;
        }
        #yewu-list td img {
            height: 40px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="yewu.php">推荐业务管理 <span class="sr-only">(current)</span></a></li>
                <li><a href="ad.php">广告管理</a></li>
                <li><a href="data_plan.php">流量套餐管理</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>图标</th>
                    <th>业务名称</th>
                    <th>业务状态</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody id="yewu-list">
                <?php foreach($result as $k=>$yewu):?>
                <tr>
                    <td><?=($k+1);?></td>
                    <td><img src="<?=$yewu['icon'];?>" alt=""></td>
                    <td><?=$yewu['name'];?></td>
                    <?php if($yewu['status']==0):?>
                        <td>暂停中</td>
                    <?php else: ?>
                        <td>销售中</td>
                    <?php endif; ?>
                    <td><a href="javascript:void(0);" class="edit-btn" data-id="<?=$yewu['id'];?>" data-name="<?=$yewu['name'];?>" data-status="<?=$yewu['status'];?>">编辑</a></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="create-btn">新建业务</button>

        </div>
    </div>
</div>

<div class="modal fade" id="edit-yewu" tabindex="-1" role="dialog" aria-labelledby="editYewuLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="yewu-title"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="yewu-name" class="control-label">业务名称:</label>
                        <input type="text" class="form-control" id="yewu-name">
                    </div>
                    <div class="form-group">
                        <label for="yewu-icon" class="control-label">业务图片:</label>
                        <input type="text" class="form-control" id="yewu-icon">
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="yewu-status" id="yewu-status-1" value="1"> 开始销售
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="yewu-status" id="yewu-status-0" value="0"> 暂停销售
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="edit-confirm">确认</button>
            </div>
        </div>
    </div>
</div>
<script>
$(".edit-btn").click(function() {
    var yewu_tr = $(this).parent().parent();
    var id = $(this).data("id");
    var icon = $(yewu_tr).find("img").attr("src");
    var name = $(this).data("name");
    var status = $(this).data("status");

    $("#yewu-title").text("编辑 "+name);
    $("#yewu-name").val(name);
    $("#yewu-icon").val(icon);
    $("#yewu-status-"+status).attr("checked",true);
    $("#edit-confirm").data("id",id);

    $("#edit-yewu").modal();

});
$("#create-btn").click(function() {
    $("#yewu-title").text("新建业务");
    $("#yewu-name").val("");
    $("#yewu-icon").val("");
    $("#yewu-status-1").attr("checked",true);
    $("#edit-confirm").data("id",0);

    $("#edit-yewu").modal();
});
$("#edit-confirm").click(function() {
    var id = $(this).data("id");
    var name = $("#yewu-name").val();
    var icon = $("#yewu-icon").val();
    var status = $("input[name='yewu-status']:checked").val();

    if(parseInt(id)>0) {
        var api = "api.php?act=edit_yewu";
        $.get(api,{id:id,name:name,icon:icon,status:status},function() {
            location.href=location.href;
        });
    } else {
        var api = "api.php?act=create_yewu";
        $.post(api,{name:name,icon:icon,status:status},function() {
            location.href=location.href;
        });
    }
});

</script>
</body>
</html>
