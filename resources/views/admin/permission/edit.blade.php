<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    @include('/admin/common/meta')
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form" onsubmit="return false;">
            <div class="layui-form-item">
                <label for="permissionName" class="layui-form-label">
                    <span class="x-red">*</span>权限名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="permissionName" value="{{$permission['permissionName']}}" name="permissionName" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">上级权限</label>
                <div class="layui-input-inline">
                    <select name="parentId" id="parentId">
                        <option value="0">顶级权限</option>
                        @foreach($allPermission as $val)
                            @if($permission['parentId'] == $val['id'])
                                  <option value="{{$val['id']}}" selected="selected">{{$val['permissionName']}}</option>
                            @else
                                <option value="{{$val['id']}}">{{$val['permissionName']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="username" class="layui-form-label">
                    路由url
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="url" name="url" value="{{$permission['url']}}"  autocomplete="off" class="layui-input">
                    <input type="hidden" value="{{$permission['id']}}" name="id" />
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">请求方法</label>
                <div class="layui-input-inline">
                    <select name="method">
                        <option value="GET" @if($permission['method'] == 'GET') selected="selected" @endif>GET</option>
                        <option value="POST" @if($permission['method'] == 'POST') selected="selected" @endif>POST</option>
                        <option value="DELETE" @if($permission['method'] == 'DELETE') selected="selected" @endif>DELETE</option>
                        <option value="PUT" @if($permission['method'] == 'PUT') selected="selected" @endif>PUT</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button id="edit"  class="layui-btn"  lay-submit="">
                    编辑
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script type="text/javascript">

    layui.use(['form', 'layer'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;
        });



    $(function() {
        var form = layui.form,
            layer = layui.layer;

        $("#edit").click(function(e) {
            var id = $("input[name='id']").val();
            var permissionName = $("input[name='permissionName']").val();
            var parentId = $("#parentId:selected").val();
            var url = $("input[name='url']").val();
            var method = $("select[name='method']:selected").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/admin/permission/doEdit',
                data:{id:id,permissionName:permissionName,parentId:parentId,url:url,method:method},
                type:'put',
                dataType:'json',
                success:function(data) {
                    console.log(data);
                    if(data.status === '000') {
                        layer.msg(data.message,{icon:1});
                        setTimeout(function() {
                            parent.window.location.reload();
                        },1000);
                    }else if(data.status === '001') {
                        layer.msg(data.message,{icon:2});
                    }else {
                        //其他错误
                        $.each(data.errors,function(k,v) {
                            layer.msg(v[0],{icon:2});
                            return false;   //跳出循环
                        });
                    }
                }
            });
        });
    });
</script>
