<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>登录</title>
    <script src=""></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">

</head>

<body>
<h2>请登录</h2>

<div class="form-group">
    <label for="exampleInputName1">用户名</label>
    <input type="text" class="form-control" id="exampleInputName1" placeholder="用户名" name="u_name">
</div>
<div class="form-group">
    <label for="exampleInputPassword1">密码</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="u_pwd">
</div>
<button class="btn btn-success btn-block" onclick="login()">登录</button>


<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>
<script>
    function login(){
        //e.preventDefault();
        var u_name = document.getElementById('exampleInputName1').value;
        var u_pwd = document.getElementById('exampleInputPassword1').value;
        //alert(u_pwd);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'login',
            data: {u_name:u_name,u_pwd:u_pwd},
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
</body>

</html>
