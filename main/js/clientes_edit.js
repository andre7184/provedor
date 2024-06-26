$(function($){
	getUfs('uf1_clientesfc'); //CARREGA SELECT CIDADES
	//
	$("#cpf_cnpj_clientesfc").mask('999.999.999-99');
	$(".mask-data").mask('99/99/9999', {placeholder: '__/__/____'});
	$(".mask-cep").mask('00000-000', {placeholder: '_____-___'});
	$(".mask-phone").mask('(00) 00000-0000', {placeholder: '(__)_____-____'});
	//	
	$("#pessoa_juridica_clientesfc").change(function(){
		var valor=$(this).val();
	   	if (valor=='on'){
	       	$("#div_rs").show();
	   		$("#div_resposavel").show();
	   		$("#div_nascimento").hide();
			$("#imp_rg-ie").html("Ie");
			$("#imp_cpf-cnpj").html("Cnpj");
			$("#cpf_cnpj_clientesfc").val("");
			$("#cpf_cnpj_clientesfc").mask('99.999.999/9999-99');
		}else{
		   	$("#div_rs").hide();
		   	$("#div_resposavel").hide();
			$("#div_nascimento").show();
			$("#imp_rg-ie").html("Rg");
			$("#imp_cpf-cnpj").html("Cpf");
			$("#cpf_cnpj_clientesfc").val("");
			$("#cpf_cnpj_clientesfc").mask('999.999.999-99');
		}
	});
	$('#dados_ajax').on('change', function() { 
		var dados=JSON.parse($(this).val()); 
		//alert(dados.new); 
		if(dados.new)
			$(location).attr('href','http://mkfacil.top/main/pages/index.php?page=clientes_serv.php&id_cliente='+dados.id+'&nome='+dados.nome);
		else
			$(location).attr('href','http://mkfacil.top/main/pages/index.php?page=clientes_list.php&busca_clientes_sel=Nome&busca_clientes_text='+dados.nome);
	});
});