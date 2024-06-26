<?php 
$msg_retorno=isset($_REQUEST["msg_retorno"]) ? $_REQUEST["msg_retorno"] : false;
$title='CADASTRO/ALTERAR SEVIÇOS MENSAIS';
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
$page='servmensal.php';
require_once("_validar.php");
	if(!$authSession){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>CADASTRO/ALTERAR SEVIÇOS MENSAIS - LOGIN</title>
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
			            var envio = $.post("_logar.php?page=servmensal.php", {login:$("#login").val(),senha:$("#senha").val()})
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
			<div data-role="page" id="home" data-theme="a" style="width: 100%;">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRO/ALTERAR SEVIÇOS MENSAIS - LOGIN</font></h3></center></div>
				</div>
				<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
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
						<title>CADASTRO/ALTERAR SEVIÇOS MENSAIS - GRUPO</title>
						<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
						<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
						<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
						<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
						<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
						<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
					</head>
					<body>
						<div data-role="page" id="home" data-theme="a" style="width: 100%;">
							<div data-role="header" style="overflow:hidden;" data-position="fixed">
								<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRO/ALTERAR SEVIÇOS MENSAIS - Grupo</font></h3></center></div>
							</div>
							<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
								<center>
									<form action="servmensal.php" method="post">
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
						    		<a href="servmensal.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
						    	</center>
							</div><!-- /header -->
						</div>
					</body>
				</html>
			<?php 
		}else{
			$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
			$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
			$nome_clientesfc = utf8_encode($_REQUEST["nome_clientesfc"]);
			$id_sevmensal = isset($_REQUEST["id_sevmensal"]) ? $_REQUEST["id_sevmensal"] : false;
			if(!$id_sevmensal){
			?>
				<!DOCTYPE html>
				<html>
					<head>
						<meta charset="ISO-8859-1"> 
						<meta name="viewport" content="width=device-width, initial-scale=1">
					    <title><?php echo $title;?></title>
						<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
						<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
						<script src="_js/jquery/jquery-1.11.3.min.js"></script>
						<script src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
						<script src="_js/jquery/jquery-ui.min.js"></script>
						<script src="_js/mask.js"></script>
						<script src="_js/mask_real.js"></script>
						<script src="_js/funcoes.js"></script>
						<script src="_js/auto_complete.js"></script>  
				    </head>
				    <body>
					    <div data-role="page" id="home" data-theme="a" style="width: 100%;">
					    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
					    		<center><?php echo $title;?><br>
								<?php 
								$error = $error ? $error : false;
								if($authSession && !$error){
									echo "<font color=blue>$nome_clientesfc<br>$cpf_cnpj</font>";
								}else{
									echo "<font color=red>$error</font>";
								}
								//
								if($id_clientesfc)
									$urlBusca='id_clientesfc='.$id_clientesfc.'&nome='.$nome_cliente;
								//
								?>
								</center> 
							</div><!-- /header -->
							<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
								<center>
									<script type="text/javascript">
										function dataClik(vl,obj){ 
											var id=$('#id_clientesfc').val();
											$('#nome_clientesfc').val($('input[data-id-ul="'+obj+'"]').val());
											$("#id_sevmensal").attr('data-url', '_dados.php?cmd=select&tipo=servmensal&id_cliente_mensalfc=' + id);
											getSelect();
										}
										function getSelect(n) {
											if(n){
												//alert(n instanceof Object);
												if(n instanceof Object)
													var sel=n;
												else
													var sel='select[name="'+n+'"][data-role="auto"][data-url]';
											}else
												var sel='select[data-role="auto"][data-url]';
											//
											$(sel).each(function() {
												var inp=$(this);
												var dataUrl=inp.attr("data-url");
												//alert('ok');
												$.ajax({url: dataUrl,
										            success: function(output) {
										            	//alert('ok1');
										               inp.html(output);
										           },
										         error: function (xhr, ajaxOptions, thrownError) {
										           alert(xhr.status + " "+ thrownError);
										         }});
											});
										}
									</script>
									<form action="servmensal.php" method="post">
										<label for="id_clientesfc">Nome/cpf/cnpj/e-mail:</label>
										<div class="ui-grid-solo">
											<div class="ui-block-a">
												<input onkeyup="AutoCompleteText($(this));" data-id-click="id_clientesfc" type="text" placeholder="Buscar cliente..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-load-click="dataClik" data-url="_dados.php?cmd=busca&tipo=cliente&query={val}">
											</div>
										</div>
										<select onchange="this.form.submit();" id="id_sevmensal" name="id_sevmensal" data-role="auto" data-url="_dados.php?cmd=select&tipo=servmensal" data-mini="true">
											<option value="">Selecione Serviço Mensal</option>
										</select>
										<input id="id_clientesfc" name="id_clientesfc" type="hidden">
										<input id="nome_clientesfc" name="nome_clientesfc" type="hidden">
									</form>
								</center>
							</div>
							<div data-role="footer" style="overflow:hidden;" data-position="fixed">
								<center>
									<font color="red" size="2"><?php echo $login_usuario;?></font><br>
						    		<a href="servmensal.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
						    	</center>
							</div><!-- /header -->
						</div>
					</body>
				</html>
		<?php 
			}else{
				if($id_sevmensal=='new')
					$id_sevmensal='';
				//
		?>
				<!DOCTYPE html>
				<html>
					<head>
						<meta charset="ISO-8859-1"> 
						<meta name="viewport" content="width=device-width, initial-scale=1">
					    <title><?php echo $title;?></title>
						<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
						<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
						<script src="_js/jquery/jquery-1.11.3.min.js"></script>
						<script src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
						<script src="_js/jquery/jquery-ui.min.js"></script>
						<script src="_js/mask.js"></script>
						<script src="_js/mask_real.js"></script>
						<script src="_js/funcoes.js"></script>
						<script src="_js/auto_complete.js"></script>
						<script type="text/javascript">
							function salvaDados(id,pg) {
								var pai=$("#"+id);
								var validad=true;
								$(pai).find("input.required").each(function() {
									if($(this).val()==''){
										validad=false; 
									}
								});
								if(!validad)
									return false;
								//
								var tempName = [];
								var tempData = {};
								$(pai).find("input, textarea, select").each(function() {
									var name=$(this).attr("name");
									//alert(name+'-'+tempName[name]);
									if(name && !tempName[name]){
										//alert(name+'-'+$("[name='"+name+"']").length);
										tempName[name]=true;
										if($(pai).find("[name='"+name+"']").length>1){
											var valor=[];
											$(pai).find("[name='"+name+"']").each(function(i) {
												valor[i]=$(this).val();
											});
										}else{
											var valor=$(this).val();
										}
										tempData[name] = valor;
									}
								}); 
								getLoading('Salvando dados...');
								$.post('_dados.php',tempData,function(dados){
									$.mobile.loading("hide");
									clear_form_elements($(pai));
									//alert(dados+' - '+dados.id_clientesfc+' - '+dados.busca);
									//$(location).attr('href', 'servmensal.php?msg_retorno=Ok,'+dados);
								});
							}
							function clear_form_elements(obj) {
								$(obj).find("input, select, textarea").each(function() {
									if(this.type=='checkbox' || this.type=='radio')
										 this.checked = false;
									else
										if(!$(this).attr("data-fix") && this.type!='hidden')
											$(this).val('');
									//
									if($(this).attr("data-role")=='slider')
										$(this).slider("refresh");
									else if($(this).is('select'))
										$(this).selectmenu('refresh', true);
									//
						        });
						    }
							function alteraDB(tipo,id){
								getLoading('Localizando '+tipo+' de id:'+id+'...');
							    $.ajax({url: '_dados.php',data:'cmd=load&tipo='+tipo+'&id='+id,dataType: "json"}).then( function (retorno) {
									if(retorno.qtd==1){
										var valor='';
										var campo='tipo_'+tipo+'fc';
										$.each(retorno.data, function(key, value){
											$("[name='"+key+"']").val(value);
											if($("[name='"+key+"']").attr("type")=='hidden')
												$("[name='"+key+"']").change();
											//
											if($("[name='"+key+"']").attr("data-role")=='slider')
												$("[name='"+key+"']").slider("refresh");
											else if($("[name='"+key+"']").is('select'))
												$("[name='"+key+"']").selectmenu('refresh', true).change();
											//
											if($("[name='"+key+"']").attr("type")=='checkbox' && value=='on')
												$("[name='"+key+"']").prop('checked', true).checkboxradio('refresh');
											//
											if(key==campo)
												valor=value;
											//
										});
										var iduser=$('#id_user_sevmensalfc').val();
										if(iduser!=''){
											$.ajax({url: '_dados.php',data:'cmd=busca&tipo=userppp&id='+iduser,dataType: "html"}).then( function (texto) {
												$('#userppp').html(texto);
												$.mobile.loading("hide");
											});
										}else{
											$.mobile.loading("hide");
										}
									}
								});
							}
							function getEndServMensal(vl){
								var id=$('#id_cliente_mensalfc').val();
								alert(vl+'-'+id);
								if(vl=='on' && id>0){
									getLoading('Localizando Endereço cliente id:'+id+'...');
								    $.ajax({url: '_dados.php',data:'cmd=busca&tipo=endcliente&id='+id,dataType: "json"}).then( function (retorno) {
										$.mobile.loading("hide");
										if(retorno.qtd==1){
											var valor='';
											$.each(retorno.data, function(key, value){
												$("[name='"+key+"']").val(value);
												if($("[name='"+key+"']").attr("type")=='hidden')
													$("[name='"+key+"']").change();
												//
												if($("[name='"+key+"']").attr("data-role")=='slider')
													$("[name='"+key+"']").slider("refresh");
												else if($("[name='"+key+"']").is('select'))
													$("[name='"+key+"']").selectmenu('refresh', true).change();
												//
												if($("[name='"+key+"']").attr("type")=='checkbox' && value=='on')
													$("[name='"+key+"']").prop('checked', true).checkboxradio('refresh');
												//
											});
										}
									});
								}
							}
							function dataClik(vl,obj){ 
								var id=$('#id_clientesfc').val();
								$('#nome_clientesfc').val($('input[data-id-ul="'+obj+'"]').val());
								$("#id_sevmensal").attr('data-url', '_dados.php?cmd=select&tipo=servmensal&id_cliente_mensalfc=' + id);
								//alert(id+','+nome);
								getSelect($("#id_sevmensal"));
							}
							$(document).ready( function() {
								//
								$('.time').mask('00:00:00');
								$('.date').mask('00/00/0000');
								$('.date_time').mask('00/00/0000 00:00:00');
								$('.cep').mask('00000-000');
								$('.phone').mask('0000-0000');
								$('.phone_with_ddd').mask('(00) 00000-0000');
								$('.phone_us').mask('(000) 000-0000');
								$('.mixed').mask('AAA 000-S0S');
								$('.ip_address').mask('099.099.099.099');
								$('.money').mask('##0,00', {reverse: true});
								$('.percent').mask('##0,00%', {reverse: true});
								$('.clear-if-not-match').mask('00/00/0000', {clearIfNotMatch: true});
								$('.placeholder').mask('00/00/0000', {placeholder: '__/__/____'});									
							});		
						</script>  
				    </head>
				    <body <?php if($id_sevmensal!='') echo "onload=\"alteraDB('servmensal','$id_sevmensal');\"";?>>
					    <div data-role="page" id="home" data-theme="a" style="width: 100%;">
					    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
					    		<center>
						    		<font color=blue>
									<?php 
									echo "$title<br>$nome_clientesfc";
									if($grupo!='')
										echo " - Grupo:$grupo";
									?>
									</font>
								</center> 
							</div><!-- /header -->
							<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
								<center>
								<div id="cadastro_servmensal" style="padding:5px 10px;margin:5px">
									<fonte style="font-size: 16px;font-weight: bold;">
									<?php 
										if($id_sevmensal!='')
											echo 'Alterar Serviço Mensal id:'.$id_sevmensal;
										else 
											echo 'Cadastra Serviço Mensal';
									?>
									</font>
									<div class="ui-field-contain">
											<font style="font-size: 10px;">Acesso Grátis:</font>
											<select name="gratis_sevmensalfc" data-role="slider" data-mini="true">
												<option value="">Não</option>
												<option value="on">Sim</option>
											</select>
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Data inicio mensalidade:</font>
											<input name="data_ativado_mensalfc" placeholder="Data Ativação" class="date">
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Valor Mensal:</font>
											<input name="valor_sevmensalfc" placeholder="Valor Mensalidade" class="money">
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Descrição:</font>
											<input name="descricao_mensalfc"> 
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Ponto de Acesso?:</font>
											<select name="ponto_sevmensalfc" data-role="slider" data-mini="true">
												<option value="">Não</option>
												<option value="on">Sim</option>
											</select>
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Tipo de Conexao:</font>
											<select name="tipo_auth_sevmensalfc" data-mini="true">
												<option value="pppoe" selected>PPPOE</option>
												<option value="bindings">IPBINDINGS</option>
											</select>
										</div>
										<li class="ui-field-contain">
											<font style="font-size: 10px;">Usuário de Acesso (<font id="tipoauth">pppoe</font>):<font style="font-size: 14px;color:blue;" id="userppp"></font></font>
											<div class="ui-grid-solo">
												<div class="ui-block-a">
													<input id="name_secret_add" class="list_secrets" onkeyup="AutoCompleteText($(this));" type="text" data-id-click="id_user_sevmensalfc" placeholder="Buscar Users..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="1" data-url="_dados.php?cmd=busca&tipo=secrets&grupo=<?php echo $grupo;?>&query={val}">
												</div>
											</div>
										</li>
											<div class="ui-field-contain">
											<font style="font-size: 10px;">Instalação em Comodato:</font>
											<select name="comodato_sevmensalfc" data-role="slider" data-mini="true">
												<option value="">Não</option>
												<option value="on">Sim</option>
											</select>
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Mesmo endereço do Cadastro:</font>
											<select onchange="getEndServMensal(this.value)"; name="end_cob_sevmensalfc" data-role="slider" data-mini="true">
												<option value="">Não</option>
												<option value="on">Sim</option>
											</select>
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Cep da instalação:</font>
											<input id="cep_sevmensalfc" name="cep_sevmensalfc" placeholder="Cep da Instalação">
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Novo Endereço:</font>
											<textarea cols="40" rows="8" id="end_sevmensalfc" name="end_sevmensalfc" placeholder="Endereço da Instalação" data-mini="true"></textarea>
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Complemento do Endereço da instalação:</font>
											<input id="comp_sevmensalfc" name="comp_sevmensalfc" placeholder="casa, ap, etc...">
										</div>
										<div class="ui-field-contain">
											<font style="font-size: 10px;">Equipamentos:</font>
											<textarea cols="40" rows="8" id="equipamentos_sevmensalfc" name="equipamentos_sevmensalfc" placeholder="Equipamento instalado" data-mini="true"></textarea>
										</div>
										<input data-fix=true name="cmd" value="save" type="hidden">
										<input data-fix=true name="cache" value="false" type="hidden">
										<input data-fix=true name="tipo" value="servmensal" type="hidden">
										<input id="id_mensalfc" name="id_mensalfc" value="<?php echo $id_sevmensal;?>" type="hidden">
										<input id="id_user_sevmensalfc" name="id_user_sevmensalfc" type="hidden">
										<input name="id_cliente_mensalfc" value="<?php echo $id_clientesfc;?>" id="id_cliente_mensalfc" type="hidden">
										<fieldset class="ui-grid-a">
			                    			<div class="ui-block-a">
												<button onclick="salvaDados('cadastro_servmensal');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Salvar</button>
											</div>
			                    			<div class="ui-block-b">
												<a href="servmensal.php" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">VOLTAR</a>					
											</div>
										</fieldset>
									</div>
								</center> 
							</div><!-- /content -->
							<div data-role="footer" style="overflow:hidden;" data-position="fixed">
								<center>
									<font color="red" size="2"><?php echo $login_usuario;?></font><br>
						    		<a href="servmensal.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
						    	</center>
							</div><!-- /header -->
						</div>
				    </body>
				</html>
<?php 
			}
		}
	}
?>