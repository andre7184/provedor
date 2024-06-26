<?php 
		$nomeSession='authAdminPG';
		session_name($nomeSession);
		session_start($nomeSession);
		include_once( "../_funcoes.php");
		$error = $_REQUEST["error"];
		//
		$logout = isset($_REQUEST["logout"]) ? $_REQUEST["logout"] : false;
		if($logout){
			session_destroy();
			$auth=false;
		}
		//
		$sit_cobrancas=isset($_REQUEST["sit_cobrancas"]) ? $_REQUEST["sit_cobrancas"] : false;
		if(!$sit_cobrancas)
			$sit_cobrancas='ab';
		//
		$cpf_cnpj = isset($_REQUEST["cpf_cnpj"]) ? $_REQUEST["cpf_cnpj"] : false;
		if(!$cpf_cnpj){
			$cpf_cnpj = isset($_SESSION["cpf_cnpj"]) ? $_SESSION["cpf_cnpj"] : false;
		}
		if($cpf_cnpj && !$logout){
			require_once( "../_conf.php");
			conecta_mysql();	//concecta no banco myslq
			$consulta = mysql_query("select * from fc_clientes AS c
					INNER JOIN fc_provedor AS p ON p.id_provedorfc=c.id_provedor
					WHERE c.cpf_cnpj_clientesfc='".preg_replace("/[^0-9]/","", $cpf_cnpj)."'");
			$campos = mysql_num_rows($consulta);
			if($campos != 0) {
				// se o usuario existi verifica a senha dele
				$id_cliente=mysql_result($consulta,0,"id_clientesfc");
				$nome_cliente=mysql_result($consulta,0,"nome_clientesfc");
				$nome_provedor=mysql_result($consulta,0,"nome_provedorfc");
				$auth=true;
				$_SESSION["cpf_cnpj"]=$cpf_cnpj;
				$_SESSION["id_cliente"]=$id_cliente;
				$_SESSION["auth"]=$auth;
				//
				$resultado = mysql_query("UPDATE fc_user SET datatime_userfc=NOW() WHERE id_userfc='".$id_usuario."'") or die ("error");
			}else{
				$error='CPF/CNPJ inválido ou não cadastrado!';
			}
		}else{
			$error='<font color=blue>Digite seu CPF/CNPJ</font>';
		}
		$title = 'COBRANÇAS - '.$nome_provedor;
	?>
<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <title><?php echo $title;?></title>
		<link rel="stylesheet" href="../_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="../_js/jquery/jquery-ui.min.css" />
		<script src="../_js/jquery/jquery-1.11.3.min.js"></script>
		<script src="../_js/jquery/jquery-mobile-1.4.5.min.js"></script>
		<script src="../_js/jquery/jquery-ui.min.js"></script>
		<script src="../_js/mask.js"></script>
		<script src="../_js/mask_real.js"></script>
		<script src="../_js/funcoes.js"></script>
		<script src="../_js/auto_complete.js"></script> 
    </head>
    <body>
	    <div data-role="page" id="home"  data-theme="a" >
	    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
	    		<center><?php echo $title;?><br>
				<?php 
				$error = $error ? $error : false;
				if($auth && !$error){
					echo "<font color=blue>$nome_cliente<br>$cpf_cnpj</font>";
				}else{
					echo "<font color=red>$error</font>";
				}
				?>
				</center>
			</div><!-- /header -->
			<?php 
			if(!$auth){
			?>
				<center>
				    <form id="form1" name="form1" method="post" action="index.php">
					    <table border="0">
					    <tr>
					    <td><span class="Style6">CPF OU CNPJ:</span></td>
					    <td><span class="Style6">
					    <label>
					    <input name="cpf_cnpj" type="text" id="cpf_cnpj" />
					    </label>
					    </span></td>
					    </tr>
					    <tr>
					    <td>&nbsp;</td>
					    <td><span class="Style6">
					    <label>
					    <input type="submit" name="Submit" value="OK" />
					    </label>
					    </span></td>
					    </tr>
					    </table>
				    </form>
				</center>
			<?php
			}else{
				//
			?>
				<div role="main" class="ui-content">
					<ul data-role="listview" data-split-icon="action" data-split-theme="a" data-inset="true">
						<center>
							<a href="#" onclick="location.href='index.php?sit_cobrancas=ab'" data-icon="home" <?php if($sit_cobrancas=='ab')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Em aberto</a>
							<a href="#" onclick="location.href='index.php?sit_cobrancas=pg'" data-icon="home" <?php if($sit_cobrancas=='pg')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>Pagas</a>
							<a href="#" onclick="location.href='index.php?sit_cobrancas=all'" data-icon="home" <?php if($sit_cobrancas=='all')echo 'class="ui-btn-active ui-btn ui-btn-inline ui-mini"';else echo 'class="ui-btn ui-btn-inline ui-mini"';?>>All</a>
						</center>	
							<?php 
						    	$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : false;
						    	if($sort){
						    		$chars = array('\\', '//', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
						    		$data = str_replace($chars, "", $sort);
						    		$data_array = json_decode(utf8_encode($data), true);
						    		$order=" ORDER BY ".$data_array[0][property]." ".$data_array[0][direction];
						    	}else{
						    		$order=" ORDER BY vencimento_cobrancasfc DESC";
						    	}
						    	if($id_cliente!='')
						    		$busca="id_cobrancasfc='".$id_cliente."'";
						    	//
						    	$data_vencimento = isset($_REQUEST["data_vencimento"]) ? $_REQUEST["data_vencimento"] : false;
						    	if ($data_vencimento){
						    		if($busca!='')
						    			$busca.=" AND ";
						    		//
						    		$busca.="vencimento_cobrancasfc='".$data_vencimento."'";
						    	}
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
										$linha=mysql_fetch_object(mysql_query("SELECT sum(valor_atual_cobrancasfc) AS valor_total, min(vencimento_cobrancasfc) AS vencimento FROM `fcv_cobrancas` WHERE id_cobrancasfc='".$id_cliente."' GROUP BY id_cobrancasfc"));
										echo '<li>';
											echo '<a href="boleto.php?data='.$linha->vencimento.'&valor='.($linha->valor_total*1).'" target="_blank" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">';
											echo '<b>Dívida Total</b><br>';
											echo '<b>Valor Total:</b>R$ '.number_format($linha->valor_total, 2, ',', '.').'<br>';
											echo '<center><font size=1 color=red><< Gerar Boleto do Valor Total >></font></center>';
											echo '</a>';
										echo '</li>';
									}
									$resultadoDados = mysql_query($select." ".$order) or die ('Não foi possível realizar a consulta ao banco de dados linha 98');
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
						    				$cor='Gold';
						    			}
						    			if($linhas->valor_atual_cobrancasfc*1 > 0){
						    				$text_valor='<b>Valor atualizado:</b> R$ '.number_format($linhas->valor_atual_cobrancasfc, 2, ',', '.').'<br>';
						    				$text_sit="Cobrança $n - $status_cobrancas";
						    				$botoes='<a href="boleto.php?data='.$linhas->vencimento_cobrancasfc.'&valor='.($linhas->valor_atual_cobrancasfc*1).'" target="_blank" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Gerar Boleto</a>';
										}else{
						    				$text_valor='<b>Valor Cobrança:</b> R$ '.number_format(($linhas->valor_cobrancasfc+$linhas->valor_encargos_cobrancasfc), 2, ',', '.').'<br>';
						    				$text_sit="Cobrança $n - paga";
						    				$cor='green';
						    				$botoes='<a href="#popupListPg" onclick="listPgs(\''.$nome_cliente.'\',\''.mostrarDataSimples($linhas->vencimento_cobrancasfc).'\');" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Gerar Recibo</a>';
						    			}
										$botoes.='<a href="#" data-rel="back" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">Cancel</a>';
										// 
										echo '<li>';
										echo '<a href="#infor_'.$n.'" data-rel="popup" data-position-to="window" data-transition="pop">';
										echo '<font color='.$cor.'><b>'.$text_sit.'</b></font><br>';
										echo $text_vencimento.'<br>';
										echo $text_valor;
										//
										echo '<center><font size=1 color=red><< + INFORMAÇÕES >></font></center>';
										echo '</a>';
										echo '<a href="#action_'.$n.'" data-rel="popup" data-position-to="window" data-transition="pop">';
										echo '';
	    								echo '</a>';
										//
										echo '</li>';
										echo '<div data-role="popup" id="infor_'.$n.'" data-theme="a" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">';
										echo '<h3>'.$text_sit.'</h3>';
										echo $text_vencimento.'<br>';
										echo '<b>Débitos:</b> + R$ '.number_format($linhas->debitos_cobrancasfc, 2, ',', '.').'<br>';
										echo '<b>Descontos:</b> - R$ '.number_format($linhas->descontos_cobrancasfc, 2, ',', '.').'<br>';
										echo '<b>Juros/Encargos:</b> + R$ '.number_format($linhas->valor_encargos_cobrancasfc, 2, ',', '.').'<br>';
										echo $text_valor;
										echo '<b>Pagamentos/Créditos:</b> - R$ '.number_format($linhas->pagamentos_creditos_cobrancasfc, 2, ',', '.').'<br>';
										echo '<b>Valor Restante:</b> = R$ '.number_format($linhas->valor_atual_cobrancasfc, 2, ',', '.').'<br>';
										echo $botoes;
										echo '</div>';
										echo '<div data-role="popup" id="action_'.$n.'" data-theme="a" data-overlay-theme="b" class="ui-content" style="padding-bottom:2em;">';
										echo '<h3>'.$text_sit.'</h3>';
										echo $botoes;
										echo '</div>';
										$n--;
									}
								}	
							?>
					</ul>
				</div><!-- /content -->
				<div data-role="footer" style="overflow:hidden;" data-position="fixed">
		    		<ul data-role="listview" data-split-theme="a" data-inset="true"><li><a href="index.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini"><center><< SAIR >></center></a></li></ul>
				</div><!-- /header -->
				<style type="text/css">
	
				</style>
				<script type="text/javascript">
				function listPgs(nome,data){
					$("#nome_cliente_pg").html(nome);
					$("#data_mes_pg").html(data);
					//alert(obj);
					getLoading('Localizando Pagamentos...');
		  	    	$.ajax({url: '../remote.php',data:'cmd=busca&tipo=pagamentos&data_caixafc='+data,dataType: "json"}).then( function ( response ) {
		  	      		if(!response.auth) 
		  	      			location.reload();
		  	      		//
		  	      		var html='';
		  	      		if(response.qtd==0){
		  	      			html +="<li><font color='red'>Nenhum Pagamento</font>'</li>";
		  	      		}
		  	      		if(response.qtd!=0){
			  	      		$.each(response.suggestion, function ( i, dados ) {
			  	              	html += "<li><a onclick=\"gerarRecibo('"+dados.id+"','"+dados.name+"');\" href=\"#\">"+dados.name+"<BR><center><font size=1 color=green><< GERAR RECIBO >></font></center></a></li>";
			  	            });
		  	      		}
		  	      		$("#listpg").html(html);
		  	      		$("#listpg").listview("refresh");
		  	      		$("#listpg").trigger("updatelayout");
		  	          	$.mobile.loading("hide")
		  	      	});
				}
				function gerarRecibo(id,msg){
					$.mobile.changePage("#cadastroFim");
					$("#local_texto_retorno").html('GERAR RECIBO - '+msg);
					//
					$(".recibos").each(function() {
						var tipo=$(this).attr("data-tg");
						if(tipo=='email')
							$("#id_caixafc").val(id);
						else
							$(this).attr("href", "recibo.php?id_caixafc="+id+"&tipo="+tipo);
						//
					});
				}
				function enviarEmail(){
					$("#send_email").attr("href", "recibo.php?id_caixafc="+$("#id_caixafc").val()+"&tipo=email&email="+$("#email").val());
				}
				</script>
				<?php 
			}
			?>
		</div><!-- /page -->
		<div data-role="page" id="popupListPg">
			<div role="main" class="ui-content">
				<div style="padding:5px 10px;">  
				    <center><b>Pagamentos<br><font color=blue id=nome_cliente_pg></font> - Mês<font color=blue id=data_mes_pg></font></b></center>
					<div style="padding:5px 10px;">  
					    <ul id="listpg" data-role="listview" data-inset="true"></ul>
					</div>
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
		<div data-role="page" id="cadastroFim">
			<div role="main" class="ui-content">
				<div style="padding:10px 20px;"> 
				    <center>
				    	<font color=blue size=5 id="local_texto_retorno"></font><Br><Br>Escolha abaixo para Gerar recibo<br>
						<a href="#home" class="ui-btn ui-shadow ui-corner-all ui-icon-carat-l ui-btn-icon-notext"></a>
						<a data-tg="html" href="#" target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">HTML</a>
						<a data-tg="pdf" href="#" target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">PDF</a>
						<a data-tg="email" href="#" onclick='$("#end_email").css("display", "block")'; target="_blank" class="recibos ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-edit">Email</a>
					</center>	
					<div id="end_email" class="ui-field-contain" style="display: none;">
						<center>
							<input id="email" name="email" type="text" placeholder="Digite o E-mail">
							<input id="id_caixafc" type="hidden">
							<a id="send_email" href="#" onclick="enviarEmail();" target="_blank" class="ui-btn ui-btn-inline ui-shadow ui-btn-a ui-btn-icon-left ui-icon-edit">Enviar Email</a>
						</center>
					</div>	
				</div>
			</div><!-- /content -->
		</div><!-- /page -->
	</body>
</html>