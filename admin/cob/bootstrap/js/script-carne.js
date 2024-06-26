$(document).ready(function(){
     //Aplicando as mascaras nos inputs cpf, valor e vencimento.
    $("#btn_emitir_boleto").click(function (){
		 if($('#form')[0].checkValidity()) {
			 
         $("#myModal").modal('show');
         $("#boleto").addClass("hide");
         var descricao = $("#descricao").val();
		 
		 
         var valor = $("#valor").val();
		  var email = $("#email").val();
         var quantidade = $("#quantidade").val();
         var nome_cliente = $("#nome_cliente").val();
          var cpf = $("#cpf").val();
         var telefone = $("#telefone").val();
         var vencimento = $("#vencimento").val();
		 var instrucao1 = $("#instrucao1").val();
		 var instrucao2 = $("#instrucao2").val();
		 var instrucao3 = $("#instrucao3").val();
		 var instrucao4 = $("#instrucao4").val();
		 var repeticoes = $("#repeticoes").val();
		 
		 console.log(parseInt(nome_cliente))
		 console.log(parseInt(valor))
			if(parseInt(nome_cliente)=="NaN" || parseInt(valor)=="NaN"){
				$("#myModal").modal('hide');
			
				alert("Dados inválidos.");
				
				return false;
			}	
           
       
         	$.ajax({
		  url: "../carne/emitir_carne.php",
		  data:{descricao:descricao,valor:valor,quantidade:quantidade,nome_cliente:nome_cliente,cpf:cpf,telefone:telefone,vencimento:vencimento,repeticoes,instrucao1,instrucao2,instrucao3,instrucao4,email:email},
		  type:'post',
		  dataType:'json',
		  success: function(resposta){
                      $("#myModal").modal('hide');
                      console.log(resposta)
			if(resposta.code == 200){
							 $("#myModalResult").modal('show');	
                             $("#boleto").removeClass("hide");
								console.log("***********##***********");
				$("#table_id_ass").html(resposta.data.carnet_id);
				$("#table_status").html(resposta.data.status)
				$("#table_link").html("<a class='btn btn-default' target='_blank' href="+resposta.data.link+">Visualizar</a>");
				console.log(resposta.data.link);
				var html ="";
			
				for(var i = 0; i< resposta.data.charges.length;i++){
					html+="<tr><td>"+resposta.data.charges[i].charge_id+"</td><td>"+resposta.data.charges[i].parcel+"</td><td>"+resposta.data.charges[i].value+"</td><td>"+resposta.data.charges[i].expire_at+"</td><td><a target='_blank'  class='btn btn-danger btn-xs' href='"+resposta.data.charges[i].url+"'>Ver</a></td></tr>"
				}
				$("#charges_tb").html(html);
				$("#modalStatus").modal('hide');
							}else{
                            $("#myModal").modal('hide');
                            alert("Code: "+ resposta.code)
			}
		  },
                  error:function (resposta){
                      $("#myModal").modal('hide');
                      alert("Ocorreu um erro - Mensagem: "+resposta.responseText)
                  }
		});
		} //endif
		else {
                alert("Você deverá preencher todos dados do formulário.")
            }
     })
     
     
})