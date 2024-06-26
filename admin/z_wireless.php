<!DOCTYPE html> 
<html>
	<head>
		<title>MKFÁCIL - Controle de Mikrotiks</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="_js/jquery/jquery-mobile-1.4.5.min.css" />
		<link rel="stylesheet" href="_js/jquery/jquery-ui.min.css" />
		<link rel="stylesheet" href="_js/sd.min.css" />
		<link rel="stylesheet"  href="_js/jquery/icon-pack-custom.css" />
		<style type="text/css">
		</style>
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
			function Ol(id){
				var vlr='ASC';
				if(iordem!=''){
					var ioarray=iordem.split('|');
					var ido=ioarray[0];
					var vlo=ioarray[1];
					if(id==ido){
						if(vlo=='ASC')
							vlr='DESC';
					}
				}
				var ordem=id+'|'+vlr;
				listar(ipage,itipo,iobj,iargs,ordem);
			}
			function listar(page,tipo,obj,args,ordem){
				ipage=page;
				itipo=tipo;
				iobj=obj;
				var urlargs='';
				if(args){
					iargs=args;
					var argArray=args.split('|');
					var urlargs='';
					for(i=0;i<argArray.length;i++){
						urlargs+='&'+argArray[i];
					}
				}
				if(ordem){
					iordem=ordem;
					urlargs+='&ordem='+ordem;
				}
				getLoading('Localizando '+tipo+'...');
	  	    	$.ajax({url: 'remote_teste.php',data:'cmd=list&tipo='+tipo+''+urlargs,dataType: "json"}).then( function ( response ) {
	  	      		if(!response.auth) 
	  	      			location.reload();
	  	      		//
					if($("#valor_custos_"+tipo).length)
						$("#valor_custos_"+tipo).html(response.valor_total);
					//
					$("#buscou").html('Listando "'+response.busca+'"');
	  	      		var html='<li data-role="list-divider">'+response.title+'<span class="ui-li-count">'+response.qtd+'</span></li>';
	  	      		if(response.qtd==0){
	  	      			html +="<li><font color='red'>Nenhum(a) "+tipo+"</font></li>";
	  	      		}
	  	      		if(response.qtd!=0){
		  	      		$.each(response.suggestion, function ( i, dados ) {
		  	              	html += "<li>"+dados.name+"</li>";
		  	            });
	  	      		}
	  	      		$("#"+obj).html(html);
	  	      		$("#"+obj).listview("refresh");
	  	      		$("#"+obj).trigger("updatelayout");
	  	          	$.mobile.loading("hide")
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
				$('.percent').mask('##0,00%', {reverse: true});
				$('.clear-if-not-match').mask('00/00/0000', {clearIfNotMatch: true});
				$('.placeholder').mask('00/00/0000', {placeholder: '__/__/____'});
			});	
		</script>
	</head>
	<body onload="listar(false,'wireless','lista_wireless')"> 
		<div data-role="page">
			<div role="main" class="ui-content" id="content">
				<div id="buscou"></div>
				<ul id="lista_wireless" data-role="listview" data-theme="a" data-inset="true" style="white-space:normal;">
				</ul>
			</div>
		</div>
	</body>
</html>