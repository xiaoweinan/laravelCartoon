<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>@yield('title')</title>
<style type="text/css">
.pagination { display: inline-block; padding-left: 0; margin: 20px 0; border-radius: 4px;}
.pagination li { display: inline; }
.pagination li a,.pagination li span { position: relative; padding: 6px 12px; ; line-height: 1.428571429; text-decoration: none; background-color: #f5fafe; border: 1px solid #ddd; color:black;}
.pagination li:first-child a { margin-left: 0; border-bottom-left-radius: 4px; border-top-left-radius: 4px; }
.pagination li:last-child a { border-top-right-radius: 4px; border-bottom-right-radius: 4px; }
.pagination li a:hover, .pagination li a:focus { background-color: #eee; }
.pagination .active span, .pagination .active span:hover, .pagination .active span:focus { z-index: 2; color: #fff; cursor: default; background-color: #428bca; border-color: #428bca; }
.pagination .disabled span, .pagination .disabled span:hover, .pagination .disabled span:focus { color: #999; cursor: not-allowed; background-color: #fff; border-color: #ddd; }
.pagination-lg li a { padding: 10px 16px; font-size: 18px; }
.pagination-sm li a, .pagination-sm li span { padding: 5px 10px; font-size: 12px; }
</style>
</head>
<body>
@yield('body')
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
@yield('js')
</body>
</html>