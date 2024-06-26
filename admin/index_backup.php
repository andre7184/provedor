<?php 
	$page=isset($_REQUEST["page"]) ? $_REQUEST["page"] : false;
	if(!$page)$page="home";
	//
	switch($page) {case "home":$title='Pagina Inicial';break;case "contas":$title='Contas/Clientes';break;case "vendas":$title='Serviços/Vendas';break;case "caixa":$title='Financeiro/Caixa';break;case "logmk":$title='Logs Acessos/MK';break;}
	//
	require_once("validar.php");
	//
	$error = $error ? $error : false; 
?>
<!DOCTYPE html> 
<html>
	<head>
<?php 
	    if($refresh) 
	    	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?page=$page\">";
?>
		<meta charset="ISO-8859-1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Mk Facil => <?php echo $title;?></title>
		<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
		<script src="_js/jquery/jquery-1.11.3.min.js"></script>
		<script src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
		<script src="_js/jquery/jquery-ui.min.js"></script>
		<script src="_js/funcoes.js"></script>
		<script src="_js/all.js"></script>
		<script src="_js/mask.js"></script>
		<script src="_js/mask_real.js"></script>
		<script src="_js/auto_complete.js"></script>
		<script src="_js/mapa.js"></script>
		<style type="text/css">
			.disabled {
			  pointer-events: none;
			
			  /* for "disabled" effect */
			  opacity: 0.5;
			  background: #CCC;
			}
			.controlgroup-textinput {
			    padding-top:.22em;
			    padding-bottom:.22em;
			}
		</style>
    </head>
    <body>
    <div data-role="page" style="background-color:#ADD8E6">
