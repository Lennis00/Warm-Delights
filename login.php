<?php
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
    header("Location:./");
    exit;
}
require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | Warm Delights Bakery</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
    <style>
        html, body{
            height:100%;
        }
        body{
            background-image:url('./images/wallpaper.jpg') !important;
            background-size:cover;
            background-repeat:no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1#sys_title {
            font-size: 2em;
            text-shadow: 3px 3px 10px #000000;
        }
        @media (max-with:700px){
            h1#sys_title {
                font-size: inherit !important;
            }
        }
    </style>
</head>
<body>
   <div class="h-100 d-flex justify-content-center align-items-center">
       <div class='w-100'>
        <h1 class="py-5 text-center text-light px-4" id="sys_title">Warm Delights Bakery</h1>
        <div class="card my-3 col-md-4 offset-md-4 justify-content-center" style="width: 25rem;">
            <div class="card-body rounded-pill m-1 p-3">
                <form action="" id="login-form" class="justify-content-center">
                    <h6 class="card-title text-center">Please enter your credentials.</h6>
                    <div class="form-group">
                        <!-- <label for="username" class="control-label" style="color: darksalmon;">Username</label> -->
                        <input type="text" id="username" placeholder="Username" autofocus name="username" class="form-control form-control-md rounded-pill m-3 p-2" required>
                    </div>
                    <div class="form-group">
                        <!-- <label for="password" class="control-label" style="color: darksalmon;">Password</label> -->
                        <input type="password" id="password" placeholder="Password" name="password" class="form-control form-control-md rounded-pill m-3 p-2" required>
                    </div>
                    <div class="form-group d-flex btn-block w-100 justify-content-center">
                        <button type="submit" class="btn btn-md btn-block active rounded-pill p-2 m-3 my-1" style=" width: 50%; height: 100%; padding: 45px 40px; text-align: center; border: none; border-radius: 30px; transition: .3s; background: darksalmon;">Login</button>
                    </div>
                </form>
            </div>
        </div>
       </div>
   </div>
</body>
<script>
    $(function(){
        $('#login-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            _this.find('button[type="submit"]').text('Loging in...')
            $.ajax({
                url:'./Actions.php?a=login',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        setTimeout(() => {
                            location.replace('./');
                        }, 2000);
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>
</html>