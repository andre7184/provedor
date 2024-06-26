$(function($){
	$('#name_secret_add').bootcomplete({
	    url:'../_ajax.php',
	    minLength : 1,
	    method:'post',
	    idField:true,
	    idFieldName:'id_user_sevmensalfc',
	    dataParams:{
	    	'cmd':'busca',
	    	'tipo':'secrets'
	    },
	    formParams: {
	        'secret' : $('#tipo_auth_sevmensalfc')
	    }
	});
	$('#name_cliente_add').bootcomplete({
	    url:'../_ajax.php',
	    minLength : 3,
	    method:'post',
	    idField:true,
	    idFieldName:'id_cliente_mensalfc',
	    dataParams:{
	    	'cmd':'busca',
	    	'tipo':'clientes'
	    }
	});
	$('#dados_ajax').on('change', function() {
		var dados=JSON.parse($(this).val());
		if(dados.new)
			if(dados.cobranca=='on')
				$(location).attr('href','http://mkfacil.top/main/pages/index.php?page=clientes_itens.php&id_cliente='+dados.id+'&nome='+dados.nome);
			else
				$(location).attr('href','http://mkfacil.top/main/pages/index.php?page=clientes_list.php&busca_clientes_sel=Id&busca_clientes_text='+dados.id);
	});
});
function getServicos(obj,id){
	$("#"+obj).children().remove();
	$("#"+obj).append($(document.createElement('option')).attr("value","").text("Carregando..."));	
	$.ajax({url: '../_ajax.php',data:'cmd=select&tipo=servicos&id_cliente='+id,dataType: "json"}).then( function (retorno) {
		if(retorno!='')
			$("#"+obj).children().remove();
		//
		$.each(retorno, function(key, value){
			var dados=value.split("|");
			if(retorno.length==2 && dados[0]=='new')
				$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
			else if(retorno.length==3 && dados[0]>0)
				$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
			else if(retorno.length>3 && dados[0]=='sel')
				$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]).attr('selected', true));
			else
				$("#"+obj).append($(document.createElement('option')).attr("value",dados[0]).text(dados[1]));
		});	
		$("#"+obj).change();
		$("#"+obj).selectmenu('refresh', true);
	});		
}
function getEndServMensal(vl){
	var id=$("[name='id_cliente_mensalfc']").val();
	if(vl=='on' && id>0){
		BootstrapDialog.show({
			title: 'Localizando Endereço do cliente id:'+id+'...',
			id: 'loading_endcliente',
			message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
		});
	    $.ajax({url: '../_ajax.php',data:'cmd=busca&tipo=endcliente&id='+id,dataType: "json"}).then( function (retorno) {
	    	$("#loading_endcliente").modal("hide");
			if(retorno!=''){
				$.each(retorno, function(key, value){
					$("[name='"+key+"']").val(value);
					if($("[name='"+key+"']").attr("type")=='hidden')
						$("[name='"+key+"']").change();
					//
				});
			}
		});
	}else{
		
	}
}
function alteraDadosPonto(vl){
	if(vl!='on'){
		$('#dados_ponto-acesso').find('*').prop('disabled',true);
	}else{
		$('#dados_ponto-acesso').find('*').prop('disabled',false);
	}
}
function getServMensal(vl){
	if(vl>0){
		alteraDB(vl);
	}else if(vl=='new'){
		var obj=$("#cadastro_mensal");
		$("#id_mensalfc").val('');
		$("#id_mensalfc").change();
	}
}