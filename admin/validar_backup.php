<?php
$LOCAL_HOME='/home/provedor/';
$error = $_REQUEST["error"];
$logout=isset($_REQUEST["logout"]) ? $_REQUEST["logout"] : false;
$new=isset($_REQUEST["new"]) ? $_REQUEST["new"] : false;
$home = strstr(end(explode("/", $_SERVER['PHP_SELF'])), '.', true).".php";
//
$reload = isset($_REQUEST["reload"]) ? $_REQUEST["reload"] : false;
if($reload)
	header('Refresh: 0; url=index.php');
if($logout){
	// inicializa a sessão
	$nomeSession='authAdminFC';
	session_name($nomeSession);
	// Inicia sessões
	session_start($nomeSession);
	session_destroy();
	header('Refresh: 0; url=index.php');
}else{
	$session = isset($_REQUEST["session"]) ? $_REQUEST["session"] : false;
	if($session){
		$authSession = $session["user_auth"];
		if($authSession){
			$login_usuario = $session["user_login"];
			$id_usuario = $session["user_id"];
			$id_provedor_usuario = $session["user_id_provedor"];
			$provedor_usuario = $session["user_nome_provedor"];
			$cod_provedor_usuario = $session["user_codigo_provedor"];
			$senha_usuario = $session["user_senha"];
			$token = $session["user_token"];
			$url_script_atual = $session["url_atual"];
		}
	}else{
		$nomeSession='authAdminFC';
		session_name($nomeSession);
		session_start($nomeSession);
		$authSession = $_SESSION["user_auth"];
		if($authSession){
			$login_usuario = $_SESSION["user_login"];
			$id_usuario = $_SESSION["user_id"];
			$id_provedor_usuario = $_SESSION["user_id_provedor"];
			$cod_provedor_usuario = $_SESSION["user_codigo_provedor"];
			$provedor_usuario = $_SESSION["user_nome_provedor"];
			$senha_usuario = $_SESSION["user_senha"];
			$token = $_SESSION["user_token"];
			$url_script_atual = $_SESSION["url_atual"];
			//
			include_once($LOCAL_HOME."classes/funcoes_novas.php");
			require_once($LOCAL_HOME."classes/conf_facil.php");
			conecta_mysql();	//concecta no banco myslq
			//fc_loguser
			//
		}else{
			$envio = isset($_REQUEST["envio"]) ? $_REQUEST["envio"] : false;
			$login_usuario = isset($_REQUEST["login"]) ? $_REQUEST["login"] : false;
			$senha_usuario = isset($_REQUEST["senha"]) ? $_REQUEST["senha"] : false;
			if($login_usuario && $senha_usuario){
				include_once($LOCAL_HOME."classes/funcoes_novas.php");
				require_once($LOCAL_HOME."classes/conf_facil.php");
				conecta_mysql();	//concecta no banco myslq
				//
				$consulta = mysql_query("select * from fc_user WHERE login_userfc='$login_usuario'");
				$campos = mysql_num_rows($consulta);
				if($campos != 0) {
					// se o usuario existi verifica a senha dele
					if($senha_usuario != mysql_result($consulta,0,"senhar_userfc")) {
						$error.='Login ou Senha inválidos';
					}else{
						$auth=true;
						$id_usuario=mysql_result($consulta,0,"id_userfc");
						$id_provedor_usuario=mysql_result($consulta,0,"id_provedor");
						$provedor_usuario=mysql_result(mysql_query("select nome_provedorfc from fc_provedor WHERE id_provedorfc='$id_provedor_usuario'"),0,"nome_provedorfc");
						$cod_provedor_usuario=mysql_result(mysql_query("select codigo_provedorfc from fc_provedor WHERE id_provedorfc='$id_provedor_usuario'"),0,"codigo_provedorfc");
						$authSession=true;
						//
						$resultado = mysql_query("UPDATE fc_user SET datatime_userfc=NOW() WHERE id_userfc='".$id_usuario."'") or die ("error");
						// criar a sessão
						$_SESSION["user_login"] = $login_usuario;
						$_SESSION["user_id"] = $id_usuario;
						$_SESSION["user_id_provedor"] = $id_provedor_usuario;
						$_SESSION["user_nome_provedor"] = $provedor_usuario;
						$_SESSION["user_codigo_provedor"] = $cod_provedor_usuario;
						$_SESSION["user_senha"] = $senha_usuario;
						$_SESSION["user_auth"]= $authSession;
					}
				}else{
					$error.='Dados inválidos';
				}
			}else{
				$error.='<font color=blue>MKFÁCIL - Login e Senha </font>';
				$form_login='
					<center>
					    <form id="form1" name="form1" method="post" action="'.$home.'?page='.$page.'">
						    <table border="0">
						    <tr>
						    <td><span class="Style6">Login:</span></td>
						    <td><span class="Style6">
						    <label>
						    <input name="login" type="text" id="login" />
						    </label>
						    </span></td>
						    </tr>
						    <tr>
						    <td><span class="Style6">Senha:</span></td>
						    <td><span class="Style6">
						    <label>
						    <input name="senha" type="password" id="senha" />
						    </label>
						    </span></td>
						    </tr>
						    <tr>
						    <td>&nbsp;</td>
						    <td><span class="Style6">
						    <label>
						    <input type="submit" name="Submit" value="OK" />
						    </label>
						    </span></td>
						    </tr>
						    </table>
					    </form>
					</center>
				';
			}
		}
	}
	if($authSession){
		//
		$session_array=array(
				'user_auth' => $authSession,
				'user_login' => $login_usuario,
				'user_id' => $id_usuario,
				'user_id_provedor' => $id_provedor_usuario,
				'user_nome_provedor' => $provedor_usuario,
				'user_codigo_provedor' => $cod_provedor_usuario,
				'user_senha' => $senha_usuario,
				'user_token' => $token,
				'url_atual' => $url_script_atual
		);
		$ip = $_SERVER['REMOTE_ADDR']; //função para pegar o ip do usuário
		$navegador = $_SERVER['HTTP_USER_AGENT']; //função para pegar o navegador do visitante
		//
		$insert_secretpp = mysql_query("INSERT INTO `fc_loguser` (`datatime_loguserfc`, `session_id_loguserfc`, `page_loguserfc`, `menu_loguserfc`, `cmd_loguserfc`, `query_loguserfc`, `tipo_loguserfc`, `id_user_loguserfc`, `nome_user_loguserfc`, `id_provedor`) VALUES
			(NOW(),'".session_id()."','".$page."','".$menu."','".$cmd."','".$query."', '".$tipo."', '".$id_usuario."', '".$login_usuario."', '".$id_provedor_usuario."')") or die ("Nao foi possivel INSERIR linha 52");
		$id_loguserfc = mysql_insert_id();
	}
}

?>