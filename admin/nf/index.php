<?php 
	require_once("validar.php");
	$title='NF';
	if($login_usuario!='')
		$title.=' - '.$login_usuario;
	if($provedor_usuario!='')
		$title.=' - '.$provedor_usuario;
	?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="ISO-8859-1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <title><?php echo $title;?></title>
		<link rel="stylesheet" href="../_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../_js/jquery/jquery-ui.min.css" />
		<script src="../_js/jquery/jquery-1.11.3.min.js"></script>
		<script src="../_js/jquery/jquery-mobile-1.4.5.min.js"></script>
		<script src="../_js/jquery/jquery-ui.min.js"></script>
		<script src="../_js/mask_real.js"></script>
		<script src="../_js/funcoes.js"></script>
		<script src="../_js/auto_complete.js"></script> 
    </head>
    <body>
	    <div data-role="page" id="home" style="background-color:#ADD8E6">
	    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
				<?php 
				$error = $error ? $error : false;
				if($authSession && !$error){
					$bar='<div data-role="navbar">
						<ul>
							<li><a href="#list_notas" onclick="onloadNotas();" data-icon="bullets">Listar/Cadastrar</a></li>
							<li><a href="#new_empresa" data-icon="shop">Alterar</a></li>
							<li><a href="#print" data-icon="calendar">Imprimir</a></li>
							<li><a href="#" onclick="location.href=\'index.php?logout=true\'" data-icon="power">Sair</a></li>
						</ul>
					</div>';
					echo $bar;
				}else{
					echo "<h2><font color=red>$error</font></h2>";
				}
				?>
			</div><!-- /header -->
			<?php 
			if(!$authSession){
				echo $form_login;
			?>
		</div><!-- /page --> 
		<?php 
		}else{
			$htmlfat='<div id="fat_01" data-role="collapsible" data-collapsed="false" class="faturas">
				<legend>Fatura<font class="n-item">01</font></legend>
					<div class="ui-field-contain">
				    <label for="tipo_servico">Tipo de serviço:</label>
				    <select onchange="selServ($(this));" name="tipo_servico" data-native-menu="false">
				        <option value="104" selected>Assinatura de serviços de provimento de acesso à internet</option>
					</select>
				</div>
				<div class="ui-field-contain">
					<label for="valor_servico">Valor do Serviço:</label>
					<input onkeyup="somar();" name="valor_servico" type="text" class="money" value="0,00">
				</div>
				<input class="id_cliente" name="id_cliente_servico" type="hidden">
				<input name="descricao_servico" type="hidden">
				<input name="unidade_servico" value="UN" type="hidden">
				<input name="qtd_contratada_servico" value="1" type="hidden">
				<input name="qtd_fornecida_servico" value="1" type="hidden">
				<input name="icms_servico" value="0" type="hidden">
				<input name="reducao_servico" value="0" type="hidden">
				<input name="alicota_servico" value="0" type="hidden">
				<button class="bt-remove-item" onclick="$(this).parent().parent().remove();" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-delete" style="display: none;">Remover Fatura</button>
			</div>';
		?> 
			</div><!-- /page --> 
			<div data-role="page" id="list_notas">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<?php 
					echo $bar;
					?>
				</div><!-- /header -->
				<div role="main" class="ui-content">
					<div style="padding:5px 10px;">  
					    <center>
					    	<b>Notas<br><font color=blue id=nome_cliente_pg></font> - Mês<font color=blue id=data_mes_pg></font></b>
							<a href="#" onclick="location.href='caixa.php?sit_cobrancas=ab&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='ab')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Em aberto</a>
							<a href="#" onclick="location.href='caixa.php?sit_cobrancas=pg&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='pg')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Pagas</a>
							<a href="#" onclick="location.href='caixa.php?sit_cobrancas=all&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='all')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>All</a>
						</center>
						<input id="status_notasnf" type="hidden">
						<input id="data_notasnf" type="hidden">
						<ul id="lista_notas" data-role="listview" data-inset="true"></ul>
					</div>
				</div><!-- /content -->
			</div><!-- /page -->
			<div data-role="page" id="new_nota">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<?php 
					echo $bar;
					?>
				</div><!-- /header -->
				<div role="main" class="ui-content">
					<div style="padding:5px 10px;">  
					    <center>
					    	<b><font size=5>Cadastrar Notas</font></b><br>
					    </center>
					    <div data-role="collapsible" data-collapsed="false">
					    	<legend>Notas (<font class="n-item">Nenhuma Nota</font>)</legend>
							<div style="padding:5px 10px;">  
							    <ul id="linhas_nota" data-role="listview" data-inset="true"></ul>
							</div>	
							<div class="ui-field-contain">
								<label for="valor_total">Valor Total:</label>
								R$ <font id="valor_total" class="money">0,00</font>
							</div>				    	
					    </div>
					    <div id="itens_nota" data-role="collapsible" data-collapsed="true">
					    	<legend>Itens da Nota</legend>
							<div class="ui-field-contain">
								<div class="ui-grid-solo">
									<div class="ui-block-a">
										<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar empresa..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" name="nome_empresanf" data-id-click="id_empresanf" data-url="remote.php?cmd=busca&tipo=empresas&query={val}">
									</div>
								</div>
							</div>
							<input name="id_empresanf" id="id_empresanf" type="hidden">
							<div class="ui-field-contain">
								<div class="ui-grid-solo">
									<div class="ui-block-a">
										<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar cliente..." data-newitem="new_cliente" data-loading="Buscando ... aguarde." data-minlen="2" name="nome_clientesnf" data-id-click="id_clientesnf" data-url="remote.php?cmd=busca&tipo=clientes&query={val}">
									</div>
								</div>
							</div>
							<input name="id_clientesnf" id="id_clientesnf" type="hidden">
							<?php echo $htmlfat;?>
							<button onclick="addFat()" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">Add Fatura</button>
							<div class="ui-field-contain">
								<label for="valor_nota">Valor da Nota:</label>
								R$ <font id="valor_nota" class="money">0,00</font>
							</div>
						</div>
						<center>
							<button onclick="addNotas();" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">Add Nota</button><br>
							<input name="qtd_fat_clientenf" type="hidden">
							<input data-fix=true name="cmd" value="save" type="hidden">
							<input data-fix=true name="cache" value="false" type="hidden">
							<input data-fix=true name="tipo" value="notas" type="hidden">
							<input name="id_notasnf" id="id_notasnf" type="hidden">
							<a href="#" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-right" data-transition="pop">Voltar</a>
							<button onclick="salvaDados('new_notas');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Salvar/Cadastrar Notas</button>							
						</center>
					</div>
				</div><!-- /content -->
			</div><!-- /page -->
			<div data-role="page" id="new_cliente">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<?php 
					echo $bar;
					?>
				</div><!-- /header -->
				<div role="main" class="ui-content">
					<div style="padding:5px 10px;">  
					    <center>
					    	<b><font id="ConfigurarCliente_titulo" size=5>Cadastrar/Alterar Cliente</font></b><br>
					    </center>
						<div class="ui-field-contain">
						    <label>Busca de Cliente:</label>
						    <div class="ui-grid-solo">
								<div class="ui-block-a">
									<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar cliente..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_clientesnf" data-load-click="loadDados('dados_clientes','id_clientesnf');" data-url="remote.php?cmd=busca&tipo=clientes&query={val}">
								</div>
							</div>
						</div>
						<div class="ui-field-contain">
						    <label for="bt_ConfigurarCliente_novo">Limpar Formulário:</label>
							<a href="#" onclick="clear_form_elements('new_cliente')" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo (Limpar dados)</a>
						</div>
						<div data-role="collapsible" data-collapsed="false">
							<legend>Dados Pessoais</legend>
						    <div class="ui-field-contain">
								<label for="tipo_pessoa_clientesnf">Tipo Pessoa:</label>
								<select name="tipo_pessoa_clientesnf" id="tipo_pessoa_clientesnf" data-role="slider" data-mini="false">
								    <option value="f">Física</option>
								    <option value="j">Jurídica</option>
								</select>
							</div>
						    <div class="ui-field-contain">
								<label for="nome_clientesnf">Nome:</label>
								<input name="nome_clientesnf" id="nome_clientesnf" type="text" class="required">
							</div>
						    <div class="ui-field-contain">
								<label for="razao_clientesnf ">Razão Social(jurídica):</label>
								<input name="razao_clientesnf" id="razao_clientesnf" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="rg_ie_clientesnf">RG/Incrição Estatual:</label>
								<input name="rg_ie_clientesnf" id="rg_ie_clientesnf" type="text" class="required">
							</div>
							    <div class="ui-field-contain">
									<label for="cpf_cnpj_clientesnf">Cpf/Cnpj:</label>
									<input name="cpf_cnpj_clientesnf" id="cpf_cnpj_clientesnf" type="text" class="required">
								</div>
							    <div class="ui-field-contain">
									<label for="responsavel_clientesfc">Responsavel(jurídica):</label>
									<input name="responsavel_clientesfc" id="responsavel_clientesfc" type="text">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Dados de Contato</legend>
								<div class="ui-field-contain">
								    <label for=telefone_clientesnf>Telefone 1:</label>
								    <input name="telefone_clientesnf" id="telefone_clientesnf" class="required phone_with_ddd" type="text" placeholder="Telefone">
								</div>
								<div class="ui-field-contain">
								    <label for="email_clientesnf">Email:</label>
								    <input name="email_clientesnf" id="email_clientesnf" type="text" class="required">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Endereço</legend>
								<div class="ui-field-contain">
								    <label for="cep_clientesnf">Endereço Cep:</label>
						    		<input name="cep_clientesnf" size="10" id="cep_clientesnf" type="text" placeholder="Cep" class="ui-mini" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="endereco_clientesnf">Endereço Logradouro:</label>
								    <input name="endereco_clientesnf" id="endereco_clientesnf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="endereco_clientesnf">Endereço Numero:</label>
								    <input name="numero_clientesnf" id="numero_clientesnf" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="bairro_clientesnf">Endereço Bairro:</label>
								    <input name="bairro_clientesnf" id="bairro_clientesnf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="cidade_clientesnf">Endereço Cidade:</label>
								    <input name="cidade_clientesnf" id="cidade_clientesnf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="uf_clientesnf">Endereço Estado:</label>
								   	<select name="uf_clientesnf" id="uf_clientesnf" data-native-menu="true" class="ui-mini" class="required">
									    <option value="0">Selecione o Estado</option>
										<option value="AC">Acre</option>
										<option value="AL">Alagoas</option>
										<option value="AP">Amapá</option>
										<option value="AM">Amazonas</option>
										<option value="BA">Bahia</option>
										<option value="CE">Ceará</option>
										<option value="DF">Distrito Federal</option>
										<option value="ES">Espirito Santo</option>
										<option value="GO">Goiás</option>
										<option value="MA">Maranhão</option>
										<option value="MS" selected>Mato Grosso do Sul</option>
										<option value="MT">Mato Grosso</option>
										<option value="MG">Minas Gerais</option>
										<option value="PA">Pará</option>
										<option value="PB">Paraíba</option>
										<option value="PR">Paraná</option>
										<option value="PE">Pernambuco</option>
										<option value="PI">Piauí</option>
										<option value="RJ">Rio de Janeiro</option>
										<option value="RN">Rio Grande do Norte</option>
										<option value="RS">Rio Grande do Sul</option>
										<option value="RO">Rondônia</option>
										<option value="RR">Roraima</option>
										<option value="SC">Santa Catarina</option>
										<option value="SP">São Paulo</option>
										<option value="SE">Sergipe</option>
										<option value="TO">Tocantins</option>
									</select>
								</div>
							</div>
							<center>
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="cliente" type="hidden">
								<input name="id_clientesnf" id="id_clientesnf" type="hidden">
								<a href="#" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button onclick="salvaDados('new_cliente');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>							</center>
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
			<div data-role="page" id="new_empresa">
				<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<?php 
					echo $bar;
					?>
				</div><!-- /header -->
				<div role="main" class="ui-content">
					<div style="padding:5px 10px;">  
					    <center>
					    	<b><font id="ConfigurarCliente_titulo" size=5>Cadastrar/Alterar Empresa</font></b><br>
					    </center>
						<div class="ui-field-contain">
						    <label>Busca de Empresa:</label>
						    <div class="ui-grid-solo">
								<div class="ui-block-a">
									<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar empresa..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_empresafc" data-url="remote.php?cmd=busca&tipo=empresa&query={val}">
								</div>
							</div>
						</div>
						<div class="ui-field-contain">
						    <label for="bt_ConfigurarCliente_novo">Limpar Formulário:</label>
							<a href="#" id="bt_ConfigurarCliente_novo" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo (Limpar dados)</a>
						</div>
						<div data-role="collapsible" data-collapsed="false">
							<legend>Dados Pessoais</legend>
						    <div class="ui-field-contain">
								<label for="nome_empresanf">Nome Fantasia:</label>
								<input name="nome_empresanf" id="nome_empresanf" type="text" class="required">
							</div>
						    <div class="ui-field-contain">
								<label for="razao_empresanf">Razão Social:</label>
								<input name="razao_empresanf" id="razao_empresanf" type="text" class="required">
							</div>
						    <div class="ui-field-contain">
								<label for="ie_empresanf">Incrição Estatual:</label>
								<input name="ie_empresanf" id="ie_empresanf" type="text" class="required">
							</div>
							    <div class="ui-field-contain">
									<label for="cnpj_empresanf">Cnpj:</label>
									<input name="cnpj_empresanf" id="cnpj_empresanf" type="text" class="required">
								</div>
							    <div class="ui-field-contain">
									<label for="responsavel_empresanf">Responsavel:</label>
									<input name="responsavel_empresanf" id="responsavel_empresanf" type="text" class="required">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Dados de Contato</legend>
								<div class="ui-field-contain">
								    <label for=telefone_empresanf>Telefone 1:</label>
								    <input name="telefone_empresanf" id="telefone_empresanf" class="phone_with_ddd" type="text" placeholder="Telefone" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="email_empresanf">Email:</label>
								    <input name="email_empresanf" id="email_empresanf" type="text" class="required">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Endereço</legend>
								<div class="ui-field-contain">
								    <label for="cep_empresanf">Endereço Cep:</label>
						    		<input name="cep_empresanf" size="10" id="cep_empresanf" type="text" placeholder="Cep" class="ui-mini" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="endereco_empresanf">Endereço Logradouro:</label>
								    <input name="endereco_empresanf" id="endereco_empresanf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="numero_empresanf">Endereço Numero:</label>
								    <input name="numero_empresanf" id="numero_empresanf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="bairro_empresanf">Endereço Bairro:</label>
								    <input name="bairro_empresanf" id="bairro_empresanf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="cidade_empresanf">Endereço Cidade:</label>
								    <input name="cidade_empresanf" id="cidade_empresanf" type="text" class="required">
								</div>
								<div class="ui-field-contain">
								    <label for="uf_empresanf">Endereço Estado:</label>
								   	<select name="uf_empresanf" id="uf_empresanf" data-native-menu="true" class="ui-mini" class="required">
									    <option value="0">Selecione o Estado</option>
										<option value="AC">Acre</option>
										<option value="AL">Alagoas</option>
										<option value="AP">Amapá</option>
										<option value="AM">Amazonas</option>
										<option value="BA">Bahia</option>
										<option value="CE">Ceará</option>
										<option value="DF">Distrito Federal</option>
										<option value="ES">Espirito Santo</option>
										<option value="GO">Goiás</option>
										<option value="MA">Maranhão</option>
										<option value="MS" selected>Mato Grosso do Sul</option>
										<option value="MT">Mato Grosso</option>
										<option value="MG">Minas Gerais</option>
										<option value="PA">Pará</option>
										<option value="PB">Paraíba</option>
										<option value="PR">Paraná</option>
										<option value="PE">Pernambuco</option>
										<option value="PI">Piauí</option>
										<option value="RJ">Rio de Janeiro</option>
										<option value="RN">Rio Grande do Norte</option>
										<option value="RS">Rio Grande do Sul</option>
										<option value="RO">Rondônia</option>
										<option value="RR">Roraima</option>
										<option value="SC">Santa Catarina</option>
										<option value="SP">São Paulo</option>
										<option value="SE">Sergipe</option>
										<option value="TO">Tocantins</option>
									</select>
								</div>
							</div>
							<center>
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="empresa" type="hidden">
								<input name="id_empresanf" id="id_empresanf" type="hidden">
								<a href="#" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button onclick="salvaDados('new_empresa');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>
							</center>
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
				<div data-role="page" id="cadastroFim">
					<div role="main" class="ui-content">
						<div style="padding:10px 20px;"> 
						    <center><h3>STATUS DO CADASTRO</h3>
						    	<font color=blue size=5 id="local_texto_retorno"></font><Br><Br>
								<a href="<?php echo $home;?>" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>
							</center>
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
				<script type="text/javascript">
				$(document).ready( function() {
					//
					$('.money').maskMoney({prefix:'R$ ', decimal:',', affixesStay: true});
					$('.phone_with_ddd').mask('(00) 0000-0000');
					$(".datebox").datepicker({
					    dateFormat: 'dd/mm/yy',
					    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
					    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
					});
					//
					$("input[type=checkbox]").change(function () {
						if($(this).is(':checked'))
							$(this).val('on');  // checked
						else
							$(this).val('');  // unchecked
					});		
					//						
					$('#id_clientesnf').change(function () {
						//alert($(this).val());
						//if($(this).val()==''){
							//clear_form_elements('ConfigurarCliente');
							//$("#ConfigurarCliente_titulo").html('Cadastrar Novo Cliente');
						//}else
							//$("#ConfigurarCliente_titulo").html('Alterar Cliente');
						//
						//getSelect();
						$('.id_cliente').val($(this).val());
						somar();
					});
					//
				});		
				//	
				var fat='<?php echo preg_replace('/\s/',' ',$htmlfat);?>';
				function addFat() {
					var id='faturas';
					var n_new=$("."+id).length+1;
					if(n_new<10){
						n_new='0'+n_new;
					}
					var obj=$( fat ).insertAfter("."+id+":last").collapsible().collapsible("refresh").enhanceWithin();
					obj.attr("id","fat_"+n_new);
					obj.find("input").val("");
					obj.find(".n-item").html(n_new);
					obj.find(".bt-remove-item").css("display", "block");
					$('.id_cliente').val($('#id_clientenf').val());
				};
				//
				function salvaDados(id) {
					//VALIDAÇÃO
					var validad=true;
					$("#"+id+" input.required").each(function() {
						if($(this).val()==''){
							validad=false; 
						}
					});
					if(!validad)
						return false;
					//
					var tempName = [];
					var tempData = {};
					$("#"+id+" input, #"+id+" select").each(function() {
						var name=$(this).attr("name");
						if(name && !tempName[name]){
							//alert(name+'-'+$("[name='"+name+"']").length);
							tempName[name]=true;
							if($("[name='"+name+"']").length>1){
								var valor=[];
								$("[name='"+name+"']").each(function(i) {
									valor[i]=$(this).val();
								});
							}else{
								var valor=$(this).val();
							}
							tempData[name] = valor;
						}
					});
					$.mobile.loading('show');
					$.post('remote.php',tempData,function(data){
						$.mobile.loading("hide");
						$.mobile.changePage("#cadastroFim");
						$("#local_texto_retorno").html(data);
					});
				}
				//
				function selServ(obj){ 
					if($(obj).html()!='')
						$(obj).closest('.faturas').find("input[name='descricao_servico']").val($(obj).html());
					//
				}
				//
				function somar(){ 
					var total=0;
					$('.faturas').each(function(){
						var obj=$(this).closest('.faturas');
						total+=obj.find("input[name='valor_servico']").maskMoney('unmasked')[0]*1;
					});
					$("#valor_nota").html(decimalFormat(total));
				}
				//
				function loadDados(tipo,idud){ 
					var id=$("#"+idud).val();
					openPg(tipo,'','',id);
				}
				//
				function onloadNotas(){
					var status=$("#status_notasnf").val();
					var data=$("#data_notasnf").val();
					getLoading('Localizando Notas...');
					$.ajax({url: 'remote.php',data:'cmd=busca&tipo=notas&status_notasnf='+status+'&data_notasnf='+data,dataType: "json"}).then( function ( response ) {
		  	      		if(!response.auth) 
		  	      			location.reload();
		  	      		//
		  	      		var html='';
		  	      		if(response.qtd==0){
		  	      			html +="<li><font color='red'>Nenhum(a) Notas</font>'</li>";
		  	      		}
		  	      		if(response.qtd!=0){
			  	      		$.each(response.suggestion, function ( i, dados ) {
			  	              	html += "<li><a onclick=\"listarNota('"+dados.id+"','"+dados.name+"');\" href=\"#\">"+dados.name+"<BR><center><font size=1 color=green><< VER/ALTERAR NOTA >></font></center></a></li>";
			  	            });
		  	      		}
		  	      		$("#lista_notas").html(html);
		  	      		$("#lista_notas").listview("refresh");
		  	      		$("#lista_notas").trigger("updatelayout");
		  	          	$.mobile.loading("hide")
		  	      	});
				}
				//
				function onloadNota(id){
					getLoading('Localizando Dados da Nota...');
					$.ajax({url: 'remote.php',data:'cmd=busca&tipo=dados_nota&id_notasnf='+id,dataType: "json"}).then( function ( response ) {
		  	      		if(!response.auth) 
		  	      			location.reload();
		  	      		//
		  	      		var html='';
		  	      		if(response.qtd==0){
		  	      			html +="<li><font color='red'>Nenhum Dado</font>'</li>";
		  	      		}
		  	      		if(response.qtd!=0){
			  	      		$.each(response.suggestion, function ( i, dados ) {
			  	              	html += "<li><a onclick=\"altNota('"+id+"','"+dados.id+"','"+dados.name+"');\" href=\"#\">"+dados.name+"<BR><center><font size=1 color=green><< VER/ALTERAR DADO DA NOTA >></font></center></a></li>";
			  	            });
		  	      		}
		  	      		$("#linhas_nota").html(html);
		  	      		$("#linhas_nota").listview("refresh");
		  	      		$("#linhas_nota").trigger("updatelayout");
		  	          	$.mobile.loading("hide")
		  	      	});
				}
				//
				function listarNota(id,nome){
					$.mobile.changePage("#new_nota");
					onloadNota(id);
				}
				function altNota(id_nota,id,nome){
					openPg('dados_notas','id_notasnf',id_nota,id);
				}
				function openPg(tipo,col,val,id) {
					alert(tipo+','+col+','+val+','+id);
					$.mobile.loading('show');
				    $.ajax({
				        type: 'POST',
				        cache:false,
				        url: 'remote.php',
				        data: {cmd:'load',tipo:tipo,id:id,col:col,val:val},
				        dataType: 'json',
				        success: function(retorno) {
							$.mobile.loading("hide");
							if(retorno.qtd==1){
								$.each(retorno.data, function(key, value){
									if(key=='fat'){
										if(value.length>0){
											$("#itens_nota").collapsible("expand");
											$.each(value, function(i,item){
												var n=i+1;
												if(n<10)
													n='0'+n;
												//
												if(i>0){
													$("#fat_"+n).remove();
													addFat();
												}
												$.each(item, function(key1, value1){
													if(key1=='valor_servico')
														$("#fat_"+n).find("[name='"+key1+"']").maskMoney('mask',value1);
													else
														$("#fat_"+n).find("[name='"+key1+"']").val(value1);
													//
													if($("#"+n).find("[name='"+key1+"']").attr("type")=='number')
														$("#"+n).find("[name='"+key1+"']").slider("refresh");
													//
													if($("#"+n).find("[name='"+key1+"']").attr("type")=='hidden')
														$("#"+n).find("[name='"+key1+"']").change();
													//
													if($("#"+n).find("[name='"+key1+"']").attr("data-role")=='slider')
														$("#"+n).find("[name='"+key1+"']").slider("refresh");
													else if($("#"+n).find("[name='"+key1+"']").is('select'))
														$("#"+n).find("[name='"+key1+"']").selectmenu('refresh', true).change();
													//
													if($("#"+n).find("[name='"+key1+"']").attr("type")=='checkbox' && value1=='on')
														$("#"+n).find("[name='"+key1+"']").prop('checked', true).checkboxradio('refresh');
													//
												});
												//
											});
										}
									}else{	
										$("[name='"+key+"']").val(value);
										if($("[name='"+key+"']").attr("type")=='number')
											$("[name='"+key+"']").slider("refresh");
										//
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
									}
								});
							}else if(retorno.qtd>1){
								$("#"+retorno.id_select).html(retorno.data).selectmenu('refresh', true);
							}
							
				        }
					});
				}
				//
				function salvaDados(id) {
					//VALIDAÇÃO
					var validad=true;
					$("#"+id+" input.required").each(function() {
						if($(this).val()==''){
							validad=false; 
						}
					});
					if(!validad)
						return false;
					//
					var tempName = [];
					var tempData = {};
					$("#"+id+" input, #"+id+" select").each(function() {
						var name=$(this).attr("name");
						if(name && !tempName[name]){
							//alert(name+'-'+$("[name='"+name+"']").length);
							tempName[name]=true;
							if($("#"+id+" [name='"+name+"']").length>1){
								var valor=[];
								$("#"+id+" [name='"+name+"']").each(function(i) {
									valor[i]=$(this).val();
								});
							}else{
								var valor=$(this).val();
							}
							tempData[name] = valor;
						}
					});
					$.mobile.loading('show');
					$.post('remote.php',tempData,function(data){
						$.mobile.loading("hide");
						$.mobile.changePage("#cadastroFim");
						$("#local_texto_retorno").html(data);
					});
				}
				//
				</script>
		<?php 
		}
		?>
	</body>
</html>