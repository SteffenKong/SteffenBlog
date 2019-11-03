<!doctype html>
<html class="x-admin-sm">
<head>
    @include('/admin/common/meta')
</head>
<body class="index">
    @include('/admin/common/header')
<!-- 中部开始 -->
    @include('/admin/common/menu')

    @yield('content')
<!-- 中部结束 -->
</body>

</html>
