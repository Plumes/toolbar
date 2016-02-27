$("body").append('<div class="cmcc-panel"><div class="container"></div></div><div class="cmcc-toolbar"><div class="container"><div class="logo" id="cmcc-logo"><img src="http://192.168.33.10:8080/image/logo.gif" alt="" /></div></div></div>');
var content = '<div class="left-bar"><div class="app-btn" id="liuliang"><img src="http://192.168.33.10:8080/image/logo.gif" alt="" /><p class="title">流量查询</p></div>';
content += '<div class="app-btn" id="data-plan"><img src="http://192.168.33.10:8080/image/logo.gif" alt="" /><p class="title">套餐办理</p></div>';
content += '<div class="app-btn" id="yewu"><img src="http://192.168.33.10:8080/image/logo.gif" alt="" /><p class="title">业务办理</p></div>';
content += '<div class="app-btn" id="ad"><img src="http://192.168.33.10:8080/image/logo.gif" alt="" /><p class="title">最新活动</p></div></div>';
$(".cmcc-toolbar").find(".logo").before(content);

$(document).ready(function() {
    $(".cmcc-panel").hide();
    $(".cmcc-toolbar").find(".left-bar").hide();
    //获取功能列表
    var api = "http://192.168.33.10:8080/api.php?act=get_btn";
    $.ajax( {
        url: api,
        dataTpye: "jsonp",
        success: function( response ) {
            response = JSON.parse(response);
            console.log( response ); // server response
        }
    });
});

//获取流量情况
$("#liuliang").click(function() {
    $(".cmcc-panel").find(".container").empty();
    var api = "http://192.168.33.10:8080/api.php?act=get_liuliang";
    $.ajax( {
        url: api,
        dataTpye: "jsonp",
        success: function( response ) {
            response = JSON.parse(response);
            var content = "";
            var total_size = 0;
            var total_used = 0;
            for(var i in response) {
                var package = response[i];
                total_size += parseInt(package['size']);
                total_used += parseFloat(package['used']);
                content += '<div class="package"><div class="intro"><div class="item" style="width: 40%;text-align: left;">'+package['name']+'</div><div class="item">'+package['size']+'</div><div class="item">'+package['used']+'</div><div class="item" style="text-align: right;">'+(parseInt(package['size']) - parseFloat(package['used'])).toFixed(2)+'</div></div>';
                var used_per = parseFloat(package['used'])/parseInt(package['size'])*100;
                content += '<div class="data-bar"><div class="used" style="width: '+used_per.toFixed(2)+'%;"></div><div class="remain" style="width: '+(100-used_per).toFixed(2)+'%;"></div></div></div>'
            }
            var total_remain = (total_size-total_used).toFixed(2);
            content = '<div class="total-package"><div class="item"><p class="title">总流量</p><p class="num">'+total_size+'MB</p></div><div class="item"><p class="title">剩余流量</p><p class="num" style="color: #9ee035;">'+total_remain+'MB</p></div></div>' + content;
            content = '<div id="close-btn" style="color: #fff;">X</div>' + content;
            $(".cmcc-panel").find(".container").append(content);
            $(".cmcc-panel").show();
        }
    });
});

//获取流量套餐列表
$("#data-plan").click(function() {
    $(".cmcc-panel").find(".container").empty();
    var api = "http://192.168.33.10:8080/api.php?act=get_data_plan";
    $.ajax( {
        url: api,
        dataTpye: "jsonp",
        success: function( response ) {
            response = JSON.parse(response);
            var content = '<div class="plan-wrapper">';
            for(var i in response['data']) {
                var plan = response['data'][i];
                content += '<div class="plan"><div class="title">'+plan['name']+'</div><div class="price">'+plan['price']+' 元</div><div class="oper"><a href="javascript:void(0);" class="buy-plan-btn" data-id="'+plan['id']+'">订购</a></div></div>';
            }
            content += "</div>";
            content = '<div id="close-btn">&times;</div>'+content;
            $(".cmcc-panel").find(".container").append(content);
            $(".cmcc-panel").show();
        }
    });
});

//获取业务列表
$("#yewu").click(function() {
    $(".cmcc-panel").find(".container").empty();
    var api = "http://192.168.33.10:8080/api.php?act=get_yewu";
    $.ajax( {
        url: api,
        dataTpye: "jsonp",
        success: function( response ) {
            response = JSON.parse(response);
            var content = '<div class="yewu-wrapper">';
            for(var i in response) {
                var yewu = response[i];
                console.log(yewu);
                content += '<div class="yewu"><img src="'+yewu['image']+'" alt="" /><p class="title">'+yewu['name']+'</p><a href="javascript:void(0);" class="buy-yewu-btn" data-yewu-id="'+yewu['id']+'">订购</a></div>';
            }
            content += "</div>";
            content = '<div id="close-btn">X</div>'+content;
            $(".cmcc-panel").find(".container").append(content);
            $(".cmcc-panel").show();
        }
    });
});

//获取最近活动
$("#ad").click(function() {
    $(".cmcc-panel").find(".container").empty();
    var api = "http://192.168.33.10:8080/api.php?act=get_ad";
    $.ajax( {
        url: api,
        dataTpye: "jsonp",
        success: function( response ) {
            response = JSON.parse(response);
            var content = "";
            for(var i in response) {
                var ad = response[i];
                content += '<div class="ad-wrapper"><a href="'+ad['link']+'"><img src="'+ad['image']+'" alt="" /></a></div>';
            }
            content = '<div id="close-btn">X</div>'+content;
            $(".cmcc-panel").find(".container").append(content);
            $(".cmcc-panel").show();
        }
    });
});

$(".cmcc-panel").on('click',"#close-btn",function() {
    $(".cmcc-panel").hide();
});

$("#cmcc-logo").click(function() {
    $(".cmcc-toolbar").find(".left-bar").toggle();
    if($(".cmcc-panel").css("display")=="block") {
        $(".cmcc-panel").hide();
    }
})

$(".cmcc-panel").on('click','.buy-yewu-btn',function() {
    var api = "http://192.168.33.10:8080/api.php";
    var yewu_id = $(this).data("yewuId");
    $.get(api,{act:"buy_yewu",id:yewu_id},function() {
        location.href=location.href;
    })
});

$(".cmcc-panel").on('click','.buy-plan-btn',function() {
    var api = "http://192.168.33.10:8080/api.php";
    var plan_id = $(this).data("id");
    $.get(api,{act:"buy_data_plan",id:plan_id},function() {
        location.href=location.href;
    })
});