<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>注册</title>
    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">

</head>

<body>
<h2>请注册</h2>
<div class="form-group">
    <label for="uname">用户名</label>
    <input type="text" class="form-control" id="uname" placeholder="用户名" name="u_name">
</div>
<div class="form-group">
    <label for="uemail">邮箱</label>
    <input type="email" class="form-control" id="uemail" placeholder="邮箱" name="u_email">
</div>
<div class="form-group">
    <label for="upwd">密码</label>
    <input type="password" class="form-control" id="upwd" placeholder="Password" name="u_pwd">
</div>
<div class="form-group">
    <label for="yespwd">确认密码</label>
    <input type="password" class="form-control" id="yespwd" placeholder="Password" name="u_pwd1">
</div>
<button class="btn btn-success btn-block" onclick="register()">注册</button>
</body>
<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>
<script>
    function register(){
        //e.preventDefault();
        var u_name = document.getElementById('uname').value;
        var u_pwd = document.getElementById('upwd').value;
        var u_pwd1 = document.getElementById('yespwd').value;
        var u_email = document.getElementById('uemail').value;
        //alert(u_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/register',
            data: {u_name:u_name,u_pwd:u_pwd,u_pwd1:u_pwd1,u_email:u_email},
            async: true, // 异步 || 同步
            dataType: 'json',
            type: 'post',
            timeout: 10000,
            success: function(data) {
                // 请求成功
                if(data.errno == 0){
                    alert(data.msg);
                    location.href = "{{$redirect}}";
                }else{
                    var msg = data.errno + ":" + data.msg;
                    alert(msg);
                }
            },

        });
    }
</script>
</html>
