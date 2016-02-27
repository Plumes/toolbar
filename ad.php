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
$result = DB::query("SELECT * FROM ad ORDER BY id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>广告管理</title>
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
                <li><a href="yewu.php">推荐业务管理</a></li>
                <li class="active"><a href="ad.php">广告管理<span class="sr-only">(current)</span></a></li>
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
                    <th>图片</th>
                    <th>广告链接</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody id="yewu-list">
                <?php foreach($result as $k=>$ad):?>
                <tr>
                    <td><?=($k+1);?></td>
                    <td><img src="<?=$ad['image'];?>" alt=""></td>
                    <td><a href="<?=$ad['link'];?>"><?=$ad['link'];?></a></td>
                    <?php if($ad['status']==0):?>
                        <td>暂停中</td>
                    <?php else: ?>
                        <td>正常</td>
                    <?php endif; ?>
                    <td><a href="javascript:void(0);" class="edit-btn" data-id="<?=$ad['id'];?>" data-link="<?=$ad['link'];?>" data-status="<?=$ad['status'];?>">编辑</a></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="create-btn">添加广告</button>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-ad" tabindex="-1" role="dialog" aria-labelledby="editAdLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ad-title">编辑广告</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="ad-image" class="control-label">广告图片地址:</label>
                        <input type="text" class="form-control" id="ad-image">
                    </div>
                    <div class="form-group">
                        <label for="ad-link" class="control-label">广告链接:</label>
                        <input type="text" class="form-control" id="ad-link">
                    </div>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="ad-status" id="ad-status-1" value="1"> 开始显示
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="ad-status" id="ad-status-0" value="0"> 暂停显示
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
        var ad_tr = $(this).parent().parent();
        var id = $(this).data("id");
        var image = $(ad_tr).find("img").attr("src");
        var link = $(this).data("link");
        var status = $(this).data("status");

        $("#ad-link").val(link);
        $("#ad-image").val(image);
        $("#ad-status-"+status).attr("checked",true);
        $("#edit-confirm").data("id",id);

        $("#edit-ad").modal();

    });
    $("#create-btn").click(function() {
        $("#ad-title").text("新建广告");
        $("#ad-image").val("");
        $("#ad-link").val("");
        $("#ad-status-1").attr("checked",true);
        $("#edit-confirm").data("id",0);

        $("#edit-ad").modal();
    });
    $("#edit-confirm").click(function() {
        var id = $(this).data("id");
        var image = $("#ad-image").val();
        var link = $("#ad-link").val();
        var status = $("input[name='ad-status']:checked").val();

        if(parseInt(id)>0) {
            var api = "api.php?act=edit_ad";
            $.post(api,{id:id,image:image,link:link,status:status},function() {
                location.href=location.href;
            });
        } else {
            var api = "api.php?act=create_ad";
            $.post(api,{image:image,link:link,status:status},function() {
                location.href=location.href;
            });
        }
    });

</script>
</body>
</html>
