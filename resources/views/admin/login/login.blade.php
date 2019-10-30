<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>孔浩源个人博客 - 后台系统</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('/static/admin')}}/css/font.css">
    <link rel="stylesheet" href="{{asset('/static/admin')}}/css/login.css">
    <link rel="stylesheet" href="{{asset('/static/admin')}}/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('/static/admin')}}/lib/layui/layui.js" charset="utf-8"></script>
    <script src="{{asset('/static/common')}}/jsencrypt/jsencrypt.min.js" charset="utf-8"></script>
    <script src="{{asset('/static/admin')}}/js/login.js" charset="utf-8"></script>
{{--    <script src="{{asset('/static/admin')}}/js/layer/layer.js" charset="utf-8"></script>--}}
    <script src="https://cdn.bootcss.com/layer/2.3/layer.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">

    <div class="login layui-anim layui-anim-up">
        <div class="message">孔浩源博客系统-登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" >
            <input name="account" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="text" lay-verify="required" placeholder="验证码" style="width:90px; float:left;"  type="text" class="layui-input">
            <img src="{!! captcha_src('math') !!}" class="captcha" style="float:left;  margin-left:10px; height: 50px; width:240px;" />
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
</body>
</html>
