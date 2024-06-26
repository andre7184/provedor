<?php 
//importa funçoes
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
$query = isset($_REQUEST["query"]) ? $_REQUEST["query"] : false;
$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
//IMPORTA SITE SEGURO
header("Content-Type: text/html; charset=ISO-8859-1",true) ;
require_once("_validar.php");
if($authSession){
	// get command 
	//
	$chars = array('(', ')', '-');
	//
	switch($cmd) {
		case "pages": //
			$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : false;
			switch($page) {
				case "home":
					?>
					<div id="page">
						<input id="myscripts" value="setArgData" type="hidden">
						<center>
							<div data-role="navbar">
							    <ul>
							        <li><a href="#" onclick="loadPage('home');" class="ui-btn-active">Dados Gerais</a></li>
							        <li><a href="#" onclick="loadPage('clientes');">Clientes</a></li> 
							    </ul>
							</div><!-- /navbar -->									
						</center>

					</div>  
					<?php 
				break;
				case "clientes":
					?>
					<div id="page">
						<input id="myscripts" value="setArgData,listar,onloadPontos" type="hidden">
						<input id="myruns" value="listar('clientes','clientes','lista_clientes');" type="hidden">
						<center>
							<div data-role="navbar">
							    <ul>
							        <li><a href="#" onclick="loadPage('home');">Dados Gerais</a></li>
							        <li><a href="#" onclick="loadPage('clientes');" class="ui-btn-active">Contas</a></li>
							    </ul>
							</div><!-- /navbar -->									
						</center>
						<a href="#" onclick="$('#cadastro_clientes').simpledialog2();$('#id_clientesfc').val('');loadScript('','cadastro_clientes');" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo Cliente</a>
						<ul id="lista_clientes" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
						</ul>
						<div id="cadastro_clientes" style="display:none" data-options='{"themeDialog":"a","mode":"blank","blankContent":true,"blankContentAdopt":true,"fullScreen":true,"fullScreenForce":true,"headerText":"Cadastrar/Alterar Cliente","headerClose":true,"width":"100%","zindex":"1000"}'>
							<div style="padding: 5px;height: 90%;overflow: auto;" id="tela_cadastro_clientes">
								<center>
									<div data-role="collapsible" data-collapsed="false">
										<legend>Dados Pessoais</legend>
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Pessoa Jurídica:</font>
												<select name="pessoa_juridica_clientesfc" id="pessoa_juridica_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on">On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Nome:</font>
												<input name="nome_clientesfc" id="nome_clientesfc" type="text" onkeyup="$(this).val($(this).val().toUpperCase());">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Razão Social(jurídica):</font>
												<input name="razao_social_clientesfc" id="razao_social_clientesfc" type="text" class="upperCase">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">RG/Incrição Estatual:</font>
												<input name="rg_ie_clientesfc" id="rg_ie_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Cpf/Cnpj:</font>
												<input name="cpf_cnpj_clientesfc" id="cpf_cnpj_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Responsavel(jurídica):</font>
												<input name="responsavel_clientesfc" id="responsavel_clientesfc" type="text" class="upperCase">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Data de Nascimento:</font>
												<input name="data_nascimento_clientesfc" id="data_nascimento_clientesfc" class="date" type="text">
											</li>
										</ul>
									</div>
									<div data-role="collapsible" data-collapsed="true">
										<legend>Dados de Contato</legend>
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Telefone 1:</font>
											    <div class="ui-grid-a center">
											    	<div class="ui-block-a">
												    	<input name="tel1_clientesfc" id="tel1_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone" data-mini="true">
											        </div>
											        <div class="ui-block-b">
												        <select name="op1_clientesfc" id="op1_clientesfc" data-mini="true">
												        	<option value="" select>Oper</option>
												            <option value="OI">Oi</option>
												            <option value="VIVO">Vivo</option>
												            <option value="CLARO">Claro</option>
												            <option value="TIM">Tim</option>
												            <option value="NET">Net</option>
												            <option value="NEXTEL">Nextel</option>
												        </select>
												    </div>
												</div>
												<div class="ui-grid-a center">
											        <div class="ui-block-a">
											        	<font style="font-size: 10px;">Wz:</font>
														<select name="wsap1_clientesfc" id="wsap1_clientesfc" data-role="slider" data-mini="true">
														    <option value="">Off</option>
														    <option value="on">On</option>
														</select>
					        						</div>
					        						<div class="ui-block-b">
										    			<input name="nome1_clientesfc" id="nome1_clientesfc" type="text" placeholder="Nome Contato" data-mini="true">
													</div>
												</div>											
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Telefone 2:</font>
											    <div class="ui-grid-a center">
											    	<div class="ui-block-a">
												    	<input name="tel2_clientesfc" id="tel2_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone" data-mini="true">
											        </div>
											        <div class="ui-block-b">
												        <select name="op2_clientesfc" id="op2_clientesfc" data-mini="true">
												        	<option value="" select>Oper</option>
												            <option value="OI">Oi</option>
												            <option value="VIVO">Vivo</option>
												            <option value="CLARO">Claro</option>
												            <option value="TIM">Tim</option>
												            <option value="NET">Net</option>
												            <option value="NEXTEL">Nextel</option>
												        </select>
												    </div>
												</div>
												<div class="ui-grid-a center">
											        <div class="ui-block-a">
											     		<font style="font-size: 10px;">Wz:</font>
														<select name="wsap2_clientesfc" id="wsap2_clientesfc" data-role="slider" data-mini="true">
														    <option value="">Off</option>
														    <option value="on">On</option>
														</select>
					        						</div>
					        						<div class="ui-block-b">
											    		<input name="nome2_clientesfc" id="nome2_clientesfc" type="text" placeholder="Nome Contato" data-mini="true">
													</div>
												</div>											
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Telefone 3:</font>
											    <div class="ui-grid-a center">
											    	<div class="ui-block-a">
												    	<input name="tel3_clientesfc" id="tel3_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone" data-mini="true">
											        </div>
											        <div class="ui-block-b">
												        <select name="op3_clientesfc" id="op3_clientesfc" data-mini="true">
												        	<option value="" select>Oper</option>
												            <option value="OI">Oi</option>
												            <option value="VIVO">Vivo</option>
												            <option value="CLARO">Claro</option>
												            <option value="TIM">Tim</option>
												            <option value="NET">Net</option>
												            <option value="NEXTEL">Nextel</option>
												        </select>
												    </div>
												</div>
												<div class="ui-grid-a center">
											        <div class="ui-block-a">
											        	<font style="font-size: 10px;">Wz:</font>
														<select name="wsap3_clientesfc" id="wsap3_clientesfc" data-role="slider" data-mini="true">
														    <option value="">Off</option>
														    <option value="on">On</option>
														</select>
					        						</div>
					        						<div class="ui-block-b">
											    		<input name="nome3_clientesfc" id="nome3_clientesfc" type="text" placeholder="Nome Contato" data-mini="true">										    
													</div>
												</div>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Email:</font>
										    	<input name="email_clientesfc" id="email_clientesfc" type="text">
											</li>
										</ul>
									</div>
									<div data-role="collapsible" data-collapsed="true" class="openMe">
										<legend>Endereço 1</legend>
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 (Cobrança?):</font>
												<select name="cob1_clientesfc" id="cob1_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on" selected>On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Cep:</font>
										   		<input name="cep1_clientesfc" size="10" id="cep1_clientesfc" class="cep" type="text" placeholder="Cep" class="ui-mini">
											</li>	
											<li class="ui-field-contain">
										    	<a href="#" onclick="getEnd($('#cep1_clientesfc').val(),{cep:'cep1_clientesfc',logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Endereço 1</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Logradouro:</font>
											    <input name="end1_clientesfc" id="end1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Número:</font>
											    <input name="num1_clientesfc" id="num1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Complemento:</font>
											    <input name="comp1_clientesfc" id="comp1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Bairro:</font>
											    <input name="bar1_clientesfc" id="bar1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Estado:</font>
											   	<select name="uf1_clientesfc" id="uf1_clientesfc" data-native-menu="true" class="ui-mini" data-mini="true">
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
											</li>
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Cidade:</font>
											    <input name="cid1_clientesfc" id="cid1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Busca Cep (Pelo endereço):</font>
												<a href="#" onclick="getCep({cep:'cep1_clientesfc',logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar CEP 1</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Localizar Latitude e Longitude:</font>
											    <a href="#" onclick="loadScript('mapaG',false,'openMapa(\'1\')');" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Latitude:</font>
											    <input name="lat1_clientesfc" id="lat1_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 1 Longitude:</font>
											    <input name="long1_clientesfc" id="long1_clientesfc" type="text">
											</li>
										</ul>
									</div>
									<div data-role="collapsible" data-collapsed="true">
										<legend>Endereço 2</legend>
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 (Cobrança?):</font>
												<select name="cob2_clientesfc" id="cob2_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on">On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Logradouro:</font>
											    <input name="end2_clientesfc" id="end2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Número:</font>
											    <input name="num2_clientesfc" id="num2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Complemento:</font>
											    <input name="comp2_clientesfc" id="comp2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Cep:</font>
												<input name="cep2_clientesfc" id="cep2_clientesfc" class="cep" type="text" placeholder="Cep" data-wrapper-class="controlgroup-textinput ui-btn">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Buscar Endereço 2 (pelo cep):</font>
										    	<a href="#" onclick="getEnd($('#cep2_clientesfc').val(),{cep:'cep2_clientesfc',logradouro:'end2_clientesfc',numero:'num2_clientesfc',bairro:'bar2_clientesfc',cidade:'cid2_clientesfc',uf:'uf2_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Endereço 2</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Bairro:</font>
											    <input name="bar2_clientesfc" id="bar2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Cidade:</font>
											    <input name="cid2_clientesfc" id="cid2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Estado:</font>
											   	<select name="uf2_clientesfc" id="uf2_clientesfc" data-native-menu="true" class="ui-mini" data-mini="true">
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
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Busca Cep 2 (Pelo endereço 2):</font>
												<a href="#" onclick="getCep({cep:'cep2_clientesfc',logradouro:'end2_clientesfc',numero:'num2_clientesfc',bairro:'bar2_clientesfc',cidade:'cid2_clientesfc',uf:'uf2_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar CEP 2</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Localizar Latitude e Longitude:</font>
											    <a href="#" onclick="loadScript('mapaG',false,'openMapa(\'2\')');" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Latitude:</font>
											    <input name="lat2_clientesfc" id="lat2_clientesfc" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Endereço 2 Longitude:</font>
											    <input name="long2_clientesfc" id="long2_clientesfc" type="text">
											</li>
										</ul>
									</div>
									<div data-role="collapsible" data-collapsed="true">
										<legend>Configurações de Cobrança</legend>
										<ul>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Dia do Vencimento:</font>
											    <select name="venc_clientesfc" id="venc_clientesfc" data-native-menu="false">
											        <option value="10">10</option>
											        <option value="15">15</option>
											        <option value="20">20</option>
											        <option value="25">25</option> 
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Acesso Grátis:</font>
											    <select name="acesso_gratis_clientesfc" id="acesso_gratis_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on">On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Desativar Juros e Multa:</font>
											    <select name="desativar_juros_clientesfc" id="desativar_juros_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on">On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Desativar Bloqueio Automático:</font>
											    <select name="destivar_bloqueio_clientesfc" id="destivar_bloqueio_clientesfc" data-role="slider" data-mini="true">
												    <option value="">Off</option>
												    <option value="on">On</option>
												</select>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Valor Mínimo para Bloqueio:</font>
												<input name="valor_bloqueio_clientesfc" id="valor_bloqueio_clientesfc" class="money" value="0" type="text">
											</li>
										</ul>
									</div>
									<div data-role="collapsible" data-collapsed="true">
										<legend>Pontos de Acessos</legend>
										<ul id="itens_pontos" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
											<li data-role="list-divider">Itens <span class="ui-li-count" id="qtd_itens_pontos">0</span></li>
										</ul>
										<button onclick="onloadPontos();$('#itc_endereco').addClass('ui-screen-hidden');$('#cadastro_clientes_pontos').simpledialog2();" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">Add Ponto</button>
									</div>
									<div data-role="collapsible" data-collapsed="true">
										<legend>OUTROS</legend>
										<ul>
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Valor Mensalidade:</font>
												R$ <font id="valor_mensalidade" class="money">0,00</font>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Valor serviço Instalação:</font>
												<input class="valor_instalacao" name="valor_instalacao" value="0,00" class="money" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Obs:</font>
												<textarea cols="40" rows="8" name="obs_clientesfc" id="obs_clientesfc" data-mini="true"></textarea>
											</li>
										</ul>
									</div>
									<input name="qtd_pontos_clientesfc" type="hidden">
									<input data-fix=true name="cmd" value="save" type="hidden">
									<input data-fix=true name="cache" value="false" type="hidden">
									<input data-fix=true name="tipo" value="cliente" type="hidden">
									<input name="id_clientesfc" id="id_clientesfc" type="hidden">
									<a rel="close" onclick="salvaDados('tela_cadastro_clientes');" data-role="button" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">SALVAR</a>	
									<a rel="close" data-role="button" href="#">Fechar</a>	
								</center>
							</div><!-- /popup -->
						</div>  
						<div id="cadastro_clientes_pontos" style="display:none" data-options='{"themeDialog":"a","mode":"blank","blankContent":true,"blankContentAdopt":true,"headerText":"Cadastrar/Alterar Ponto de acesso","headerClose":true,"width":"100%","zindex":"2000"}'>
							<div style="padding: 5px;">
								<ul data-role="listview" data-inset="true" id="cd_pontos">
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Selecione Endereço:</font>
									    <select id="end_add" onchange="if($(this).val()=='0'){$('#itc_endereco').removeClass('ui-screen-hidden');}else{$('#itc_endereco').addClass('ui-screen-hidden');};$('#cd_pontos').listview('refresh');" data-mini="true">
									    	<option value="">Selecione o endereço</option>
									    	<option value="1">Endereço 1</option>
									    	<option value="2">Endereço 2</option>
									    	<option value="0">Outro Endereço</option>
									    </select>
									</li>	
									<li class="ui-field-contain" id="itc_endereco">
										<font style="font-size: 10px;">Digite o Endereço (rua,num,bairro,cidade-uf):</font>
									    <input id="outro_end_add" type="text" data-mini="true">
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Torre de Acesso:</font>
									    <select id="torre_add" data-role="auto" data-url="remote.php?cmd=busca&tipo=select_torre" data-mini="true">
									    </select>
									</li>
									<li class="ui-field-contain">
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Localizar Latitude e Longitude:</font>
											    <a href="#" onclick="loadScript('mapaG',false,'openMapa(\'ponto\')');" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Latitude:</font>
											    <input id="lat_add" type="text">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Longitude:</font>
											    <input id="lon_add" type="text">
											</li>
										</ul>
									</li>
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Mk de Acesso:</font>
									    <select id="mk_add" data-role="auto" data-url="remote.php?cmd=busca&tipo=select_mk" data-mini="true">
									    </select>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Equipamentos instalados:</font>
									    <textarea id="equip_add" cols="40" rows="8" data-mini="true"></textarea>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Tipo de iquipamento:</font>
									    <select id="tipo_equip_add" data-native-menu="false">
									        <option value="alugado">Alugado/emprestado</option>
									        <option value="cliente">Do cliente</option>
									        <option value="vendido">Vendido</option>
									        <option value="nunhum">Nenhum</option>
										</select>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Tipo de Autenticação:</font>
									    <select id="tipo_auth_add" data-native-menu="true">
									        <option value="pppoe">Pppoe</option>
									        <option value="hotspot">Hotspot</option>
									        <option value="binding">IpBinding</option>
									        <option value="nunhum">Nenhum</option>
										</select>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Usuário de Acesso (secrets mk):</font>
									    <div class="ui-grid-solo">
										    <div class="ui-block-a">
										    	<input id="name_secret_add" class="list_secrets" onkeyup="AutoCompleteText($(this));" type="text" data-id-click="id_secret_add" args-send-value="auth|tipo_auth_add" placeholder="Buscar Users..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="3" data-url="remote.php?cmd=busca&tipo=secret&query={val}">
										    </div>
										</div>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Plano de Acesso:</font>
									    <select id="plano_add" data-role="auto" data-url="remote.php?cmd=busca&tipo=select_produto&mensal=true&int=true">
									    </select>
									</li>	
									<li class="ui-field-contain">
										<font style="font-size: 10px;">Serviço Mensal Grátis:</font>
									    <select id="gratis_add" data-role="slider" data-mini="true">
										    <option value="">Off</option>
										    <option value="on">On</option>
										</select>
									</li>	
									<li class="ui-field-contain">
										<ul data-role="listview" data-inset="true">
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Descontos:</font>
											    <input id="desconto_add" type="text" class="money">
											</li>	
											<li class="ui-field-contain">
												<font style="font-size: 10px;">Acréscimos:</font>
											    <input id="acrescimo_add" type="text" class="money">
											</li>
										</ul>
									</li>	
									<li class="ui-field-contain">
										<input id="id_secret_add" type="hidden">
										<input id="id_pontos_add" type="hidden">
										<input id="new_item_add" type="hidden">
										<input id="id_item_add" type="hidden">
							            <a rel="close" onclick="addIntemPontos();" data-role="button" href="#" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-plus">Add</a>
							            <a rel="close" data-role="button" href="#">Fechar</a>
									</li>
								</ul>
							</div>
					  	</div>
						<div id="PageListView" style="display:none" data-options='{"themeDialog":"a","mode":"blank","blankContent":true,"headerText":"Selecione Item(s)","headerClose":true,"width":"100%","zindex":"3000"}'>
							<div style="padding: 5px;"> 
							    <center><font color="blue" size="5" id="titulo_PageListView"></font></center>
							    <ul id="list_PageListView" data-role="listview" ></ul><br>
							    <center>
									<a rel="close" data-role="button" href="#">Fechar</a>
								</center>
							</div>
					  	</div>
					</div>
					<?php 
				break;
				case "caixa":
					$diaH=date('d/m/Y');$mesH=date('d/m');$anoH=date('Y');
					$tipo_data = isset($_REQUEST["tipo_data"]) ? $_REQUEST["tipo_data"] : false;
					$data_real = isset($_REQUEST["data_real"]) ? $_REQUEST["data_real"] : date('d/m/Y');
					$mes=date_format(date_create(converterDataSimples($data_real)), 'm/Y');
					$ano=date_format(date_create(converterDataSimples($data_real)), 'Y');
					$semana = array(
						'0' => 'Domingo',
						'1' => 'Segunda-Feira',
						'2' => 'Terca-Feira',
						'3' => 'Quarta-Feira',
						'4' => 'Quinta-Feira',
						'5' => 'Sexta-Feira',
						'6' => 'Sabado'
					);
					//
					if($tipo_data=='dia'){
						$busca="DATE_FORMAT(datatime_vendasfc,\"%Y-%m-%d\")='".converterDataSimples($data_real)."' AND";
						$tipo='dia';$valor=$data_real;
					}else if($tipo_data=='mes'){
						$busca="DATE_FORMAT(datatime_vendasfc,\"%m/%Y\")='$mes' AND";
						$tipo='mes';$valor=$mes;
					}else if($tipo_data=='ano'){
						$busca="DATE_FORMAT(datatime_vendasfc,\"%Y\")='$ano' AND";
						$tipo='ano';$valor=$ano;
					}else{ 
						$busca="DATE_FORMAT(datatime_vendasfc,\"%Y-%m-%d\")=curdate() AND";
						$tipo='hoje';$valor=date('d/m/Y');
					}
					$linha=mysql_fetch_object(mysql_query("SELECT count(*) AS qtd, sum(qtd_vendasfc) AS qtd_itens, sum(valor_vendasfc) AS valor_total, sum(valor_desconto_vendasfc) AS valor_desconto_total, sum(valor_pago_vendasfc) AS valor_pago_total FROM `fc_vendas` WHERE $busca id_provedor='$id_provedor_usuario' GROUP BY id_provedor"));
					if($tipo_data=='mes'){
						$qtd_itens=mysql_num_rows(mysql_query("SELECT id_vendasfc FROM `fc_vendas` WHERE $busca id_provedor='$id_provedor_usuario' group by DAY(data_pg_vendasfc)")); 
						$dadosAdd="<br>".$qtd_itens." Dia(s) <br>R$ ".number_format($linha->valor_pago_total/$qtd_itens, 2, ',', '.')." por Dia";
					}else if($tipo_data=='ano'){
						$qtd_itens=mysql_num_rows(mysql_query("SELECT id_vendasfc FROM `fc_vendas` WHERE $busca id_provedor='$id_provedor_usuario' group by MONTH(data_pg_vendasfc)"));
						$dadosAdd="<br>".$qtd_itens." Mes(es) <br>R$ ".number_format($linha->valor_pago_total/$qtd_itens, 2, ',', '.')." por Mes";
					}else{
						$dia_semana=$semana[date('w', strtotime(converterDataSimples($valor)))];
					}
					?>
					<div id="page">
						<input id="myscripts" value="setArgData" type="hidden">
						<center>
							<div data-role="navbar">
							    <ul>
							        <li><a href="#" onclick="loadPage('caixa');" class="ui-btn-active">Caixa</a></li>
							        <li><a href="#" onclick="loadPage('saidas');">Financas</a></li>
							    </ul>
							</div><!-- /navbar -->									
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
							    <a href="#" onclick="setArgData($('#periodo_data').val(),$('#data_real').val(),'-');loadPage('caixa','tipo_data',$('#tipo_data').html(),'data_real',$('#data_real').val());" class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-l ui-btn-icon-right ui-btn-icon-notext">Anterior</a>
							    <label for="periodo">Select</label>
							    <select id="periodo_data" onchange="setArgData($(this).val(),$('#data_real').val());loadPage('caixa','tipo_data',$(this).val(),'data_real',$('#data_real').val());">
							        <option value="dia" <?php if($tipo=='dia') echo 'selected';?>>Dia</option>
							        <option value="mes" <?php if($tipo=='mes') echo 'selected';?>>Mes</option>
							        <option value="ano" <?php if($tipo=='ano') echo 'selected';?>>Ano</option>
							        <option value="hoje" <?php if($tipo=='hoje') echo 'selected';?>>Hoje</option>
					 		  	</select>
							    <a href="#" onclick="setArgData($('#periodo_data').val(),$('#data_real').val(),'+');loadPage('caixa','tipo_data',$('#tipo_data').html(),'data_real',$('#data_real').val());" class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-r ui-btn-icon-right ui-btn-icon-notext">Próximo</a>
							</fieldset>
							<ul data-role="listview" data-split-icon="plus" data-theme="a" data-inset="true">
								<li data-role="list-divider">Caixa <?php echo " <font id=\"tipo_data\">$tipo</font> <font id=\"valor_data\">$valor</font> $dia_semana";?><input id="data_real" value="<?php  echo $data_real;?>" type="hidden"><input id="data_hoje" value="<?php  echo date('d/m/Y');?>" type="hidden"></li>
							    <li>
							        <a href="#detalhes_vendas" onclick="loadScript('listar',false,'listar(\'caixa\',\'vendas\',\'lista_vendas\',\'tipo_data\',\'<?php echo $tipo;?>\',\'data_real\',\'<?php echo $data_real;?>\')');" data-rel="popup" data-position-to="window" data-transition="pop"><fieldset class="ui-grid-a"><div class="ui-block-a"><?php echo $linha->qtd;?> Vendas<br><?php echo $linha->qtd_itens;?> Itens <?php echo $dadosAdd;?></div><div class="ui-block-b"><font size=5><?php echo "R$ ".number_format($linha->valor_pago_total, 2, ',', '.');?></font></div></fieldset></a>
							        <a href="#cadastro_vendas" onclick="$('#id_vendasfc').val('');loadScript('','cadastro_vendas');" data-rel="popup" data-position-to="window" data-transition="pop">Cadastrar Venda</a>
							    </li>
							</ul>					
						</center>
						<div data-role="popup" id="detalhes_vendas" style="width:100%;max-width:900px;">
							<div style="padding:10px 20px;">
								<center>
									<ul id="lista_vendas" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
									</ul>	
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>				
								</center>
							</div>
						</div>
						<div data-role="popup" id="cadastro_vendas">
							<div style="padding:10px 20px;">
								<center>
									<h2><font id=title_cadastro_vendas>Cadastrar</font> Venda</h2>
									<div class="ui-field-contain">
									    <label for="identificacao_vendasfc">Produto:</label> 
									    <div class="ui-grid-solo">
										    <div class="ui-block-a">
										    	<input name="descricao_vendasfc" class="list_secrets" onkeyup="AutoCompleteText($(this),'cadastro_vendas');" type="text" placeholder="Buscar produto..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="idvalor" data-load-click="onLoadProdutos" data-url="remote.php?cmd=busca&tipo=produto&query={val}">
										    </div>
										</div>
									</div>	
									<div class="ui-field-contain">
									    <label for="qtd_vendasfc">Qtd:</label> 
									    <input name="qtd_vendasfc" id="qtd_vendasfc" value="1" min="1" max="100" type="number" onkeyup="sum()">
									</div>
									<div class="ui-field-contain">
									    <label for="valor_desconto_vendasfc">Desconto:</label> 
										<input name="valor_desconto_vendasfc" id="valor_desconto_vendasfc" class="money" onkeyup="sum()">
									</div>	
									<div class="ui-field-contain">
										Valor Total: <b>R$ <font id="valor_total" class="money">0,00</font></b>
									</div>
									<div class="ui-field-contain">
									    <label for="valor_pago_vendasfc">Valor Pago:</label> 
										<input name="valor_pago_vendasfc" id="valor_pago_vendasfc" class="money">
									</div>	
									<input name=" " id="idvalor" type="hidden">
									<input name="id_produto_vendasfc" id="id_produto_vendasfc" type="hidden">
									<input name="valor_vendasfc" id="valor_vendasfc" type="hidden">
									<input name="valor_custo_vendasfc" id="valor_custo_vendasfc" type="hidden"> 
									<input name="valor_total_custos_vendasfc" id="valor_total_custos_vendasfc" type="hidden">
									<input name="valor_total_vendasfc" id="valor_total_vendasfc" type="hidden">				
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="vendas" type="hidden">
									<input name="id_vendasfc" id="id_vendasfc" type="hidden">
									<button onclick="salvaDados(this,'cadastro_vendas');$('#cadastro_vendas').one('popupafterclose').popup('close');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
					</div>
					<?php 
				break;
				case "saidas":
					$diaH=date('d/m/Y');$mesH=date('d/m');$anoH=date('Y');
					$tipo_data = isset($_REQUEST["tipo_data"]) ? $_REQUEST["tipo_data"] : false;
					$data_real = isset($_REQUEST["data_real"]) ? $_REQUEST["data_real"] : date('d/m/Y');
					$mes=date_format(date_create(converterDataSimples($data_real)), 'm/Y');
					$ano=date_format(date_create(converterDataSimples($data_real)), 'Y');
					$semana = array(
						'0' => 'Domingo',
						'1' => 'Segunda-Feira',
						'2' => 'Terca-Feira',
						'3' => 'Quarta-Feira',
						'4' => 'Quinta-Feira',
						'5' => 'Sexta-Feira',
						'6' => 'Sabado'
					);
					//
					if($tipo_data=='dia'){
						$buscaOut="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\")='".converterDataSimples($data_real)."' AND";
						$buscaOutAll="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\") <= '".converterDataSimples($data_real)."' AND";
						$buscaIn="DATE_FORMAT(data_pg_vendasfc,\"%Y-%m-%d\")='".converterDataSimples($data_real)."' AND";
						$tipo='dia';$valor=$data_real;
					}else if($tipo_data=='mes'){
						$buscaOut="DATE_FORMAT(datatime_saidasfc,\"%m/%Y\")='$mes' AND";
						$buscaOutAll="DATE_FORMAT(datatime_saidasfc,\"%m/%Y\") <= '$mes' AND";
						$buscaIn="DATE_FORMAT(data_pg_vendasfc,\"%m/%Y\")='$mes' AND";
						$tipo='mes';$valor=$mes;
					}else if($tipo_data=='ano'){
						$buscaOut="DATE_FORMAT(datatime_saidasfc,\"%Y\")='$ano' AND";
						$buscaOutAll="DATE_FORMAT(datatime_saidasfc,\"%Y\") <= '$ano' AND";
						$buscaIn="DATE_FORMAT(data_pg_vendasfc,\"%Y\")='$ano' AND";
						
						$tipo='ano';$valor=$ano;
					}else{ 
						$buscaOut="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\")=curdate() AND";
						$buscaOutAll="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\") <= curdate() AND";
						$buscaIn="DATE_FORMAT(data_pg_vendasfc,\"%Y-%m-%d\")=curdate() AND";
						$tipo='hoje';$valor=date('d/m/Y');
					}
					$valorIn=mysql_fetch_object(mysql_query("SELECT SUM(valor_pago_vendasfc) as valor_in FROM `fc_vendas` WHERE $buscaIn id_provedor='$id_provedor_usuario'"))->valor_in;
					$valouInAll=mysql_fetch_object(mysql_query("SELECT SUM(valor_pago_vendasfc) as valor_in FROM `fc_vendas` WHERE id_provedor='$id_provedor_usuario'"))->valor_in;
					//
					$resultadoOut=mysql_query("SELECT count(*) AS qtd, tipo_saidasfc, sum(valor_saidasfc) AS valor FROM `fc_saidas` WHERE $buscaOut id_provedor='$id_provedor_usuario' GROUP BY tipo_saidasfc");
					$resultadoOutAll=mysql_query("SELECT count(*) AS qtd, tipo_saidasfc, sum(valor_saidasfc) AS valor FROM `fc_saidas` WHERE id_provedor='$id_provedor_usuario' GROUP BY tipo_saidasfc");
					if($tipo_data=='hoje' || $tipo_data=='dia'){
						$dia_semana=$semana[date('w', strtotime(converterDataSimples($valor)))];
					}
					?>
					<div id="page">
						<input id="myscripts" value="setArgData" type="hidden">
						<center>
							<div data-role="navbar">
								<ul>
									<li><a href="#" onclick="loadPage('caixa');">Caixa</a></li>
									<li><a href="#" onclick="loadPage('saidas');" class="ui-btn-active">Financas</a></li>
								</ul>
							</div><!-- /navbar -->
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
							    <a href="#" onclick="setArgData($('#periodo_data').val(),$('#data_real').val(),'-');loadPage('saidas','tipo_data',$('#tipo_data').html(),'data_real',$('#data_real').val());" class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-l ui-btn-icon-right ui-btn-icon-notext">Anterior</a>
							    <label for="periodo">Select</label>
							    <select id="periodo_data" onchange="setArgData($(this).val(),$('#data_real').val());loadPage('saidas','tipo_data',$(this).val(),'data_real',$('#data_real').val());">
							        <option value="dia" <?php if($tipo=='dia') echo 'selected';?>>Dia</option>
							        <option value="mes" <?php if($tipo=='mes') echo 'selected';?>>Mes</option>
							        <option value="ano" <?php if($tipo=='ano') echo 'selected';?>>Ano</option>
							        <option value="hoje" <?php if($tipo=='hoje') echo 'selected';?>>Hoje</option>
					 		  	</select>
							    <a href="#" onclick="setArgData($('#periodo_data').val(),$('#data_real').val(),'+');loadPage('saidas','tipo_data',$('#tipo_data').html(),'data_real',$('#data_real').val());" class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-r ui-btn-icon-right ui-btn-icon-notext">Próximo</a>
							</fieldset>
							<ul data-role="listview" data-split-icon="plus" data-theme="a" data-inset="true">
								<li data-role="list-divider"><center>Movimentacoes <?php echo " <font id=\"tipo_data\">$tipo</font> <font id=\"valor_data\">$valor</font> $dia_semana";?><input id="data_real" value="<?php  echo $data_real;?>" type="hidden"><input id="data_hoje" value="<?php  echo date('d/m/Y');?>" type="hidden"></center></li>
								<li data-role="list-divider"><h3><font color=blue>Entradas <?php echo "R$ ".number_format($valorIn, 2, ',', '.');?></font></h3></li>
							    <?php
								$valorCustos=0;
								$valorOut=0;
								while($linha_dados=mysql_fetch_object($resultadoOut)){
									$valorOut+=$linha_dados->valor;
									if($linha_dados->tipo_saidasfc!='retirada')
										$valorCustos+=$linha_dados->valor;
								?>
								    <li>
								        <a href="#detalhes_saidas" onclick="loadScript('listar',false,'listar(\'saidas\',\'saidas\',\'lista_saidas\',\'tipo_saidasfc\',\'<?php echo $linha_dados->tipo_saidasfc;?>\',\'tipo_data\',\'<?php echo $tipo;?>\',\'data_real\',\'<?php echo $data_real;?>\')');" data-rel="popup" data-position-to="window" data-transition="pop">
									        <fieldset class="ui-grid-a">
									        	<div class="ui-block-a">
									        		<?php echo $linha_dados->qtd;?> <?php echo $linha_dados->tipo_saidasfc;?>
									        	</div>
									        	<div class="ui-block-b">
									        		<font size=5>
									        			<?php echo "R$ ".number_format($linha_dados->valor, 2, ',', '.');?>
									        		</font>
									        	</div>
									        </fieldset>
								        </a>
								    </li>
								<?php
								}
								$valorSaldo=$valorIn-$valorOut;
								$valorSaldoLiq=$valorIn-$valorCustos;
								?>
								<li data-role="list-divider">
									<font color=blue>Saldo <?php echo "R$ ".number_format($valorSaldo, 2, ',', '.');?></font><br>
									<font color=blue>Saldo Liquido <?php echo "R$ ".number_format($valorSaldoLiq, 2, ',', '.');?></font>
								</li>
								<li data-role="list-divider"><center>Movimentacoes Gerais</center></li>
								<li data-role="list-divider"><h3><font color=blue>Entradas (Geral) <?php echo "R$ ".number_format($valouInAll, 2, ',', '.');?></font></h3></li>
								<?php 
								$valorCustosAll=0;
								$valorOutAll=0;
								while($linha_dados=mysql_fetch_object($resultadoOutAll)){
									$valorOutAll+=$linha_dados->valor;
									if($linha_dados->tipo_saidasfc!='retirada')
										$valorCustosAll+=$linha_dados->valor;
								?>
										<li>
											<a href="#detalhes_saidas" onclick="loadScript('saidas','detalhes_saidas','listar(\'saidas\',\'saidas\',\'lista_saidas\',\'tipo_saidasfc\',\'<?php echo $linha_dados->tipo_saidasfc;?>\')');" data-rel="popup" data-position-to="window" data-transition="pop">
												<fieldset class="ui-grid-a">
													<div class="ui-block-a">
														<?php echo $linha_dados->qtd;?> <?php echo $linha_dados->tipo_saidasfc;?> 
													</div>
													<div class="ui-block-b">
														<font size=5>
															<?php echo "R$ ".number_format($linha_dados->valor, 2, ',', '.');?>
														</font>
													</div>
												</fieldset>
											</a>
										</li>
									<?php
								}
								$valorSaldoGeral=$valouInAll-$valorOutAll;
								$valorSaldoLiqGeral=$valouInAll-$valorCustosAll;
							    ?>
								<li data-role="list-divider">
									<font color=blue>Saldo <?php echo "R$ ".number_format($valorSaldoGeral, 2, ',', '.');?></font><br>
									<font color=blue>Saldo Liquido <?php echo "R$ ".number_format($valorSaldoLiqGeral, 2, ',', '.');?></font>
								</li>
							    <li><a href="#cadastro_saidas" onclick="$('#id_saidasfc').val('');loadScript('saidas','cadastro_saidas');" data-rel="popup" data-position-to="window" data-transition="pop"><center>Cadastrar Saida</center></a></li>
							</ul>					
						</center>
						<div data-role="popup" id="detalhes_saidas">
							<div style="padding:10px 20px;">
								<center>
									<ul id="lista_saidas" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
									</ul>	
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>				
								</center>
							</div>
						</div>
						<div data-role="popup" id="cadastro_saidas">
							<div style="padding:10px 20px;">
								<center>
									<h2><font id=title_cadastro_saidas>Cadastrar</font> Compra/Retirada</h2>
									<div class="ui-field-contain">
										<label for="datatime_saidasfc">Data:</label>
										<input name="datatime_saidasfc" class="datebox" type="text">
									</div>
									<div class="ui-field-contain">
										<label>Tipo:</label> 
										<select name="tipo_saidasfc" data-mini="true" onchange="visibleItens($(this),'cadastro_itens',$(this).val());">
										    <option value="compra" selected>Compra</option>
										    <option value="conta">Conta</option>
											<option value="retirada">Retirada</option>
										</select>
									</div>
									<div class="ui-field-contain">
										<label>Descricao:</label> 
										<input name="descricao_saidasfc"> 
									</div>	
									<div class="ui-field-contain">
									    <label>Valor:</label> 
										<input name="valor_saidasfc" class="money">
									</div>		
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="saidas" type="hidden">	
									<input name="id_saidasfc" id="id_saidasfc" type="hidden">				
									<button onclick="salvaDados(this,'cadastro_saidas');$('#cadastro_saidas').one('popupafterclose').popup('close');"  type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Salvar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
					</div>
					<?php 
				break;
				case "produtos":
					?>
					<div id="page">
						<input id="myscripts" value="listar" type="hidden">
						<input id="myruns" value="listar('produtos','produtos','lista_produtos');" type="hidden">
						<center>
							<div data-role="navbar">
							    <ul>
							        <li><a href="#" onclick="loadPage('produtos');" class="ui-btn-active">Produtos</a></li>
							        <li><a href="#" onclick="loadPage('itens');">Itens</a></li>
							    </ul>
							</div><!-- /navbar -->
							<a href="#cadastro_produtos" onclick="$('#id_produtosfc').val('');$('#title_cadastro_produtos').html('Cadastrar');loadScript('produtos','cadastro_produtos');" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo Produto</a>
							<ul id="lista_produtos" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
							</ul>					
						</center>
						<div data-role="popup" id="cadastro_produtos">
							<div style="padding:10px 20px;">
								<center>
									<h2><font id=title_cadastro_produtos>Cadastrar</font> Produto</h2>
									<div class="ui-field-contain">
									    <label>Tipo:</label> 
										<select name="tipo_produtofc" data-mini="true" onchange="visibleItens('cadastro_produtos',$(this).val());">
										    <option value="produzido">Producao</option>
										    <option value="comprado" selected>Compra</option>
										</select>
									</div>
									<div class="ui-field-contain">
									    <label>Produto:</label> 
										<input name="descricao_produtosfc">
									</div>
									<div id="infor_itens_cadastro_produtos" data-role="collapsible" data-collapsed="false" style="display: none;">
										<legend>Itens de Producao</legend>
										<font color=red>Para cadastrar itens, cadastre o protuto e depois va em alterar e adicione item por item.</font>
									</div>	
									<div id="itens_cadastro_produtos" data-role="collapsible" data-collapsed="false" style="display: none;">
										<legend>Itens de Producao</legend>
										<ul id="lista_itens_produtos" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
										</ul>
										<a href="#" onclick="$('#cadastro_produtos').one('popupafterclose', function(){$('#cadastro_itens_produto').popup('open')}).popup('close');$('#id_produtos_item').val($('#id_produtosfc').val());" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo Item</a>
										<div class="ui-field-contain">
											<label>Valor Custo: <b>R$ <font id="valor_custos_itens_produtos" class="money"></font></b></label>
											
										</div>
									</div>
									<div id="custo_cadastro_produtos" class="ui-field-contain">
									    <label>Valor Compra/Custo:</label> 
										<input name="valor_custo_produtosfc" class="money">
									</div>
									<div class="ui-field-contain">
									    <label>Valor Venda:</label> 
										<input name="valor_produtosfc" class="money">
									</div>		
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="produtos" type="hidden">
									<input name="id_produtosfc" id="id_produtosfc" type="hidden">					
									<button onclick="salvaDados(this,'cadastro_produtos');$('#cadastro_produtos').one('popupafterclose').popup('close');listar('produtos','produtos','lista_produtos');"  type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
						<div data-role="popup" id="cadastro_itens_produto">
							<div style="padding:10px 20px;">
								<center>
									<h2>Cadastrar Itens p/ Produto</h2>
									<div class="ui-field-contain">
									    <label for="nome_item">Item:</label> 
									    <div class="ui-grid-solo">
										    <div class="ui-block-a">
										    	<input name="nome_item" class="list_secrets" onkeyup="AutoCompleteText($(this),'cadastro_itens_produto');" type="text" placeholder="Buscar Itens..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_embalagem_valor_item" data-load-click="onLoadItens" data-url="remote.php?cmd=busca&tipo=itens&query={val}">
										    </div>
										</div>
									</div>
									<div class="ui-field-contain">
									    <label for="qtd_item">Qtd (<font id="embalagem_item"></font>):</label> 
									    <input id="qtd_item" name="qtd_item" value="1" min="1" max="10000" type="number" onkeyup="sumItem();">
									</div>	
									<div class="ui-field-contain">
									    <label for="valor_item">Valor:</label> 
									    <font id="valor_item"></font>
									</div>
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="itens_produto" type="hidden">
									<input name="id_item" id="id_item" type="hidden">
									<input name="id_produtos_item" id="id_produtos_item" type="hidden">
									<input name="valor_inicial_item" id="valor_inicial_item" type="hidden">
									<input name="id_embalagem_valor_item" id="id_embalagem_valor_item" type="hidden">
									<button onclick="salvaDados(this,'cadastro_itens_produto');$('#cadastro_itens_produto').one('popupafterclose', function(){$('#cadastro_produtos').popup('open')}).popup('close');listar('produtos','itens_produtos','lista_itens_produtos','id',$('#id_produtosfc').val());"  type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
					</div>
					<?php 
				break;
				case "itens":
					?>
					<div id="page">
						<input id="myscripts" value="listar" type="hidden">
						<input id="myruns" value="listar('itens','itens','lista_itens');" type="hidden">
						<center>
							<div data-role="navbar">
								<ul>
									<li><a href="#" onclick="loadPage('produtos');">Produtos</a></li>
									<li><a href="#" onclick="loadPage('itens');" class="ui-btn-active">Itens</a></li>
								</ul>
							</div><!-- /navbar -->
							<a href="#cadastro_itens" onclick="$('#id_itensfc').val('');$('#title_cadastro_itens').html('Cadastrar');loadScript('itens','cadastro_itens');" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo Item</a></h2>
							<ul id="lista_itens" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
							</ul>					
						</center>
						<div data-role="popup" id="cadastro_itens">
							<div style="padding:10px 20px;">
								<center>
									<h2><font id=title_cadastro_itens>Cadastrar</font> Itens</h2>
									<div class="ui-field-contain">
									    <label>Tipo:</label> 
										<select name="tipo_itensfc" data-mini="true" onchange="visibleItens('cadastro_itens',$(this).val());">
										    <option value="produzido">Producao</option>
										    <option value="comprado" selected>Compra</option>
										</select>
									</div>
									<div class="ui-field-contain">
									    <label>Produto:</label> 
										<input name="descricao_itensfc"> 
									</div>	
									<div id="infor_itens_cadastro_itens" data-role="collapsible" data-collapsed="false" style="display: none;">
										<legend>Itens de Producao</legend>
										<font color=red>Para cadastrar itens, cadastre o protuto e depois va em alterar e adicione item por item.</font>
									</div>	
									<div id="itens_cadastro_itens" data-role="collapsible" data-collapsed="false" style="display: none;">
										<legend>Itens de Producao</legend>
										<ul id="lista_itens_itens" data-role="listview" data-split-icon="delete" data-theme="a" data-inset="true" style="white-space:normal;">
										</ul>
										<a href="#" onclick="$('#cadastro_itens').one('popupafterclose', function(){$('#cadastro_itens_itens').popup('open')}).popup('close');$('#id_itens_item').val($('#id_itensfc').val());" data-rel="popup" data-position-to="window" data-transition="pop" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus">Novo Item</a>
										<div class="ui-field-contain">
											<label>Valor Custo:</label>
											<font id="valor_custos_itens_itens"></font>
										</div>
									</div>
									<div id="custo_cadastro_itens" class="ui-field-contain">
									    <label>Valor Compra/Custo:</label> 
										<input name="valor_itensfc" class="money">
									</div>
									<div class="ui-field-contain">
									    <label>Qtd Compra/Producao:</label> 
										<input name="qtd_itensfc" value="1" min="1" max="100000" type="number">
									</div>
									<div class="ui-field-contain"> 
									    <label>Tipo/Embalagem:</label> 
										<input name="embalagem_itensfc">
									</div>		
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="itens" type="hidden">	
									<input name="id_itensfc" id="id_itensfc" type="hidden">				
									<button onclick="salvaDados(this,'cadastro_itens');$('#cadastro_itens').one('popupafterclose').popup('close');listar('itens','itens','lista_itens');"  type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
						<div data-role="popup" id="cadastro_itens_itens">
							<div style="padding:10px 20px;">
								<center>
									<h2>Cadastrar Itens p/ Item</h2>
									<div class="ui-field-contain">
									    <label for="nome_item_itens">Item:</label> 
									    <div class="ui-grid-solo">
										    <div class="ui-block-a">
										    	<input name="nome_item_itens" class="list_secrets" onkeyup="AutoCompleteText($(this),'cadastro_itens_itens');" type="text" placeholder="Buscar Itens..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_embalagem_valor_item_itens" data-load-click="onLoadItensItens" data-url="remote.php?cmd=busca&tipo=itens&query={val}">
										    </div>
										</div>
									</div> 
									<div class="ui-field-contain">
									    <label for="qtd_item_itens">Qtd (<font id="embalagem_item_itens"></font>):</label> 
									    <input id="qtd_item_itens" name="qtd_item_itens" value="1" min="1" max="10000" type="number" onkeyup="sumItem();">
									</div>	
									<div class="ui-field-contain">
									    <label for="valor_item_itens">Valor:</label> 
									    <font id="valor_item_itens"></font>
									</div>
									<input name="cmd" value="save" type="hidden">
									<input name="cache" value="false" type="hidden">
									<input name="tipo" value="itens_itens" type="hidden">
									<input name="id_item_itens" id="id_item_itens" type="hidden">
									<input name="id_itens_item" id="id_itens_item" type="hidden">
									<input name="valor_inicial_item_itens" id="valor_inicial_item_itens" type="hidden">
									<input name="id_embalagem_valor_item_itens" id="id_embalagem_valor_item_itens" type="hidden">
									<button onclick="salvaDados(this,'cadastro_itens_itens');$('#cadastro_itens_itens').one('popupafterclose', function(){$('#cadastro_itens').popup('open')}).popup('close');"  type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
									<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>					
								</center>
							</div>
						</div>
					</div>
					<?php 
				break;
			}
		//
		break;
		case "scripts": //ATUALIZA DADOS NA PAGINA
			//include_once( $LOCAL_HOME."classes/class.JavaScriptPacker.php");
			function formatStringArray($array){
				for($i=0;$i<count($array);$i++){
					$array[$i] = "'{$array[$i]}'";
				}
				return $array;
			}
			function depScripts($nome,$not){
				if($nome!=''){
					$nome=explode(",",$nome);
					$nome=implode(',', formatStringArray($nome));
					//
					if($not!=''){
						$notn=explode(",",$not);
						$notn=implode(',', formatStringArray($notn));
						$buscanot="AND nome_scriptsfc not IN ($notn)";
					}						
					$select="SELECT * FROM fc_scripts WHERE nome_scriptsfc IN ($nome) $buscanot";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult != 0){
						$dados='';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							$dados.='|,|'.$linha_dados->html_scriptsfc.'>|'.$linha_dados->nome_scriptsfc.depScripts($linha_dados->dependencia_scriptsfc,$not);
						}
						return $dados;
					}
				}
			}
			$nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
			if($nome){
				$nomen=explode(",",$nome);
				$nomen=implode(',', formatStringArray($nomen));
				$select="SELECT * FROM fc_scripts WHERE nome_scriptsfc IN ($nomen)";
				//echo $select;
				$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 445"}');
				$qtdResult=mysql_num_rows($resultadoDados);
				if ($qtdResult != 0){
					$dados='';
					while($linha_dados=mysql_fetch_object($resultadoDados)){
						$dados.=$linha_dados->html_scriptsfc.'>|'.$linha_dados->nome_scriptsfc.depScripts($linha_dados->dependencia_scriptsfc,$nome).'|,|';
					}
					$dados=substr($dados,0,-3);
				}
				echo $dados;				
			}else{
				$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : false;
				$link = isset($_REQUEST["link"]) ? $_REQUEST["link"] : false;
				$run='';
				switch($page) {
					case "caixa":
						switch($link) {
							case "page":
								$scripts='setArgData,getDezena';
							break;
							case "detalhes_vendas":
								$scripts='listar';
							break;
							case "cadastro_vendas":
								$scripts='salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadProdutos,sum,intFormat,decimalFormat';
							break;
							case "removeDB":
								$scripts='removeDB';
							break;
							case "alteraDB":
								$scripts='alteraDB,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadProdutos,sum,intFormat,decimalFormat';
							break;
						}
					break;
					case "saidas":
						switch($link) {
							case "page":
								$scripts='setArgData,getDezena';
							break;
							case "detalhes_saidas":
								$scripts='listar';
							break;
							case "cadastro_saidas":
								$scripts='salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadProdutos,sum,intFormat,decimalFormat,datepicker';
							break;
							case "removeDB":
								$scripts='removeDB';
							break;
							case "alteraDB":
								$scripts='alteraDB,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadProdutos,sum,intFormat,decimalFormat';
							break;
						}
					break; 
					case "produtos":
						switch($link) {
							case "page":
								$scripts='listar';$run="listar('produtos','produtos','lista_produtos');";
							break;
							case "cadastro_produtos":
								$scripts='listar,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadItens,intFormat,decimalFormat';
							break;
							case "removeDB":
								$scripts='removeDB';
							break;
							case "alteraDB":
								$scripts='alteraDB,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadItens,intFormat,decimalFormat';
							break;
						}
					break;
					case "itens":
						switch($link) {
							case "page":
								$scripts='listar';$run="listar('itens','itens','lista_itens');";
							break;
							case "cadastro_itens":
								$scripts='listar,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadItens,sumItem,intFormat,decimalFormat';
							break;
							case "removeDB":
								$scripts='removeDB';
							break;
							case "alteraDB":
								$scripts='alteraDB,salvarDados,clear_form_elements,visibleItens,autoCompleteText,ocac,getPassword,onLoadItens,onLoadItensItens,sumItem,sumItemItem,intFormat,decimalFormat';
							break;
						}
					break;
				}
				$nomen=explode(",",$scripts);
				$nomen=implode(',', formatStringArray($nomen));
				$select="SELECT * FROM fc_scripts WHERE nome_scriptsfc IN ($nomen)";
				//echo $select;
				$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 445"}');
				$qtdResult=mysql_num_rows($resultadoDados);
				if ($qtdResult != 0){
					$dados='';
					while($linha_dados=mysql_fetch_object($resultadoDados)){
						$dados.=$linha_dados->html_scriptsfc;
					}
				}
				echo $dados.$run;
			}
		break;
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "vendas": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_vendas WHERE id_vendasfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 637"}');
						//
						$qtdLinhas=mysql_num_rows($resultadoDados);
						if ($qtdLinhas == 0){
							echo '{"auth":"'.$authSession.'","data":""}';
						}else{
							$colunas=mysql_fetch_assoc($resultadoDados);
							foreach ($colunas as $id=>$value){
								$value=toVarUtf8($value);
								$linha=true;
								if (strpos($id, "data_") !== false) {
									$value=mostrarDataSimples($value);
								}
								if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
									$linha=false;
								}
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE id_clientesfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 637"}');
						//
						$qtdLinhas=mysql_num_rows($resultadoDados);
						if ($qtdLinhas == 0){
							echo '{"auth":"'.$authSession.'","data":""}';
						}else{
							$colunas=mysql_fetch_assoc($resultadoDados);
							foreach ($colunas as $id=>$value){
								$value=toVarUtf8($value);
								$linha=true;
								if (strpos($id, "data_") !== false) {
									$value=mostrarDataSimples($value);
								}
								if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
									$linha=false;
								}
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "itens": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE id_itensfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 637"}');
						//
						$qtdLinhas=mysql_num_rows($resultadoDados);
						if ($qtdLinhas == 0){
							echo '{"auth":"'.$authSession.'","data":""}';
						}else{
							$colunas=mysql_fetch_assoc($resultadoDados);
							foreach ($colunas as $id=>$value){
								$value=toVarUtf8($value);
								$linha=true;
								if (strpos($id, "data_") !== false) {
									$value=mostrarDataSimples($value);
								}
								if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
									$linha=false;
								}
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "saidas": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_saidas WHERE id_saidasfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 637"}');
						//
						$qtdLinhas=mysql_num_rows($resultadoDados);
						if ($qtdLinhas == 0){
							echo '{"auth":"'.$authSession.'","data":""}';
						}else{
							$colunas=mysql_fetch_assoc($resultadoDados);
							foreach ($colunas as $id=>$value){
								$value=toVarUtf8($value);
								$linha=true;
								if (strpos($id, "data_") !== false) {
									$value=mostrarDataSimples($value);
								}
								if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
									$linha=false;
								}
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
			}			
		break;
		case "busca": //ATUALIZA DADOS NA PAGINA
			$retorno = isset($_REQUEST["retorno"]) ? $_REQUEST["retorno"] : false;
			switch($tipo) {
				case "cliente": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca="(nome_clientesfc like '%".$query."%' OR cpf_cnpj_clientesfc like '".$query."') AND";
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_clientesfc.'"
								,"name":"'.strtr($linha_dados->nome_clientesfc, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC").'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "end":
					$cep = isset($_REQUEST["cep"]) ? $_REQUEST["cep"] : false;
					$formato = isset($_REQUEST["formato"]) ? $_REQUEST["formato"] : false;
					$contents = file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?formato='.$formato.'&cep='.$cep);
					echo $contents;
				break;
				case "cep":
					$end = isset($_REQUEST["end"]) ? $_REQUEST["end"] : false;
					$contents = file_get_contents('https://viacep.com.br/ws/'.$end.'/json/');
					echo $contents;
				break;
				case "select_torre": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_torre WHERE id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="0">All Torres</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione a torre</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_torrefc.'|'.$linha_dados->latitude_torrefc.'|'.$linha_dados->longitude_torrefc.'|'.$linha_dados->nome_torrefc.'">'.$linha_dados->nome_torrefc.'</option>';
						}
					}
				break;
				case "select_mk": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM mk_mikrotiks WHERE codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Nenhum Mikrotik</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o mikrotik</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_mikrotiks.'">'.$linha_dados->identy_mikrotiks." - ".$linha_dados->name_rb_mikrotiks."</option>";
						}
					}
				break;
				case "select_produto": //ATUALIZA DADOS NA PAGINA
					$int = isset($_REQUEST["int"]) ? $_REQUEST["int"] : false;
					$mensal = isset($_REQUEST["mensal"]) ? $_REQUEST["mensal"] : false;
					$busca='';
					if($mensal)
						$busca.=" mensal_produtosfc='on' AND ";
					//
					if($int)
						$busca.=" internet_produtosfc='on' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Nenhum Produt</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o Produto</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_produtosfc.'|'.$linha_dados->valor_produtosfc.'|'.$linha_dados->id_profilepp_produtosfc.'|'.$linha_dados->id_profilehp_produtosfc.'|'.$linha_dados->id_profilebi_produtosfc.'|'.$linha_dados->descricao_produtosfc.'">'.$linha_dados->descricao_produtosfc.' - R$ '.number_format($linha_dados->valor_produtosfc, 2, ',', '').'</option>';
						}
					}
				break;
				case "pagamentos": //ATUALIZA DADOS NA PAGINA
					$id_caixafc = isset($_REQUEST["id_caixafc"]) ? $_REQUEST["id_caixafc"] : false;
					$data_caixafc = isset($_REQUEST["data_caixafc"]) ? $_REQUEST["data_caixafc"] : false;
					$busca='';
					if($id_caixafc)
						$busca.=" id_caixafc='$id_caixafc' AND ";
					//
					if($data_caixafc)
						$busca.=" data_caixafc='".converterDataSimples($data_caixafc)."' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_caixa WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_caixafc.'"
								,"name":"Pagamento em:'.mostrarDataSimples($linha_dados->data_pagamento_caixafc).' de R$ '.number_format($linha_dados->valor_caixafc, 2, ',', '').'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "secretlisboa": //ATUALIZA DADOS NA PAGINA
					$busca="((`name_secretpp` NOT REGEXP '-' AND `mk_secretpp` LIKE 'LISBOA-VN1') OR `name_secretpp` like '%lisboa-%') AND `name_secretpp` like '%".$query."%' AND ";
					//
					$select="SELECT id_secretpp AS id, CONCAT(name_secretpp,' - ',mk_secretpp) AS name FROM mk_secretpp WHERE $busca id_provedor='$id_provedor_usuario'";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id.'"
								,"name":"'.$linha_dados->name.'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
					break;
				case "secret": //ATUALIZA DADOS NA PAGINA
					$auth = isset($_REQUEST["auth"]) ? $_REQUEST["auth"] : false;
					$mk = isset($_REQUEST["mk"]) ? $_REQUEST["mk"] : false;
					switch($auth) {
						case "pppoe":
							if($mk)
								$busca=" (mk_secretpp='$mk' OR mk_secretpp='') AND ";
								//
								if($query!='*all')
									$busca.=" name_secretpp like '%".$query."%' AND ";
									//
									$resultadoDados = mysql_query("SELECT id_secretpp AS id, CONCAT(name_secretpp,' - ',mk_secretpp) AS name FROM mk_secretpp WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
									break;
						case "binding":
							if($mk)
								$busca=" (mk_secretbi='$mk' OR mk_secretbi='') AND ";
								//
								if($query!='*all')
									$busca.=" name_secretbi like '%".$query."%' AND ";
									//
									$resultadoDados = mysql_query("SELECT id_secretbi AS id, CONCAT(name_secretbi,' - Mk:',mk_secretbi) AS name FROM mk_secretbi WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
									break;
					}
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id.'"
								,"name":"'.$linha_dados->name.'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "produto": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca.=" descricao_produtosfc like '%".$query."%' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_produtosfc.'|'.$linha_dados->valor_produtosfc.'|'.$linha_dados->valor_custo_produtosfc.'"
								,"name":"'.$linha_dados->descricao_produtosfc.': R$ '.number_format($linha_dados->valor_produtosfc, 2, ',', '').'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "itens": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca.=" descricao_itensfc like '%".$query."%' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_itensfc.'|'.$linha_dados->embalagem_itensfc.'|'.$linha_dados->valor_unitario_itensfc.'"
								,"name":"'.$linha_dados->descricao_itensfc.': R$ '.number_format($linha_dados->valor_unitario_itensfc, 5, ',', '').' p/ '.$linha_dados->embalagem_itensfc.'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
			}
		break;
		case "list": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "vendas": //ATUALIZA DADOS NA PAGINA
					$id_vendasfc = isset($_REQUEST["id_vendasfc"]) ? $_REQUEST["id_vendasfc"] : false;
					$busca='';
					if($id_vendasfc)
						$busca=" id_vendasfc='$id_vendasfc' AND ";
					else{
						$tipo_data = isset($_REQUEST["tipo_data"]) ? $_REQUEST["tipo_data"] : false;
						$data_real = isset($_REQUEST["data_real"]) ? $_REQUEST["data_real"] : date('d/m/Y');
						$mes=date_format(date_create(converterDataSimples($data_real)), 'm/Y');
						$ano=date_format(date_create(converterDataSimples($data_real)), 'Y');
						if($tipo_data=='dia'){
							$busca="DATE_FORMAT(datatime_vendasfc,\"%Y-%m-%d\")='".converterDataSimples($data_real)."' AND";
							$tipo='dia';$valor=$data_real;
						}else if($tipo_data=='mes'){
							$busca="DATE_FORMAT(datatime_vendasfc,\"%m/%Y\")='$mes' AND";
							$tipo='mes';$valor=$mes;
						}else if($tipo_data=='ano'){
							$busca="DATE_FORMAT(datatime_vendasfc,\"%Y\")='$ano' AND";
							$tipo='ano';$valor=$ano;
						}else{
							$busca="DATE_FORMAT(datatime_vendasfc,\"%Y-%m-%d\")=curdate() AND";
							$tipo='hoje';$valor=date('d/m/Y');
						}
					}
					$resultadoDados = mysql_query("SELECT * FROM fc_vendas WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Vendas '.$tipo.' '.$valor.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_vendasfc.'"
								,"name":"<font style=\"white-space:normal; font-size: small\"> qtd:'.$linha_dados->qtd_vendasfc.' - '.mostrarData($linha_dados->datatime_vendasfc,false).'<br>'.$linha_dados->descricao_vendasfc.' - Total: R$ '.number_format($linha_dados->valor_total_vendasfc, 2, ',', '').' Desconto: R$ '.number_format($linha_dados->valor_desconto_vendasfc, 2, ',', '').' - Valor Pg: R$ '.number_format($linha_dados->valor_pago_vendasfc, 2, ',', '').'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "saidas": //ATUALIZA DADOS NA PAGINA
					$id_saidasfc = isset($_REQUEST["id_saidasfc"]) ? $_REQUEST["id_saidasfc"] : false;
					$busca='';
					if($id_saidasfc)
						$busca=" id_saidasfc='$id_saidasfc' AND ";
					else{
						$tipo_saidasfc = isset($_REQUEST["tipo_saidasfc"]) ? $_REQUEST["tipo_saidasfc"] : false;
						if($tipo_saidasfc)
							$busca="tipo_saidasfc='$tipo_saidasfc' AND ";
						//
						$tipo_data = isset($_REQUEST["tipo_data"]) ? $_REQUEST["tipo_data"] : false;
						$data_real = isset($_REQUEST["data_real"]) ? $_REQUEST["data_real"] : date('d/m/Y');
						$mes=date_format(date_create(converterDataSimples($data_real)), 'm/Y');
						$ano=date_format(date_create(converterDataSimples($data_real)), 'Y');
						if($tipo_data){
							if($tipo_data=='dia'){
								$busca.="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\")='".converterDataSimples($data_real)."' AND";
								$tipo='dia';$valor=$data_real;
							}else if($tipo_data=='mes'){
								$busca.="DATE_FORMAT(datatime_saidasfc,\"%m/%Y\")='$mes' AND";
								$tipo='mes';$valor=$mes;
							}else if($tipo_data=='ano'){
								$busca.="DATE_FORMAT(datatime_saidasfc,\"%Y\")='$ano' AND";
								$tipo='ano';$valor=$ano;
							}else{
								$busca.="DATE_FORMAT(datatime_saidasfc,\"%Y-%m-%d\")=curdate() AND";
								$tipo='hoje';$valor=date('d/m/Y');
							}
						}else{
							$tipo='All';
						}
					}
					$resultadoDados = mysql_query("SELECT * FROM fc_saidas WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Saidas",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_saidasfc.'"
								,"name":"<font style=\"white-space:normal; font-size: small\">Saida id:'.$linha_dados->id_saidasfc.' - Tipo: '.$linha_dados->tipo_saidasfc.'<br>Data:'.mostrarData($linha_dados->datatime_saidasfc,false).'<br>'.$linha_dados->descricao_saidasfc.' - R$ '.number_format($linha_dados->valor_saidasfc, 2, ',', '').'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
					$sit_clientesfc = isset($_REQUEST["sit_clientesfc"]) ? $_REQUEST["sit_clientesfc"] : false;
					$busca='';
					if($id_clientesfc)
						$busca=" id_clientesfc='$id_clientesfc' AND ";
					else{
						if($sit_clientesfc)
							$busca=" sit_clientesfc='$sit_clientesfc' AND "; 
						//
					}
					$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Clientes",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_clientesfc.'"
								,"name":"<font style=\"white-space:normal; font-size: small\">Produto id:'.$linha_dados->id_clientesfc.'<br>'.$linha_dados->nome_clientesfc.' - Custo: R$ '.number_format($linha_dados->valor_custo_produtosfc, 2, ',', '').' - Valor de venda: R$ '.number_format($linha_dados->valor_produtosfc, 2, ',', '').'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}'; 
					}
				break;
				case "itens_produtos": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$busca='';
					if($id)
						$busca=" id_produtosfc='$id' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario' AND itens_produtosfc!=''") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 1000"}');
					$qtdResult=mysql_num_rows($resultadoDados); 
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Itens","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Itens","suggestion":{}}';
						//
						//
					}else{
						$dados='';
						$linha_dados=mysql_fetch_object($resultadoDados);
						$itensArray=explode(",",$linha_dados->itens_produtosfc);
						$valor_total=0;
						for($i=0;$i<count($itensArray);$i++){
							//array_walk($linha_dados, 'toUtf8');
							$itemArray=explode("|",$itensArray[$i]);
							$nome=$itemArray[0];
							$id=$itemArray[1];
							$qtd=$itemArray[2];
							$valorItem=mysql_fetch_object(mysql_query("SELECT valor_unitario_itensfc FROM fc_produtos_itens WHERE id_itensfc='".$id."' AND id_provedor='$id_provedor_usuario'"))->valor_unitario_itensfc;
							$embalagem=mysql_fetch_object(mysql_query("SELECT embalagem_itensfc FROM fc_produtos_itens WHERE id_itensfc='".$id."' AND id_provedor='$id_provedor_usuario'"))->embalagem_itensfc;
							$valor=$valorItem*$qtd;
							$valor_total+=$valor;
							$dados.='{
								"id":"'.$linha_dados->id_produtosfc.'"
		  	      				,"valor":"'.$nome.'|'.$id.'|'.$qtd.'"
								,"name":"<font style=\"white-space:normal; font-size: small\">'.$nome.', '.$qtd.' '.$embalagem.' <br>  R$ '.number_format($valor, 5, ',', '').'</font>"
							},';
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.count($itensArray).'","valor_total":"'.number_format($valor_total, 2, ',', '').'","query":"'.$query.'","title":"Itens",';
						echo '"suggestion":[';						
						echo substr($dados,0,-1);
						echo ']}';
					}
				break;
				case "itens": //ATUALIZA DADOS NA PAGINA
					$id_itensfc = isset($_REQUEST["id_itensfc"]) ? $_REQUEST["id_itensfc"] : false;
					$busca='';
					if($id_itensfc)
						$busca=" id_itensfc='$id_itensfc' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 1000"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Itens",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_itensfc.'"
								,"name":"<font style=\"white-space:normal; font-size: small\">Item id:'.$linha_dados->id_itensfc.' - '.$linha_dados->tipo_itensfc.'<br>'.$linha_dados->descricao_itensfc.' <br> Valor p/ '.$linha_dados->embalagem_itensfc.': R$ '.number_format($linha_dados->valor_unitario_itensfc, 5, ',', '').'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "itens_itens": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$busca='';
					if($id)
						$busca=" id_itensfc='$id' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE $busca id_provedor='$id_provedor_usuario' AND itens_itensfc!=''") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 1000"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Itens","suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Itens","suggestion":{}}';
						//
						//
					}else{
						$dados='';
						$linha_dados=mysql_fetch_object($resultadoDados);
						$itensArray=explode(",",$linha_dados->itens_itensfc);
						$valor_total=0;
						for($i=0;$i<count($itensArray);$i++){
							//array_walk($linha_dados, 'toUtf8');
							$itemArray=explode("|",$itensArray[$i]);
							$nome=$itemArray[0];
							$id=$itemArray[1];
							$qtd=$itemArray[2];
							$valorItem=mysql_fetch_object(mysql_query("SELECT valor_unitario_itensfc FROM fc_produtos_itens WHERE id_itensfc='".$id."' AND id_provedor='$id_provedor_usuario'"))->valor_unitario_itensfc;
							$embalagem=mysql_fetch_object(mysql_query("SELECT embalagem_itensfc FROM fc_produtos_itens WHERE id_itensfc='".$id."' AND id_provedor='$id_provedor_usuario'"))->embalagem_itensfc;
							$valor=$valorItem*$qtd;
							$valor_total+=$valor;
							$dados.='{
								"id":"'.$linha_dados->id_itensfc.'"
		  	      				,"valor":"'.$nome.'|'.$id.'|'.$qtd.'"
								,"name":"<font style=\"white-space:normal; font-size: small\">'.$nome.', '.$qtd.' '.$embalagem.' <br>  R$ '.number_format($valor, 5, ',', '').'</font>"
							},';
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.count($itensArray).'","valor_total":"'.number_format($valor_total, 2, ',', '').'","query":"'.$query.'","title":"Itens",';
						echo '"suggestion":[';
						echo substr($dados,0,-1);
						echo ']}';
					}
				break;
			}
		break;
		case "remove": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "vendas":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_vendas WHERE id_vendasfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Venda Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Venda Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id da Venda invalido!"}';
					}	
				break;
				case "saidas":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_saidas WHERE id_saidasfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Saida Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Saida Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id da Saida invalido!"}';
					}
				break;
				case "produtos":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_produtos WHERE id_produtosfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Produto Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Produto Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
				case "itens_produtos":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$valor = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
					if ($id){
						$new_itens='';
						$itensArray=explode(",",mysql_fetch_object(mysql_query("SELECT itens_produtosfc FROM fc_produtos WHERE id_produtosfc='$id' AND id_provedor='$id_provedor_usuario' AND itens_produtosfc!=''"))->itens_produtosfc);
						for($i=0;$i<count($itensArray);$i++){
							if($itensArray[$i]!=$valor)
								$new_itens.=$itensArray[$i].',';
							//
						}
						$new_itens=substr($new_itens,0,-1);
						//echo $new_itens;
						//REMOVE
						$sql = "UPDATE fc_produtos SET itens_produtosfc='$new_itens' WHERE id_produtosfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Itens do produto Com id:'.$id.' Alterado com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Alterar Itens do Produto Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
				case "itens_itens":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$valor = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
					if ($id){
						$new_itens='';
						$itensArray=explode(",",mysql_fetch_object(mysql_query("SELECT itens_itensfc FROM fc_produtos_itens WHERE id_itensfc='$id' AND id_provedor='$id_provedor_usuario' AND itens_produtosfc!=''"))->itens_itensfc);
						for($i=0;$i<count($itensArray);$i++){
							if($itensArray[$i]!=$valor)
								$new_itens.=$itensArray[$i].',';
							//
						}
						$new_itens=substr($new_itens,0,-1);
						//echo $new_itens;
						//REMOVE
						$sql = "UPDATE fc_produtos_itens SET itens_itensfc='$new_itens' WHERE id_itensfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Itens do Item Com id:'.$id.' Alterado com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Alterar Itens do Item Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
			}		
		break;
		case "save": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "caixa":   //TIPO -> caixa
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_caixa";
						protected $__id = "id_caixafc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_caixafc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_caixafc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										if($var[$id] != '')
											$var[$id]=converterDataSimples($var[$id]);
										//
										if ($id=="data_pagamento_caixafc" && $var[$id] == '')
											$var[$id]=date('Y-m-d');
										//
									}else
										$var[$id] = str_replace($chars, "", $var[$id]);
									//
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado";
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}else if (strpos($id, "data_") !== false) {
								if($var[$id] != '')
									$var[$id]=converterDataSimples($var[$id]);
								//
								if ($id=="data_pagamento_caixafc" && $var[$id] == '')
									$var[$id]=date('Y-m-d');
								//
							}else
								$var[$id] = str_replace($chars, "", $var[$id]);
							//
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_caixafc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_caixafc'];
					}
					echo '{"msg":"'.$msg.'","id_caixafc":"'.$var['id_caixafc'].'"}';
				break;
				case "provedor":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_provedor";
						protected $__id = "id_provedorfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedorfc']=$id_provedor_usuario;
					//
					if($var['id_provedorfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_provedorfc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado id:".$var['id_provedorfc'];
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							$var[$id] = str_replace($chars, "", $var[$id]);
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_provedorfc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_provedorfc'];
					}
					echo '{"msg":"'.$msg.'","id_provedorfc":"'.$var['id_provedorfc'].'"}';
				break;
				case "banco":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_gatewaypg";
						protected $__id = "id_gatewaypgfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_gatewaypgfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_gatewaypgfc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado id:".$var['id_gatewaypgfc'];
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							$var[$id] = str_replace($chars, "", $var[$id]);
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_gatewaypgfc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_gatewaypgfc'];
					}
					echo '{"msg":"'.$msg.'","id_gatewaypgfc":"'.$var['id_gatewaypgfc'].'"}';
				break;
				case "cliente":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item01 extends simpleCRUD{
						protected $__table = "fc_clientes";
						protected $__id = "id_clientesfc";
					}
					//
					class Facil_item02 extends simpleCRUD{
						protected $__table = "fc_pontos";
						protected $__id = "id_pontosfc";
					}
					//
					class Facil_item03 extends simpleCRUD{
						protected $__table = "fc_sevmensal";
						protected $__id = "id_mensalfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_clientesfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$facil_item = Facil_item01::find_by_id($var['id_clientesfc']);
						if ($facil_item !== false){
							foreach ($facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id] = str_replace($chars, "", $var[$id]);
									}
									$facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$facil_item->update();
							//
							$msg="atualizado cliente:".$var['id_clientesfc']."<Br>";
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item01::find_by_field();
						$new_itens = new Facil_item01();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
								$var[$id] = str_replace($chars, "", $var[$id]);
							}
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_clientesfc'] = $new_itens->id;
						//
						$msg='Cadastrado cliente:'.$var['id_clientesfc']."<Br>";
					}
					for ($i=0;$i<count($var['id_pontosfc']);$i++){
							if($var['id_pontosfc'][$i]!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
								//ATUALIZA DADOS COM O ID VINDO DA PAGINA
								//INSERE NOVOS DADOS NAS TABELAS
								$facil_item = Facil_item02::find_by_id($var['id_pontosfc'][$i]);
								if ($facil_item !== false){
									foreach ($facil_item->toArray() as $id=>$value){
										if(isset($var[$id][$i]) && $var[$id][$i]!=$value){
											if (strpos($id, "data_") !== false) {
												$var[$id][$i]=converterDataSimples($var[$id][$i]);
											}
											if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
												$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
											}
											if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
												$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											}
											$facil_item->$id = utf8_decode($var[$id][$i]);
										}
									}
									$facil_item->update();
									//
									$msg.="atualizado Ponto:".$var['id_pontosfc'][$i]."<Br>";
								}else{
									$inserir=true;
								}
							}else{
								$inserir=true;
							}
							if($inserir){// INSERE PONTOS
								if($var['id_cliente_pontosfc'][$i]=='')
									$var['id_cliente_pontosfc'][$i]=$var['id_clientesfc'];
								//
								//INSERE NOVOS DADOS NAS TABELAS
								$field_itens = Facil_item02::find_by_field();
								$new_itens = new Facil_item02();
								foreach ($field_itens as $id){
									if (strpos($id, "datatime_") !== false) {
										if($var[$id][$i]==""){
											$var[$id][$i]=date('Y-m-d H:i:s');
										}
									}
									if (strpos($id, "data_") !== false) {
										$var[$id][$i]=converterDataSimples($var[$id][$i]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
									}
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									}
									$new_itens->$id=utf8_decode($var[$id][$i]);
									//echo $var[$id]."\n";
								}
								$new_itens->insert();
								$var['id_pontosfc'] = $new_itens->id;
								//
								$msg.='Cadastrado Ponto:'.$var['id_pontosfc']."<Br>";
							}	
							if($var['id_mensalfc'][$i]!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
								//ATUALIZA DADOS COM O ID VINDO DA PAGINA
								//INSERE NOVOS DADOS NAS TABELAS
								$facil_item = Facil_item03::find_by_id($var['id_mensalfc'][$i]);
								if ($facil_item !== false){
									foreach ($facil_item->toArray() as $id=>$value){
										if(isset($var[$id][$i]) && $var[$id][$i]!=$value){
											if (strpos($id, "data_") !== false) {
												$var[$id][$i]=converterDataSimples($var[$id][$i]);
											}
											if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
												$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
											}
											if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
												$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											}
											$facil_item->$id = utf8_decode($var[$id][$i]);
										}
									}
									$facil_item->update();
									//
									$msg.="atualizado Serviço Mensal:".$var['id_mensalfc'][$i]."<Br>";
								}else{
									$inserir=true;
								}
							}else{
								$inserir=true;
							}
							if($inserir){// INSERE SERVICO MENSAL
								if($var['id_cliente_mensalfc'][$i]=='')
									$var['id_cliente_mensalfc'][$i]=$var['id_clientesfc'];
								//
								//INSERE NOVOS DADOS NAS TABELAS
								$field_itens = Facil_item03::find_by_field();
								$new_itens = new Facil_item03();
								foreach ($field_itens as $id){
									if (strpos($id, "datatime_") !== false) {
										if($var[$id][$i]==""){
											$var[$id][$i]=date('Y-m-d H:i:s');
										}
									}
									if (strpos($id, "data_") !== false) {
										$var[$id][$i]=converterDataSimples($var[$id][$i]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
									}
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									}
									$new_itens->$id=utf8_decode($var[$id][$i]);
									//echo $var[$id]."\n";
								}
								$new_itens->insert();
								$var['id_mensalfc'] = $new_itens->id;
								//
								$msg.='Cadastrado Serviço Mensal:'.$var['id_mensalfc']."<Br>";
							}
							switch($var['tipo_auth_pontosfc'][$i]) {
								case "pppoe":
									$profile=mysql_result(mysql_query("SELECT name_profilepp FROM mk_profilepp WHERE id_profilepp='".$var['id_profile'][$i]."'"),0,"name_profilepp");
									$resultado = mysql_query("UPDATE mk_secretpp SET profile_secretpp='$profile',profile_save_secretpp='$profile',id_cliente_secretpp='".$var['id_clientesfc']."',tipo_secretpp='atz',comment_secretpp='".$var['nome_clientesfc']."' WHERE id_secretpp='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User pppoe atualizado:'.$var['id_secretpp'][$i]."<Br>";
								break;
								case "hotspot":
									$profile=mysql_result(mysql_query("SELECT name_profilehp FROM mk_profilehp WHERE id_profilehp='".$var['id_profile'][$i]."'"),0,"name_profilehp");
									$resultado = mysql_query("UPDATE mk_secrethp SET profile_secrethp='$profile',profile_save_secrethp='$profile',id_cliente_secrethp='".$var['id_clientesfc']."',tipo_secrethp='atz',comment_secrethp='".$var['nome_clientesfc']."' WHERE id_secrethp='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User hotspot atualizado:'.$var['id_secrethp'][$i]."<Br>";
								break;
								case "binding":
									$profile=mysql_result(mysql_query("SELECT name_profilebi FROM mk_profilebi WHERE id_profilebi='".$var['id_profile'][$i]."'"),0,"name_profilebi");
									$resultado = mysql_query("UPDATE mk_secretbi SET profile_secretbi='$profile',profile_save_secretbi='$profile',id_cliente_secretbi='".$var['id_clientesfc']."',tipo_secretbi='atz',comment_secretbi='".$var['nome_clientesfc']."' WHERE id_secretbi='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User ipbinding atualizado:'.$var['id_secretbi'][$i]."<Br>";
								break;
							}
					}			
					echo '{"msg":"'.$msg.'","id_clientesfc":"'.$var['id_clientesfc'].'"}';
				break;
			}
		break;
	}
}else{
	echo '{"JSON":true,"auth":false,"msg":"Não Autenticado"}';
}			
?>