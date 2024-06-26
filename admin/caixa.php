<?php 
header('Location: http://www.mkfacil.cf/main/pages/caixa.php');
/*
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
$page='caixa.php';
require_once("_validar.php");
	if(!$authSession){
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>GEOPAG - LOGIN</title>
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
			            var envio = $.post("_logar.php?page=caixa.php", {login:$("#login").val(),senha:$("#senha").val()})
			            envio.done(function(data) {
			                $("#resultado").html(data);
			                $.mobile.loading("hide");
			            })
			            envio.fail(function() { alert("Erro na requisi��o");$.mobile.loading("hide"); })
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
					<div data-role="navbar"><center><h3><font color=red id="resultado">GEOPAG - LOGIN</font></h3></center></div>
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
		$title='Recebimento - '.$provedor_usuario;
		$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
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
							$nome_cliente = utf8_encode($_REQUEST["nome"]);
							echo "<font color=blue>$nome_cliente<br>$cpf_cnpj</font>";
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
						<label for="id_clientesfc">Nome/cpf/cnpj/e-mail:</label>
						<div class="ui-grid-solo">
							<div class="ui-block-a">
								<input onkeyup="AutoCompleteText($(this));" data-id-click="id_clientesfc" type="text" placeholder="Buscar cliente..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-load-click="dataClik" data-url="_dados.php?cmd=busca&tipo=cliente&query={val}">
							</div>
						</div>
						<input id="id_clientesfc" name="id_clientesfc" type="hidden">						
						<script type="text/javascript">
							function dataClik(vl,obj){ 
								var id=$('#id_clientesfc').val();
								var nome=$('input[data-id-ul="'+obj+'"]').val();
								//alert(id+','+nome);
								location.href='caixa.php?id_clientesfc='+id+'&nome='+encodeURIComponent(nome);
							}
						</script>
						<ul data-role="listview" data-split-icon="action" data-split-theme="a" data-inset="true">
							<center>
								<a href="#" onclick="location.href='caixa.php?sit_cobrancas=ab&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='ab')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Em aberto</a>
								<a href="#" onclick="location.href='caixa.php?sit_cobrancas=pg&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='pg')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Pagas</a>
								<a href="#" onclick="location.href='caixa.php?sit_cobrancas=all&<?php echo $urlBusca;?>'" data-icon="home" <?php if($sit_cobrancas=='all')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>All</a>
							</center>	
						<?php 
							if($id_clientesfc){
								$urlBusca='id_clientesfc='.$id_clientesfc.'&nome='.$nome_cliente;
								//
								$sit_cobrancas=isset($_REQUEST["sit_cobrancas"]) ? $_REQUEST["sit_cobrancas"] : false;
								if(!$sit_cobrancas)
									$sit_cobrancas='ab';
								//
								$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : false;
								if($sort){
								   	$chars = array('\\', '//', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
								   	$data = str_replace($chars, "", $sort);
								   	$data_array = json_decode(utf8_encode($data), true);
								   	$order=" ORDER BY ".$data_array[0][property]." ".$data_array[0][direction];
								}else{
								   	$order=" ORDER BY vencimento_cobrancasfc DESC";
								}
								if($id_clientesfc!='')
								   	$busca="id_cobrancasfc='".$id_clientesfc."'";
								//
								if($sit_cobrancas && $sit_cobrancas!='all'){
								    if($busca!='')
								    	$busca.=" AND ";
								    //
								    if($sit_cobrancas=='pg'){
								    	$busca.="(tipo_pago_cobrancasfc='TOTAL' OR tipo_pago_cobrancasfc='MAIOR')";
								    	$textBusca=' paga';
								    }
								    //
								    if($sit_cobrancas=='ab'){
								    	$busca.="valor_atual_cobrancasfc > 0";
								    	$textBusca=' em aberto';
								    }
								}
								//
								if($busca!='')
								    $busca = "WHERE $busca";
								//
								$select = "SELECT * FROM fcv_cobrancas $busca";
								//echo $select;
								$qtdResult=mysql_num_rows(mysql_query($select));
								if ($qtdResult == 0){
								    echo '<center><b>Não existem cobranças'.$textBusca.'!</b></center>';
								}else{
									$n=$qtdResult;
									if($sit_cobrancas!='pg' && $qtdResult>1){
										$vencidas=false;
										$linha1=mysql_fetch_object(mysql_query("SELECT count(*) AS qtd, sum(valor_atual_cobrancasfc) AS valor_total, min(vencimento_cobrancasfc) AS vencimento FROM `fcv_cobrancas` WHERE id_cobrancasfc='".$id_clientesfc."' AND valor_atual_cobrancasfc > 0 AND vencimento_cobrancasfc < CURDATE() GROUP BY id_cobrancasfc"));
										//	
										$linha2=mysql_fetch_object(mysql_query("SELECT count(*) AS qtd, sum(valor_atual_cobrancasfc) AS valor_total, min(vencimento_cobrancasfc) AS vencimento FROM `fcv_cobrancas` WHERE id_cobrancasfc='".$id_clientesfc."' AND valor_atual_cobrancasfc > 0 GROUP BY id_cobrancasfc"));
										if($linha1->qtd < $linha2->qtd){
											$linha=$linha2;
											$vencidas=true;
										}else{
											$linha=$linha1;
										}
										echo '<li>';
											echo '<a href="#pop_escolha_all" data-rel="popup" data-position-to="window" data-transition="pop">';
											$value='{"acao":"popupPg","nome":"'.$nome_cliente.'","debitos":"'.number_format($linha->valor_total, 2, ',', '.').'","descontos":"'.number_format(0, 2, ',', '.').'","creditos":"'.number_format(0, 2, ',', '.').'","encargos":"'.number_format(0, 2, ',', '.').'","recebido":"'.number_format($linha->valor_total, 2, ',', '.').'","data":"'.mostrarDataSimples($linha->vencimento).'","id_cliente":"'.$id_clientesfc.'"}';
											echo "<input id='dados_all' value='$value' type='hidden'>";
											echo '<font color=SteelBlue><b>Dívida Total - '.$linha->qtd.' Cobrança(s)</b></font><br>';
											echo '<b>Valor Total Atualizado:</b> R$ '.number_format($linha->valor_total*1, 2, ',', '.').'<br>';
											echo '<center><font size=1 color=blue><< RECEBER DÍVIDA TOTAL >></font></center>';
											echo '</a>';
											echo '<div data-role="popup" id="pop_escolha_all" data-theme="a" data-overlay-theme="b" class="ui-content" style="padding-bottom:2em;">';
											echo '<h3>DÍVIDA TOTAL R$ '.number_format($linha->valor_total*1, 2, ',', '.').'</h3>';
											echo '<a href="#popupPg" id="all" class="popup ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">RECEBER COBRANÇA</a><a href="cob/boleto.php?id_cliente='.$linhas->id_cobrancasfc.'&data='.$linha->vencimento.'&valor='.($linha->valor_total*1).'" target="_blank" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Gerar Boleto</a>';
											echo '</div>';
										echo '</li>'; 
										if($vencidas){
											echo '<li>';
											echo '<a href="#pop_escolha_venc" data-rel="popup" data-position-to="window" data-transition="pop">';
											$value='{"acao":"popupPg","nome":"'.$nome_cliente.'","debitos":"'.number_format($linha1->valor_total, 2, ',', '.').'","descontos":"'.number_format(0, 2, ',', '.').'","creditos":"'.number_format(0, 2, ',', '.').'","encargos":"'.number_format(0, 2, ',', '.').'","recebido":"'.number_format($linha1->valor_total, 2, ',', '.').'","data":"'.mostrarDataSimples($linha1->vencimento).'","id_cliente":"'.$id_clientesfc.'"}';
											echo "<input id='dados_venc' value='$value' type='hidden'>";
											echo '<font color=Gray><b>Total Vencidas - '.$linha1->qtd.' Cobran�a(s)</b></font><br>';
											echo '<b>Valor Total Atualizado:</b> R$ '.number_format($linha1->valor_total*1, 2, ',', '.').'<br>';
											echo '<center><font size=1 color=blue><< RECEBER COBRANÇAS VENCIDAS >></font></center>';
											echo '</a>';
											echo '<div data-role="popup" id="pop_escolha_venc" data-theme="a" data-overlay-theme="b" class="ui-content" style="padding-bottom:2em;">';
											echo '<h3>COBRANÇAS VENCIDAS R$ '.number_format($linha1->valor_total*1, 2, ',', '.').'</h3>';
											echo '<a href="#popupPg" id="venc" class="popup ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">RECEBER COBRANÇA</a><a href="cob/boleto.php?id_cliente='.$linhas->id_cobrancasfc.'&data='.$linha1->vencimento.'&valor='.($linhas1->valor_total*1).'" target="_blank" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Gerar Boleto</a>';
											echo '</div>';
											echo '</li>';
										}
									}
									$resultadoDados = mysql_query($select." ".$order) or die ('N�o foi poss�vel realizar a consulta ao banco de dados linha 98');
									while($linhas=mysql_fetch_object($resultadoDados)){
									    //array_walk($linhas, 'toUtf8');
									    if($n<10)$n='00'.$n;else if($n<100)$n='0'.$n;
									    //
									    $text_vencimento=toVarUtf8('<b>Vencimento:</b>'.mostrarDataSimples($linhas->vencimento_cobrancasfc).'');
									    if(strtotime($linhas->vencimento_cobrancasfc) < strtotime(date('Y-m-d'))){
											$status_cobrancas='vencida';
											$cor='red';
										}else if(strtotime($linhas->vencimento_cobrancasfc) == strtotime(date('Y-m-d'))){
											$status_cobrancas='vencendo hoje';
											$cor='DodgerBlue';
										}else{
											$status_cobrancas='em aberto';
											$cor='Gren';
										}
									    if($linhas->valor_atual_cobrancasfc*1 > 0){
											$text_valor='<b>Valor atualizado:</b>R$ '.number_format($linhas->valor_atual_cobrancasfc, 2, ',', '.').'<br>';
											$text_sit="Cobrança $n - $status_cobrancas";
											$text_cob='RECEBER COBRANÇA / GERAR BOLETO';
											$popup='<a href="#pop_escolha_'.$n.'" data-rel="popup" data-position-to="window" data-transition="pop">';
											$acao='popupPg';
										}else{
											$text_valor='<b>Valor Cobran�a:</b>R$ '.number_format(($linhas->valor_cobrancasfc+$linhas->valor_encargos_cobrancasfc), 2, ',', '.').'<br>';
											$text_sit="Cobrança $n - paga";	
											$cor='green';
											$text_cob='GERAR RECIBO';
											$acao='popupListPg';
											$popup='<a href="#popupListPg" id="'.$n.'" class="popup">';
										}
										// 
										echo '<li>';
										echo $popup;
										echo '<font color='.$cor.'><b>'.$text_sit.'</b></font><br>';
										echo $text_vencimento.'<br>';
										echo $text_valor;
										//
										$value='{"acao":"'.$acao.'","nome":"'.$nome_cliente.'","vencimento":"'.$text_vencimento.'","debitos":"'.number_format($linhas->debitos_cobrancasfc, 2, ',', '.').'","descontos":"'.number_format($linhas->descontos_cobrancasfc, 2, ',', '.').'","creditos":"'.number_format($linhas->pagamentos_creditos_cobrancasfc, 2, ',', '.').'","encargos":"'.number_format($linhas->valor_encargos_cobrancasfc, 2, ',', '.').'","t_valor":"'.$text_valor.'","recebido":"'.number_format($linhas->valor_atual_cobrancasfc, 2, ',', '.').'","data":"'.mostrarDataSimples($linhas->vencimento_cobrancasfc).'","id_cliente":"'.$linhas->id_cobrancasfc.'"}';
										echo "<input id='dados_$n' value='$value' type='hidden'>";
										echo '<center><font size=1 color=blue><< '.$text_cob.' '.$n.' >></font></center>';
										echo '</a>';
										echo '<div data-role="popup" id="pop_escolha_'.$n.'" data-theme="a" data-overlay-theme="b" class="ui-content" style="padding-bottom:2em;">';
										echo '<h3>'.$text_sit.'</h3>';
										echo '<a href="#popupPg" id="'.$n.'" class="popup ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">RECEBER COBRAN�A</a><a href="cob/boleto.php?id_cliente='.$linhas->id_cobrancasfc.'&data='.$linhas->vencimento_cobrancasfc.'&valor='.($linhas->valor_atual_cobrancasfc*1).'" target="_blank" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Gerar Boleto</a>';
										echo '</div>';
										echo '</li>';
										$n--;
									}
								}
							}
							?>
							</ul>
						</div><!-- /content -->
						<div data-role="footer" style="overflow:hidden;" data-position="fixed">
							<center>
								<font color="red" size="2"><?php echo $login_usuario;?></font><br>
				    			<a href="caixa.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
				    		</center>
						</div><!-- /header -->
						<script type="text/javascript">
						var origem='home';
						$(function(){
							$( "#calendario" ).datepicker();
							//
						    $('.money').maskMoney({prefix:'R$ ', decimal:',', affixesStay: true});
						    $('.time').mask('00:00:00');
						    $('.date_time').mask('00/00/0000 00:00:00');
						    $('.cep').mask('00000-000');
						    $('.phone').mask('0000-0000');
						    $('.phone_with_ddd').mask('(00) 0000-0000');
						    $('.phone_us').mask('(000) 000-0000');
						    $('.mixed').mask('AAA 000-S0S');
						    $('.ip_address').mask('099.099.099.099');
						    $('.percent').mask('##0,00%', {reverse: true});
						    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
						    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
							//
						    $(".datebox").datepicker({
						        dateFormat: 'dd/mm/yy',
						        dayNames: ['Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'],
						        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
						        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
						        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
						    });
							//
							var somarDesconto = function(tipo){
								if(tipo){
								    var desconto=$('#valor_desconto_caixafc').maskMoney('unmasked')[0]*1;
								    var valor_divida=intFormat($("#valor_divida_atual").html());
								    var valor_atual=(valor_divida-desconto);
									var valor_atual_real=decimalFormat(valor_atual);
								    $("#valor_divida_desconto").html(valor_atual_real);
								    if(valor_atual<0)
								    	valor_atual_real='R$ 0,00';
							    	//
							    	$('#valor_caixafc').val('R$ '+valor_atual_real); 
								}
								var valor_restante=intFormat($("#valor_divida_desconto").html())-$('#valor_caixafc').maskMoney('unmasked')[0];
								var tipo_restante='';
								if(valor_restante<0){
									valor_restante=valor_restante*-1;
									tipo_restante='CRÉDITO';
									$("#div-data-debitos").css("display", "none");
									$( "#tipo_valor_restante" ).attr( "color", "green");
								}else if(valor_restante>0){
									tipo_restante='D�BITO';
									$("#div-data-debitos").css("display", "block");
									$( "#tipo_valor_restante" ).attr( "color", "red");
								}
								//
								$("#valor_restante").html(decimalFormat(valor_restante));
								$("#tipo_valor_restante").html(tipo_restante);
							};
							$(".popup").click(function(){
								var valor=$("#dados_"+$(this).attr('id')).val();
								var obj = $.parseJSON(valor);
								//alert(obj);
								$("#nome_clientesfc").val(obj.nome);
								$("#id_clientesfc").val(obj.id_cliente);
								if(obj.acao=='popupPg'){
									$("#nome_cliente").html(obj.nome);
									$('#valor_caixafc').val(obj.recebido);
									$("#valor_divida_atual").html(obj.recebido);
									$("#valor_divida_desconto").html(obj.recebido);
									$("#id_cliente_caixafc").val(obj.id_cliente);
									$("#data_caixafc").val(obj.data);
								}else{
									$("#nome_cliente_pg").html(obj.nome);
									$("#data_mes_pg").html(obj.data);
									getLoading('Localizando Pagamentos...');
						  	    	$.ajax({url: '_dados.php',data:'cmd=busca&tipo=pagamentos&id_cliente_caixafc='+obj.id_cliente+'&data_caixafc='+obj.data,dataType: "json"}).then( function ( response ) {
						  	      		if(!response.auth) 
						  	      			location.reload();
						  	      		//
						  	      		var html='';
						  	      		if(response.qtd==0){
						  	      			html +="<li><font color='red'>Nenhum Pagamento</font>'</li>";
						  	      		}
						  	      		if(response.qtd!=0){
							  	      		$.each(response.suggestion, function ( i, dados ) {
							  	              	html += "<li><a onclick=\"gerarRecibo('"+dados.id+"','"+dados.name+"',true);\" href=\"#\">"+dados.name+"<BR><center><font size=1 color=green><< GERAR RECIBO >></font></center></a></li>";
							  	            });
						  	      		}
						  	      		$("#listpg").html(html);
						  	      		$("#listpg").listview("refresh");
						  	      		$("#listpg").trigger("updatelayout");
						  	          	$.mobile.loading("hide")
						  	      	});
								}
								//$("#id_cliente_caixafc").val(obj.id_cliente);
							});
						    $("#valor_desconto_caixafc").keyup(function(){
						    	somarDesconto(true);
						    });
						    $("#valor_caixafc").keyup(function(){
						    	somarDesconto(false);
						    });
							//
							$("#bt_cadastrar_recebimentos").click(function(){
								//VALIDA��O
								var validad=true;
								$("#popupPg input.required").each(function() {
									if($(this).val()==''){
										validad=false; 
									}
								});
								if(!validad)
									return false;
								//
								$.mobile.loading('show');
								$.post('_dados.php',{
									cmd: 'save',
									cache: false,
									tipo: 'caixa',
									tipo_caixafc: 'in',
									data_caixafc:$('#data_caixafc').val(),
									origem_caixafc:'local',
									especie_caixafc:$('#especie_caixafc').val(),
									data_credito_caixafc:$('#data_credito_caixafc').val(),
									id_cliente_caixafc:$('#id_cliente_caixafc').val(),
									valor_desconto_caixafc:$('#valor_desconto_caixafc').maskMoney('unmasked')[0],
									valor_caixafc:$('#valor_caixafc').maskMoney('unmasked')[0],
									data_inforpgfc:$('#data_inforpgfc').val()
								},function(data){
									var obj = $.parseJSON(data);
									gerarRecibo(obj.id_caixafc,obj.msg);
									$.mobile.loading("hide");
								});
							});
						}); 
						function gerarRecibo(id,msg,recibo){
							$.mobile.changePage("#cadastroFim");
							$("#nome_cliente_fim").html($("#nome_clientesfc").val());
							if(!recibo)
								$("#local_texto_retorno").html('Pagamento '+msg);
							else
								$("#local_texto_retorno").html('GERAR RECIBO - '+msg);
							//
							$(".recibos").each(function() {
								var tipo=$(this).attr("data-tg");
								if(tipo=='email')
									$("#id_caixafc").val(id);
								else
									$(this).attr("href", "cob/recibo.php?id_caixafc="+id+"&tipo="+tipo);
								//
							});
						}
						function enviarEmail(){
							$("#send_email").attr("href", "cob/recibo.php?id_caixafc="+$("#id_caixafc").val()+"&tipo=email&email="+$("#email").val());
						}
						function reload(){
							var url=location.href.split("#");
							location.href=url[0];
						}
					</script>
					<input id="id_clientesfc" type="hidden">
					<input id="nome_clientesfc" type="hidden">
				</div><!-- /page -->
				<div data-role="page" id="popupPg" style="width: 100%;">
					<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
						<div style="padding:5px 10px;">  
						    <center><b>Receber Pagamento<br><font color=blue id=nome_cliente></font></b></center>
						    <div class="ui-field-contain">
								<label for="valor_divida_atual">Valor Dívida:</label>
								R$ <font id="valor_divida_atual" class="money">0,00</font>
							</div>
						    <div class="ui-field-contain">
								<label for="valor_desconto_caixafc">Valor Desconto:</label>
								<input name="valor_desconto_caixafc" id="valor_desconto_caixafc" value="0,00" class="money" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="valor_divida_desconto">Dívida com Desconto:</label>
								R$ <font id="valor_divida_desconto" class="money">0,00</font>
							</div>
							<div class="ui-field-contain">
							    <label for="valor_caixafc">Valor Recebido:</label>
							    <input name="valor_caixafc" id="valor_caixafc" value="0,00" class="money" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="valor_divida_desconto">Valor Restante:</label>
								<font id="tipo_valor_restante"></font> R$ <font id="valor_restante" class="money">0,00</font>
							</div>
						    <div class="ui-field-contain" id="div-data-debitos" style="display: none;">
								<label for="data_inforpgfc">Data dos Débitos:</label>
								<input name="data_inforpgfc" id="data_inforpgfc" class="datebox" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="especie_caixafc">Tipo do Pagamento:</label>
								<select name="especie_caixafc" id="especie_caixafc" data-native-menu="false">
						          <option value="dinheiro"  selected>Dinheiro</option> 
						          <option value="cheque">Cheque</option> 
						          <option value="cartao-cred">Cartão Crédito</option>
						          <option value="cartao-debi">Cartão Débito</option>
						          <option value="deposito">Depósito</option>
						          <option value="outros">Outros</option>
						        </select>
							</div>
						    <div class="ui-field-contain">
								<label for="data_credito_caixafc">Data Crédito:</label>  
								<input name="data_credito_caixafc" id="data_credito_caixafc" value="<?php echo date("d/m/Y");?>" class="datebox" type="text">
							</div>
						    <div class="ui-field-contain">
								<label for="obs_caixafc">Observação/Descrição:</label>   
								<textarea name="obs_caixafc" id="obs_caixafc"></textarea>
							</div>
							<center>
							    <input name="data_caixafc" id="data_caixafc" type="hidden">
								<input name="id_cliente_caixafc" id="id_cliente_caixafc" type="hidden">
								<a href="#" data-rel="back" id='cancelar_cadastrar_recebimentos' class="ui-shadow ui-btn ui-btn-inline ui-icon-carat-l ui-btn-icon-right" data-transition="pop">Voltar</a>
								<button id="bt_cadastrar_recebimentos" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar</button>
							</center>
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
				<div data-role="page" id="popupListPg" style="width: 100%;">
					<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
						<div style="padding:5px 10px;">  
						    <center><b>Pagamentos<br><font color=blue id=nome_cliente_pg></font> - Mês<font color=blue id=data_mes_pg></font></b></center>
							<div style="padding:5px 10px;">  
							    <ul id="listpg" data-role="listview" data-inset="true"></ul>
							    
							</div>
							<center><a href="#home" class="ui-btn ui-btn-inline ui-shadow ui-btn-a ui-btn-icon-left ui-icon-carat-l">Voltar</a></center>
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
				<div data-role="page" id="cadastroFim" style="width: 100%;">
					<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
						<div style="padding:10px 20px;"> 
						    <center><h3>STATUS DO CADASTRO</h3>
						    	<font color=blue id=nome_cliente_fim></font><br><font color=blue size=5 id="local_texto_retorno"></font><Br><Br>Escolha abaixo para Gerar recibo<br>
								<a href="#home" onclick="reload();" class="ui-btn ui-btn-inline ui-shadow ui-btn-a ui-btn-icon-left ui-icon-carat-l">Voltar</a><br>
								<a data-tg="html" href="#" target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">HTML</a>
								<a data-tg="pdf" href="#" target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">PDF</a>
								<a data-tg="email" href="#" onclick='$("#end_email").css("display", "block")'; target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">Email</a>
							</center>	
							<div id="end_email" class="ui-field-contain" style="display: none;">
								<center>
									<label for="email">Digite o Email:</label>
									<input id="email" name="email" type="text">
									<input id="id_caixafc" type="hidden">
									<a id="send_email" href="#" onclick="enviarEmail();" target="_blank" class="ui-btn ui-btn-inline ui-shadow ui-btn-a ui-btn-icon-left ui-icon-edit">Enviar Email</a>
								</center>
							</div>	
						</div>
					</div><!-- /content -->
				</div><!-- /page -->
			</body>
		</html>
<?php 
	}
?>
*/
?>