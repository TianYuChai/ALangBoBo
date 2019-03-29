<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/login/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('admin/login/assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>多商户管理中心</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{ asset('admin/login/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/login/assets/css/now-ui-kit.css?v=1.1.0') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('admin/login/assets/css/demo.css') }}" rel="stylesheet" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="" />
    <!--  Social tags      -->
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>

<body class="login-page sidebar-collapse">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
    <div class="container">
    </div>
</nav>
<!-- End Navbar -->
<div class="page-header" filter-color="orange">
    <div class="page-header-image" style="background-image:url({{ asset('admin/login/assets/img/login.jpg') }})"></div>
    <div class="container">
        <div class="col-md-4 content-center">
            <div class="card card-login card-plain">
                <form class="form" method="" action="" id="fileinfo">
                    <div class="header header-primary text-center">
                        <div class="logo-container">
                            <img src="{{ asset('admin/login/assets/img/now-logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="content">
                        <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons users_circle-08"></i>
                                </span>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons text_caps-small"></i>
                                </span>
                            <input type="password" class="form-control" name="password"/>
                        </div>
                    </div>
                    <div class="footer text-center">
                        <a href="javascript:void(0)" class="btn btn-primary btn-round btn-lg btn-block">Get Started</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="{{ asset('admin/login/assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/login/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/login/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('admin/login/assets/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('admin/login/assets/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{ asset('admin/login/assets/js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Share Library etc -->
<script src="{{ asset('admin/login/assets/js/plugins/jquery.sharrre.js') }}" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('admin/login/assets/js/now-ui-kit.js?v=1.1.0') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('admin/lib/layer/2.4/layer.js') }}"></script>

<script type="text/javascript">
    $('.btn-block').click(function () {
        var formData = $('#fileinfo').serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method:"POST",
            url:"{!! route('backstage.admin.login') !!}",
            data:formData,
            success:function (res) {
                if(res.status == 200) {
                    layer.msg(res.info);
                    setTimeout(function () {
                        window.location.href = res.url;
                    }, 1000)
                }
            },
            error:function (XMLHttpRequest) {
                //返回提示信息
                var errors = XMLHttpRequest.responseJSON.errors;
                for (var value in errors) {
                    layer.msg(errors[value][0]);return;
                }
            }
        });
    })
</script>
</html>
