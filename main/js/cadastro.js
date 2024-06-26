function getUfs(id) {
	$("#"+id).children().remove();
	$("#"+id).append($(document.createElement('option')).attr("value","").text("Carregando..."));	
	$.ajax({url: '../_ajax.php',data:'cmd=select&tipo=ufs',dataType: "json"}).then( function (retorno) {
		if(retorno!='')
			$("#"+id).children().remove();
		//
		$.each(retorno, function(key, value){
			if(value=='MS')
				$("#"+id).append($(document.createElement('option')).attr("value",value).text(value).attr('selected', true));
			else
				$("#"+id).append($(document.createElement('option')).attr("value",value).text(value));
		});	
		$("#"+id).change();
		$("#"+id).selectmenu('refresh', true);
		getCidades($("#uf1_clientesfc").val(),'cid1_clientesfc');
	});		
}
function getCidades(uf,id) {
	$("#"+id).children().remove();
	$("#"+id).append($(document.createElement('option')).attr("value","").text("Carregando..."));	
	$.ajax({url: '../_ajax.php',data:'cmd=select&tipo=cidades&uf='+uf,dataType: "json"}).then( function (retorno) {
		if(retorno!='')
			$("#"+id).children().remove();
		//
		$.each(retorno, function(key, value){
			if(value=='CAMPO GRANDE')
				$("#"+id).append($(document.createElement('option')).attr("value",value).text(value).attr('selected', true));
			else
				$("#"+id).append($(document.createElement('option')).attr("value",value).text(value));
		});	
		$("#"+id).change();
		$("#"+id).selectmenu('refresh', true);
	});		
}
function getEnd(cep,valEnd) {
	if($.trim(cep) != ""){
		BootstrapDialog.show({
			title: 'Buscando Endereço, aguarde...',
			id: 'loading_end',
			message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
		}); 
		//getLoading('Buscando Endere�o, aguarde...');
		$.getScript("../_ajax.php?cmd=busca&tipo=end&formato=javascript&cep="+cep, function(){
	  		if(resultadoCEP["resultado"]){
	  			$("#"+valEnd.logradouro).val(unescape(resultadoCEP["tipo_logradouro"]).toUpperCase()+' '+unescape(resultadoCEP["logradouro"]).toUpperCase());
	  			$("#"+valEnd.bairro).val(unescape(resultadoCEP["bairro"]).toUpperCase());
	  			$("#"+valEnd.cidade).val(unescape(resultadoCEP["cidade"]).toUpperCase()); 
	  			$("#"+valEnd.uf).val(unescape(resultadoCEP["uf"]).toUpperCase());
	  			$("#loading_end").modal("hide");
	  			//showPopup({title: "Sucesso!", message: "Cep "+cep+" correto, End:"+resultadoCEP['tipo_logradouro']+" "+resultadoCEP['logradouro']+"!", buttonText: "I know!", width: "500px"});
			}else{
				BootstrapDialog.alert('Nenhum endereço encontrado!');
			}
		});			
	}else{
		$("#"+valEnd.cep).focus();
		BootstrapDialog.alert('Preencha corretamento o cep!');
	}	
}
function getCep(valEnd) {
	var uf=$("#"+valEnd.uf).val();
	var cid=$("#"+valEnd.cidade).val();
	var log=$("#"+valEnd.logradouro).val();
	var end='';
	if(uf!='' && cid!='' && log!=''){
		end=uf+'/'+cid+'/'+log;
	}
	if(end != ''){
		//getLoading('Buscando Cep, aguarde...');
		BootstrapDialog.show({
			title: 'Buscando Cep, aguarde...',
			id: 'loading_cep',
			message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
		}); 
		$.ajax({
			url: "https://viacep.com.br/ws/"+end+"/json/",
  	    	dataType: "json",
  	    	crossDomain: !0
  	    }).then( function (results) {
			//$.mobile.loading("hide");
			//alert(results);
			if(results.length!=0){
				var output = [];
				$.each(results, function( key1, val1 ) {
					if(val1.cep!='')
						output.push('<a class="list-group-item close-modal" href="#" onclick="$(\'#'+valEnd.cep+'\').val(\''+val1.cep+'\');$(\'#'+valEnd.logradouro+'\').val(\''+val1.logradouro.toUpperCase()+'\');$(\'#'+valEnd.bairro+'\').val(\''+val1.bairro.toUpperCase()+'\');$(\'#dialog_cep\').modal(\'hide\');">'+val1.cep+' - '+val1.logradouro+', '+val1.bairro+'</a>');
				});
				if(output.length>0){
					$("#loading_cep").modal("hide");
					BootstrapDialog.show({
						title: 'Cep(s) ('+output.length+')',
						id: 'dialog_cep',
						message: '<div class="list-group">'+output+'</div>'
					}); 
				}else{
					BootstrapDialog.alert('Nenhum cep encontrado!');
				}
			}else{
				BootstrapDialog.alert('Nenhum cep encontrado!');
			}
		});
	}else{
		$("#"+valEnd.logradouro).focus();
		BootstrapDialog.alert('Preencha corretamento o endereço!');
	}	
}
function salvaDados(id,obj,url='_ajax.php') {
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
	BootstrapDialog.show({
		title:'Salvando dados, aguarde...',
		id: 'loading_form',
		message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
	}); 
	//
	$.post('../'+url,tempData,function(dadosj){
		clear_form_elements($(pai));
		$("#loading_form").modal("hide");
		if($("#"+obj).length>0){
			$("#"+obj).val(dadosj); 
			$("#"+obj).change();
		}else{
			dados=JSON.parse(dadosj);
			BootstrapDialog.alert(dados.msg);
		}
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
    });
}
function alteraDB(id){
	var tipo=$("#tipo").val();
	$("#title_"+tipo).html('Alterar');
	$("#id_"+tipo).html('id:'+id);
	BootstrapDialog.show({
		title: 'Buscando Dados '+tipo+', aguarde...',
		id: 'loading_form',
		message: '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Carregando<span class="dotdotdot"></span></span></div></div>'
	}); 
    $.ajax({url: '../_ajax.php',data:'cmd=load&tipo='+tipo+'&id='+id,dataType: "json"}).then( function (retorno) {
    	$("#loading_form").modal("hide");
		if(retorno){
			$.each(retorno, function(key, value){
				if ($("[name='"+key+"']").is("font"))
					$("[name='"+key+"']").text(value);
				else
					$("[name='"+key+"']").val(value);
				//
				if($("[name='"+key+"']").attr("type")=='hidden')
					$("[name='"+key+"']").change();
				//
			});
		}
	});
}