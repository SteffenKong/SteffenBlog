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
                <label for="username" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="roleName"  value="{{$role['roleName']}}" name="roleName" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea name="description" id="description" placeholder="请输入内容" class="layui-textarea">{{$role['description']}}</textarea>
                    <input type="hidden" value="{{$role['id']}}" name="id" />
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button id="edit"  class="layui-btn" lay-filter="add" lay-submit="">
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
            var roleName = $("input[name='roleName']").val();
            var description = $("#description").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/admin/role/doEdit',
                data:{id:id,roleName:roleName,description:description},
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
