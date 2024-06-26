<?php
$htmlponto='
<div data-role="collapsible" data-collapsed="false" class="pontos">
	<legend>Ponto de Acesso <font class="n-item">01</font></legend>
	<div class="ui-field-contain">
		<label for="tipo_auth_pontosfc">Tipo de Autenticação:</label>
		<select name="tipo_auth_pontosfc" data-native-menu="true">
			<option value="">Selecione autenticação</option>
			<option value="pppoe">Pppoe</option>
			<option value="hotspot">Hotspot</option>
			<option value="binding">IpBinding</option>
			<option value="nunhum">Nenhum</option>
		</select>
	</div>
	<div class="ui-field-contain">
		<label>Usuário de Acesso:</label>
		<div class="ui-grid-solo">
			<div class="ui-block-a">
				<input onkeyup="AutoCompleteText($(this));" type="text" placeholder="Categories" data-no-match="Nada Encontrado" data-loading="Buscando ... aguarde." data-minlen="2" data-load-click="listSecretsLoad" data-url="remote.php?cmd=busca&tipo=secret&query={val}&auth=pp">
			</div>
		</div>
	</div> 
	<input name="id_pontosfc" type="hidden">
	<input class="id_secret" name="id_secretpp" type="hidden">
	<button class="bt-remove-item" onclick="$(this).parent().parent().remove();" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-delete" style="display: none;">Remover Ponto</button>
</div>';
?>
<!DOCTYPE html>  
<html>
	<head>
	    		<meta charset="ISO-8859-1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Provedor Fácil >> Pagina Inicial</title>
		<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
		<script src="_js/jquery/jquery-1.11.3.min.js"></script>
		<script src="_js/jquery/jquery-mobile-1.4.5.min.js"></script>
		<script src="_js/jquery/jquery-ui.min.js"></script>
		<script src="_js/funcoes.js"></script>
		<script src="_js/mask.js"></script>
		<script src="_js/mask_real.js"></script>
    </head>
    <body>
    <div data-role="page" id="home" style="background-color:#ADD8E6">
    	<div data-role="header" style="overflow:hidden;" data-position="fixed">
			<div data-role="navbar">
				<ul>
					<li><a href="#" onclick="openPg('dados_provedor');" data-icon="home">Home</a></li>
				</ul>
			</div><!-- /navbar -->
		</div><!-- /header -->
		<div role="main" class="ui-content">
				<div style="padding:5px 10px;"> 
					<?php echo $htmlponto;?>
					<button onclick="cloneItem('pontos');" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-icon-left ui-icon-plus">Add Ponto</button>
					<div class="ui-field-contain">
					    <label for="valor_caixafc">Valor Recebido:</label>
					    <input name="valor_caixafc" id="valor_caixafc" value="0,00" class="money" type="text">
					</div>
					<button id="bt_cadastrar_cliente" type="submit" class="ui-btn ui-btn-inline ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check">Cadastrar/Alterar</button>
				</div>		
			</div><!-- /content --> 
		<script type="text/javascript">
			var pontos='<?php echo preg_replace('/\s/',' ',$htmlponto);?>';
		 	function cloneItem(id) {
				var n_new=$("."+id).length+1;
				if(n_new<10){
					n_new='0'+n_new;
				}
				var obj=$( pontos ).insertAfter("."+id+":last").collapsible().collapsible("refresh").enhanceWithin();
				obj.find("input").val("")
				obj.find("select").val("")
				obj.find(".n-item").html(n_new);
				obj.find(".bt-remove-item").css("display", "block");
				obj.find('*').each(function(){
					if($(this).attr("id")){
						var idArr=$(this).attr("id").split("_");
						var newid=idArr[0]+"_"+n_new;
						$(this).attr("id",newid);
					}
				});
		 	};
			function listSecretsLoad(valor,id){ 
				var obj=$('input[data-id-ul="'+id+'"]');
				$(obj).closest('.pontos').find(".id_secret").val(valor);
			}
		 	var interval = 0;
		  	function AutoCompleteText(obj){		
		  		var idul=false;
		  		if(obj.attr("data-id-ul") && obj.attr("data-id-ul")!='' && $("#"+obj.attr("data-id-ul")).is("ul")){
		  			idul=obj.attr("data-id-ul");
		  		}else{
		  			idul=getPassword('ul_',6);
		  			$(obj).after('<ul id="'+idul+'" data-role="listview" data-inset="true"></ul>');
		  			$("#"+idul).listview();
		  			obj.attr("data-id-ul",idul);
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
		  			if(obj.attr("data-titulo")){
		  				titulo=obj.attr("data-titulo");
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
		  	      		dataDelay=500;
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
		  	      		minlen = 2;
		  	      	} 
		  	      	clearInterval(interval);
		  	      	interval = window.setTimeout(function(){
			  	      	var val=obj.val().trim();
	  	        		if (val.length >= minlen) {
	  	        			var callData=dataData;
	  	        			//$("#"+idul).html("<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>");
	  	        			//$("#"+idul).listview("refresh");
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
				  	      		if(response.qtd==0 && match!=''){
				  	      			html +="<li>"+match+" com '<font color='"+color+"'>"+response.query+"</font>'</li>";
				  	      		}
				  	      		if(response.qtd!=0){
					  	      		if(titulo!='')
					  	      			html += "<li><center><b>"+titulo+"</b></center></li>";
					  	      		//
					  	      		$.each(response.suggestion, function ( i, dados ) {
					  	         		var resultado = dados.name.replace(/\"/g,"\\\"");
					  	              	if (loadclick != ''){
					  	              		loadclick += "('"+dados.id+"','"+idul+"')";
					  	              	}
					  	              	var reg = RegExp("("+response.query+")",'gi'); 
					  	              	//alert(reg);
					  	              	var textname = dados.name.replace(reg,"<font color='"+color+"'>$1</font>");
					  	              	//alert(textname);
					  	              	html += "<li><a onclick=\""+loadclick+";ocac('"+dados.id+"','"+resultado+"','"+idclick+"','"+idul+"');\" href=\"#\">"+textname+"</a></li>";
					  	            });
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
						alert(name+'-'+$("[name='"+name+"']").length);
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
				$.post('teste2.php',tempData,function(data){
					$.mobile.loading("hide");
					//$.mobile.changePage("#cadastroFim");
					//$("#local_texto_retorno").html(data);
					alert('fim');
				});
			}
			//
			$(document).ready( function() {
				//
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
				$('#bt_cadastrar_cliente').click(function(){
					salvaDados('home');
				});
			});	
		</script>
		</div><!-- /page -->
	</body>
</html>