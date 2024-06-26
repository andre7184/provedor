<?php 
//importa funçoes
include_once( "../../classes/funcoes_novas.php");
//IMPORTA SITE SEGURO
require_once("validar.php");
if($authSession){
	// get command
	$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
	// no command?
	if(!$cmd) {
		echo '{"success":false,"errors":"No command"}';
		exit;
	}
	// verifica argumento passado?
	switch($cmd) {
		case "load": //ATUALIZA DADOS NA PAGINA
			$id_nfempresa = $_REQUEST["id_nfempresa"];
			$resultadoDados = mysql_query("SELECT * FROM nf_empresa WHERE id_nfempresa='".$id_nfempresa."' 
			") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 19"}');
			if (mysql_num_rows($resultadoDados) == 0){
				echo '{"success":true,"data":""}';
			}else{
				$linha_dados=mysql_fetch_object($resultadoDados);
				//array_walk($linha_dados, 'toUtf8');
				echo '{
					"success":"true"
					,"data":{
						"id_nfempresa":"'.$linha_dados->id_nfempresa.'"
						,"cod_user_nfempresa":"'.$linha_dados->cod_user_nfempresa.'"
						,"nome_nfempresa":"'.$linha_dados->nome_nfempresa.'"
						,"razao_nfempresa":"'.$linha_dados->razao_nfempresa.'"
						,"ie_nfempresa":"'.$linha_dados->ie_nfempresa.'"
						,"cnpj_nfempresa":"'.$linha_dados->cnpj_nfempresa.'"
						,"endereco_nfempresa":"'.$linha_dados->endereco_nfempresa.'"
						,"bairro_nfempresa":"'.$linha_dados->bairro_nfempresa.'"
						,"cidade_nfempresa":"'.$linha_dados->cidade_nfempresa.'"
						,"cep_nfempresa":"'.$linha_dados->cep_nfempresa.'"
						,"uf_nfempresa":"'.$linha_dados->uf_nfempresa.'"
						,"responsavel_nfempresa":"'.$linha_dados->responsavel_nfempresa.'"
						,"cargo_nfempresa":"'.$linha_dados->cargo_nfempresa.'"
						,"telefone_nfempresa":"'.$linha_dados->telefone_nfempresa.'"
						,"email_nfempresa":"'.$linha_dados->email_nfempresa.'"
					}
				}';
			} 		
			break;
		case "list": //ATUALIZA DADOS NA PAGINA
			
			break;
		case "save": //ATUALIZA DADOS NA PAGINA
			// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
			require_once( "../../classes/crud.class.php");
				
			// GERA CLASSE DA(S) TABELA(S) USADA(S)
			class Empresa_conf extends simpleCRUD{
				protected $__table = "nf_empresa";
				protected $__id = "id_nfempresa";
			}
			$var=$_POST;
			$var['cod_user_nfempresa']=$id_usuario;
			if($var['id_nfempresa']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
				//ATUALIZA DADOS COM O ID VINDO DA PAGINA
				$Atualiza_nfempresa = Empresa_conf::find_by_id($var['id_nfempresa']);
				if ($Atualiza_nfempresa !== false){
					foreach ($Atualiza_nfempresa->toArray() as $id=>$value){
						//echo "id:$id - valor:".$var[$id]." - valor2:$value<br>";
						if(isset($var[$id]) && $var[$id]!=$value){
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							//$vkkkk=$id.":".$var[$id];
							$Atualiza_nfempresa->$id = $var[$id];
						}
					}
					$Atualiza_nfempresa->update();
					//
					$msg="Dados da Empresa atualizado corretamente!";
				}else{
					$inserir=true;
				}
			}else{
				$inserir=true;
			}
			if($inserir){
				//INSERE NOVOS DADOS NA TABELA
				//
				$field_nfempresa = Empresa_conf::find_by_field();
				$new_nfempresa = new Empresa_conf();
				foreach ($field_nfempresa as $id){
					$new_nfempresa->$id=$var[$id];
				}
				$new_nfempresa->insert();
				//
				$id = $new_nfempresa->id;
				$msg="Dados da Empresa cadastrados corretamente id:$id!";
				$var['id_nfempresa']=$id;
			}
			echo "ok|".$var['id_nfempresa']."|".$var['razao_nfempresa']."|$msg";
	}
	mysql_close();
}else{
	echo '{"success":false,"errors":"Sem logar"}';
	exit;
}

?>