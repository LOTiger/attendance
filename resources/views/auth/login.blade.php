<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>考勤系统后台登录</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('auth/css/style.css')}}">
    <script src="{{asset('backend/plugins/layer/layer.js')}}"></script>
</head>
@if(session('tips'))
    <script>
        layer.msg('{{session('tips')['msg']}}', {
            icon: '{{session('tips')['icon']}}',
            time: 720
        });
    </script>
@endif
<body>
    <div class="wrapper">
        <div class="container">
            <h1>Welcome</h1>
            <form class="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <input id="account" type="text" placeholder="邮箱" name="account" value="{{ old('account') }}" required>
                @if ($errors->has('account'))
                    <span class="help-block danger">
                        <strong style="color:#ac2925;">{{ $errors->first('account') }}</strong>
                    </span>
                @endif
                <input id="password" type="password" name="password" placeholder="密码" required>
                @if ($errors->has('password'))
                    <span class="help-block danger">
                        <strong style="color:#ac2925;">{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit" id="login-button">登录</button>
            </form>
            <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
    <script src="{{asset('backend/bower_components/jquery/dist/jquery.min.js')}}"></script>
    {{--<script  src="{{asset('auth/js/index.js')}}"></script>--}}
</body>
</html>