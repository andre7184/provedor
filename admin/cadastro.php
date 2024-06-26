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
$page='cadastro.php';
require_once("_validar.php");
if(!$authSession){
	?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>CADASTRAR/ALTERAR CLIENTES - LOGIN</title>
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
			            var envio = $.post("_logar.php?page=<?php echo $page;?>", {login:$("#login").val(),senha:$("#senha").val()})
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
					<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRAR/ALTERAR CLIENTES - LOGIN</font></h3></center></div>
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
						<title>CADASTRAR/ALTERAR CLIENTES - GRUPO</title>
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
								<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRAR/ALTERAR CLIENTES - Grupo</font></h3></center></div>
							</div>
							<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
								<center>
									<form action="<?php echo $page;?>" method="post">
									    <select onchange="this.form.submit();" name="grupo" id="grupo" style="float:right;" data-native-menu="false">
									        <option value="">Selecione um Grupo</option>
									        <option value="lisboa">LISBOA</option> 
									        <option value="fazenda">FAZENDAS</option>
										    <option value="idealnet">IDEALNET</option>
										    <option value="tecnet">TECNET</option>
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
			$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>MKFÁCIL - CADASTRO</title>
				<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
				<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
				<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
				<link rel="stylesheet" href="_js/sd.min.css" />
				<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
				<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
				<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
				<script type="text/javascript" src="_js/mask.js"></script>
				<script type="text/javascript" src="_js/sd.min.js"></script>
				<script type="text/javascript">
				 	var ipage='';
				 	var itipo=''; 
				 	var iobj='';
				 	var iargs=''; 
				 	var iordem='';
				 	<?php echo $getLoading;?>
				 	function getCidades(n) {
						var sigra=$("#uf"+n+"_clientesfc").val();
						getLoading('Buscando Cidades, aguarde...');	
						$.ajax({url: '_estados_cidades.php',data:'sigra='+sigra,dataType: "json"}).then( function (retorno) {
							if(retorno.cidades!='')
								$("#cid"+n+"_clientesfc").children().remove();
							$.each(retorno.cidades, function(key, value){
								if(value=='Campo Grande')
									$("#cid"+n+"_clientesfc").append($(document.createElement('option')).attr("value",value).text(value).attr('selected', true));
								else
									$("#cid"+n+"_clientesfc").append($(document.createElement('option')).attr("value",value).text(value));
							});	
							//$("#cid"+n+"_clientesfc").html(option);
							$("#cid"+n+"_clientesfc").change();
							$("#cid"+n+"_clientesfc").selectmenu('refresh', true);
							$.mobile.loading("hide")
						});		
					}
				 	function getEnd(n) {
						var cep=$('#cep'+n+'_clientesfc').val();
						var valEnd={cep:'cep'+n+'_clientesfc',logradouro:'end'+n+'_clientesfc',numero:'num'+n+'_clientesfc',bairro:'bar'+n+'_clientesfc',cidade:'cid'+n+'_clientesfc',uf:'uf'+n+'_clientesfc'};
						if($.trim(cep) != ""){
							getLoading('Buscando Endereço, aguarde...');
							$.getScript("_dados.php?cmd=busca&tipo=end&formato=javascript&cep="+cep, function(){
						  		if(resultadoCEP["resultado"]){
						  			$("#"+valEnd.logradouro).val(unescape(resultadoCEP["tipo_logradouro"]).toUpperCase()+' '+unescape(resultadoCEP["logradouro"]).toUpperCase());
						  			$("#"+valEnd.bairro).val(unescape(resultadoCEP["bairro"]).toUpperCase());
						  			$("#"+valEnd.cidade).val(unescape(resultadoCEP["cidade"]).toUpperCase()); 
						  			$("#"+valEnd.uf).val(unescape(resultadoCEP["uf"]).toUpperCase());
						  			$.mobile.loading("hide");
						  			//showPopup({title: "Sucesso!", message: "Cep "+cep+" correto, End:"+resultadoCEP['tipo_logradouro']+" "+resultadoCEP['logradouro']+"!", buttonText: "I know!", width: "500px"});
								}else{
									//showPopup({title: "Error", message: 'Cep não encontrado!', buttonText: "I know!", width: "500px"});
									//$("#popupDialog").popup("open");
									$.mobile.loading("hide");
									alert('Nenhum endereço encontrado!');
								}
							});			
						}else{
							$("#"+valEnd.cep).focus();
							alert('Preencha corretamento o cep!');
						}	
					}
					function getCep(n) {
						var valEnd={cep:'cep'+n+'_clientesfc',logradouro:'end'+n+'_clientesfc',numero:'num'+n+'_clientesfc',bairro:'bar'+n+'_clientesfc',cidade:'cid'+n+'_clientesfc',uf:'uf'+n+'_clientesfc'};
						var uf=$("#"+valEnd.uf).val();
						var cid=$("#"+valEnd.cidade).val();
						var log=$("#"+valEnd.logradouro).val();
						var end='';
						if(uf!='' && cid!='' && log!=''){
							end=uf+'/'+cid+'/'+log;
						}
						if(end != ''){
							alert(end);
							getLoading('Buscando Cep, aguarde...');
							$.ajax({
					  	    		url: "https://viacep.com.br/ws/"+end+"/json/",
					  	    		dataType: "json",
					  	    		crossDomain: !0
					  	      	}).then( function (results) {
								$.mobile.loading("hide");
								//alert(results);
								if(results.length!=0){
									var output = [];
									$.each(results, function( key1, val1 ) {
										//alert(val1.formatted_address)
										if(val1.cep!='')
											output.push('<li><a onclick="$(\'#'+valEnd.cep+'\').val(\''+val1.cep+'\');$(\'#'+valEnd.logradouro+'\').val(\''+val1.logradouro+'\');$(\'#'+valEnd.bairro+'\').val(\''+val1.bairro+'\');$.mobile.sdCurrentDialog.close();">'+val1.cep+' - '+val1.logradouro+', '+val1.bairro+'</a></li>');
										//
									});
									//alert(output);
									if(output.length>0){
										$('<div>').simpledialog2({
								            mode: 'blank',
								            headerText: "Cep(s) ("+output.length+")",
								            width:'600px',
								            headerClose: true,
								            transition: 'flip',
								            themeDialog: 'a',
								            zindex: 2000,
								            blankContent : 
								              "<div id='text_popup' style='padding: 15px;'>"+
								              "<ul data-role='listview'>"+output.join('')+"</ul>"+
								              "<a rel='close' data-role='button' href='#'>FECHAR</a></div>"
								        }); 
									}else{
										alert("Nenhum cep encontrado!");
									}
								}else{
									alert('Nenhum cep encontrado!');
								}
							});
						}else{
							$("#"+valEnd.logradouro).focus();
							alert('Preencha corretamento o endereço!');
						}	
					}
					//
					var interval = 0;
				  	function AutoCompleteText(obj,idp){		
				  		var idul=false;
				  		if(obj.attr("data-id-ul") && obj.attr("data-id-ul")!='' && $("#"+obj.attr("data-id-ul")).is("ul")){
				  			idul=obj.attr("data-id-ul");
				  			if(obj.attr("data-name-input"))
				  				obj.attr("name",obj.attr("data-name-input"));
				  			//
				  		}else{
				  			idul=getPassword('ul_',6);
				  			$(obj).after('<ul id="'+idul+'" data-role="listview" data-inset="true"></ul>');
				  			$("#"+idul).listview();
				  			obj.attr("data-id-ul",idul);
				  			if(obj.attr("data-name-input"))
				  				obj.attr("name",obj.attr("data-name-input"));
				  			//
				  		}
				  			var value = obj.val();
				  	        var html = "";
				  	      	$("#"+idul).html("");
				  	      	var dataUrl = obj.attr("data-url").replace("{val}", value);
				  	      	var dataData='';
				  	      	var q = dataUrl.indexOf("?");
				  			if(q>0){
				  				dataData=dataUrl.substr(q+1);
				  				dataUrl=dataUrl.substr(0,q);
				  			}
				  	      	var titulo='';
				  	      	var newitem='';
				  	      	var match='';
				  	      	var idclick='';
				  	    	var loadclick='';
				  	  		var color='red';
				  	  		var dataDelay=100;
				  	  		var dataSpeed='';
				  	  		var useCache='';
				  	  		var useTimeout='';
				  	  		var loading='';
				  	  		var minlen='';
				  	  		var argsSend='';
				  			if(obj.attr("data-titulo")){
				  				titulo=obj.attr("data-titulo");
				  			}
				  			if(obj.attr("args-send-value")){
				  				var argSarray=obj.attr("args-send-value").split("|");
				  				argsSend='&'+argSarray[0]+'='+$("#"+argSarray[1]).val();
				  			}
				  			if(obj.attr("data-newitem")){
				  				newitem=obj.attr("data-newitem");
				  			}
				  			if(obj.attr("data-no-match")){
				  				match=obj.attr("data-no-match");
				  			}
				  			if(obj.attr("data-id-click")){
				  				idclick=obj.attr("data-id-click");
				  			}
				  			if(obj.attr("data-load-click")){
				  				loadclick=obj.attr("data-load-click");
				  			}
				  			if(obj.attr("data-color")){
				  				color=obj.attr("data-color");
				  			}
				  			if(obj.attr("data-loading")){
				  				loading=obj.attr("data-loading");
				  			}
					  		if(obj.attr("data-speed")) try{
								dataSpeed=parseInt(obj.attr("data-speed"));
							}catch(x){
								dataSpeed=200;
							}
				  	      	if (obj.attr("data-delay")) try {
				  	      		dataDelay = parseInt(obj.attr("data-delay"))
				  	      	} catch (x) {
				  	      		dataDelay=1000;
				  	      	}
				  	      	if (obj.attr("data-cache")) try {
				  	      		useCache = parseBool(obj.attr("data-cache"))
				  	      	} catch (x) {
				  	      		useCache = !0;
				  	      	}
				  	      	if (obj.attr("data-timeout")) try {
				  	      		useTimeout = parseInt(obj.attr("data-timeout"))
				  	      	} catch (x) {
				  	        	useTimeout = 0;
				  	      	}
				  	      	if (obj.attr("data-minlen")) try {
				  	      		minlen = parseInt(obj.attr("data-minlen"))
				  	      	} catch (x) {
				  	      		minlen = 1;
				  	      	} 
				  	      	clearInterval(interval);
				  	      	interval = window.setTimeout(function(){
					  	      	var val=obj.val().trim();
			  	        		if (val.length >= minlen) {
			  	        			var callData=dataData+argsSend;
			  	        			var loading = loading || $.mobile.loader.prototype.options.text;
						  	        getLoading(loading);
						  	    	$.ajax({
						  	    		url: dataUrl,
						  	            data: callData,
						  	            cache: useCache,
						  	            dataType: "json",
						  	            crossDomain: !0,
						  	            timeout: useTimeout
						  	      	}).then( function ( response ) {
						  	      		if(!response.auth) 
						  	      			location.reload();
						  	      		//
						  	      		if(response.qtd==0){
						  	      			if(newitem)
						  	      				html +="<li><a href=\"#"+newitem+"\"><font size='2'>Cadastrar Novo</font></a></li>";
						  	      			else if(match!='')
						  	      				html +="<li>"+match+" com '<font color=\""+color+"\">"+response.query+"</font>'</li>";
						  	      		}
						  	      		if(response.qtd!=0){
							  	      		if(titulo!='')
							  	      			html += "<li><center><b>"+titulo+"</b></center></li>";
							  	      		//
							  	      		$.each(response.suggestion, function ( i, dados ) {
							  	         		var resultado = dados.name;
							  	              	if (loadclick != ''){
							  	              		loadclick += "('"+idp+"','"+dados.id+"','"+idul+"')";
							  	              	}
							  	              	var reg = RegExp("("+response.query+")",'gi'); 
							  	              	//alert(reg);
							  	              	var textname = dados.name.replace(reg,"<font color='"+color+"'>$1</font>");
							  	              	//alert(textname);
							  	              	html += "<li><a onclick=\"ocac('"+dados.id+"','"+resultado+"','"+idclick+"','"+idul+"');"+loadclick+";\" href=\"#\">"+textname+"</a></li>";
							  	            });
						  	      			if(newitem)
						  	      				html +="<li><a href=\"#"+newitem+"\"><font size='2'>Cadastrar Novo</font></a></li>";
						  	      		}
						  	      		$("#"+idul).html(html);
						  	      		$("#"+idul).listview("refresh");
						  	      		$("#"+idul).trigger("updatelayout");
						  	          	$.mobile.loading("hide")
						  	          	
						  	      	});
			  	        		}
			  	    		}, dataDelay);
				  	      	
			  		}
			  		//
				  	function ocac(id,value,idclick,idul){
						if(idclick && idclick!='')
							if($("#"+idclick).is("input"))
								$("#"+idclick).val(id);
							else
								$("#"+idclick).html(id);
						//
						$('input[data-id-ul="'+idul+'"]').val(value);
						$("#"+idul+" li").remove();
						$("#"+idul).listview("refresh");
						$("#"+idul).remove();
					}
					//
					function getPassword(iniciais,qtd) {
						if(!iniciais)
							var iniciais=""
									var rc = iniciais;
						var numberChars = "0123456789";
						var count = qtd-rc.length;
						for (var idx = 1; idx <= count; ++idx) {
							rc = rc + numberChars.charAt(Math.floor(Math.random() * (numberChars.length - 0)) + 0);
						}
						return rc;
					}																			
					//
					function loadSecrets(a,b,c){
						if($("#id_secret_add").val()=='new'){
							
						}
					}
					//
					function alteraDB(tipo,id){
						$("#title_cadastro_"+tipo).html('Alterar');
						getLoading('Localizando '+tipo+' de id:'+id+'...');
					    $.ajax({url: '_remote.php',data:'cmd=load&tipo='+tipo+'&id='+id,dataType: "json"}).then( function (retorno) {
							$.mobile.loading("hide");
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
							}
						});
					}
					//
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
							dados=JSON.parse(dados);
							$(location).attr('href', 'cadastro.php?msg_retorno=Ok,'+dados.msg);
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
			<body onload="<?php if($tipo && $id){echo "alteraDB('$tipo','$id');";}else{echo "getCidades('1');getCidades('2');";}?>"> 
				<div data-role="page" id="home" data-theme="a" style="width: 100%;">
					<div data-role="header" style="overflow:hidden;" data-position="fixed">
						<div data-role="navbar"><center><h3><font color=red id="resultado">CADASTRO/ALTERAR CLIENTES</font></h3></center></div>
					</div>
					<div role="main" class="ui-content" style="max-width:700px;margin: 0 auto;">
						<center>
							<div id="cadastro_clientes" style="padding:5px 10px;margin:5px">
								<fonte style="font-size: 16px;font-weight: bold;"><font id=title_cadastro_clientes>Cadastrar</font> Cliente</font>
								<?php if($grupo) echo "<fonte style=\"font-size: 12px;font-weight: bold;\">(GRUPO $grupo)</font>";?>
								<div data-role="collapsible" data-collapsed="false">
									<legend>Dados Pessoais</legend>
									<div class="ui-field-contain">
										<div style="height: 25px;display: table;">
											<font style="font-size: 14px;font-weight: bold;display: table-cell;vertical-align:middle;">Pessoa Jurídica: </font>
											<select name="pessoa_juridica_clientesfc" id="pessoa_juridica_clientesfc" data-role="slider" data-mini="true">
												<option value="">Off</option>
												<option value="on">On</option>
											</select>
										</div>
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Nome:</font>
										<input onkeyup="$(this).val($(this).val().toUpperCase());" name="nome_clientesfc" id="nome_clientesfc" placeholder="Nome" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Razão Social:</font>
										<input name="razao_social_clientesfc" id="razao_social_clientesfc" placeholder="Razão Social(jurídica)" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Rg/IE:</font>
										<input name="rg_ie_clientesfc" id="rg_ie_clientesfc" placeholder="RG/Incrição Estatual" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Cpf/Cnpj:</font>
										<input name="cpf_cnpj_clientesfc" id="cpf_cnpj_clientesfc" placeholder="Cpf/Cnpj" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Responsavel:</font>
										<input name="responsavel_clientesfc" id="responsavel_clientesfc" placeholder="Responsavel(jurídica)" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Data Nascimento:</font>
										<input name="data_nascimento_clientesfc" id="data_nascimento_clientesfc" placeholder="Nascimento"  class="date" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">E-mail:</font>
										<input name="email_clientesfc" id="email_clientesfc" placeholder="E-mail"  type="text">
									</div>
								</div> 
								<div data-role="collapsible" data-collapsed="false"> 
									<legend>Endereço Cobrança/instalação</legend>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Cep:</font>
										<input name="cep1_clientesfc" size="10" id="cep1_clientesfc" class="cep" type="text" placeholder="Cep" class="ui-mini">
									</div>
									<div class="ui-field-contain">
										<a href="#" onclick="getEnd('1');" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Endereço</a>
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Logradouro:</font>
										<input name="end1_clientesfc" id="end1_clientesfc" placeholder="Logradouro" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Número:</font>
										<input name="num1_clientesfc" id="num1_clientesfc" placeholder="Número" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Complemento:</font>
										<input name="comp1_clientesfc" id="comp1_clientesfc" placeholder="Complemento" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">bairro:</font>
										<input name="bar1_clientesfc" id="bar1_clientesfc" placeholder="Bairro" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Uf:</font>
										<select onchange="getCidades('1');" name="uf1_clientesfc" id="uf1_clientesfc" data-native-menu="true" class="ui-mini">
											<option value="0">Estado</option>
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
										<font style="font-size: 10px;">Cidade:</font>
										<select name="cid1_clientesfc" id="cid1_clientesfc">
											<option value="">Selecione o estado antes</option>
										</select>
									</div>
									<div class="ui-field-contain">
										<a href="#" onclick="getCep('1');"class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar CEP</a>
									</div>
									<div class="ui-field-contain">
										<a href="#" onclick="" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-left ui-icon-search">Localizar Latitude/Longitude</a>
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Latitude:</font>
										<input name="lat1_clientesfc" id="lat1_clientesfc" placeholder="Latitude" type="text">
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Longitude:</font>
										<input name="long1_clientesfc" id="long1_clientesfc" placeholder="Longitude" type="text">
									</div>
								</div>
								<div data-role="collapsible" data-collapsed="false">
									<legend>Telefone 1:</legend>
									<div class="ui-field-contain">
										<input name="tel1_clientesfc" id="tel1_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone 1" data-mini="true">
										<select name="op1_clientesfc" id="op1_clientesfc" data-mini="true">
											<option value="" select>Oper</option>
											<option value="OI">Oi</option>
											<option value="VIVO">Vivo</option>
											<option value="CLARO">Claro</option>
											<option value="TIM">Tim</option>
											<option value="NET">Net</option>
											<option value="NEXTEL">Nextel</option>
											<option value="FIXO">Fixo</option>
										</select>
										<div style="height: 25px;display: table;">
											<font style="font-size: 14px;font-weight: bold;display: table-cell;vertical-align:middle;">WhatsApp: </font>
											<select name="wsap1_clientesfc" id="wsap1_clientesfc" data-role="slider" data-mini="true">
												<option value="">Off</option> 
												<option value="on">On</option>
											</select>
										</div>
										<input name="nome1_clientesfc" id="nome1_clientesfc" type="text" placeholder="Nome Contato 1" data-mini="true">
									</div>
								</div>
								<div data-role="collapsible" data-collapsed="true">
									<legend>Telefone 2:</legend>
									<div class="ui-field-contain">
										<input name="tel2_clientesfc" id="tel2_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone 2" data-mini="true">
										<select name="op2_clientesfc" id="op2_clientesfc" data-mini="true">
											<option value="" select>Oper</option>
											<option value="OI">Oi</option>
											<option value="VIVO">Vivo</option>
											<option value="CLARO">Claro</option>
											<option value="TIM">Tim</option>
											<option value="NET">Net</option>
											<option value="NEXTEL">Nextel</option>
											<option value="FIXO">Fixo</option>
										</select>
										<div style="height: 25px;display: table;">
											<font style="font-size: 14px;font-weight: bold;display: table-cell;vertical-align:middle;">WhatsApp: </font>
											<select name="wsap2_clientesfc" id="wsap2_clientesfc" data-role="slider" data-mini="true">
												<option value="">Off</option> 
												<option value="on">On</option>
											</select>
										</div>
										<input name="nome2_clientesfc" id="nome2_clientesfc" type="text" placeholder="Nome Contato 2" data-mini="true">
									</div>
								</div>
								<div data-role="collapsible" data-collapsed="true">
									<legend>Telefone 3:</legend>
									<div class="ui-field-contain">
										<input name="tel3_clientesfc" id="tel3_clientesfc" class="phone_with_ddd" type="text" placeholder="Telefone 3" data-mini="true">
										<select name="op3_clientesfc" id="op3_clientesfc" data-mini="true">
											<option value="" select>Oper</option>
											<option value="OI">Oi</option>
											<option value="VIVO">Vivo</option>
											<option value="CLARO">Claro</option>
											<option value="TIM">Tim</option>
											<option value="NET">Net</option>
											<option value="NEXTEL">Nextel</option>
											<option value="FIXO">Fixo</option>
										</select>
										<div style="height: 25px;display: table;">
											<font style="font-size: 14px;font-weight: bold;display: table-cell;vertical-align:middle;">WhatsApp: </font>
											<select name="wsap3_clientesfc" id="wsap3_clientesfc" data-role="slider" data-mini="true">
												<option value="">Off</option> 
												<option value="on">On</option>
											</select>
										</div>
										<input name="nome3_clientesfc" id="nome3_clientesfc" type="text" placeholder="Nome Contato 3" data-mini="true">										    
									</div>
								</div>
								<div data-role="collapsible" data-collapsed="false">
									<legend>Configurações de Cobrança</legend>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Vencimento:</font>
										<select name="venc_clientesfc" id="venc_clientesfc" data-native-menu="true">
										   	<option value="">Vencimento</option>
										    <option value="5">05</option>
										    <option value="6">06</option>
										    <option value="7">07</option>
										    <option value="8">08</option>
										    <option value="9">09</option>
										    <option value="10">10</option>
										    <option value="11">11</option>
										    <option value="12">12</option>
										    <option value="13">13</option>
										    <option value="14">14</option>
										    <option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
										</select>
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Desativar Juros e Multa:</font>
										<select name="desativar_juros_clientesfc" id="desativar_juros_clientesfc" data-role="slider" data-mini="true">
											<option value="">Off</option>
											<option value="on">On</option>
										</select>
									</div>
									<div class="ui-field-contain">
										<font style="font-size: 10px;">Desativar Bloqueio Automático:</font>
										<select name="destivar_bloqueio_clientesfc" id="destivar_bloqueio_clientesfc" data-role="slider" data-mini="true">
											<option value="">Off</option>
											<option value="on">On</option>
										</select>
									</div>
									<div class="ui-field-contain"> 
										<font style="font-size: 10px;">Obs:</font>
										<textarea cols="40" rows="8" name="obs_clientesfc" id="obs_clientesfc" placeholder="Obs." data-mini="true"></textarea>
									</div>
								</div>
								<input data-fix=true name="cmd" value="save" type="hidden">
								<input data-fix=true name="cache" value="false" type="hidden">
								<input data-fix=true name="tipo" value="cliente" type="hidden">
								<input name="id_clientesfc" id="id_clientesfc" type="hidden">
								<fieldset class="ui-grid-a">
	                    			<div class="ui-block-a">
										<button onclick="salvaDados('cadastro_clientes');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Salvar</button>
									</div>
	                    			<div class="ui-block-b">
										<a href="cadastro.php?logout=true" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">LOGOUT</a>					
									</div>
								</fieldset> 
							</div>
						</center> 
					</div><!-- /content -->
					<div data-role="footer" style="overflow:hidden;" data-position="fixed">
						<center>
							<font color="red" size="2"><?php echo $login_usuario;?></font><br>
				    		<a href="cadastro.php?logout=true" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-mini">SAIR</a>
				    	</center>
					</div><!-- /header -->
				</div>
			</body>
		</html>
<?php 
		}
	}
?>