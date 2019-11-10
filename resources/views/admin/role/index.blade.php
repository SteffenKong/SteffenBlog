<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/2.3/layer.js" charset="utf-8"></script>
    <link rel="stylesheet" href="{{asset('/static/admin')}}/css/font.css">
    <link rel="stylesheet" href="{{asset('/static/admin')}}/css/xadmin.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('/static/admin')}}/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('/static/admin')}}/js/xadmin.js"></script>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">角色管理</a>
            <a>
              <cite>角色列表</cite></a>
          </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5" method="GET" action="/admin/role/index">
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="roleName"  placeholder="请输入角色名" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn" onclick="xadmin.open('添加用户','/admin/role/add',600,300)"><i class="layui-icon"></i>添加</button>
                </div>
                <div class="layui-card-body">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>角色名</th>
                            <th>描述</th>
                            <th>创建时间</th>
                            <th>编辑时间</th>
                            <th>操作</th>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role['id']}}</td>
                            <td>{{$role['roleName']}}</td>
                            <td><a href="#" data="{{$role['description']}}">查看描述</a></td>
                            <td>{{$role['createdAt']}}</td>
                            <td>{{$role['updatedAt']}}</td>
                            <td class="td-manage">
                                <a title="编辑"  onclick="xadmin.open('编辑','/admin/role/update/{{$role['id']}}')" href="javascript:;">
                                    <i class="layui-icon">&#xe642;</i>
                                </a>
                                <a title="删除" onclick="member_del(this,{{$role['id']}})" href="javascript:;">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="layui-card-body ">
                    <div class="page">
                        {{$paginate->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });


    /*角色-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //发异步删除数据
            $.ajax({
                url:'/admin/role/delete/'+id,
                data:null,
                dataType:'json',
                type:'delete',
                success:function(response) {
                    if(response.status === '000') {
                        layer.msg(response.message,{icon:1});
                        $(obj).parents("tr").remove();
                    }else {
                        layer.msg(response.message,{icon:2});
                        window.setInterval(function() {
                            window.location.reload();
                        },1000);
                    }
                }
            });
        });
    }

</script>
</html>
