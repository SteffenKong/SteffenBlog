$(function() {

    //页面加载时获取publicKey
    $.ajax({
        url:'getPublicKey',
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


    $('input[type="submit"]').click(function(e) {
        //防止提交
        e.preventDefault();

        var submitFlag = true;
        var account = $('input[name="account"]').val();
        var password = $('input[name="password"]').val();
        var captcha = $('input[name="captcha"]').val();

        // layer.msg('账号不能为空',{icon:1});
        if (account == '') {
            layer.msg('账号不能为空', {icon: 2});
            return false;
        }

        if (password == '') {
            layer.msg('密码不能为空', {icon: 2});
            return false;
        }

        if (captcha == '') {
            layer.msg('验证码不能为空', {icon: 2});
            return false;
        }

        var encrypt = new JSEncrypt();

        //在本地存储中获取公钥
        var publicKey = localStorage.getItem('publicKey');

        //设置公钥
        encrypt.setPublicKey(publicKey);

        //给密码加密
        var passWord = encrypt.encrypt(password);

        //给表单赋值
        $('input[name="password"]').val(passWord);

        //加密后清除本地存储
        localStorage.removeItem('publicKey');

        //提交
        $.ajax({
            url: '/admin/sign',
            data: {'account': account, password: passWord, captcha: captcha},
            type: 'post',
            dataType: 'json',
            success: function () {
                if (response.code == '000') {
                    layer.msg('登录成功', {icon: 1});
                    setTimeout(function() {
                        window.location = '/admin/index';
                    },1000);
                } else if (response.code === '001') {
                    layer.msg('登录失败', {icon: 2});
                } else if (response.code === '002') {
                    //用户未启用
                    layer.msg('用户未启用', {icon: 2});
                } else {
                    //其他错误
                }
            }
        });
    });


    //点击更换验证码
    $(".captcha").click(function () {
        changeCaptcha();
    });
});


/**
 * 更换验证码函数
 */
function changeCaptcha() {
    var captchaUrl = 'http://www.steffenblog.com/index.php/captcha/math?'+Math.random();
    $("img").attr('src',captchaUrl);
}
