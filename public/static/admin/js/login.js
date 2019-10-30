$(function() {
    $('input[type="submit"]').click((e)=>{
        //防止提交
        e.preventDefault();

        let submitFlag = true;
        let account = $('input[name="account"]').val();
        let password = $('input[name="password"]').val();
        let captcha = $('input[name="captcha"]').val();

        // layer.msg('账号不能为空',{icon:1});
        layer.alert(123);
        if(account == '') {
            layer.msg('账号不能为空',{icon:2});
            return false;
        }

        if(password == '') {
            layer.msg('密码不能为空',{icon:2});
            return false;
        }

        if(captcha == '') {
            layer.msg('验证码不能为空',{icon:2});
            return false;
        }


        //提交
        $.ajax({
            url:'/admin/login',
            data:{'account':account,password:password,captcha:captcha},
            type:'post',
            dataType:'json',
            success:(response)=>{
                if(response.code == '000') {
                    layer.msg('登录成功',{icon:1});
                }else if (response.code === '001') {
                    layer.msg('登录失败',{icon:2});
                }else if (response.code === '002') {
                    //用户未启用
                    layer.msg('用户未启用',{icon:2});
                }else {
                    //其他错误
                }
            }
        });
    });


    //点击更换验证码
    $(".captcha").click(()=>{
        changeCaptcha();
    })
});


/**
 * 更换验证码函数
 */
function changeCaptcha() {
    let captchaUrl = 'http://www.steffenblog.com/index.php/captcha/math?'+Math.random();
    $("img").attr('src',captchaUrl);
}
