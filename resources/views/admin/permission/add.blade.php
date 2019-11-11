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
                          <input type="text" id="permissionName" name="permissionName" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">上级权限</label>
                        <div class="layui-input-inline">
                            <select name="parentId" id="parentId">
                                <option value="0">顶级权限</option>
                                @foreach($perissions as $permission)
                                    <option value="{{$permission['id']}}">{{$permission['permissionName']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            路由url
                        </label>
                        <div class="layui-input-inline">
                            <input type="text" id="url" name="url" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">请求方法</label>
                        <div class="layui-input-inline">
                            <select name="method">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                                <option value="DELETE">DELETE</option>
                                <option value="PUT">PUT</option>
                            </select>
                        </div>
                    </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button id="add"  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
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

        $("#add").click(function(e) {
            var permissionName = $("input[name='permissionName']").val();
            var parentId = $("select[name='parentId']").val();
            var url = $("input[name='url']").val();
            var method = $("select[name='method']").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/admin/permission/doAdd',
                data:{permissionName:permissionName,parentId:parentId,url:url,method:method},
                type:'post',
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
