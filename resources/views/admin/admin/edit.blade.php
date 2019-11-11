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
                    <span class="x-red">*</span>账号
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="username" name="account" value="{{$admin['account']}}" required="" lay-verify="required"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="phone" class="layui-form-label">
                    <span class="x-red">*</span>手机
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="phone" value="{{$admin['phone']}}"  name="phone" required="" lay-verify="phone"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮箱
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" value="{{$admin['email']}}"  required="" lay-verify="email"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="status" class="layui-form-label">
                    状态
                </label>
                <div class="layui-input-inline">
                    @if($admin['status'] == 1)
                        <input type="checkbox" name="status" lay-skin="primary" value="1" title="启用" checked="">
                    @else
                        <input type="checkbox" name="status" lay-skin="primary" value="1" title="启用" >
                    @endif
                </div>
            </div>

            {{--                    <div class="layui-form-item">--}}
            {{--                        <label for="status" class="layui-form-label">--}}
            {{--                            是否为超级管理员--}}
            {{--                        </label>--}}
            {{--                        <div class="layui-input-inline">--}}
            {{--                            <input type="checkbox" name="status" lay-skin="primary" title="启用" checked="">--}}
            {{--                        </div>--}}
            {{--                    </div>--}}

            {{--                  <div class="layui-form-item">--}}
            {{--                      <label class="layui-form-label"><span class="x-red">*</span>角色</label>--}}
            {{--                      <div class="layui-input-block">--}}
            {{--                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="超级管理员" checked="">--}}
            {{--                        <input type="checkbox" name="like1[read]" lay-skin="primary" title="编辑人员">--}}
            {{--                        <input type="checkbox" name="like1[write]" lay-skin="primary" title="宣传人员" checked="">--}}
            {{--                      </div>--}}
            {{--                  </div>--}}
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="password" lay-verify="pass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="password_confirmation"  lay-verify="repass"
                           autocomplete="off" class="layui-input">
                    <input type="hidden" name="id" value="{{$admin['id']}}" />
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button id="edit"  class="layui-btn" lay-filter="edit" lay-submit="">
                    编辑
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('/static/common')}}/jsencrypt/bin/jsencrypt.min.js" charset="utf-8"></script>
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

        //页面加载时获取publicKey
        $.ajax({
            url:'/admin/getPublicKey',
            data:{},
            dataType:'json',
            type:'get',
            success:function(response) {
                //获取公钥
                var publicKey = response.data.publicKey;

                //将公钥保存到本地存储
                localStorage.setItem('publicKey',publicKey);
            }
        });


        var form = layui.form,
            layer = layui.layer;

        $("#edit").click(function(e) {

                var id = $("input[name='id']").val();
                var account = $("input[name='account']").val();
                var password = $("input[name='password']").val();
                var password_confirmation = $("input[name='password_confirmation']").val();
                var email = $("input[name='email']").val();
                var phone = $("input[name='phone']").val();
                var status = $("input[name='status']:checked").val();

                if(password !== password_confirmation) {
                    layer.alert('密码不一致',{icon:2});
                    return false;
                }

                //处理status
                if(status != 1) {
                    status = 0;
                }

                if(password != '') {
                    var encrypt = new JSEncrypt();

                    //在本地存储中获取公钥
                    var publicKey = localStorage.getItem('publicKey');

                    //设置公钥
                    encrypt.setPublicKey(publicKey);

                    //给密码加密
                    password = encrypt.encrypt(password);

                    //给表单赋值
                    $("input[name='password']").val(password);
                }




                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/admin/admin/edit',
                    data:{id:id,account:account,password:password,email:email,phone:phone,status:status},
                    type:'put',
                    dataType:'json',
                    success:function(data) {
                        if(data.status === '000') {
                            layer.msg(data.message,{icon:1});
                            //清除本地存储
                            localStorage.removeItem('publicKey');
                            setTimeout(function() {
                                parent.window.location.reload();
                            },1000);
                        }else if(data.status === '001') {
                            layer.msg(data.message, {icon: 2});
                        }
                        else if(data.status === '002') {
                            layer.msg(data.message,{icon:2});
                        } else {
                            //其他错误
                            $.each(data.errors,function(k,v) {
                                layer.msg(v[0],{icon:2});
                                return false;   //跳出循环
                            });

                            $("input[name='password']").val();
                            $("input[name='password_confirmation']").val();
                        }
                    }
                });
        });
    });
</script>
