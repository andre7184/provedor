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
              <a class="navbar-brand" href="#"><b>Dívidas <?php echo '(<font class="small"><b>'.$_SESSION['login_userfc'].'</b></font>)';?></b></a>
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
                    <li><a href="recebimentos.php"><i class="fa fa-dollar fa-fw"></i>Recebimentos</a></li>
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
					    $grupo = isset($_REQUEST["busca_dividas_grupo"]) ? $_REQUEST["busca_dividas_grupo"] : 'all';
					    $matual = isset($_REQUEST["busca_dividas_matual"]) ? $_REQUEST["busca_dividas_matual"] : 'all';
					?>
				    	<input id="busca_dividas_grupo" value="<?php echo $grupo;?>" type="hidden">
				    	<input id="busca_dividas_matual" value="<?php echo $matual;?>" type="hidden">
						<table id="table_amostra" style="white-space: nowrap;" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        	<thead>
                           		<tr>
                                	<th></th>
                                    	<th>Id</th><th>Nome</th><th>Sit</th><th>End</th><th>Tels</th><th>Qtd</th><th>Valor</th><th>Encargos</th><th>Total</th><th>Vencimentos</th><th>Grupo</th><th>Provedor</th><th>Id Bloqueio</th>
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
                                <input name="page" type="hidden" value="inadimplentes.php">
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
	<!-- Bootstrap datepicker JS and CSS -->
	<script src="../vendor/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../vendor/datepicker/js/locales/bootstrap-datepicker.pt-BR.js"></script>
	<link rel="stylesheet" href="../vendor/datepicker/css/datepicker.css"></link>
	<script src="../js/cadastro.js"></script>
	<script src="../js/bloqueios.js"></script>
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
	<script type="text/javascript">
		var dataHoje='<?php echo date('d/m/Y')?>';
		var table = '';
		$(document).ready(function() {
	        table = $("#table_amostra").DataTable({
		        columns:[{
		        	className:'details-control',
		             orderable:false,
		             data:null,
		             defaultContent:''
		            },{"data":"Id"},{"data":"Nome"},{"data":"Sit"},{"data":"End","visible": false},{"data":"Tels","visible": false},{"data":"Qtd"},{"data":"Valor"},{"data":"Encargos"},{"data":"Total"},{"data":"Vencimentos"},{"data":"Grupo"},{"data":"Provedor","visible": false},{"data":"id_bloqueio","visible":false}
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
						d.tipo = "inadimplentes";
						d.matual = $("#busca_dividas_matual").val();
						d.grupo = $("#busca_dividas_grupo").val();
						loading('Buscando Dívidas','loading_busca_dividas');
		            }
		        },
				dom: '<"toolbar">frtip<"footer">'
		    });
	    	table.on('xhr', function () {
	    		var json = table.ajax.json();
	    		$("#qtd_dividas").text(json.qtd);
	    		setSelBusca();
	    		$("#loading_busca_dividas").modal("hide");
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
			$("#reload_busca_dividas").click(function() {
				table.ajax.reload();
			});
		});
		function toolbarFind() {
			return '<span class="badge" id="qtd_dividas"></span><b>Dívidas </b>'+
			'<div class="form-group input-group">'+
				'<span class="input-group-btn">'+
					'<button id="reload_busca_dividas" class="btn btn-default btn-sm" type="button"><i class="fa fa-refresh"></i>'+
					'</button>'+
				'</span>'+
				'<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Mês Dívidas<span id="local_resultado_matual"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_matual_dividas">'+ 
    			  		'<li class="dropdown-header">Selecione Período da dívida</li>'+ 
    			  		'<li class="busca_dividas_matual" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style=""></i>Todos</a></li>'+
    			  		'<li class="busca_dividas_matual" onclick="setBusca(this);" v="on"><a href="#"><i class="fa fa-check" style=""></i>Somente Mês Atual</a></li>'+
    			  		'<li class="busca_dividas_matual" onclick="setBusca(this);" v="no"><a href="#"><i class="fa fa-check" style=""></i>Somente Outros meses</a></li>'+
    	    		'</ul>'+
        		'</span>'+
				<?php if($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){?>
        		'<span class="input-group-btn">'+
    				'<button type="button" data-toggle="dropdown" class="btn btn-default btn-sm">Grupo<span id="local_resultado_grupo"></span><span class="caret"></span></button>'+
    			  	'<ul class="bts_busca dropdown-menu" id="local_grupo_dividas">'+ 
    	    		'</ul>'+
	    		'</span>'+        
           <?php }?>
	    		
			'</div>';
		}
		function format(obj) {
			var acao='';
    		if(obj['Sit']=='ativo')
    			acao='<a href="#" onclick="AlteraSit(\'Bloquear ['+obj['Nome']+'('+obj['Id']+')]\',\'bl\',\''+obj['Id']+'\',\''+obj['Grupo']+'\',false);" title="Bloquear" class="btn btn-xs btn-danger"><i class="fa fa-lock"></i> Bloquear</a>';
    		else if(obj['Sit']=='bloqueado')
				acao='<a href="#" onclick="AlteraSit(\'('+obj['id_bloqueio']+')Desbloquear ['+obj['Nome']+']\',\'at\',\''+obj['id_bloqueio']+'\',\''+obj['Grupo']+'\',false);" title="Desbloquear" class="btn btn-xs btn-success"><i class="fa fa-unlock"></i> Ativar</a> | <a href="#" onclick="AlteraSit(\''+obj['Nome']+'\',\'ca\',\''+obj['Id']+'\',\''+obj['Grupo']+'\',false);" title="Cancelar" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Cancelar</a>';
    		//
			var li='<li class="list-group-item">'+acao+' '+obj['End']+' - '+obj['Tels']+'</li>';
			//
			return '<div class="btn-group" role="group">'+
			'<ul class="list-group">'+
			li+  	
			'</ul>'+
			'</div>'; 
		}
		function getDadosTBF(){
			loading('Buscabdo Dados Toolbar','loading_dados_toolbar');
			$.post('../_ajax.php',{'cmd':'busca','tipo':'busca_inadimplentes'},function(dados){
				var dados=JSON.parse(dados);
				$("#loading_dados_toolbar").modal("hide");
                <?php 
                if($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!=''){
                ?>
            		$("#local_grupo_dividas").html('');
    				var lig='<li class="dropdown-header">Seleciona o Grupo</li>'+
    				'<li class="busca_dividas_grupo" onclick="setBusca(this);" v="all"><a href="#"><i class="fa fa-check" style=""></i>Todos</a></li>';
    				//
    				$.each(dados['grupo'], function (i, item) {
    					lig+='<li class="busca_dividas_grupo" onclick="setBusca(this);" v="'+item.grupo+'"><a href="#"><i class="fa fa-check" style="display: none;"></i>'+item.grupo+'</a></li>';
    				});
    				$("#local_grupo_dividas").append(lig);
       	        <?php 
                }
                ?>

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
			
			if(nome=='busca_dividas_grupo'){
				if(valor=='all')
					$("#local_resultado_grupo").html('');
				else
					$("#local_resultado_grupo").html(' ('+valor+')');
			}
			//
			table.ajax.reload();
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
        .datepicker table tr td{
           width:auto !important;
           height: auto !important;
           font-size: 11px !important;
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
