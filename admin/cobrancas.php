<?php 
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
$cob=true;
require_once("_validar.php");
if(!$authSession){
	$auth=true;
	$id_cliente = isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
	$cpf_cnpj= "SELECT cpf_cnpj_clientesfc FROM fc_clientes WHERE id_clientesfc='".$id_cliente."'";
	$nome_cliente="SELECT nome_clientesfc FROM fc_clientes WHERE id_clientesfc='".$id_cliente."'";
	$nome_provedor=$provedor_usuario;
	$auth=true;
}else{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>CENTRAL DO CLIENTE</title>
			<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
			<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
			<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
			<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
			<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<script type="text/javascript">
				<?php echo $getLoading;?>
			    function enviar(){
			        	getLoading('Autenticando...');
			            var envio = $.post("_logar.php?page=cobrancas.php", {cpf_cnpj:$("#cpf_cnpj").val()})
			            envio.done(function(data) {
			                $("#resultado").html(data);
			                $.mobile.loading("hide");
			            })
			            envio.fail(function() { alert("Erro na requisição");$.mobile.loading("hide"); })
			    };
			</script>
		</head>
		<body>
			<div data-role="page">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<div data-role="navbar"><center><h3><font color=red id="resultado">PAGUE FÁCIL - Login</font></h3></center></div>
				</div>
					<center>
					<form>
					    <table border="0">
						    <tr>
							    <td><span class="Style6">CPF OU CNPJ:</span></td>
							    <td>
							    	<span class="Style6">
								    	<label>
									    	<input name="cpf_cnpj" type="text" id="cpf_cnpj" />
								    	</label>
								    </span>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<span class="Style6">
									    <label>
									    	<button
											class="g-recaptcha"
											data-sitekey="6LdHgxEUAAAAANqSB2r_otM4xlnvdl-rfbzmOwHw"
											data-callback="enviar">
											Submit
											</button>
										</label>
								    </span>
								</td>
							</tr>
						</table>
						</form>
					</center>
				</div>
			</body>
		</html>
<?php 
}
?>