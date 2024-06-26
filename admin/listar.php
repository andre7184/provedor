<?php 
$msg_retorno=isset($_REQUEST["msg_retorno"]) ? $_REQUEST["msg_retorno"] : false;
//
$getLoading = <<<END
	function getLoading(m) {
		$.mobile.loading("hide");
		$.mobile.loading("show",{
			text: m,
			textVisible: true,
			theme: $.mobile.loader.prototype.options.theme,
			textonly: false,
			html: ''
		});
	}
END;
$page='listar.php';
require_once("_validar.php");
	if(!$authSession){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>CADASTRO - LOGIN</title>
			<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
			<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
			<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
			<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
			<script type="text/javascript">
				<?php echo $getLoading;?>
			    $(document).ready(function(){
			        $("#btnEntrar").click(function(){
			        	getLoading('Autenticando...');
			            var envio = $.post("_logar.php?page=listar.php", {login:$("#login").val(),senha:$("#senha").val()})
			            envio.done(function(data) {
			                $("#resultado").html(data);
			                $.mobile.loading("hide");
			            })
			            envio.fail(function() { alert("Erro na requisição");$.mobile.loading("hide"); })
			        });
			        $('#senha').keypress(function(event){
			        	var keycode = (event.keyCode ? event.keyCode : event.which);
			        	if ((keycode == '13' || keycode == '10')) {
			        	   	$("#btnEntrar").click();
			        	}
			        });
			    });
			</script>
		</head>
		<body>
			<div data-role="page">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRO - LOGIN</font></h3></center></div>
				</div>
					<center>
					    <table border="0">
						    <tr>
							    <td><span class="Style6">Login:</span></td>
							    <td>
							    	<span class="Style6">
								    	<label>
									    	<input name="login" type="text" id="login" />
								    	</label>
								    </span>
								</td>
							</tr> 
							<tr>
								<td><span class="Style6">Senha:</span></td>
								<td>
									<span class="Style6">
									    <label>
										    <input name="senha" type="password" id="senha" />
									    </label>
									</span>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<span class="Style6">
									    <label>
									    	<input type="button" id="btnEntrar" value="Entrar" class="button" />
										</label>
								    </span>
								</td>
							</tr>
						</table>
					</center>
				</div>
			</body>
		</html>
<?php 
	}else{
		if($grupo_usuario=='admin' & !$grupo){
			?>
					<!DOCTYPE html>
					<html>
					<head>
						<title>CADASTRO - LOGIN</title>
						<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
						<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
						<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
						<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
						<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
						<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
					</head>
					<body>
						<div data-role="page">
							<div data-role="header" style="overflow:hidden;" data-position="fixed">
								<div data-role="navbar"><center><h3><font color=red id="resultado">Listar Clientes - Grupo</font></h3></center></div>
							</div>
							<div role="main" class="ui-content" id="content">
								<center>
									<form action="listar.php" method="post">
									    <select onchange="this.form.submit();" name="grupo" id="grupo" style="float:right;" data-native-menu="false">
									        <option value="">Selecione um Grupo</option>
									        <option value="lisboa">LISBOA</option> 
									        <option value="fazenda">FAZENDAS</option>
										    <option value="idealnet">IDEALNET</option>
									        <option value="admin">Nenhum</option>
									    </select>
									</form>
								</center>
							</div>
							<div data-role="footer" style="overflow:hidden;" data-position="fixed">
								<center>
									<font color="red" size="2"><?php echo $login_usuario;?></font><br>
						    		<a href="listar.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
						    	</center>
							</div><!-- /header -->
							</div>
						</body>
					</html>
			<?php 
		}else{
			$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
			$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>MKFÁCIL - LISTAR</title>
				<meta name="viewport" content="initial-scale=1, maximum-scale=1" >
		 		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/bootstrap-table.min.css">
				<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css">
				<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css">
				<link rel="stylesheet" href="_js/sd.min.css" />
				<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
				<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
      			<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/bootstrap-table.min.js"></script>
		      	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/locale/bootstrap-table-pt-BR.min.js"></script>
			</head>
			<body onload="<?php if($tipo && $id){echo "";}else{echo "";}?>"> 
				<div data-role="page">
					<div role="main" class="ui-content" id="content">
						<div class="table-responsive">
							<table id="table" style="white-space: nowrap;"></table>
						</div>  
					</div><!-- /content -->
					<div data-role="footer" style="overflow:hidden;" data-position="fixed">
						<center>
							<font color="red" size="2"><?php echo $login_usuario;?></font><br>
				    		<a href="listar.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
				    	</center>
					</div><!-- /header -->
				</div>
				<script type="text/javascript">
				$('#table').bootstrapTable({
				    url: '_dados.php?cmd=list&tipo=clientes',
				    columns: [{
				        field: 'id_clientesfc',
				        title: 'ID'
				    }, {
				        field: 'nome_clientesfc',
				        title: 'Nome'
				    }, {
				        field: 'end1_clientesfc',
				        title: 'End'
				    }, {
				        field: 'num1_clientesfc',
				        title: 'N'
				    }, {
				        field: 'bar1_clientesfc',
				        title: 'Bairro'
				    }, {
				        field: 'tel1_clientesfc',
				        title: 'Tel1'
				    }, {
				        field: 'op1_clientesfc',
				        title: 'Oper1'
				    }, {
				        field: 'wsap1_clientesfc',
				        title: 'Wzap1'
				    }, {
				        field: 'nome1_clientesfc',
				        title: 'NTel'
				    }, {
				        field: 'tel2_clientesfc',
				        title: 'Tel2'
				    }, {
				        field: 'op2_clientesfc',
				        title: 'Oper2'
				    }, {
				        field: 'wsap2_clientesfc',
				        title: 'Wzap2'
				    }, {
				        field: 'nome2_clientesfc',
				        title: 'NTe2'
				    }, {
				        field: 'tel3_clientesfc',
				        title: 'Tel3'
				    }, {
				        field: 'op3_clientesfc',
				        title: 'Oper3'
				    }, {
				        field: 'wsap3_clientesfc',
				        title: 'Wzap3'
				    }, {
				        field: 'nome3_clientesfc',
				        title: 'NTe3'
				    }, ]
				});
				</script>
			</body>
		</html>
<?php 
		}
	}
?>