<?php 
	if(!$authSession){
?>
		<div data-role="header" style="overflow:hidden;" data-position="fixed">				
			<div data-role="navbar"><center><h2><font color=red><?php echo $error;?></font></h2></center></div>
		</div>
		<div role="main" class="ui-content">
<?php 
			echo $form_login;
?>
		</div>
	</div><!-- /page --> 
<?php 
	}else{
?>
	<script type="text/javascript">
				var page='<?php echo $page;?>';
				var link=false;
				$(document).ready( function() {
					$('a').on('click', function() {
				           link = $(this).attr('href').split("#")[1];
					});
				});
				$(document).bind("pagecreate", '[data-role="page"]', function(){
					if(!link)
						link = window.location.hash.split("#")[1];
					//
					if(!link)
						link='';
					//
					var obj=$(this);
					getLoading('Carregando Página...');
					$.ajax({url: 'remote.php',data:'cmd=dados_html&page='+page+'&link='+link}).then( function ( r ) {
						var dados=r.split("|");
						alert(obj.find('[data-role="header"]').html());
						obj.find('[data-role="header"]').html(dados[1]).listview("refresh").trigger("updatelayout");
						obj.find("#texto_rodape").html(dados[2]).listview("refresh").trigger("updatelayout");
						obj.find(".li_menu").html(dados[3]).listview("refresh").trigger("updatelayout");
						$.mobile.loading("hide")
					});
				});
			</script>
			<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
<?php 
			switch($page) {
				case "contas":
					$htmlponto='
						<div id="ponto_01" data-role="collapsible" data-collapsed="false" class="pontos">
							<legend>Ponto de Acesso <font class="n-item">01</font></legend>
							<div class="ui-field-contain">
							    <label for="endereco_pontosfc">Selecione Endereço:</label>
							    <select onchange="selEndPonto($(this));" name="endereco_pontosfc" data-native-menu="true">
							    </select>
							</div>
							<div class="outro_end_ponto ui-field-contain" style="display: none;">
							    <label for="outro_endereco_pontosfc">Digite o Endereço (rua,num,bairro,cidade-uf):</label>
							    <input name="outro_endereco_pontosfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="id_torre_pontosfc">Torre de Acesso:</label>
							    <select onchange="selTorre($(this));" name="id_torre_pontosfc" data-role="auto" data-native-menu="true" data-url="remote.php?cmd=busca&tipo=torre">
							    </select>
							</div>
							<div class="ui-field-contain">
							    <label for="latitude_pontosfc">Latitude e longitude:</label>
							    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="false">
								    <input name="latitude_pontosfc" placeholder="Latitude" type="text" data-wrapper-class="controlgroup-textinput ui-btn">
								    <input name="longitude_pontosfc" placeholder="Longitude" type="text" data-wrapper-class="controlgroup-textinput ui-btn">
								    <a href="#map-page" onclick="openMapa(\\\'ponto\\\',$(this))" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search ui-btn-icon-notext">Localizar Latitude/Longitude</a>
							    </fieldset>
							</div>
							<div class="ui-field-contain">
							    <label for="equipamentos_pontosfc">Descrição do Equipamento instalado:</label>
							    <textarea cols="40" rows="8" name="equipamentos_pontosfc" data-mini="true"></textarea>
							</div>
							<div class="ui-field-contain">
							    <label for="tipo_equipamento_pontosfc">Tipo de iquipamento:</label>
							    <select name="tipo_equipamento_pontosfc" data-native-menu="false">
							        <option value="alugado">Alugado/emprestado</option>
							        <option value="cliente">Do cliente</option>
							        <option value="vendido">Vendido</option>
							        <option value="nunhum">Nenhum</option>
								</select>
							</div>
							<div class="ui-field-contain">
							    <label for="tipo_auth_pontosfc">Tipo de Autenticação:</label>
							    <select onchange="selTipoAuth($(this));" name="tipo_auth_pontosfc" data-native-menu="true">
							        <option value="pppoe">Pppoe</option>
							        <option value="hotspot">Hotspot</option>
							        <option value="binding">IpBinding</option>
							        <option value="nunhum">Nenhum</option>
								</select>
							</div>
							<div class="ui-field-contain">
							    <label>Usuário de Acesso (secrets mk):</label>
							    <div class="ui-grid-solo">
								    <div class="ui-block-a">
								    	<input name="name_secretpp" class="list_secrets" onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar Users..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-load-click="listSecretsLoad" data-url="remote.php?cmd=busca&tipo=secret&query={val}&auth=pp">
								    </div>
								</div>
							</div>
							<div class="ui-field-contain">
							    <label for="id_produto_mensalfc">Plano de Acesso:</label>
							    <select name="id_produto_mensalfc" onchange="selProduto($(this));" data-role="auto" data-native-menu="true" data-url="remote.php?cmd=busca&tipo=produto&mensal=true&int=true">
							    </select>
							</div>
							<div class="ui-field-contain">
							    <label for="gratis_sevmensal">Serviço Mensal Grátis:</label>
							    <select onchange="somaMensalidade();" name="gratis_sevmensalfc" data-role="slider" data-mini="true">
								    <option value="">Off</option>
								    <option value="on">On</option>
								</select>
							</div>
							<div class="ui-field-contain">
							    <label for="desconto_mensalfc">Descontos e Acréscimos:</label>
							    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="false">
								    <input onkeyup="somaMensalidade();" name="valor_desconto_mensalfc" placeholder="Desconto" type="text" class="money" data-wrapper-class="controlgroup-textinput ui-btn">
								    <input onkeyup="somaMensalidade();" name="valor_acrescimo_mensalfc" placeholder="Acrescimo" type="text" class="money" data-wrapper-class="controlgroup-textinput ui-btn">
							    </fieldset>
							</div>
							<input name="id_pontosfc" type="hidden">
							<input name="id_mensalfc" type="hidden">
							<input name="lat_torre_pontosfc" type="hidden">
							<input name="lng_torre_pontosfc" type="hidden">
							<input name="val_produto_pontosfc" type="hidden">
							<input name="id_profile_pp" type="hidden">
							<input name="id_profile_hp" type="hidden">
							<input name="id_profile_bi" type="hidden">
							<input class="id_cliente" name="id_cliente_pontosfc" type="hidden">
							<input class="id_secret" name="id_secretpp" type="hidden">
							<input class="id_cliente id_cliente_secret" name="id_cliente_secretpp" type="hidden">
							<input class="id_cliente" name="id_cliente_mensalfc" type="hidden">
							<button class="bt-remove-item" onclick="$(this).parent().parent().remove();" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-delete" style="display: none;">Remover Ponto</button>
						</div>';
					?>
						<div role="main" class="ui-content">
							<center><font size="4"><b><?php echo $title;?></b></font></center>
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
							<Br>--<Br>--<BR>--<br>---<br>--
						</div><!-- /content -->
						<div data-role="footer" data-position="fixed"></div>
						<script type="text/javascript">
							var val_end1={};
							var val_end2={};
							var end1="";
							var end2="";
							$(document).ready( function() {
								//
								$('#bt_cadastrar_cliente').click(function(){
									salvaDados('ConfigurarCliente');
								});
								$('#bt_cadastrar_banco').click(function(){
									salvaDados('ConfigurarBanco');
								});
								$('#bt_ConfigurarCliente_novo').click(function(){
									$('#id_clientesfc').val('').change();
								});
								//
								$('#select_banco').on('change', function () {
								    openPg('dados_banco','id_gatewaypgfc',$(this).val());
								});
								$('#id_clientesfc').change(function () {
									//alert($(this).val());
									if($(this).val()==''){
										clear_form_elements('ConfigurarCliente');
										$("#ConfigurarCliente_titulo").html('Cadastrar Novo Cliente');
									}else
										$("#ConfigurarCliente_titulo").html('Alterar Cliente');
									//
									getSelect();
									$('.id_cliente').val($(this).val());
								});
								$("[name='qtd_pontos_clientesfc']").change(function () {
									
									for($i=0;$i<$(this).val();$i++){
										var np=($i+1);
										if(np<10)
											np='0'+np;
										//
										if($i>0){
											$("#ponto_"+np).remove();
											addPonto('pontos');
										}
										//
										openPg('clientes_pontos','id_cliente_pontosfc',$('#id_clientesfc').val(),($i+1));
									}
									somaMensalidade();
								});
								$("select[name='endereco_pontosfc']").focus(function () {
									$(this).empty();
									$(this).append(setEndToSel());
								});
							});
							//	
							function setEndToSel(){
								var sel='<option value="">Selecione um Endereço</option>';
								if($("#end1_clientesfc").val()!='')//$("#end1_clientesfc").val()+', '+$("#num1_clientesfc").val()+', '+$("#bar1_clientesfc").val()+', '+$("#cid1_clientesfc").val()+'-'+$("#uf1_clientesfc").val()
									sel+='<option value="1">'+$("#end1_clientesfc").val()+', '+$("#num1_clientesfc").val()+', '+$("#bar1_clientesfc").val()+', '+$("#cid1_clientesfc").val()+'-'+$("#uf1_clientesfc").val()+'</option>';
								//
								if($("#end2_clientesfc").val()!='')
									sel+='<option value="2">'+$("#end2_clientesfc").val()+', '+$("#num2_clientesfc").val()+', '+$("#bar2_clientesfc").val()+', '+$("#cid2_clientesfc").val()+'-'+$("#uf2_clientesfc").val()+'</option>';
								//
								sel+='<option value="0">Outro Endereço</option>';
								return sel;
							}	
							//
							function onLoad(){ 
								openPg('dados_cliente','id_clientesfc',$('#id_clientesfc').val());
							}
							//
							function onLoadLista(){ 
								var id=$("#id_cliente_busca").val();
								getLoading('Localizando Clientes...');
						  	    $.ajax({url: 'remote.php',data:'cmd=list&tipo=clientes&id_clientesfc='+id,dataType: "json"}).then( function ( r ) {
						  	    	if(!r.auth) 
						  	    		location.reload();
						  	    	//
						  	    	var html='';
						  	    	if(r.qtd_atual==0){
						  	    		html +="<li><font color='red'>Nenhum Cliente</font>'</li>";
						  	    	}
						  	    	if(r.qtd_atual!=0){
							  	   		$.each(r.data, function ( i, d ) {
							  	           	html += '<li style="white-space:normal;">';
							  	          	html += '<div><b>'+d.nome+'</b> | '+d.telefone1+d.telefone2+d.telefone3+' @:'+d.email+'</div>';
											//sit - plano<Br>
											html += '<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">';
											html += '<select id="grid-select-2" name="grid-select-2" data-native-menu="false" data-mini="true">';
											html += '<option value="">Alterar</option>';
											html += '<option value="#">Dados Pessoais</option>';
											html += '<option value="#">Cobrança</option>';
											html += '<option value="#">Plano</option>';
											html += '</select>';
											html += '<a class="ui-shadow ui-btn ui-corner-all ui-icon-grid ui-btn-icon-left ui-btn-inline ui-mini">Button c</a></div>';
											html += '<a class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-r ui-btn-icon-left ui-btn-inline ui-mini">Button e </a></div>';
											html += '<a class="ui-shadow ui-btn ui-corner-all ui-icon-gear ui-btn-icon-left ui-btn-inline ui-mini">Button e</a></div>';
											html += '</fieldset>';
											//html += '<a href="#" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left">Left</a>';
											//html += '<a href="#" class="ui-btn ui-corner-all ui-icon-delete ui-btn-icon-left">Right</a>';
											//html += '</fieldset>';
											html += '</li>';
											//<button class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">1</button><button class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">2</button><button class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">3</button><button class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">4</button>
											//</li>
							  	           	//";
							  	     	});
						  	    	}
						  	    	$("#lista-clientes").html(html);
						  	    	$("#lista-clientes").listview("refresh");
						  	    	$("#lista-clientes").trigger("updatelayout");
						  	       	$.mobile.loading("hide")
						  	    });
							}
							//
							var pontos='<?php echo preg_replace('/\s/',' ',$htmlponto);?>';
						 	function addPonto(id) {
								var n_new=$("."+id).length+1;
								if(n_new<10){
									n_new='0'+n_new;
								}
								var obj=$( pontos ).insertAfter("."+id+":last").collapsible().collapsible("refresh").enhanceWithin();
								obj.attr("id","ponto_"+n_new);
								obj.find("input").val("");
								obj.find("select").val("");
								obj.find(".n-item").html(n_new);
								obj.find(".bt-remove-item").css("display", "block");
								obj.find("select[name='endereco_pontosfc']").empty();
								obj.find("select[name='endereco_pontosfc']").append(setEndToSel());
								obj.find('*').each(function(){
									if($(this).attr("id")){
										var idArr=$(this).attr("id").split("_");
										var newid=idArr[0]+"_"+n_new;
										$(this).attr("id",newid);
									}
									if($(this).attr("data-role")=='auto')
										getSelect($(this));
									//
								});
								$('.id_cliente').val($('#id_clientesfc').val());
						 	};
							//	
							function selEndPonto(obj){ 
								if($(obj).val()!=''){
									if($(obj).val()=='1'){
										var lat=$("#lat1_clientesfc").val();
										var lon=$("#long1_clientesfc").val();
										$(obj).closest('.pontos').find(".outro_end_ponto").css("display", "none");
									}else if($(obj).val()=='2'){
										var lat=$("#lat2_clientesfc").val();
										var lon=$("#long2_clientesfc").val();
										$(obj).closest('.pontos').find(".outro_end_ponto").css("display", "none");
									}else{
										var lat='';
										var lon='';	
										$(obj).closest('.pontos').find(".outro_end_ponto").css("display", "block");				
									}
									$(obj).closest('.pontos').find("input[name='latitude_pontosfc']").val(lat);
									$(obj).closest('.pontos').find("input[name='longitude_pontosfc']").val(lon);
									
								}
							}	
							//							        
							function selTipoAuth(obj){ 
								if($(obj).val()!='nunhum'){
									var n1,n2,n3 = '';
									switch ($(obj).val()) {
									    case 'pppoe':
									        n1 = 'id_secretpp';
									        n2 = 'id_cliente_secretpp';
									        n3 = 'pp';
									        break;
									    case 'hotspot':
									        n1 = 'id_secrethp';
									        n2 = 'id_cliente_secrethp';
									        n3 = 'hp';
									        break;
									    case 'binding':
									        n1 = 'id_secretbi';
									        n2 = 'id_cliente_secretbi';
									        n3 = 'bi';
										break;
									} 
									var url=$(obj).closest('.pontos').find('.list_secrets').attr('data-url');
									$(obj).closest('.pontos').find('.list_secrets').attr('data-url', url.substring(0,(url.length - 2))+n3);
									$(obj).closest('.pontos').find(".id_cliente_secret").attr('name', n2);
									$(obj).closest('.pontos').find(".id_secret").attr('name', n1);
								}
							}
							//
							function selTorre(obj){ 
								if($(obj).html()!='0'){
									var valorArr=$(obj).html().split("|");
									$(obj).closest('.pontos').find("input[name='lat_torre_pontosfc']").val(valorArr[1]);
									$(obj).closest('.pontos').find("input[name='lng_torre_pontosfc']").val(valorArr[2]);
								}
							}
							//
							function selProduto(obj){ 
								if($(obj).html()!='0'){
									var valorArr=$(obj).html().split("|");
									$(obj).closest('.pontos').find("input[name='val_produto_pontosfc']").val(valorArr[1]);
									$(obj).closest('.pontos').find("input[name='id_profile_pp']").val(valorArr[2]);
									$(obj).closest('.pontos').find("input[name='id_profile_hp']").val(valorArr[3]);
									$(obj).closest('.pontos').find("input[name='id_profile_bi']").val(valorArr[4]);
									somaMensalidade();
								}
							}
							//
							function somaMensalidade(){ 
								var total=0;
								$('.pontos').each(function(){
									if($(this).find("[name='gratis_sevmensalfc']").val()!='on'){
										var obj=$(this).closest('.pontos');
										var valor_ponto=obj.find("input[name='val_produto_pontosfc']").val()*1+obj.find("input[name='valor_acrescimo_mensalfc']").maskMoney('unmasked')[0]*1-obj.find("input[name='valor_desconto_mensalfc']").maskMoney('unmasked')[0]*1;
										total+=valor_ponto;
									}
								});
								$("#valor_mensalidade").html(decimalFormat(total));
							}
							//
							function listSecretsLoad(valor,id){ 
								var obj=$('input[data-id-ul="'+id+'"]');
								$(obj).closest('.pontos').find(".id_secret").val(valor);
							}
							function openMapa(tipo){
								var address=''; 
								var torre={};
								var ids={};
								var latlng={};
								if(tipo=='ponto'){
									var lat='';var lon='';
									if($('#end_add').val()=='0')
										address=$('#outro_end_add').val();
									else if($('#end_add').val()=='1'){
										address=$("#end_add").find('option[value=1]').html();
										lat=$("#lat1_clientesfc").val();lon=$("#long1_clientesfc").val();
									}else if($('#end_add').val()=='2'){
										address=$("#end_add").find('option[value=2]').html();
										lat=$("#lat2_clientesfc").val();lon=$("#long2_clientesfc").val();
									}//
									if(lat=='' && $("#lat_add").val()!='')
										lat=$("#lat_add").val();
									if(lon=='' && $("#lon_add").val()!='')
										lon=$("#lon_add").val();
									//
									latlng.lat=lat;
									latlng.lon=lon;
									//
									ids.lat='lat_add';ids.lng='lon_add';
									var torreArr=$("#torre_add").val().split("|");
									torre.nome=torreArr[3];torre.lat=torreArr[1];torre.lon=torreArr[2];
								}else if(tipo=='1'){
									if($("#end1_clientesfc").val()!='')
										address=$("#end1_clientesfc").val()+', '+$("#num1_clientesfc").val()+', '+$("#bar1_clientesfc").val()+', '+$("#cid1_clientesfc").val()+'-'+$("#uf1_clientesfc").val();
									//
									latlng.lat=$("#lat1_clientesfc").val();
									latlng.lon=$("#long2_clientesfc").val();
									ids.lat='lat1_clientesfc';ids.lng='long1_clientesfc';
									torre=false;
								}else if(tipo=='2'){
									if($("#end2_clientesfc").val()!='')
										address=$("#end2_clientesfc").val()+', '+$("#num2_clientesfc").val()+', '+$("#bar2_clientesfc").val()+', '+$("#cid2_clientesfc").val()+'-'+$("#uf2_clientesfc").val();
									//
									latlng.lat=$("#lat2_clientesfc").val();
									latlng.lon=$("#long2_clientesfc").val();
									ids.lat='lat2_clientesfc';ids.lng='long2_clientesfc';
									torre=false;
								}else{
									ids=false;
									address=false;
									latlng=false;
									torre=false;
								}
								//alert(ids.lat+'-'+ids.lng);
								if((latlng.lat!='' && latlng.lon!='') || address=='')
									address=false;
								//
								//$("#lat").val(lat);
								//$("#lng").val(lng);
								getMap(ids,latlng,address,torre);
							}
							//
						</script>
					<?php 
				break;
				case "vendas":
					?>
					<div role="main" class="ui-content">
						<center><font size="4"><b><?php echo $title;?></b></font></center>
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div><!-- /content -->
					<?php 
				break;
				case "caixa":
					?>
					<div role="main" class="ui-content">
						<center><font size="4"><b><?php echo $title;?></b></font></center>
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div><!-- /content -->
					<?php 
				break;
				case "logmk":
					?>
					<div role="main" class="ui-content">
						<center><font size="4"><b><?php echo $title;?></b></font></center>
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div><!-- /content -->
					<?php 
				break;				
				default:
					?>
					<div role="main" class="ui-content">
						<center><font size="4"><b><?php echo $title;?></b></font></center>
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div><!-- /content -->
					<script type="text/javascript">
						$(document).ready( function() {
						//
							$('#bt_cadastrar_provedor').click(function(){
								salvaDados('ConfigurarProvedor');
							});
							$('#bt_cadastrar_banco').click(function(){
								salvaDados('ConfigurarBanco');
							});
							$('#select_banco').on('change', function () {
							    openPg('dados_banco','id_gatewaypgfc',$(this).val());
							});
						});			
					</script>
					<?php 
				break;					
			}
			?>
			<div data-role="footer" data-position="fixed">
				<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
				<div data-role="popup" id="popupMenu">
					<ul class="li_menu" data-role="listview" data-inset="true"></ul>
				</div>
				<font id="texto_rodape"></font>
				<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
			</div><!-- /footer --> 
		</div><!-- /page -->
			<?php 
			if($page=='home'){
				?>
				<div data-role="page" id="ConfigurarProvedor">
					<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
					<div role="main" class="ui-content">
						<div style="padding:2px;">  
						    <center><b>Cadastrar/Alterar Provedor<br><font color=blue id=identificacao_provedor></font></b></center>
						    <div class="ui-field-contain">
								<label for="pessoa_juridica_provedorfc ">Pessoa Jurídica:</label>
								<select name="pessoa_juridica_provedorfc" id="pessoa_juridica_provedorfc" data-role="slider" data-mini="true">
								    <option value="">Off</option>
								    <option value="on">On</option>
								</select>
							</div>
						    <div class="ui-field-contain">
								<label for="nome_provedorfc ">Nome Provedor/Pessoa:</label>
								<input name="nome_provedorfc" id="nome_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="razao_social_provedorfc ">Razão Social(jurídica):</label>
								<input name="razao_social_provedorfc" id="razao_social_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="rg_ie_provedorfc">RG/Incrição Estatual:</label>
								<input name="rg_ie_provedorfc" id="rg_ie_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="cpf_cnpj_provedorfc">Cpf/Cnpj:</label>
								<input name="cpf_cnpj_provedorfc" id="cpf_cnpj_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="responsavel_provedorfc">Responsavel(jurídica):</label>
								<input name="responsavel_provedorfc" id="responsavel_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="endereco1_provedorfc">Endereço 1 Logradouro:</label>
							    <input name="endereco1_provedorfc" id="endereco1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="numero1_provedorfc">Endereço 1 Número:</label>
							    <input name="numero1_provedorfc" id="numero1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="complemento1_provedorfc">Endereço 1 Complemento:</label>
							    <input name="complemento1_provedorfc" id="complemento1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="cep1_provedorfc">Endereço 1 Cep:</label>
							    <input name="cep1_provedorfc" id="cep1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="bairro1_provedorfc">Endereço 1 Bairro:</label>
							    <input name="bairro1_provedorfc" id="bairro1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="cidade1_provedorfc">Endereço 1 Cidade:</label>
							    <input name="cidade1_provedorfc" id="cidade1_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="uf1_provedorfc">Endereço 1 Estado:</label>
							    <input name="uf1_provedorfc" id="uf1_provedorfc" type="text">
							</div>
							<div data-role="collapsible" data-collapsed="true">
								<legend>Endereço 2</legend>
								<div class="ui-field-contain">
								    <label for="endereco2_provedorfc">Endereço 2 Logradouro:</label>
								    <input name="endereco2_provedorfc" id="endereco2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="numero2_provedorfc">Endereço 2 Número:</label>
								    <input name="numero2_provedorfc" id="numero2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="complemento2_provedorfc">Endereço 2 Complemento:</label>
								    <input name="complemento2_provedorfc" id="complemento2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="cep2_provedorfc">Endereço 2 Cep:</label>
								    <input name="cep2_provedorfc" id="cep2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="bairro2_provedorfc">Endereço 2 Bairro:</label>
								    <input name="bairro2_provedorfc" id="bairro2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="cidade2_provedorfc">Endereço 2 Cidade:</label>
								    <input name="cidade2_provedorfc" id="cidade2_provedorfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="uf2_provedorfc">Endereço 2 Estado:</label>
								    <input name="uf2_provedorfc" id="uf2_provedorfc" type="text">
								</div>
							</div>
							<div class="ui-field-contain">
							    <label for=telefone_provedorfc>Telefone Principal:</label>
							    <input name="telefone_provedorfc" id="telefone_provedorfc" class="phone_with_ddd" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="telefone2_provedorfc">Telefone 2:</label>
							    <input name="telefone2_provedorfc" id="telefone2_provedorfc" class="phone_with_ddd" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="telefone3_provedorfc">Telefone 3:</label>
							    <input name="telefone3_provedorfc" id="telefone3_provedorfc" class="phone_with_ddd" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="email_provedorfc">Email:</label>
							    <input name="email_provedorfc" id="email_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="site_provedorfc">Site:</label>
							    <input name="site_provedorfc" id="site_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="licenca_provedorfc">Nº da Licença Anatel:</label>
							    <input name="licenca_provedorfc" id="licenca_provedorfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="dias_bloqueio_auto_provedorfc">Dias Para Bloqueio Auto:</label>
								<input name="dias_bloqueio_auto_provedorfc" id="dias_bloqueio_auto_provedorfc" value="5" min="0" max="100" type="range">
							</div>
							<div class="ui-field-contain">
							    <label for="porcentagem_desbloqueio_provedorfc">% da dívida a paga para desbloqueio Auto:</label>
							    <input name="porcentagem_desbloqueio_provedorfc" id="porcentagem_desbloqueio_provedorfc" class="percent" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="porcentagem_cobrar_bloqueio_provedorfc">% a cobrar durante período bloqueado:</label>
								<input name="porcentagem_cobrar_bloqueio_provedorfc" id="porcentagem_cobrar_bloqueio_provedorfc" class="percent" value="0" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="dias_desconto_provedorfc">Dias p/ desconto de pagamento antecipado:</label>
								<input name="dias_desconto_provedorfc" id="dias_desconto_provedorfc" value="0" min="0" max="100" type="range">
							</div>
						    <div class="ui-field-contain">
								<label for="porcentagem_desconto_provedorfc">% de Desconto:</label>
								<input name="porcentagem_desconto_provedorfc" id="porcentagem_desconto_provedorfc" class="percent" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="porcentagem_juros_provedorfc">% Juros de Atraso:</label>
								<input name="porcentagem_juros_provedorfc" id="porcentagem_juros_provedorfc" class="percent" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="porcentagem_multa_provedorfc">% Multa de Atraso:</label>
								<input name="porcentagem_multa_provedorfc" id="porcentagem_multa_provedorfc" class="percent" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="email_send_provedorfc">Email de envio auto:</label>
								<input name="email_send_provedorfc" id="email_send_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="host_contaemail_provedorfc">Host conta Email:</label>
								<input name="host_contaemail_provedorfc" id="host_contaemail_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="user_contaemail_provedorfc">User conta Email:</label>
								<input name="user_contaemail_provedorfc" id="user_contaemail_provedorfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="senha_contaemail_provedorfc">Senha conta Email:</label>
								<input name="senha_contaemail_provedorfc" id="senha_contaemail_provedorfc" type="password">
							</div>
							<center>
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="provedor" type="hidden">
								<input name="id_provedorfc" id="id_provedorfc" type="hidden">
								<a href="#" data-direction="reverse" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-notext ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button id="bt_cadastrar_provedor" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>
							</center>
						</div>
					</div><!-- /content -->
					<div data-role="footer" data-position="fixed">
						<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
						<div data-role="popup" id="popupMenu">
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
						</div>
						<font id="texto_rodape"></font>
						<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
					</div><!-- /footer --> 
				</div><!-- /page -->
				<div data-role="page" id="ConfigurarBanco">
					<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
					<div role="main" class="ui-content">
						<div style="padding:5px 10px;">  
						    <center>
						    	<b>Cadastrar/Alterar Banco</b><br>
								<div data-role="fieldcontain">
								    <label for="select_banco">Selecione o Banco:</label>
								    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
									 	<select id="select_banco" data-native-menu="false" data-mini="true" disabled>
								    	</select>
									    <button class="ui-shadow ui-btn ui-corner-all ui-icon-plus ui-btn-icon-notext">Add</button>
									</fieldset>
								</div>
						    </center>
						    <div class="ui-field-contain">
								<label for="padrao_gatewaypgfc">Banco Padrão:</label>
								<select name="padrao_gatewaypgfc" id="padrao_gatewaypgfc" data-role="slider" data-mini="true">
								    <option value="">Off</option>
								    <option value="on">On</option>
								</select>
							</div>
						    <div class="ui-field-contain">
								<label for="banco_gatewaypgfc">Nome Banco:</label>
								<input name="banco_gatewaypgfc" id="banco_gatewaypgfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="num_agencia_gatewaypgfc">Número da Agencia:</label>
								<input name="num_agencia_gatewaypgfc" id="num_agencia_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="dig_agencia_gatewaypgfc">Digito da Agencia:</label>
							    <input name="dig_agencia_gatewaypgfc" id="dig_agencia_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
								<label for="num_conta_gatewaypgfc">Número da Conta:</label>
								<input name="num_conta_gatewaypgfc" id="num_conta_gatewaypgfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="dig_conta_gatewaypgfc">Digito da Conta:</label>
								<input name="dig_conta_gatewaypgfc" id="dig_conta_gatewaypgfc" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="senha_conta_gatewaypgfc">Senha de Acesso (webserviço):</label>
								<input name="senha_conta_gatewaypgfc" id="senha_conta_gatewaypgfc" type="password">
							</div>
							<div class="ui-field-contain">
							    <label for="dias_nao_receber_gatewaypgfc">Dias vencido não receber:</label>
								<input name="dias_nao_receber_gatewaypgfc" id="dias_nao_receber_gatewaypgfc" value="180" min="0" max="1000" type="range">
							</div>
							<div class="ui-field-contain">
							    <label for="carteira_gatewaypgfc">Carteira:</label>
							    <input name="carteira_gatewaypgfc" id="carteira_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="convenio_gatewaypgfc">Convenio:</label>
							    <input name="convenio_gatewaypgfc" id="convenio_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="cedente_gatewaypgfc">Cedente:</label>
							    <input name="cedente_gatewaypgfc" id="cedente_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="taxa_gatewaypgfc">Taxa:</label>
							    <input name="taxa_gatewaypgfc" id="taxa_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="nosso_num_gatewaypgfc">Nosso Número:</label>
							    <input name="nosso_num_gatewaypgfc" id="nosso_num_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="cpf_cnpj_gatewaypgfc">Cpf/Cnpj:</label>
							    <input name="cpf_cnpj_gatewaypgfc" id="cpf_cnpj_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="esp_doc_gatewaypgfc">Especie Doc:</label>
							    <input name="esp_doc_gatewaypgfc" id="esp_doc_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="local_pg_gatewaypgfc">Local Pagamento:</label>
							    <input name="local_pg_gatewaypgfc" id="local_pg_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="avalista_gatewaypgfc">Avalista:</label>
							    <input name="avalista_gatewaypgfc" id="avalista_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="obs_linha1_gatewaypgfc">Obs Linha1:</label>
							    <input name="obs_linha1_gatewaypgfc" id="obs_linha1_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="obs_linha2_gatewaypgfc">Obs Linha2:</label>
							    <input name="obs_linha2_gatewaypgfc" id="obs_linha2_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="obs_linha3_gatewaypgfc">Obs Linha3:</label>
							    <input name="obs_linha3_gatewaypgfc" id="obs_linha3_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="obs_linha4_gatewaypgfc">Obs Linha4:</label>
							    <input name="obs_linha4_gatewaypgfc" id="obs_linha4_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="instr_linha1_gatewaypgfc">Instrução Linha1:</label>
							    <input name="instr_linha1_gatewaypgfc" id="instr_linha1_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="instr_linha2_gatewaypgfc">Instrução Linha2:</label>
							    <input name="instr_linha2_gatewaypgfc" id="instr_linha2_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="instr_linha3_gatewaypgfc">Instrução Linha3:</label>
							    <input name="instr_linha3_gatewaypgfc" id="instr_linha3_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="instr_linha4_gatewaypgfc">Instrução Linha4:</label>
							    <input name="instr_linha4_gatewaypgfc" id="instr_linha4_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="local_pg_facil_gatewaypgfc">Local Pagamento Fácil:</label>
							    <input name="local_pg_facil_gatewaypgfc" id="local_pg_facil_gatewaypgfc" type="text">
							</div>
							<div class="ui-field-contain">
							    <label for="endereco_pg_facil_gatewaypgfc">Endereço Pagamento Fácil:</label>
							    <input name="endereco_pg_facil_gatewaypgfc" id="endereco_pg_facil_gatewaypgfc" type="text">
							</div>
							<center>
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="banco" type="hidden">
								<input name="id_gatewaypgfc" id="id_gatewaypgfc" type="hidden">
								<a href="#" data-direction="reverse" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-notext ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button id="bt_cadastrar_banco" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>
							</center>
						</div>
					</div><!-- /content -->
					<div data-role="footer" data-position="fixed">
						<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
						<div data-role="popup" id="popupMenu">
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
						</div>
						<font id="texto_rodape"></font>
						<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
					</div><!-- /footer -->
				</div><!-- /page -->
				<?php 
			}
			if($page=='contas'){
				?>
				<div data-role="page" id="ListarCliente">
					<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
					<div role="main" class="ui-content">
						<div style="padding:5px 10px;">  
						    <center>
						    	<b><font id="ListarCliente_titulo" size=5>Clientes</font></b><a href="#ConfigurarCliente" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-plus ui-btn-inline ui-mini">Novo</a>
						    </center>
							<div class="ui-field-contain">
							    <label>Busca de Cliente:</label>
							    <div class="ui-grid-solo">
									<div class="ui-block-a">
										<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar nome/cpf..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_cliente_busca" data-load-click="onLoadLista" data-url="remote.php?cmd=busca&tipo=cliente&query={val}">
										<input id="id_cliente_busca" type="hidden">
									</div>
								</div>
							</div>
							<font id="ListarCliente_titulo" size=5></font>
							<ul id="lista-clientes" data-role="listview" data-inset="true">
							</ul>
						</div>
					</div><!-- /content -->
					<div data-role="footer" data-position="fixed">
						<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
						<div data-role="popup" id="popupMenu">
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
						</div>
						<font id="texto_rodape"></font>
						<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
					</div><!-- /footer -->
				</div><!-- /page -->
				<div data-role="page" id="ConfigurarCliente">
					<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
					<div role="main" class="ui-content">
						<div style="padding:5px 10px;">  
						    <center>
						    	<b><font id="ConfigurarCliente_titulo" size=5>Cadastrar novo Cliente</font></b><br>
						    </center>
							<div class="ui-field-contain">
							    <label>Busca de Cliente:</label>
							    <div class="ui-grid-solo">
									<div class="ui-block-a">
										<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Buscar cliente..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-id-click="id_clientesfc" data-load-click="onLoad" data-url="remote.php?cmd=busca&tipo=cliente&query={val}">
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
									<label for="pessoa_juridica_clientesfc ">Pessoa Jurídica:</label>
									<select name="pessoa_juridica_clientesfc" id="pessoa_juridica_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
							    <div class="ui-field-contain">
									<label for="nome_clientesfc">Nome:</label>
									<input name="nome_clientesfc" id="nome_clientesfc" type="text">
								</div>
							    <div class="ui-field-contain">
									<label for="razao_social_clientesfc ">Razão Social(jurídica):</label>
									<input name="razao_social_clientesfc" id="razao_social_clientesfc" type="text">
								</div>
							    <div class="ui-field-contain">
									<label for="rg_ie_clientesfc">RG/Incrição Estatual:</label>
									<input name="rg_ie_clientesfc" id="rg_ie_clientesfc" type="text">
								</div>
							    <div class="ui-field-contain">
									<label for="cpf_cnpj_clientesfc">Cpf/Cnpj:</label>
									<input name="cpf_cnpj_clientesfc" id="cpf_cnpj_clientesfc" type="text">
								</div>
							    <div class="ui-field-contain">
									<label for="responsavel_clientesfc">Responsavel(jurídica):</label>
									<input name="responsavel_clientesfc" id="responsavel_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
									<label for="data_nascimento_clientesfc">Data de Nascimento:</label>
									<input name="data_nascimento_clientesfc" id="data_nascimento_clientesfc" class="datebox" type="text">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Dados de Contato</legend>
								<div class="ui-field-contain">
								    <label for=tel1_clientesfc>Telefone 1:</label>
								    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="false">
									    <input name="tel1_clientesfc" id="tel1_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone" data-wrapper-class="controlgroup-textinput ui-btn">
								        <select name="op1_clientesfc" id="op1_clientesfc">
								        	<option value="" select>Oper</option>
								            <option value="OI">Oi</option>
								            <option value="VIVO">Vivo</option>
								            <option value="CLARO">Claro</option>
								            <option value="TIM">Tim</option>
								            <option value="NET">Net</option>
								            <option value="NEXTEL">Nextel</option>
								        </select>
								        <label for="wsap1_clientesfc">Watsap</label>
		        						<input name="wsap1_clientesfc" id="wsap1_clientesfc" type="checkbox">
		        						<input name="nome1_clientesfc" id="nome1_clientesfc" type="text" placeholder="Nome Contato" data-wrapper-class="controlgroup-textinput ui-btn">
								    </fieldset>
								</div>
								<div class="ui-field-contain">
								    <label for=tel2_clientesfc>Telefone 2:</label>
								    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="false">
									    <input name="tel2_clientesfc" id="tel2_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone 2" data-wrapper-class="controlgroup-textinput ui-btn">
								        <select name="op2_clientesfc" id="op2_clientesfc">
								        	<option value="" select>Oper</option>
								            <option value="OI">Oi</option>
								            <option value="VIVO">Vivo</option>
								            <option value="CLARO">Claro</option>
								            <option value="TIM">Tim</option>
								            <option value="NET">Net</option>
								            <option value="NEXTEL">Nextel</option>
								        </select>
								        <label for="wsap2_clientesfc">Watsap</label>
		        						<input name="wsap2_clientesfc" id="wsap2_clientesfc" type="checkbox">
		        						<input name="nome2_clientesfc" id="nome2_clientesfc" type="text" placeholder="Nome Contato" data-wrapper-class="controlgroup-textinput ui-btn">
								    </fieldset>
								</div>
								<div class="ui-field-contain">
								    <label for=tel3_clientesfc>Telefone 3:</label>
								    <fieldset data-role="controlgroup" data-type="horizontal" data-mini="false">
									    <input name="tel3_clientesfc" id="tel3_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone 2" data-wrapper-class="controlgroup-textinput ui-btn">
								        <select name="op3_clientesfc" id="op3_clientesfc">
								        	<option value="" select>Oper</option>
								            <option value="OI">Oi</option>
								            <option value="VIVO">Vivo</option>
								            <option value="CLARO">Claro</option>
								            <option value="TIM">Tim</option>
								            <option value="NET">Net</option>
								            <option value="NEXTEL">Nextel</option>
								        </select>
								        <label for="wsap3_clientesfc">Watsap</label>
		        						<input name="wsap3_clientesfc" id="wsap3_clientesfc" type="checkbox">
		        						<input name="nome3_clientesfc" id="nome3_clientesfc" type="text" placeholder="Nome Contato" data-wrapper-class="controlgroup-textinput ui-btn">
								    </fieldset>
								</div>
								<div class="ui-field-contain">
								    <label for="email_clientesfc">Email:</label>
								    <input name="email_clientesfc" id="email_clientesfc" type="text">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Endereço 1</legend>
							    <div class="ui-field-contain">
									<label for="cob1_clientesfc">Endereço 1 (endereço de Cobrança?):</label>
									<select name="cob1_clientesfc" id="cob1_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
								<div class="ui-field-contain">
								    <label for="cep1_clientesfc">Endereço 1 Cep:</label>
						    		<input name="cep1_clientesfc" size="10" id="cep1_clientesfc" class="cep" type="text" placeholder="Cep" class="ui-mini">
								</div>
								<div class="ui-field-contain">
								    <label>Buscar Endereço 1 (pelo cep):</label>
							    	<a href="#" onclick="getEnd($('#cep1_clientesfc').val(),{cep:'cep1_clientesfc',logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Endereço 1</a>
								</div>
								<div class="ui-field-contain">
								    <label for="end1_clientesfc">Endereço 1 Logradouro:</label>
								    <input name="end1_clientesfc" id="end1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="num1_clientesfc">Endereço 1 Número:</label>
								    <input name="num1_clientesfc" id="num1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="comp1_clientesfc">Endereço 1 Complemento:</label>
								    <input name="comp1_clientesfc" id="comp1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="bar1_clientesfc">Endereço 1 Bairro:</label>
								    <input name="bar1_clientesfc" id="bar1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="cid1_clientesfc">Endereço 1 Cidade:</label>
								    <input name="cid1_clientesfc" id="cid1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="uf1_clientesfc">Endereço 1 Estado:</label>
								   	<select name="uf1_clientesfc" id="uf1_clientesfc" data-native-menu="true" class="ui-mini">
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
								<div class="ui-field-contain">
								    <label>Busca Cep (Pelo endereço):</label>
									<a href="#" onclick="getCep({cep:'cep1_clientesfc',logradouro:'end1_clientesfc',numero:'num1_clientesfc',bairro:'bar1_clientesfc',cidade:'cid1_clientesfc',uf:'uf1_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar CEP 1</a>
								</div>
								<div class="ui-field-contain">
								    <label for="bt_lat1_long1">Endereço 1 Localizar Latitude e Longitude:</label>
								    <a href="#map-page" onclick="openMapa('1')" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
								</div>
								<div class="ui-field-contain">
								    <label for="lat1_clientesfc">Endereço 1 Latitude:</label>
								    <input name="lat1_clientesfc" id="lat1_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="long1_clientesfc">Endereço 1 Longitude:</label>
								    <input name="long1_clientesfc" id="long1_clientesfc" type="text">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="true">
								<legend>Endereço 2</legend>
							    <div class="ui-field-contain">
									<label for="cob2_clientesfc">Endereço 2 (endereço de Cobrança?):</label>
									<select name="cob2_clientesfc" id="cob2_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
								<div class="ui-field-contain">
								    <label for="end2_clientesfc">Endereço 2 Logradouro:</label>
								    <input name="end2_clientesfc" id="end2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="num2_clientesfc">Endereço 2 Número:</label>
								    <input name="num2_clientesfc" id="num2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="comp2_clientesfc">Endereço 2 Complemento:</label>
								    <input name="comp2_clientesfc" id="comp2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="cep2_clientesfc">Endereço 2 Cep:</label>
									<input name="cep2_clientesfc" id="cep2_clientesfc" class="cep" type="text" placeholder="Cep" data-wrapper-class="controlgroup-textinput ui-btn">
								</div>
								<div class="ui-field-contain">
								    <label>Buscar Endereço 2 (pelo cep):</label>
							    	<a href="#" onclick="getEnd($('#cep2_clientesfc').val(),{cep:'cep2_clientesfc',logradouro:'end2_clientesfc',numero:'num2_clientesfc',bairro:'bar2_clientesfc',cidade:'cid2_clientesfc',uf:'uf2_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Endereço 2</a>
								</div>
								<div class="ui-field-contain">
								    <label for="bar2_clientesfc">Endereço 2 Bairro:</label>
								    <input name="bar2_clientesfc" id="bar2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="cid2_clientesfc">Endereço 2 Cidade:</label>
								    <input name="cid2_clientesfc" id="cid2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="uf2_clientesfc">Endereço 2 Estado:</label>
								   	<select name="uf2_clientesfc" id="uf2_clientesfc" data-native-menu="true" class="ui-mini">
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
								<div class="ui-field-contain">
								    <label>Busca Cep 2 (Pelo endereço 2):</label>
									<a href="#" onclick="getCep({cep:'cep2_clientesfc',logradouro:'end2_clientesfc',numero:'num2_clientesfc',bairro:'bar2_clientesfc',cidade:'cid2_clientesfc',uf:'uf2_clientesfc'});" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar CEP 2</a>
								</div>
								<div class="ui-field-contain">
								    <label for="bt_lat2_long2">Endereço 2 Localizar Latitude e Longitude:</label>
								    <a href="#map-page" onclick="openMapa('2')" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
								</div>
								<div class="ui-field-contain">
								    <label for="lat2_clientesfc">Endereço 2 Latitude:</label>
								    <input name="lat2_clientesfc" id="lat2_clientesfc" type="text">
								</div>
								<div class="ui-field-contain">
								    <label for="long2_clientesfc">Endereço 2 Longitude:</label>
								    <input name="long2_clientesfc" id="long2_clientesfc" type="text">
								</div>
							</div>
							<div data-role="collapsible" data-collapsed="false">
								<legend>Configurações de Cobrança</legend>
								<div class="ui-field-contain">
								    <label for="venc_clientesfc">Dia do Vencimento:</label>
								    <select name="venc_clientesfc" id="venc_clientesfc" data-native-menu="false">
								        <option value="10">10</option>
								        <option value="15">15</option>
								        <option value="20">20</option>
								        <option value="25">25</option> 
									</select>
								</div>
								<div class="ui-field-contain">
								    <label for="acesso_gratis_clientesfc">Acesso Grátis:</label>
								    <select name="acesso_gratis_clientesfc" id="acesso_gratis_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
								<div class="ui-field-contain">
								    <label for="desativar_juros_clientesfc">Desativar Juros e Multa:</label>
								    <select name="desativar_juros_clientesfc" id="desativar_juros_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
								<div class="ui-field-contain">
								    <label for="destivar_bloqueio_clientesfc">Desativar Bloqueio Automático:</label>
								    <select name="destivar_bloqueio_clientesfc" id="destivar_bloqueio_clientesfc" data-role="slider" data-mini="true">
									    <option value="">Off</option>
									    <option value="on">On</option>
									</select>
								</div>
							    <div class="ui-field-contain">
									<label for="valor_bloqueio_clientesfc">Valor Mínimo para Bloqueio:</label>
									<input name="valor_bloqueio_clientesfc" id="valor_bloqueio_clientesfc" class="money" value="0" type="text">
								</div>
							</div>
							<?php echo str_replace('\\','',$htmlponto);?>
							<button onclick="addPonto('pontos');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">Add Ponto</button>
							<div data-role="collapsible" data-collapsed="false">
								<legend>OUTROS</legend>
								<div class="ui-field-contain">
									<label for="valor_mensalidade">Valor Mensalidade:</label>
									R$ <font id="valor_mensalidade" class="money">0,00</font>
								</div>
								<div class="ui-field-contain">
									<label for="valor_instalacao">Valor serviço Instalação:</label>
									<input class="valor_instalacao" name="valor_instalacao" value="0,00" class="money" type="text">
								</div>
							    <div class="ui-field-contain">
									<label for="obs_clientesfc">Obs:</label>
									<textarea cols="40" rows="8" name="obs_clientesfc" id="obs_clientesfc" data-mini="true"></textarea>
								</div>
							</div>
							<center>
								<input name="qtd_pontos_clientesfc" type="hidden">
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="cliente" type="hidden">
								<input name="id_clientesfc" id="id_clientesfc" type="hidden">
								<a href="#" data-direction="reverse" data-rel="back" class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-notext ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button id="bt_cadastrar_cliente" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>
							</center>
						</div>
					</div><!-- /content -->
					<div data-role="footer" data-position="fixed">
						<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
						<div data-role="popup" id="popupMenu">
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
						</div>
						<font id="texto_rodape"></font>
						<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
					</div><!-- /footer -->
				</div><!-- /page -->			
				<?php 
			}
				?>
			<div data-role="page" id="cadastroFim">
				<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
				<div role="main" class="ui-content">
					<div style="padding:10px 20px;"> 
					    <center><h3>STATUS DO CADASTRO</h3>
					    	<font color=blue size=5 id="local_texto_retorno"></font><Br><Br>
							<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>
						</center>
					</div>
				</div><!-- /content -->
				<div data-role="footer" data-position="fixed">
						<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
						<div data-role="popup" id="popupMenu">
							<ul class="li_menu" data-role="listview" data-inset="true"></ul>
						</div>
						<font id="texto_rodape"></font>
						<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
					</div><!-- /footer -->
			</div><!-- /page -->
			<div data-role="page" id="PageListView">
				<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
				<div role="main" class="ui-content">
					<div style="padding:10px 20px;"> 
					    <center><h3><font color=blue size=5 id="titulo_PageListView"></font></h3></center>
					    <ul id="list_PageListView" data-role="listview" ></ul><br>
					    <center>
							<a href="#" data-direction="reverse" data-rel="back" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">FECHAR</a>
						</center>
					</div>
				</div><!-- /content -->
				<div data-role="footer" data-position="fixed">
					<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
					<div data-role="popup" id="popupMenu">
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div>
					<font id="texto_rodape"></font>
					<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
				</div><!-- /footer -->
			</div><!-- /page -->
			<div data-role="page" data-url="map-page" id="map-page">
				<div data-role="header" style="overflow:hidden;" data-position="fixed"></div>
		    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
					<div class="ui-grid-b">
						<center> 
						    <div class="ui-block-a"><input id="lat-torre" type="hidden"><input placeholder="Digite Latitude" id="lat" type="text" data-wrapper-class="controlgroup-textinput ui-btn" style="width:75px"></div>
						    <div class="ui-block-b"><input id="lng-torre" type="hidden"><input placeholder="Digite Latitude" id="lng" type="text" data-wrapper-class="controlgroup-textinput ui-btn" style="width:75px"></div>
						    <div class="ui-block-c"><a href="#" onclick="getMap();" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search ui-btn-min">RELOAD</a></div> 
					    </center>
					</div><!-- /grid-b -->
				</div><!-- /header -->
		        <div data-role="content" id="content">
		        	<form class="ui-filterable">
						<input id="address-mapa-input" data-type="search" placeholder="Find a city...">
					</form>
					<ul id="address-mapa" data-role="listview" data-inset="true" data-filter="true" data-input="#address-mapa-input"></ul>
		            <div id="map_canvas" style="height:100%"></div>
		        </div>
		        <div data-role="footer" data-position="fixed">
		        	<center>
						<font size=2 id="distancia"></font><br></b><a href="#" onclick="getCords();" data-direction="reverse" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-delete">FECHAR</a>
					</center>
				</div><!-- /header --> 
				<div data-role="footer" data-position="fixed">
					<a href="#popupMenu" data-rel="popup" class="ui-shadow ui-btn ui-btn-left ui-corner-all ui-icon-grid ui-btn-icon-left" data-transition="pop">MENU</a>
					<div data-role="popup" id="popupMenu">
						<ul class="li_menu" data-role="listview" data-inset="true"></ul>
					</div>
					<font id="texto_rodape"></font>
					<a href="#" onclick="location.href=\'index.php?logout=true\'" class="ui-btn ui-btn-right ui-corner-all ui-icon-power ui-btn-icon-left ui-mini">Sair</a>
				</div><!-- /footer -->
			</div>
			<?php 
		}
		?>
	</body>
</html>