function AlteraSit(title,tipo,id,grupo,table){
	var data=dataHoje;
	var form=false;
	if(tipo=='bl'){
		form='<br><div class="form-group input-group">'+
			'<span class="input-group-addon">Motivo</span>'+
        	'<select class="form-control" name="motivo_bloqueiosfc">'+
        		'<option value="ATRAZO">Atrazo</option>'+
				'<option value="CANCELAMENTO">Cancelamento</option>'+
				'<option value="SOLICITADO">Solicitado</option>'+
				'<option value="PERIODICO">Periódico</option>'+
				'<option value="OUTROS">Outros</option>'+
			'</select>'+ 
		'</div>'+ 
		'<div class="form-group input-group">'+ 
			'<span class="input-group-addon">Motivo Obs</span>'+
			'<textarea cols="40" onkeyup="$(this).val($(this).val().toUpperCase());" rows="3" class="form-control" name="obs_bloqueiosfc"></textarea>'+
	    '</div>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Data Bloquear</span>'+
			'<input type="text" class="form-control" name="data_bloqueiosfc" value="'+data+'" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true" data-date-orientation="top">'+		
		'</div>'+
		'<p class="help-block">Desbloqueio na data escolhida abaixo!</p>'+
		'<div class="form-group input-group">'+
			'<span class="input-group-addon">Data Desbloquear</span>'+
			'<input type="text" class="form-control" name="data_fim_bloqueiosfc" data-provide="datepicker" data-date-autoclose="true" data-date-clear-btn="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true" data-date-orientation="top">'+		
		'</div>'+
		'<input data-fix=true name="cmd" value="save" type="hidden">'+
		'<input data-fix=true name="cache" value="false" type="hidden">'+
		'<input data-fix=true id="tipo" name="tipo" value="bloqueios" type="hidden">'+
		'<input name="grupo_parceria" value="'+grupo+'" type="hidden">'+
		'<input name="datatime_fim_bloqueiosfc" value="" type="hidden">'+
		'<input name="id_cliente_bloqueiosfc" value="'+id+'" type="hidden">';
	}else if(tipo=='at'){
		if(id==0 || id=='undefined'){
			BootstrapDialog.alert('id do Bloqueio inválido!!!'); 
		}else{
			form='<br><div class="form-group input-group">'+
				'<span class="input-group-addon">Motivo</span>'+
		    	'<select class="form-control" name="motivo_fim_bloqueiosfc">'+
		    		'<option value="PAGAMENTO">Pagamento</option>'+
					'<option value="REATIVACAO">Reativação</option>'+
					'<option value="SOLICITADO">Solicitado</option>'+
					'<option value="OUTROS">Outros</option>'+
				'</select>'+
			'</div>'+
			'<div class="form-group input-group">'+
				'<span class="input-group-addon">Motivo Obs</span>'+
				'<textarea cols="40" onkeyup="$(this).val($(this).val().toUpperCase());" rows="3" class="form-control" name="obs_fim_bloqueiosfc"></textarea>'+
		    '</div>'+
			'<div class="form-group input-group">'+
				'<span class="input-group-addon">Data Desbloquear</span>'+
				'<input type="text" class="form-control" name="data_fim_bloqueiosfc" value="'+data+'" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd/mm/yyyy" data-date-language="pt-BR" data-date-today-highlight="true" data-date-orientation="top">'+		
			'</div>'+
			'<input data-fix=true name="cmd" value="save" type="hidden">'+
			'<input data-fix=true name="cache" value="false" type="hidden">'+
			'<input data-fix=true id="tipo" name="tipo" value="bloqueios" type="hidden">'+
			'<input name="grupo_parceria" value="'+grupo+'" type="hidden">'+
			'<input name="id_bloqueiosfc" value="'+id+'" type="hidden">';
		}
	}else if(tipo=='ca'){
        BootstrapDialog.confirm({
            title: 'WARNING',
            message: 'Deseja realmente cancelar o cadastro do Cliente '+title+'? <p class="text-danger">isto apagará os serviços mensais ativos e os secrets!</p>',
            type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
            closable: true, // <-- Default value is false
            draggable: true, // <-- Default value is false
            btnCancelLabel: 'Não', // <-- Default value is 'Cancel',
            btnOKLabel: 'Sim', // <-- Default value is 'OK',
            btnOKClass: 'btn-warning', // <-- If you didn't specify it, dialog type will be used,
            callback: function(result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if(result) {
                	loading('Cancelando acesso ['+title+']','loading_cancelar_clientes');
            		$.post('../_ajax.php',{'cmd':'alterar','tipo':'cancelar_cliente','id_cliente':id},function(dados){
            			dados=JSON.parse(dados);
            			$("#loading_cancelar_clientes").modal("hide");
            			BootstrapDialog.alert(dados.result);
            			if(table)
            				table.ajax.reload();
            		});
                }
            }
        });
	}
	if(form){
	    BootstrapDialog.show({
	        title: title,
	        message: '<div id="cadastro_situacao" class="col-lg-12"><div class="form-group">'+form+'</div></div>',
	        buttons: [{
	            label: 'Salvar',
	            cssClass: 'btn-primary',
	            action: function(dialog){
	            	salvaDados('cadastro_situacao');
	                dialog.close();
	            }
	        },{
	            label: 'Fechar',
	            cssClass: 'btn-primary',
	            action: function(dialog){
	                dialog.close();
	            }
	        }]
	    });
	}
}