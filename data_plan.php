<?php
/**
 * Created by PhpStorm.
 * User: Plumes
 * Date: 2016/2/17
 * Time: 20:01
 */
session_start();
if(intval($_SESSION['userid'])<=0) {
    echo "<script>location.href='login.php';</script>";
    exit;
}
require_once 'meekrodb.2.3.class.php';
$result = DB::query("SELECT * FROM data_plan ORDER BY id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>流量套餐管理</title>
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
                <li><a href="yewu.php">推荐业务管理 </a></li>
                <li><a href="ad.php">广告管理</a></li>
                <li class="active"><a href="data_plan.php">流量套餐管理<span class="sr-only">(current)</span></a></li>
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
                    <th>套餐名称</th>
                    <th>总量</th>
                    <th>价格</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody id="yewu-list">
                <?php foreach($result as $k=>$data_plan):?>
                    <tr>
                        <td><?=($k+1);?></td>
                        <td><?=$data_plan['name'];?></td>
                        <td><?=$data_plan['size'];?> MB</td>
                        <td><?=$data_plan['price'];?> 元</td>
                        <?php if($data_plan['status']==0):?>
                            <td>暂停中</td>
                        <?php else: ?>
                            <td>销售中</td>
                        <?php endif; ?>
                        <td><a href="javascript:void(0);" class="edit-btn" data-id="<?=$data_plan['id'];?>" data-name="<?=$data_plan['name'];?>"  data-price="<?=$data_plan['price'];?>" data-size="<?=$data_plan['size'];?>" data-status="<?=$data_plan['status'];?>">编辑</a></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="create-btn">新建套餐</button>

        </div>
    </div>
</div>

<div class="modal fade" id="edit-data-plan" tabindex="-1" role="dialog" aria-labelledby="editDataPlanLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="data-plan-title"></h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="data-plan-name" class="control-label">套餐名称:</label>
                        <input type="text" class="form-control" id="data-plan-name">
                    </div>
                    <div class="form-group">
                        <label for="data-plan-size" class="control-label">套餐总量:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="data-plan-size">
                            <span class="input-group-addon">MB</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data-plan-price" class="control-label">套餐价格:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="data-plan-price">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="data-plan-status" id="data-plan-status-1" value="1"> 开始销售
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="data-plan-status" id="data-plan-status-0" value="0"> 暂停销售
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
        var dp_tr = $(this).parent().parent();
        var id = $(this).data("id");
        var name = $(this).data("name");
        var size = $(this).data("size");
        var price = $(this).data("price");
        var status = $(this).data("status");

        $("#data-plan-title").text("编辑 "+name);
        $("#data-plan-name").val(name);
        $("#data-plan-size").val(size);
        $("#data-plan-price").val(price);
        $("#data-plan-status-"+status).attr("checked",true);
        $("#edit-confirm").data("id",id);

        $("#edit-data-plan").modal();

    });
    $("#create-btn").click(function() {
        $("#data-plan-title").text("新建套餐");
        $("#data-plan-name").val("");
        $("#data-plan-size").val("");
        $("#data-plan-price").val("0.00");
        $("#data-plan-status-1").attr("checked",true);
        $("#edit-confirm").data("id",0);

        $("#edit-data-plan").modal();
    });
    $("#edit-confirm").click(function() {
        var id = $(this).data("id");
        var name = $("#data-plan-name").val();
        var size = $("#data-plan-size").val();
        var price = $("#data-plan-price").val();
        var status = $("input[name='data-plan-status']:checked").val();

        if(parseInt(id)>0) {
            var api = "api.php?act=edit_data_plan";
            $.post(api,{id:id,name:name,size:size,price:price,status:status},function() {
                location.href=location.href;
            });
        } else {
            var api = "api.php?act=create_data_plan";
            $.post(api,{name:name,size:size,price:price,status:status},function() {
                location.href=location.href;
            });
        }
    });

</script>
</body>
</html>
