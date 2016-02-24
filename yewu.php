<?php
/**
 * Created by PhpStorm.
 * User: Plumes
 * Date: 2016/2/17
 * Time: 20:01
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>推荐业务管理</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
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
                <li><a href="#">流量套餐管理</a></li>
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
                    <th>操作</th>
                </tr>
                </thead>

                <tbody id="yewu-list">
                <tr>
                    <td>1</td>
                    <td><img src="http://192.168.33.10:8080/image/logo.gif" alt=""></td>
                    <td>彩铃</td>
                    <td><a href="">停止</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
