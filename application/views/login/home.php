<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Авторизация администратора</title>

    <!-- Maniac stylesheets -->
    <link rel="stylesheet" href="<?php echo Params::plugins() ?>bootstrap/3.3.7/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo Params::plugins() ?>icon/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo Params::plugins() ?>animate/animate.css" />
    <link rel="stylesheet" href="<?php echo Params::plugins() ?>bootstrapValidator/bootstrapValidator.min.css" />
    <link rel="stylesheet" href="<?php echo Params::plugins() ?>iCheck/all.css" />
    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/style.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login fixed">
<div class="wrapper animated flipInY">
    <div class="logo"><a href="#"><i class="fa fa-bolt"></i> <span>VIA Panel 2.0</span></a></div>
    <div class="box">
        <div class="header clearfix">
            <div class="pull-left"><i class="fa fa-sign-in"></i> Вход</div>
            <div class="pull-right"><a href="<?php echo $params['url_site'] ?>"><i class="fa fa-times"></i></a></div>
        </div>
        <div><?php if(isset($error)) echo $error ?></div>
        <form id="loginform" method="post">
            <div class="box-body padding-md">
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Пароль"/>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-block">Войти</button>
                    <input type="hidden" name="auth" value="user">
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Javascript -->
<script src="<?php echo $params['theme'] ?>js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="<?php echo $params['theme'] ?>js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>

<!-- Interface -->
<script src="<?php echo $params['theme'] ?>js/plugins/pace/pace.min.js" type="text/javascript"></script>

<!-- Forms -->
<script src="<?php echo $params['theme'] ?>js/plugins/bootstrapValidator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#loginform')
            .bootstrapValidator({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Вы не ввели email адрес'
                            },
                            emailAddress: {
                                message: 'Вы ввели не верный email адрес'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Вы не ввели пароль'
                            }
                        }
                    }
                }
            });

    });
</script>
</body>
</html>