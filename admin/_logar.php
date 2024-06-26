<?php
// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//
	$cpf_cnpj = isset($_REQUEST["cpf_cnpj"]) ? $_REQUEST["cpf_cnpj"] : false;
	$login_usuario = isset($_REQUEST["login"]) ? $_REQUEST["login"] : false;
	$senha_usuario = isset($_REQUEST["senha"]) ? $_REQUEST["senha"] : false;
	$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : false;
	if(!$page)
		$page='index.php';
	//
	if($cpf_cnpj){
		$nomeSession='authAdminPG';
		session_name($nomeSession);
		session_start($nomeSession);
		require_once("_conf.php");
		conecta_mysql();	//concecta no banco myslq
		$consulta = mysql_query("select * from fc_clientes AS c
					INNER JOIN fc_provedor AS p ON p.id_provedorfc=c.id_provedor
					WHERE c.cpf_cnpj_clientesfc='".preg_replace("/[^0-9]/","", $cpf_cnpj)."'");
		$campos = mysql_num_rows($consulta);
		if($campos != 0) {
			// se o usuario existi verifica a senha dele
			$id_cliente=mysql_result($consulta,0,"id_clientesfc");
			$nome_cliente=mysql_result($consulta,0,"nome_clientesfc");
			$nome_provedor=mysql_result($consulta,0,"nome_provedorfc");
			$auth=true;
			$_SESSION["cpf_cnpj"]=$cpf_cnpj;
			$_SESSION["id_cliente"]=$id_cliente;
			$_SESSION["nome_cliente"]=$nome_cliente;
			$_SESSION["nome_provedor"]=$nome_provedor;
			$_SESSION["auth"]=$auth;
			//
		}else{
			$error='CPF/CNPJ inválido ou não cadastrado!';
		}
		break;
	}
	if($login_usuario && $senha_usuario){
		// inicializa a sessão
		$nomeSession='authAdminMk';
		require_once("_conf.php");
		conecta_mysql();	//concecta no banco myslq
		//
		$consulta = mysql_query("select * from fc_user WHERE login_userfc='$login_usuario'");
		$campos = mysql_num_rows($consulta);
		if($campos != 0) {
			// se o usuario existi verifica a senha dele
			if($senha_usuario != mysql_result($consulta,0,"senhar_userfc")) {
				echo 'Login ou Senha inválidos';
			}else{
				$id_usuario=mysql_result($consulta,0,"id_userfc");
				$grupo_usuario=mysql_result($consulta,0,"grupo_userfc");
				$id_provedor_usuario=mysql_result($consulta,0,"id_provedor");
				$provedor_usuario=mysql_result(mysql_query("select nome_provedorfc from fc_provedor WHERE id_provedorfc='$id_provedor_usuario'"),0,"nome_provedorfc");
				$authSession=true;
				//
				$resultado = mysql_query("UPDATE fc_user SET datatime_userfc=NOW() WHERE id_userfc='".$id_usuario."'") or die ("error");
				// criar a sessão
				session_name($nomeSession);
				session_start($nomeSession);
				$_SESSION["user_login"] = $login_usuario;
				$_SESSION["user_id"] = $id_usuario;
				$_SESSION["grupo_userfc"]=$grupo_usuario;
				$_SESSION["user_id_provedor"] = $id_provedor_usuario;
				$_SESSION["user_nome_provedor"] = $provedor_usuario;
				$_SESSION["user_codigo_provedor"] = $cod_provedor_usuario;
				$_SESSION["user_senha"] = $senha_usuario;
				$_SESSION["user_auth"]= $authSession;
				echo "<script> document.location = '$page' </script>";
			}
		}else{
			echo 'Dados inválidos';
		}
	}else{
		echo 'Dados inválidos';
	}
}else{
	echo 'Dados inválidos';
}
?>