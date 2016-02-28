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
require 'redis.class.php';
$redis = new Credis_Client('localhost');
$domains = $redis->keys("*");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>劫持域名管理</title>
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
                <li><a href="yewu.php">业务管理</a></li>
                <li><a href="ad.php">广告管理</a></li>
                <li><a href="data_plan.php">流量套餐管理</a></li>
                <li class="active"><a href="domain.php">劫持域名管理 <span class="sr-only">(current)</span></a></li>
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
                    <th>域名</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody id="yewu-list">
                <?php $i=1;?>
                <?php foreach($domains as $domain):?>
                    <?php if($redis->get($domain)!="192.168.33.10") continue;?>
                <tr>
                    <td><?=($i++);?></td>
                    <td><?=$domain;?></td>
                    <td><a href="javascript:void(0);" class="edit-btn" data-domain="<?=$domain;?>" >删除</a></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" id="create-btn">增加域名</button>

        </div>
    </div>
</div>

<div class="modal fade" id="add-domain" tabindex="-1" role="dialog" aria-labelledby="addDomainLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="domain-title">增加域名</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="domain-val" class="control-label">域名:</label>
                        <input type="text" class="form-control" id="domain-val" placeholder="www.example.com">
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
    var domain = $(this).data("domain");
    var api = "api.php?act=delete_domain";
    $.post(api,{domain:domain},function() {
        location.href=location.href;
    });
});
$("#create-btn").click(function() {
    $("#domain-val").val("");
    $("#edit-confirm").data("id",0);
    $("#add-domain").modal();
});
$("#edit-confirm").click(function() {
    var id = $(this).data("id");
    var domain = $("#domain-val").val();

    var api = "api.php?act=add_domain";
    $.post(api,{domain:domain},function() {
        location.href=location.href;
    });
});

</script>
</body>
</html>
