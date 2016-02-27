<?php
/**
 * Created by PhpStorm.
 * User: Plumes
 * Date: 2016/2/17
 * Time: 20:01
 */
require_once 'meekrodb.2.3.class.php';
if(isset($_POST['username'])) {
    $result = DB::queryFirstRow("SELECT * FROM manager WHERE username=%s AND password=%s",$_POST['username'],$_POST['password']);
    if(!empty($result)) {
        session_start();
        $_SESSION['userid'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        echo "<script>location.href='yewu.php';</script>";
        exit;
    } else {
        echo "<script>location.href=location.href;</script>";
        exit;
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
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
    </div>
</nav>
<div class="container">
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form action="" method="post">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">登陆</button>
        </form>
    </div>
</div>
</div>
</body>
</html>