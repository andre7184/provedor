<?php 
include("../_conf.php");
if(!isset($_SESSION['id_userfc'])){
	header("Location: login.php?page=$page");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MK FÁCIL - ADMIN</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/dialog/bootstrap-dialog.min.css">
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	
    <div id="wrapper">
		<div class="modal show" id="page-loader" role="dialog">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-body">
		          <div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>
		        </div>
		      </div>
		    </div>
		</div>
        <!-- Navigation -->
        <nav id="page-navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom: 0">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="groupbt">
		        <div class="col-xs-9">
			        <a href="index.php" class="btn bts btleft">MK FÁCIL 1.0</a>
			    </div>
			    <div class="col-xs-3">
			        <a href="#" class="btn dropdown-toggle bts btright" data-toggle="dropdown"><i class="fa fa-cubes fa-fw"></i>:<?php echo $_SESSION['grupo'];?><i class="fa fa-caret-down"></i></a>
			        <ul class="dropdown-menu">
                    <?php if($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){?>
                    	<li>
                            <div>
                              	<i class="fa fa-fw"></i>Mudar de Grupo
                            </div>
                        </li>
                    	<li class="divider"></li>
                    	<?php if(isset($_SESSION['grupos'])){
                    		foreach ($_SESSION['grupos'] as $grupo) {
                    			if($grupo!=$_SESSION['grupo']){
                    		?>
		 						<li>
		                            <a class="dropdown-toggle" data-toggle="dropdown" onclick="setGrupo('<?php echo $grupo;?>')" href="#">
		                                <div>
		                                    <i class="fa fa-arrow-circle-right fa-fw"></i><?php echo $grupo;?>
		                                </div>
		                            </a>
		                        </li> 
                        <?php }}}?>
                        <li class="divider"></li>
       					<li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Cadastrar/Alterar</a></li>
                    <?php }?>
                        <li><a href="../logar.php?logout=true"><i class="fa fa-sign-out fa-fw"></i> Logs</a></li>
                    </ul>
	            </div>
            </div>
	        <ul class="nav navbar-top-links navbar-right">
            	<li class="dropdown">
				<a class="dropdown-toggle btn-success" data-toggle="dropdown" href="#">MENU<i class="fa fa-navicon fa-fw"></i> <i class="fa fa-caret-down"></i></a>
				<ul class="dropdown-menu menu">
                    <li>
                    	<a href="<?php echo "index.php?page=home.php";?>"><i class="fa fa-home fa-fw"></i> Home</a>
                    </li>
                    <li class="dropdown-header"><i class="fa fa-users fa-fw"></i> CLIENTES</li>
                    <li>
	                	<a href="<?php echo "index.php?page=clientes_busca.php";?>"><i class="spacemenu"></i><i class="fa fa-search fa-fw"></i>Buscar Cliente</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=clientes_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Todos</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=clientes_edit.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Cadastrar/Alterar Dados</a>
	            	</li> 
                    <li>
	                	<a href="<?php echo "index.php?page=clientes_serv.php";?>"><i class="spacemenu"></i><i class="fa fa-calendar fa-fw"></i>Cadastrar/Alterar Serviço Mensal</a>
	            	</li>
                    <li>
	                	<a href="<?php echo "index.php?page=clientes_itens.php";?>"><i class="spacemenu"></i><i class="fa fa-money fa-fw"></i>Cadastrar Créditos/Débitos</a>
	            	</li>
	            	<li>
	                	<a href="caixa.php" target="_blank"><i class="spacemenu"></i><i class="fa fa-money fa-fw"></i>Cadastrar Recebimento</a>
	            	</li>
                    <li class="dropdown-header"><i class="fa fa-credit-card fa-fw"></i> Financeiro</li>
                    <li>
	                	<a href="<?php echo "index.php?page=pagamentos_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Pagamentos</a>
	                </li>                    
	                <li>
	                	<a href="<?php echo "index.php?page=recebiveis_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Recebiveis</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=cobrancas_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Cobranças</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=dividas_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Dívidas</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=itens_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Créditos/Débitos</a>
	                </li>
                    <li>
	                	<a href="<?php echo "index.php?page=encargos_list.php";?>"><i class="spacemenu"></i><i class="fa fa-list fa-fw"></i>Listar Encargos</a>
	                </li>
	               	<li class="dropdown-header"><i class="fa fa-users fa-fw"></i> SERVIÇOS</li>
      				<li>
                   		<a href="<?php echo "index.php?page=edit_servicos.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Cadastrar/Alterar</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_servicos.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Listar</a>
               		</li>
	               	<li class="dropdown-header"><i class="fa fa-users fa-fw"></i> PRODUTOS</li>
      				<li>
                   		<a href="<?php echo "index.php?page=edit_produtos.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Cadastrar/Alterar</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_produtos.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Listar</a>
               		</li>
               		<li class="dropdown-header"><i class="fa fa-bar-chart-o fa-fw"></i> CAIXA</li>
      				<li>
                   		<a href="<?php echo "index.php?page=list_caixa.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Movimentação</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_caixa.php?tipo=in";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Entradas</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_caixa.php?tipo=out";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Saídas</a>
               		</li>
               		<li class="dropdown-header"><i class="fa fa-sitemap fa-fw"></i> MIKROTIK</li>
      				<li>
                   		<a href="<?php echo "index.php?page=list_mkkauth.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>RB autenticação</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mktrans.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>RB Transmissão</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mkacessos.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Acessos</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_wirelless.php";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Wirelless</a>
               		</li>
               		<li class="dropdown-header"><i class="spacemenu"></i><i class="fa fa-sitemap fa-fw"></i> SECRETS</li>
               		<li>
                   		<a href="<?php echo "index.php?page=edit_mksecrets.php";?>"><i class="spacemenu"></i><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Cadastrar/Alterar</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mksecrets.php";?>"><i class="spacemenu"></i><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Listar</a>
               		</li>
               		<li class="dropdown-header"><i class="spacemenu"></i><i class="fa fa-sitemap fa-fw"></i> PROFILES</li>
               		<li>
                   		<a href="<?php echo "index.php?page=edit_mkprofiles.php";?>"><i class="spacemenu"></i><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Cadastrar/Alterar</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mkprofiles.php";?>"><i class="spacemenu"></i><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Listar</a>
               		</li>
               		<li class="dropdown-header"><i class="fa fa-sitemap fa-fw"></i> CONFIGURAÇÕES</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mktrans";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Provedor</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mkacessos.php?tipo=out";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Boleto</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_mkacessos.php?tipo=out";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Usuários</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_caixa.php?tipo=out";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Grupos</a>
               		</li>
               		<li>
                   		<a href="<?php echo "index.php?page=list_caixa.php?tipo=out";?>"><i class="spacemenu"></i><i class="fa fa-edit fa-fw"></i>Previlégios</a>
               		</li>
        		</ul>
        		</li>
                <li class="dropdown">
                    <a class="dropdown-toggle btn-warning" data-toggle="dropdown" href="#">Alerts <font color=red>5</font>
                        <i class="fa fa-bell fa-fw"></i><i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle btn-info" data-toggle="dropdown" href="#"><?php echo $_SESSION['login_userfc'];?>
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                         <li><a href="#"><i class="fa fa-user fa-fw"></i> Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../logar.php?logout=true"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
        <div id="page-space" class="col-xs-12" style="height:60px;"></div>
	    <div id="page-wrapper">
			<?php 
				if (file_exists($page)){
					include_once($page);
					
				}
			?>
	    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/dialog/bootstrap-dialog.min.js"></script>
	<?php 
		if($scripts){
			echo $scripts;
		}
	?>
 
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>
