<?php
header('Access-Control-Allow-Origin: *');
require_once 'meekrodb.2.3.class.php';
$act = $_GET['act'];
call_user_func($act);
function get_ip (){
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

function get_liuliang() {
    $mysqli = new mysqli("localhost", "root", "123456qwe", "toolbar");
    $mysqli->set_charset('utf8');
    $ip_addr = get_ip();
    $sql = "SELECT * FROM user_liuliang where `ip`='".$ip_addr."' ORDER BY id ASC";
    $res = $mysqli->query($sql);
    $len = $mysqli->affected_rows;
    if($len<=0) {
        $size_list = [10,30,50,100,500,1000];
        $size = $size_list[array_rand($size_list)];
        $used = sprintf("%.2f",rand(0,$size*100)/100);
        $liuliang = [["name"=>"基础流量包","used"=>$used,"size"=>$size]];
        $sql = "INSERT INTO user_liuliang (`ip`,`name`,`used`,`size`)VALUES('".$ip_addr."','基础流量包',".$used.",".$size.")";
        $mysqli->query($sql);
        $mysqli->commit();
    } else {
        while ($row = $res->fetch_assoc()) {
            $liuliang[] = array(
                "id" =>$row['id'],
                "name"=>$row['name'],
                "used"=>$row['used'],
                "size"=>$row['size']
            );
            $used = (floatval($row['used'])*100+rand(0,5))/100;
            $used = $used>$row['size']?$row['size']:$used;
            $used = sprintf("%.2f",$used);
            $sql = "UPDATE user_liuliang SET `used`='".$used."' WHERE `id`=".$row['id'];
            $mysqli->query($sql);
        }

    }
    echo(json_encode($liuliang));
}

function get_yewu() {
    $mysqli = new mysqli("localhost", "root", "123456qwe", "toolbar");
    $mysqli->set_charset('utf8');
    $ip_addr = get_ip();
    $sql = "SELECT * FROM user where `ip`='".$ip_addr."'";
    $res = $mysqli->query($sql);
    $row = $res->fetch_assoc();
    if($row) {
        $bought_list = $row['yewu'];
    } else {
        $bought_list = "-1";
    }
    $sql = "SELECT * FROM yewu where id NOT IN (".$bought_list.") AND status=1 LIMIT 0,9";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $yewu[] = array(
            "id" => $row['id'],
            "image"=>$row['icon'],
            "name"=>$row['name']
        );
    }
    echo(json_encode($yewu));
}

function create_yewu() {
    $yewu['status'] = intval($_POST['status']);
    $yewu['name'] = $_POST['name'];
    $yewu['icon'] = $_POST['icon'];

    DB::insert("yewu",$yewu);
    echo(json_encode(['code'=>0]));
}

function edit_yewu() {
    $yewu_id = $_GET['id'];
    $status = intval($_GET['status']);
    if(in_array($status,[0,1])) {
        DB::update("yewu",array("status"=>$status),"id=%i",$yewu_id); 
    }
    $name = $_GET['name'];
    if(strlen($name)>1) {
        DB::update("yewu",array("name"=>$name),"id=%i",$yewu_id);
    }

    $icon = $_GET['icon'];
    if(strlen($icon)>1) {
        DB::update("yewu",array("icon"=>$icon),"id=%i",$yewu_id);
    }
    
    echo(json_encode(['code'=>0]));
}

function buy_yewu() {
    $yewu_id = intval($_GET['id']);
    $ip_addr = get_ip();
    $result = DB::query("SELECT * FROM user WHERE ip=%s",$ip_addr);
    if(empty($result)) {
        $data['ip'] = $ip_addr;
        $data['yewu'] = strval($yewu_id);
        DB::insert("user", $data);
    } else {
        $yewu_list = explode(",", $result[0]['yewu']);
        if (!in_array($yewu_id, $yewu_list)) {
            $yewu_list[] = $yewu_id;
        }
        $yewu_list = join(',', $yewu_list);
        DB::update("user", array("yewu" => $yewu_list), "id=%i", $result[0]['id']);
    }
    echo(json_encode(['code'=>0]));
}

//广告位管理
function get_ad() {
    $mysqli = new mysqli("localhost", "root", "123456qwe", "toolbar");
    $mysqli->set_charset('utf8');
    $ip_addr = get_ip();
    $sql = "SELECT * FROM ad WHERE status=1 LIMIT 0,3";
    $res = $mysqli->query($sql);
    while ($row = $res->fetch_assoc()) {
        $ad_list[] = array(
            "image"=>$row['image'],
            "link"=>$row['link']
        );
    }
    echo(json_encode($ad_list));
}

function create_ad() {
    $ad['image'] = $_POST['image'];
    $ad['link'] = $_POST['link'];
    $ad['status'] = $_POST['status'];
    DB::insert("ad",$ad);
    echo(json_encode(['code'=>0]));
}

function edit_ad() {
    $ad_id = intval($_POST['id']);
    $ad['image'] = $_POST['image'];
    $ad['link'] = $_POST['link'];
    $ad['status'] = $_POST['status'];
    DB::update("ad",$ad,"id=%i",$ad_id);
    echo(json_encode(['code'=>0]));
}

function delete_ad() {
    $ad_id = intval($_GET['id']);
    DB::delete("ad","id=%i",$ad_id);
    echo(json_encode(['code'=>0]));
}

//流量套餐管理
function create_data_plan() {
    $plan['name'] = $_POST['name'];
    $plan['size'] = $_POST['size'];
    $plan['status'] = $_POST['status'];
    DB::insert("data_plan", $plan);
    echo(json_encode(['code'=>0]));
}

function edit_data_plan() {
    $plan_id = intval($_POST['id']);
    $plan['name'] = $_POST['name'];
    $plan['size'] = $_POST['size'];
    $plan['status'] = $_POST['status'];
    DB::update("data_plan",$plan,"id=%i",$plan_id);
    echo(json_encode(['code'=>0]));
}

function delete_data_plan() {
    $plan_id = intval($_GET['id']);
    DB::delete("data_plan","id=%i",$plan_id);
    echo(json_encode(['code'=>0]));
}

function get_data_plan() {
    $ip_addr = get_ip();
    $sql = "SELECT * FROM data_plan WHERE id NOT IN (SELECT plan_id FROM user_liuliang WHERE ip=%s) AND status=1";
    $result = DB::query($sql,$ip_addr);
    echo json_encode(['code'=>0,"data"=>$result]);
}

function buy_data_plan() {
    $ip_addr = get_ip();
    $plan_id = intval($_GET['id']);
    $plan = DB::queryFirstRow('SELECT * FROM data_plan WHERE id=%i', $plan_id);

    $data['ip'] = $ip_addr;
    $data['name'] = $plan['name'];
    $data['size'] = $plan['size'];
    $data['used'] = 0;
    $data['plan_id'] = $plan['id'];

    DB::insert("user_liuliang", $data);
    echo(json_encode(['code'=>0]));
}
?>