<?php
	include("../_conf.php");
	if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
		header("Location: index.php?page=".$page);
	}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MK FÁCIL - LOGIN</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
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
                        <h3 class="panel-title">MK FÁCIL - LOGIN</h3>
                    </div>
                    <div class="panel-body">
						<?php 
							if($_SESSION['process_result'] && isset($_SESSION['process_result'])){
						?>
                        <div class="alert alert-danger">
                           	ERROR:<?php echo $_SESSION['process_result'];?>
                        </div>
                        <?php
							}
						?>
                    	<form action="../logar.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="login" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <input name="page" type="hidden" value="index.php">
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login-submit" id="login-submit" class="btn btn-lg btn-success btn-block"  value="Login">
                            </fieldset>
                      	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
