<?php 
include_once("../_funcoes.php");
require_once("../_conf.php");
include_once("../_crud.class.php");
//
// GERA CLASSE DA(S) TABELA(S) USADA(S)
class Facil_item01 extends simpleCRUD{
	protected $__table = "fc_clientes";
	protected $__id = "id_clientesfc";
}
class Facil_item02 extends simpleCRUD{
	protected $__table = "fc_sevmensal";
	protected $__id = "id_mensalfc";
}
class Facil_item03 extends simpleCRUD{
	protected $__table = "fc_itens";
	protected $__id = "id_itensfc";
}
$errors=array();
conecta_mysql();	//concecta no banco myslq
$resultadoDados = mysql_query("SELECT * FROM aaa_table") or die ("Não foi possível realizar a consulta ao banco de dados linha 21");
while($colunas=mysql_fetch_assoc($resultadoDados)){
	$var=array();
	foreach ($colunas as $key=>$value){
		//$value=toVarUtf8($value);
		$var[$key]=$value;
	}
	$field_itens1 = Facil_item01::find_by_field();
	$new_itens1 = new Facil_item01();
	foreach ($field_itens1 as $id1){
		$new_itens1->$id1=$var[$id1];
		//echo $id1.':'.$var[$id1]." - ";
	}
	$new_itens1->insert();
	$var['id_clientesfc']=$new_itens1->id;
	echo 'id_clientesfc:'.$var['id_clientesfc'].' - ';
	if($var['id_clientesfc']>0)
		echo "Cliente cadastrado:".$var['id_clientesfc'].'<br>';
	//
	if($var['valor_debitos_anterior']>0){
		echo "cria debito anterior de:".$var['valor_debitos_anterior'].' - ';
		$var['nome_itensfc']='DEBITO';
		$var['tipo_itensfc']='+';
		$var['descricao_itensfc']='DEBITO MES 01/2017';
		$var['data_itensfc']='2017-02-'.$var['venc_clientesfc'];
		$var['data_origem_itensfc']='2017-02-25';
		$var['valor_itensfc']=$var['venc_clientesfc'];
		$var['qtd_itensfc']='1';
		$var['valor_total_itensfc']=$var['valor_debitos_anterior'];
		$var['id_cliente_itensfc']=$var['id_clientesfc'];
 		$var['valor_total_itensfc']=$var['valor_debitos_anterior'];
		$var['user_registro_item']='sistema';
		$var['id_provedor']='2';
		//
		$field_itens3 = Facil_item03::find_by_field();
		$new_itens3 = new Facil_item03();
		foreach ($field_itens3 as $id3){
			if (strpos($id3, "datatime_") !== false) {
				if($var[$id3]==""){
					$var[$id3]=date('Y-m-d H:i:s');
				}
			}
			$new_itens3->$id3=$var[$id3];
			//echo $id3.':'.$var[$id3]." - ";
		}
		$new_itens3->insert();
		$var['id_itensfc']=$new_itens3->id;
		if($var['id_itensfc']>0)
			echo "itens cadastrado:".$var['id_itensfc'].'<br>';
		//
	}
	//
	echo 'user_sevmensalfc:'.$var['user_sevmensalfc'].' - ';
	if($var['user_sevmensalfc']!=''){
		$var['id_secretpp']=mysql_result(mysql_query("SELECT id_secretpp FROM mk_secretpp WHERE name_secretpp like '".$var['user_sevmensalfc']."'"),0,"id_secretpp");
	}
	//
	$var['id_cliente_mensalfc']=$var['id_clientesfc'];
	echo 'id_cliente_mensalfc:'.$var['id_cliente_mensalfc'].' - ';
	if($var['id_cliente_mensalfc']>0){
		$var['id_user_sevmensalfc']=$var['id_secretpp'];
		//INSERE NOVOS DADOS NAS TABELAS
		$field_itens2 = Facil_item02::find_by_field();
		$new_itens2 = new Facil_item02();
		foreach ($field_itens2 as $id2){
			$new_itens2->$id2=$var[$id2];
			//echo $id2.':'.$var[$id2]." - ";
		}
		$new_itens2->insert();
		$var['id_mensalfc'] = $new_itens2->id;
		echo 'id_mensalfc:'.$var['id_mensalfc'].' - ';
		if($var['id_mensalfc']>0)
			echo "Mensal cadastrado:".$var['id_mensalfc'].'<br>';
		//
		echo 'id_secretpp:'.$var['id_secretpp'].' - ';
		if($var['id_secretpp']>0){
			$resultadoDadosConta = mysql_query("SELECT * FROM fcv_dados WHERE id_dadosfc='".$var['id_clientesfc']."'");
			$linha_dados=mysql_fetch_object($resultadoDadosConta);
			$var['comment_secretpp']=$linha_dados->nome_dadosfc." - ".$linha_dados->sit_dadosfc." - venc:".$linha_dados->venc_dadosfc." - Valor:".($var['valor_sevmensalfc']-$var['valor_desconto_mensalfc']);
			//
			$resultado = mysql_query("UPDATE mk_secretpp SET id_cliente_secretpp='".$var['id_clientesfc']."',tipo_secretpp='atz',comment_secretpp='".$var['comment_secretpp']."' WHERE id_secretpp='".$var['id_secretpp']."'") or die ("error");
			if(mysql_affected_rows()==1)
				echo 'Secret atualizado<br>';
			//$msg.='User pppoe atualizado:'.$var['id_secretpp']."<Br>";
		}
		if($var['id_clientesfc']>0){
			$resultado2 = mysql_query("UPDATE fc_clientes SET ppp_clientesfc='ok' WHERE id_clientesfc='".$var['id_clientesfc']."'") or die ("error");
			if(mysql_affected_rows()==1)
				echo 'Cliente '.$var['id_clientesfc'].' atualizado<br>';
			//
		}
	}
	//print_r($var);
	echo "<br>--------------<br>";
}

?>