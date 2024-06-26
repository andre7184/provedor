<?php
include("../_conf.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MK FÁCIL - CAIXA</title>  

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
        <!-- Navigation -->
        <?php 
        if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
        ?>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><b>Caixa <?php echo '(<font class="small" color="blue"><b>'.$_SESSION['login_userfc'].'</b></font>)';?></b></a>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">MENU<i class="fa fa-navicon fa-fw"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i>Página Inicial</a></li>
                  	<li><a href="cadastro.php"><i class="fa fa-user-plus fa-fw"></i>Novo Cliente</a></li>
                  	<li><a href="#"><i class="fa fa-users fa-fw"></i>Listar Clientes</a></li>
                    <li><a href="recebimentos.php"><i class="fa fa-dollar fa-fw"></i>Recebimentos</a></li>
                    <li><a href="inadimplentes.php"><i class="fa fa-tags fa-fw"></i>Dívidas</a></li>
                    <li><a href="#"><i class="fa fa-cogs fa-fw"></i>Configurações</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="../logar.php?logout=true&page=caixa.php"><i class="fa fa-close fa-fw"></i>Logout</a></li>
                  </ul>
                </li> 
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        <?php 
        }
        ?>
	    <div id="page-wrapper">
        	<div class="panel-body">
					<?php 
					if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
					?>
						<div class="row">
							<div class="form-group input-group">
								<span class="input-group-addon">Cliente</span>
								<input class="form-control clearable" id="name_cliente_add" type="text" name="chained">
							</div>
							<center>
								<button onclick="getFaturas($('[name=\'id_cliente\']').val(),'ab');" type="submit" class="btn btn-outline btn-warning">Aberta(s)</button>
								<button onclick="getFaturas($('[name=\'id_cliente\']').val(),'pg');" type="submit" class="btn btn-outline btn-success">Paga(s)</button>
								<button onclick="getFaturas($('[name=\'id_cliente\']').val(),'cx');" type="submit" class="btn btn-outline btn-info">Pg(s)</button>
								<div style="height:20px;"></div>	
							</center>
							<div class="col-lg-12">
								<div class="list-group" id="local_faturas">
								</div>
							</div> 
							<input id="data_hoje" value="<?php echo date('d/m/Y')?>" type="hidden">
							<input id="dados_retorno_pagamento" type="hidden">
							<input id="dados_retorno_boleto" type="hidden">
							<input id="tels_cliente_caixa" type="hidden">
						</div>
					<?php
					}else{
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
                                <input name="page" type="hidden" value="caixa.php">
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login-submit" id="login-submit" class="btn btn-lg btn-success btn-block"  value="Login">
                            </fieldset>
                      	</form>
                    <?php 
					}
                    ?>  	
        	</div>
    	</div>
    </div>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<?php 
   if(isset($_SESSION['id_userfc']) && $_SESSION['id_userfc']>0){
?>
	<script src="../vendor/dialog/bootstrap-dialog.min.js"></script>
	<link rel="stylesheet" href="../vendor/autocomplete/bootcomplete.css">
	<script type="text/javascript" src="../vendor/autocomplete/bootcomplete.js"></script>
	<!-- Bootstrap datepicker JS and CSS -->
	<script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../vendor/datepicker/js/locales/bootstrap-datepicker.pt-BR.js"></script>
	<link rel="stylesheet" href="../vendor/datepicker/css/datepicker.css"></link>
	<script src="../js/cadastro.js"></script>
	<script src="../js/bloqueios.js?"></script>
	<script src="../js/cobrancas.js?"></script>
	<script src="../js/recibo.js"></script>
	<script src="../js/mask.js"></script>
	<script type="text/javascript">
		var dataHoje='<?php echo date('d/m/Y')?>'; 
		$(function($){
			$('#name_cliente_add').bootcomplete({
			    url:'../_ajax.php',
			    minLength : 3,
			    method:'post',
			    idField:true,
			    idFieldName:'id_cliente',
			    dataParams:{
			    	'cmd':'busca',
			    	'tipo':'clientes'
			    }
			});
			$("[name='id_cliente']").change(function() {
				getFaturas($(this).val()); //CARREGA SELECT
			});
			$('#dados_retorno_pagamento').on('change', function() {
				getFaturas($("[name='id_cliente']").val()); //CARREGA SELECT
				openRecibo($(this).val());
			});
			$('#dados_retorno_boleto').on('change', function() {
				openBoleto($(this).val());
			});
			// CLEARABLE INPUT
			function tog(v){return v?'addClass':'removeClass';} 
			$(document).on('input', '.clearable', function(){
				$(this)[tog(this.value)]('x');
			}).on('mousemove', '.x', function( e ){
			    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
			}).on('click', '.onX', function(){
			    $(this).removeClass('x onX').val('').change();
			});
			//www.bijudesigner.com
		});
		function getMask(tipo){
			if(tipo=='data')
				$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
			if(tipo=='valor')
				$(".mask-valor").mask('####0,00', {placeholder: '0,00',reverse: true});
		}
		function getRecibo(id,tels,nome,valor,email){ 
			openRecibo('{"error":false,"id":"'+id+'","tels":"'+tels+'","send":{"nome_cliente_caixa":"'+nome+'","valor_caixafc":"'+valor+'","email_cliente_caixa":"'+email+'"}}');
		}
		function getFaturas(id,sit){ 
			id = id || false;
			if(id){
				sit = sit || 'ab'; 
				$('#local_faturas').empty();
				$('#local_faturas').append('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando Cobranças ...<span class="dotdotdot"></span></span></div></div>');
			    $.ajax({url: '../_ajax.php',data:'cmd=list-group&tipo=faturas&id='+id+'&sit='+sit,dataType: "json"}).then( function (retorno) {
			    	$('#local_faturas').empty();
			    	var corSit='Red';
			    	var acao='';
		    		if(retorno.Sit=='ativo'){
		    			corSit='Green';
		    			acao='<li><a href="#" onclick="AlteraSit(\'Bloquear ['+retorno.Nome+'('+retorno.Id+')]\',\'bl\',\''+retorno.Id+'\',\''+retorno.Grupo+'\',false);" title="Bloquear"><i class="fa fa-lock"></i> Bloquear</a></li>';
		    		}else if(retorno.Sit=='bloqueado'){
						corSit='Orange';
						acao='<li><a href="#" onclick="AlteraSit(\'('+retorno.id_bloqueio+')Desbloquear ['+retorno.Nome+']\',\'at\',\''+retorno.id_bloqueio+'\',\''+retorno.Grupo+'\',false);" title="Desbloquear"><i class="fa fa-unlock"></i> Desbloquear</a></li>'+
						'<li><a href="#" onclick="AlteraSit(\''+retorno.Nome+'\',\'ca\',\''+retorno.Id+'\',\''+retorno.Grupo+'\',false);" title="Cancelar"><i class="fa fa-times"></i> Cancelar</a></li>';
		    		}
					//
					var linha='<div class="dropdown">'+
						'<button class="btn btn-default btn-xs btn-inline dropdown-toggle" type="button" data-toggle="dropdown">'+
    						'<i class="fa fa-navicon fa-fw"></i><span class="caret"></span>'+
  						'</button>'+
				  		'<ul class="dropdown-menu">'+
                      		acao+
                      		'<li><a href="#">Alterar dados</a></li>'+
                      		'<li><a href="#">Cadastrar Débitos</a></li>'+
                    	'</ul>'+
                    	' <b>'+retorno.Id+':'+retorno.Nome+'</b> (<font color="blue">'+retorno.Grupo+'</font>) - <font color="'+corSit+'">'+retorno.Sit+'</font><p class="small"><a target="_blank" href="http://maps.google.com?q='+retorno.End+'">'+retorno.End+'<span class="glyphicon glyphicon-screenshot"></span></a></p>'+
					'</div>';
					//
			    	if(retorno.qtd>0){
						$('#local_faturas').append('<li class="list-group-item"><span class="badge">' + retorno.qtd+ ' Cobs.</span>'+linha+'</li>');
						var cor='list-group-item-success';
						var i=0;
						$.each(retorno.data, function(key, value){
							if(value['tipo_item']=='total'){
								var vencimento_cobranca=value['vencimento_cobrancasfc'].split(",")[0];
								cor='list-group-item-danger';
								$('#local_faturas').append('<a href="#" onclick="openCobranca(\''+value['md5_cobrancasfc']+'\',\''+value['mes_cobrancasfc']+'\',\''+vencimento_cobranca+'\',\''+value['valor_atual_cobrancasfc']+'\',\''+value['id_cobrancasfc']+'\',\''+retorno.Nome+'\',\''+retorno.Email+'\',\''+retorno.Tel1+'\',\''+value['grupo_parceria']+'\');" class="list-group-item '+cor+'"><span class="badge">Total</span>Total dos Débitos: R$ ' +value['valor_atual_cobrancasfc']+ '</a>');
							}else if(value['tipo_item']=='cob'){
								i++;
								if(value['text_sit_cobrancasfc']=='Vencida')
									cor='list-group-item-warning';
								else if(value['text_sit_cobrancasfc']=='A vencer')
									cor='list-group-item-success';
								else if(value['text_sit_cobrancasfc']=='Vencendo hoje')
									cor='list-group-item-infor';
								//
								$('#local_faturas').append('<a href="#" onclick="openCobranca(\''+value['md5_cobrancasfc']+'\',\''+value['mes_cobrancasfc']+'\',\''+value['vencimento_cobrancasfc']+'\',\''+value['valor_atual_cobrancasfc']+'\',\''+value['id_cobrancasfc']+'\',\''+retorno.Nome+'\',\''+retorno.Email+'\',\''+retorno.Tel1+'\',\''+value['grupo_parceria']+'\');" class="list-group-item '+cor+'"><span class="badge">' + value['text_mes_cobrancasfc']+ '</span>Cobrança '+i+' - '+value['text_sit_cobrancasfc']+'<br>Vencimento: '+value['vencimento_cobrancasfc']+'<br> Valor Atualizado: R$ ' +value['valor_atual_cobrancasfc']+ '</a>');
							}else if(value['tipo_item']=='pag'){
								cor='list-group-item-success';
								i++;
								$('#local_faturas').append('<a href="#" onclick="getRecibo(\''+value['ids_pg_cobrancasfc']+'\',\''+retorno.Tel1+'\',\''+retorno.Nome+'\',\''+value['valor_cobrancasfc']+'\',\''+retorno.Email+'\');" class="list-group-item '+cor+'"><span class="badge">' + value['mes_cobrancasfc']+ '</span>Cobrança '+i+' - '+value['valor_cobrancasfc']+'<br>Vencimento: '+value['vencimento_cobrancasfc']+'<br> Pagamento: '+value['datas_pg_cobrancasfc']+'<br> Valor Pago: R$ ' +value['valor_cobrancasfc']+ '</a>');
							}
						});
					}else{
						$('#local_faturas').append('<li class="list-group-item"><span class="badge">0 Cobs.</span>'+linha+'</li>');
						$('#local_faturas').append('<a href="#" onclick="openCobranca(\'\',\'<?php echo date('m/Y');?>\',\'<?php echo date('d/m/Y');?>\',\'0\',\''+retorno.Id+'\',\''+retorno.Nome+'\',\''+retorno.Email+'\',\''+retorno.Tel1+'\',\''+retorno.Grupo+'\');" class="list-group-item list-group-item-info"><span class="badge">Avulso</span>Adicionar Pagamento Avulso</a>');
					}
				});
			}
		}
	</script>
	<style type="text/css">
    	.panel-body {
        	margin: 10px;
          	padding: 10px;
          	background-color: white;
        }
		.loading {    
		    background-color: #ffffff;
		    background-image: url("http://loadinggif.com/images/image-selection/3.gif");
		    background-size: 25px 25px;
		    background-position:right center;
		    background-repeat: no-repeat;
	 	}
	 	.clearable{
		  background: #fff url(http://bijudesigner.com/blog/wp-content/uploads/2015/06/download.gif) no-repeat right -10px center;
		  padding: 3px 18px 3px 4px; /* Use the same right padding (18) in jQ! */
		  transition: background 0.4s;
		}
		.clearable.x  { background-position: right 5px center; }
		.clearable.onX{ cursor: pointer; }
		td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
        .datepicker table tr td{
           width:auto !important;
           height: auto !important;
           font-size: 11px !important;
        }
        .datepicker table tr td{
           width:auto !important;
           height: auto !important;
           font-size: 11px !important;
        }
	</style>
<?php 
   }
?> 
</body>
</html>
