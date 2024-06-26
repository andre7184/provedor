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

    <title>MK FÁCIL - DÍVIDAS</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
              <a class="navbar-brand" href="#"><b>Recebimentos <?php echo '(<font class="small"><b>'.$_SESSION['login_userfc'].'</b></font>)';?></b></a>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">MENU<i class="fa fa-navicon fa-fw"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i>Página Inicial</a></li>
                  	<li><a href="#"><i class="fa fa-user-plus fa-fw"></i>Novo Cliente</a></li>
                  	<li><a href="#"><i class="fa fa-users fa-fw"></i>Listar Clientes</a></li>
                    <li><a href="caixa.php"><i class="fa fa-money fa-fw"></i>Caixa</a></li>
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
					    $ano = isset($_REQUEST["busca_recebimentos_ano"]) ? $_REQUEST["busca_recebimentos_ano"] : date("Y");
					    $mes = isset($_REQUEST["busca_recebimentos_mes"]) ? $_REQUEST["busca_recebimentos_mes"] : date("m");
					    $user = isset($_REQUEST["busca_recebimentos_user"]) ? $_REQUEST["busca_recebimentos_user"] : 'all';
					    $grupo = isset($_REQUEST["busca_recebimentos_grupo"]) ? $_REQUEST["busca_recebimentos_grupo"] : 'all';
					?>
						<input id="busca_recebimentos_ano" value="<?php echo $ano;?>" type="hidden">
				    	<input id="busca_recebimentos_mes" value="<?php echo $mes;?>" type="hidden">
						<input id="busca_recebimentos_user" value="<?php echo $user;?>" type="hidden">
						<input id="busca_recebimentos_grupo" value="<?php echo $grupo;?>" type="hidden">
						<input id="data_hoje" value="<?php echo date('d/m/Y')?>" type="hidden">
						<input id="dados_retorno_pagamento" type="hidden">
						<input id="dados_retorno_boleto" type="hidden">
						<input id="tels_cliente_caixa" type="hidden">
						<table id="table_amostra" style="white-space: nowrap;" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        	<thead>
                           		<tr>
                                	<th></th>
                                    	<th>Mes</th><th>Login</th><th>Qtd</th><th>Valor</th><th>Descontos</th><th>Liquido</th><th>Grupo</th>
                                  	</tr>
                        	</thead>
                        </table>
                        <h5><b>Recebimentos Previstos no Mês</b></h5>
                        <table id="table_amostra2" style="white-space: nowrap;" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        	<thead>
                           		<tr>
                                	<th></th>
                                    	<th>Mes</th><th>Qtd</th><th>Valor</th><th>Grupo</th>
                                  	</tr>
                        	</thead>
                        </table>
                        
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
                                <input name="page" type="hidden" value="recebimentos.php">
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
	<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
	<script src="../vendor/otherdropdown/jquery.otherdropdown.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
	<!-- Bootstrap datepicker JS and CSS -->
	<script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../vendor/datepicker/js/locales/bootstrap-datepicker.pt-BR.js"></script>
	<link rel="stylesheet" href="../vendor/datepicker/css/datepicker.css"></link>
	<script src="../js/cadastro.js"></script>
	<script src="../js/bloqueios.js"></script>
	<script src="../js/cobrancas.js"></script>
	<script src="../js/recibo.js"></script>
	<script src="../js/mask.js"></script>
	<script type="text/javascript">
		var dataHoje='<?php echo date('d/m/Y')?>'; 
		var table = '';
		var ano_sel = '<?php echo $ano;?>';
		var mes_sel = '<?php echo $mes;?>';
		var user_sel = '<?php echo $user;?>';
		$(document).ready(function() {
	        table = $("#table_amostra").DataTable({
		        columns:[{
		        	className:'details-control',
		             orderable:false,
		             data:null,
		             defaultContent:''
		            },{"data":"Mes"},{"data":"Login"},{"data":"Qtd"},{"data":"Valor",render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )},{"data":"Descontos",render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )},{"data":"Liquido",render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )},{"data":"Grupo"},{"data":"Id","visible": false},{"data":"Clientes","visible": false},{"data":"Valores","visible": false},{"data":"Datas","visible": false}
		        ],
		        order: [[ 2, "desc" ]],
		        paging:false,
				searching: false,
				info:false,
				scrollX:true,
				responsive:false,
				ajax: {
		            url: "../_ajax.php",
		            data: function ( d ) {
		                d.cmd = "list";
						d.tipo = "recebimentos";
						d.ano = $("#busca_recebimentos_ano").val();
						d.mes = $("#busca_recebimentos_mes").val();
						d.user = $("#busca_recebimentos_user").val();
						d.grupo = $("#busca_recebimentos_grupo").val();
						loading('Buscando Recebimentos','loading_busca_recebimentos');
		            }
		        },
				dom: '<"toolbar">frtip<"footer">'
			});
	        table2 = $("#table_amostra2").DataTable({
		        columns:[{
		        	className:'details-control',
		             orderable:false,
		             data:null,
		             defaultContent:''
		            },{"data":"Mes"},{"data":"Qtd"},{"data":"Valor",render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )},{"data":"Grupo"},{"data":"Id","visible": false},{"data":"Clientes","visible": false},{"data":"Valores","visible": false},{"data":"Datas","visible": false},{"data":"Md5","visible": false},{"data":"Email","visible": false},{"data":"Tels","visible": false}
		        ],
		        order: [[ 2, "desc" ]],
		        paging:false,
				searching: false,
				info:false,
				scrollX:true,
				responsive:false,
				ajax: {
		            url: "../_ajax.php",
		            data: function ( d ) {
		                d.cmd = "list";
						d.tipo = "recebimentos_previstos";
						d.grupo = $("#busca_recebimentos_grupo").val();
						loading('Buscando Recebimentos Previstos','loading_busca_recebimentos_previstos');
		            }
		        }
		    });
	    	table.on('xhr', function () {
	    		var json = table.ajax.json();
	    		$("#qtd_recebimentos").text(json.qtd);
	    		setSelBusca();
	    		$("#loading_busca_recebimentos").modal("hide");
	    	});
	    	table2.on('xhr', function () {
	    		var json = table2.ajax.json();
	    		//$("#qtd_recebimentos").text(json.qtd);
	    		//setSelBusca();
	    		$("#loading_busca_recebimentos_previstos").modal("hide");
	    	});
	    	$("div.toolbar").html(toolbarFind(table));
	    	getDadosTBF();
	    	// Add event listener for opening and closing details
        	$("#table_amostra").on("click", "td.details-control", function () {
        		var tr = $(this).closest("tr");
        		var row = table.row(tr);
        		if (row.child.isShown()) {
        	        // This row is already open - close it
        	        row.child.hide();
        	        tr.removeClass("shown");
        		} else {
        	        // Open this row
        			row.child(format(row.data())).show();
        	        tr.addClass("shown");
        		}
        	});
        	$("#table_amostra2").on("click", "td.details-control", function () {
        		var tr = $(this).closest("tr");
        		var row = table2.row(tr);
        		if (row.child.isShown()) {
        	        // This row is already open - close it
        	        row.child.hide();
        	        tr.removeClass("shown");
        		} else {
        	        // Open this row
        			row.child(format2(row.data())).show();
        	        tr.addClass("shown");
        		}
        	});
			$('#dados_retorno_pagamento').on('change', function() {
				table.ajax.reload();
				table2.ajax.reload();
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
			$("#reload_busca_recebimentos").click(function() {
				table.ajax.reload();
				table2.ajax.reload();
			});
		});
		function getRecibo(id,tels,nome,valor,email){ 
			openRecibo('{"error":false,"id":"'+id+'","tels":"'+tels+'","send":{"nome_cliente_caixa":"'+nome+'","valor_caixafc":"'+valor+'","email_cliente_caixa":"'+email+'"}}');
		}
		function toolbarFind() {
			return '<span class="badge" id="qtd_recebimentos"></span><b>Recebimentos </b>'+
			'<div class="form-group input-group">'+
				'<span class="input-group-btn">'+
					'<button id="reload_busca_recebimentos" class="btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i>'+
					'</button>'+
				'</span>'+
				'<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Ano<span id="local_resultado_ano"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_anos_recebimentos">'+ 
    	    		'</ul>'+
        		'</span>'+
				'<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Mês<span id="local_resultado_mes"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_meses_recebimentos">'+ 
    	    		'</ul>'+
	    		'</span>'+
				'<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">User<span id="local_resultado_user"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_user_recebimentos">'+ 
    	    		'</ul>'+
	    		'</span>'+
          <?php if($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){?>
        '<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Grupo<span id="local_resultado_grupo"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_grupo_recebimentos">'+ 
    	    		'</ul>'+
	    		'</span>'+        
           <?php }?>
	    		
			'</div>';
		}
		function format(obj) {
			var idArray=obj['Id'].split("|");
			var clienteArray=obj['Clientes'].split("|");
			var valoresArray=obj['Valores'].split("|");
			var datasArray=obj['Datas'].split("|");
			var user='<?php echo $_SESSION['login_userfc'];?>';
			var admin=<?php if($_SESSION['login_userfc']!='cyberuv' AND $_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){ echo '1';}else{echo '0';}?>;
			var login=obj['Login'];
			var li='';
			var btrp='';
			//
			$.each(idArray, function (i) {
				if(admin || user==login){
					btrp='<button type="button" class="btn btn-sm btn-danger" onclick="removePagamento(\''+idArray[i]+'\',\''+clienteArray[i]+'\',\''+valoresArray[i]+'\');"><i class="fa fa-times-circle"></i></button>';
				}
				li+='<li class="list-group-item">'+btrp+' '+idArray[i]+' - '+datasArray[i]+' - R$ '+valoresArray[i]+' - '+clienteArray[i]+'</li>';
			});
			//
			return '<div class="btn-group" role="group">'+
			'<ul class="list-group">'+
			li+  	
			'</ul>'+
			'</div>'; 
		}
		function format2(obj) {
			var idArray=obj['Id'].split("|");
			var mesesArray=obj['Meses'].split("|");
			var statusArray=obj['Status'].split("|");
			var clienteArray=obj['Clientes'].split("|");
			var id_bloqueioArray='';//obj['id_bloqueio'].split("|");
			var sit_clienteArray=obj['Sit'].split("|");
			var valoresArray=obj['Valores'].split("|");
			var datasArray=obj['Datas'].split("|");
			var md5Array=obj['Md5'].split("|");
			var emailArray=obj['Email'].split("|");
			var TelsArray=obj['Tels'].split("|");
			var li='';
			var btrp='';
			//
			$.each(idArray, function (i) {
				var corData='text-primary';
				var corCliente='text-success';
				var acao='';
				if(statusArray[i]=='Vencida')
					corData='text-warning';
				else if(statusArray[i]=='Vencendo hoje')
					corData='text-info';
				//
				if(sit_clienteArray[i]=='ativo'){
					acao='<a href="#" onclick="AlteraSit(\'Bloquear ['+clienteArray[i]+'('+idArray[i]+')]\',\'bl\',\''+idArray[i]+'\',\''+obj['Grupo']+'\',false);" title="Bloquear" class="btn btn-xs btn-danger"><i class="fa fa-lock"></i> Bloquear</a>';
	    		}else if(sit_clienteArray[i]=='bloqueado'){
	    			corCliente='text-danger';
	    			acao='<a href="#" onclick="AlteraSit(\'('+id_bloqueioArray[i]+')Desbloquear ['+clienteArray[i]+']\',\'at\',\''+id_bloqueioArray[i]+'\',\''+obj['Grupo']+'\',false);" title="Desbloquear" class="btn btn-xs btn-success"><i class="fa fa-unlock"></i> Ativar</a> | <a href="#" onclick="AlteraSit(\''+clienteArray[i]+'\',\'ca\',\''+idArray[i]+'\',\''+obj['Grupo']+'\',false);" title="Cancelar" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Cancelar</a>';
	    		}
				btrp='<a href="#" onclick="openCobranca(\''+md5Array[i]+'\',\''+mesesArray[i]+'\',\''+datasArray[i]+'\',\''+valoresArray[i]+'\',\''+idArray[i]+'\',\''+clienteArray[i]+'\',\''+emailArray[i]+'\',\''+TelsArray[i]+'\',\''+obj['Grupo']+'\');" title="Receber" class="btn btn-xs btn-success" ><i class="fa fa-dollar"></i> Receber</a>';
				li+='<li class="list-group-item">'+btrp+' | '+acao+' <font class="'+corData+'">'+datasArray[i]+'</font> - R$ '+decimalFormat(valoresArray[i]*1)+' - <font class="'+corCliente+'">'+clienteArray[i]+' ('+sit_clienteArray[i]+')</font></li>'; 
			});
			//
			return '<div class="btn-group" role="group">'+
			'<ul class="list-group">'+
			li+  	
			'</ul>'+
			'</div>'; 
		}
		function getDadosTBF(){
			loading('Buscabdo Dados Toolbar','loading_dados_toolbar');
			$.post('../_ajax.php',{'cmd':'busca','tipo':'busca_recebimentos'},function(dados){
				var dados=JSON.parse(dados);
				$("#loading_dados_toolbar").modal("hide");
				$("#local_anos_recebimentos").html('');
				var lim='<li class="dropdown-header">Seleciona o Ano</li>'+
				'<li class="busca_recebimentos_ano" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
				//
				$.each(dados['ano'], function (i, item) {
					var style='style="display: none;"';
					if(item.ano==ano_sel)
						style="";
					lim+='<li class="busca_recebimentos_ano" onclick="setBusca(this);" v="'+item.ano+'"><a href="#"><i class="fa fa-check" '+style+'></i>'+item.ano+'</a></li>';
				});
				$("#local_anos_recebimentos").append(lim);
				//
				$("#local_meses_recebimentos").html('');
				var lim='<li class="dropdown-header">Seleciona o Mês</li>'+
				'<li class="busca_recebimentos_mes" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
				//
				$.each(dados['mes'], function (i, item) {
					var style='style="display: none;"';
					if(item.mes==mes_sel)
						style="";
					lim+='<li class="busca_recebimentos_mes" onclick="setBusca(this);" v="'+item.mes+'"><a href="#"><i class="fa fa-check" '+style+'></i>'+item.mes+'</a></li>';
				});
				$("#local_meses_recebimentos").append(lim);
				//
				$("#local_user_recebimentos").html('');
				var liu='<li class="dropdown-header">Seleciona o User</li>'+
				'<li class="busca_recebimentos_user" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
				//
				$.each(dados['user'], function (i, item) {
					var style='style="display: none;"';
					if(item.user==user_sel)
						style="";
					liu+='<li class="busca_recebimentos_user" onclick="setBusca(this);" v="'+item.user_login+'"><a href="#"><i class="fa fa-check" '+style+'></i>'+item.user_login+'</a></li>';
				});
				$("#local_user_recebimentos").append(liu);
                <?php 
                if($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){
                ?>
            		$("#local_grupo_recebimentos").html('');
    				var lig='<li class="dropdown-header">Seleciona o Grupo</li>'+
    				'<li class="busca_recebimentos_grupo" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style="display: none;"></i>Todos</a></li>';
    				//
    				$.each(dados['grupo'], function (i, item) {
    					lig+='<li class="busca_recebimentos_grupo" onclick="setBusca(this);" v="'+item.grupo+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.grupo+'</a></li>';
    				});
    				$("#local_grupo_recebimentos").append(lig);
       	        <?php 
                }
                ?>

     	 	});
		}
		function removePagamento(id,nome,valor){
	        BootstrapDialog.confirm({
		      	title: 'WARNING',
		        message: 'Deseja remover o pagamento:'+id+' de R$'+valor+' do Cliente '+nome+'?',
		        type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
		        closable: true, // <-- Default value is false
		        draggable: true, // <-- Default value is false
		        btnCancelLabel: 'Não', // <-- Default value is 'Cancel',
		        btnOKLabel: 'Sim', // <-- Default value is 'OK',
		        btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
		        callback: function(result) {
		        	// result will be true if button was click, while it will be false if users close the dialog directly.
		            if(result) {
		              	loading('Removendo pagamento :'+id,'loading_remove_pagamento');
		            	$.post('../_ajax.php',{'cmd':'alterar','tipo':'remover_pagamento','id':id},function(dados){
		            		dados=JSON.parse(dados);
		            		$("#loading_remove_pagamento").modal("hide");
		            		BootstrapDialog.alert(dados.result);
		            		table.ajax.reload();
		            	});
		            }
		      	}
		  	});		
		}
		function setSelBusca(){
			var urlArg=new Array();
			$(".bts_busca li").each(function() {
				var nome=$(this).attr("class");
				var valor=$(this).attr("v");
				if($("#"+nome).val()==valor){
					$(this).find("i").show();
					urlArg[nome]=valor;
				}else
					$(this).find("i").hide();
			});
			//alert('ok');
			//var busca_clientes_text=$("#busca_clientes_text").val();
			//$("#campo_busca_clientes_text").val(busca_clientes_text);
			//window.history.pushState(null,null,jQuery.query.set('busca_recebimentos_mes', urlArg['busca_recebimentos_mes']).set('busca_recebimentos_user', urlArg['busca_recebimentos_user']));
		}
		function setBusca(obj){
			var nome=$(obj).attr("class");
			var valor=$(obj).attr("v");
			$("#"+nome).val(valor);
			//
			if(nome=='busca_recebimentos_user'){
				if(valor=='all')
					$("#local_resultado_user").html('');
				else
					$("#local_resultado_user").html(' ('+valor+')');
			}
			if(nome=='busca_recebimentos_mes'){
				if(valor=='all')
					$("#local_resultado_mes").html('');
				else
					$("#local_resultado_mes").html(' ('+valor+')');
			}
			if(nome=='busca_recebimentos_grupo'){
				if(valor=='all')
					$("#local_resultado_grupo").html('');
				else
					$("#local_resultado_grupo").html(' ('+valor+')');
			}
			//
			table.ajax.reload();
			table2.ajax.reload();
		}
		function loading(title,id){
			BootstrapDialog.show({
				title: title,
				id: id,
				message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
			});
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
	</style>
<?php 
   }
   /*
   SELECT DATE_FORMAT(cx.datatime_caixafc,"%m/%Y") AS Mes, cx.user_login AS Login, COUNT(*) AS Qtd, SUM(cx.valor_caixafc) AS Valor, SUM(cx.valor_taxa_caixafc) AS Descontos, SUM(cx.valor_caixafc)-SUM(cx.valor_taxa_caixafc) AS Liquido, cl.grupo_parceria AS Grupo, GROUP_CONCAT(cl.nome_clientesfc separator '|') AS Clientes, GROUP_CONCAT(cx.valor_caixafc separator '|') AS Valores, GROUP_CONCAT(cx.data_credito_caixafc separator '|') AS Datas FROM `fc_caixa` AS cx 
INNER JOIN `fc_clientes` AS cl ON cl.id_clientesfc=cx.id_cliente_caixafc
WHERE cl.grupo_parceria='lisboa' AND cx.valor_caixafc>0 AND DATE_FORMAT(cx.datatime_caixafc,"%m/%Y")='03/2018'
group by cx.user_login
    */
?>
</body>
</html>
