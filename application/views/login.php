<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Computer Science Stock</title>

    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/plugins/metisMenu/metisMenu.min.css') ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/css/sb-admin-2.css') ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('assets/bootstrap-sb-admin-2/font-awesome-4.1.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form id="form" role="form" method="post" action="<?php echo base_url("login/check");?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                
                                
                                <div class="checkbox">
                                    <label id="errorMessage">
                                         <h5 style="color:red;"><?php echo ( $error != 'message_login' ? $error : "");?> </h5>
                                    </label>
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block" > Login </button>
                                <!--<a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/jquery-1.11.0.js') ?>"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/bootstrap.min.js') ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/plugins/metisMenu/metisMenu.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap-sb-admin-2/js/sb-admin-2.js') ?>"></script>

</body>

<script type="text/javascript">
    $(function(){
//        var errorMessage = "<?php echo $error; ?>";
//        if(errorMessage !== "message_login"){
//            alert(errorMessage);
//        }
    });
    
    
    $(function() {
//        $( "input[type=submit], input[type=reset]" ).button();
        $( "#form" ).submit(function( event ) {
            $(".hide").hide().find("span").html("");
            $("input[name=username], input[name=password]").each(function(){
                var $this = $(this);
                if($this.val() === ""){
//                    var $error = $("#"+$this.attr("name"));
                    
                    
//                    $("input[name=password]").css("border-color", "red");
                    
                    
                    $this.css("border-color", "red");
//                    $error.fadeIn(1000).find("span").html("This Field is Require").delay(3000).fadeOut(1000);
                    $this.focus();
                    event.preventDefault();
                    return;
                }
            });


        });

        $("[name=user]").focus();

        $("#errorMessage").fadeIn(1000).delay(3000).fadeOut(1000);
    });
</script>
</html>
