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
$page='edit_secrets.php';
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
			            var envio = $.post("_logar.php?page=edit_secrets.php", {login:$("#login").val(),senha:$("#senha").val()})
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
					<div data-role="navbar"><center><h3><font color=red id="resultado">EDITAR SECRETS - LOGIN</font></h3></center></div>
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
						<title>EDITAR SECRETS - LOGIN</title>
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
								<div data-role="navbar"><center><h3><font color=red id="resultado">Edit Secrets - Grupo</font></h3></center></div>
							</div>
								<center>
									<form action="edit_secrets.php" method="post">
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
						</body>
					</html>
			<?php 
		}else{
			$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
			$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
			if(!$id){
			?>
				<!DOCTYPE html>
					<html>
					<head>
						<title>EDITAR SECRETS - Cliente</title>
							<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
							<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
							<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
							<script type="text/javascript" src="_js/jquery/jquery-1.11.3.min.js"></script>
							<script type="text/javascript" src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
							<script type="text/javascript" src="_js/jquery/jquery-ui.min.js"></script>
							<script type="text/javascript">
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
									$.ajax({url: dataUrl,
							            success: function(output) {
							               inp.html(output);
							           },
							         error: function (xhr, ajaxOptions, thrownError) {
							           alert(xhr.status + " "+ thrownError);
							         }});
								});
							}
							</script>
						</head>
						<body onload="getSelect();">
							<div data-role="page">
								<div data-role="header" style="overflow:hidden;" data-position="fixed">
									<div data-role="navbar"><center><?php if($msg_retorno) echo "<fonte style=\"font-size: 10px;font-weight: bold;\">($msg_retorno)</font>";?><h3><font color=red id="resultado">Edit Secret - Cliente</font></h3></center></div>
								</div>
											<center>
												<form action="edit_secrets.php" method="post">
												    <select onchange="this.form.submit();" name="id" data-role="auto" data-url="_dados.php?cmd=select&tipo=clientes" data-mini="true">
									    			</select>
												</form>
											</center>
								</div>
						</body>
					</html>
			<?php 
			}else{
				$nome_cliente=mysql_result(mysql_query("SELECT nome_clientesfc FROM fc_clientes WHERE id_clientesfc='".$id."'"),0,"nome_clientesfc");
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>MKFÁCIL - EDITAR SECRETS</title>
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
				//
				<?php echo $getLoading;?>
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
					$(pai).find("input, select").each(function() {
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
						//$(location).attr('href', 'edit_secrets.php?msg_retorno=Ok,'+dados);
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
			<body onload=""> 
				<div data-role="page">
					<div role="main" class="ui-content" id="content">
						<center>
							<div id="cadastro_secretpp" style="padding:5px 10px;margin:5px">
								<fonte style="font-size: 16px;font-weight: bold;">Alterar Secrets (<?php echo $nome_cliente.'-'.$id;?>)</font>
								<?php if($grupo) echo "<fonte style=\"font-size: 12px;font-weight: bold;\">(GRUPO $grupo)</font>";?>
								<li class="ui-field-contain">
									<font style="font-size: 10px;">Usuário de Acesso (secrets mk):</font>
									<div class="ui-grid-solo">
										<div class="ui-block-a">
											<input id="name_secret_add" class="list_secrets" onkeyup="AutoCompleteText($(this));" type="text" data-id-click="id_secretpp" placeholder="Buscar Users..." data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="1" data-url="_dados.php?cmd=busca&tipo=secrets&grupo=<?php echo $grupo;?>&query={val}">
										</div>
									</div>
								</li>
										<input data-fix=true name="cmd" value="save" type="hidden">
										<input data-fix=true name="cache" value="false" type="hidden">
										<input data-fix=true name="tipo" value="secretpp" type="hidden">
										<input id="id_secretpp" name="id_secretpp" type="hidden">
										<input id="tipo_secretpp" name="tipo_secretpp" value="atz" type="hidden">
										<input name="id_cliente_secretpp" value="<?php echo $id;?>" id="id_cliente_secretpp" type="hidden">
										<fieldset class="ui-grid-a">
	                    					<div class="ui-block-a">
												<button onclick="salvaDados('cadastro_secretpp');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Salvar</button>
											</div>
	                    					<div class="ui-block-b">
												<a href="edit_secrets.php?logout=true" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-delete">LOGOUT</a>					
											</div>
										</fieldset>
									</li>
								</ul>
							</div>
						</center> 
					</div>
				</div>
			</body>
		</html>
<?php 
			}
		}
	}
?>