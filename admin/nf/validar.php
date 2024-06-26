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
	$nomeSession='authAdminNFC';
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
			$admin_usuario = $session["user_admin"];
			$id_provedor_usuario = $session["user_id_provedor"];
			$provedor_usuario = $session["user_nome_provedor"];
			$token = $session["user_token"];
			$url_script_atual = $session["url_atual"];
		}
	}else{
		$nomeSession='authAdminNFC';
		session_name($nomeSession);
		session_start($nomeSession);
		$authSession = $_SESSION["user_auth"];
		if($authSession){
			//echo "1";
			$login_usuario = $_SESSION["user_login"];
			$id_usuario = $_SESSION["user_id"];
			$admin_usuario = $_SESSION["user_admin"];
			$id_provedor_usuario = $_SESSION["user_id_provedor"];
			$provedor_usuario = $_SESSION["user_nome_provedor"];
			$token = $_SESSION["user_token"];
			$url_script_atual = $_SESSION["url_atual"];
			//
			include_once($LOCAL_HOME."classes/funcoes_novas.php");
			require_once($LOCAL_HOME."classes/conf_facil.php");
			conecta_mysql();	//concecta no banco myslq
			//fc_loguser
			//
		}else{
			//echo "2";
			$envio = isset($_REQUEST["envio"]) ? $_REQUEST["envio"] : false;
			$login_usuario = isset($_REQUEST["login"]) ? $_REQUEST["login"] : false;
			$senha_usuario = isset($_REQUEST["senha"]) ? $_REQUEST["senha"] : false;
			if($login_usuario && $senha_usuario){
				include_once($LOCAL_HOME."classes/funcoes_novas.php");
				require_once($LOCAL_HOME."classes/conf_facil.php");
				conecta_mysql();	//concecta no banco myslq
				//
				$consulta = mysql_query("select * from nf_user WHERE login_usernf='$login_usuario'");
				$campos = mysql_num_rows($consulta);
				if($campos != 0) {
					// se o usuario existi verifica a senha delecho
					//echo "2a";
					if($senha_usuario != mysql_result($consulta,0,"senha_usernf")) {
						$error.='Login ou Senha inválidos';
					}else{
						$auth=true;
						$id_usuario=mysql_result($consulta,0,"id_usernf");
						$admin_usuario=mysql_result($consulta,0,"tipo_usernf");
						$id_provedor_usuario=mysql_result($consulta,0,"id_provedor");
						if($id_provedor_usuario!='')
							$provedor_usuario=mysql_result(mysql_query("select nome_provedorfc from fc_provedor WHERE id_provedorfc='$id_provedor_usuario'"),0,"nome_provedorfc");
						//
						$authSession=true;
						//
						$resultado = mysql_query("UPDATE nf_user SET datatime_usernf=NOW() WHERE id_usernf='".$id_usuario."'") or die ("error");
						// criar a sessão
						$_SESSION["user_login"] = $login_usuario;
						$_SESSION["user_id"] = $id_usuario;
						$_SESSION["user_admin"] = $admin_usuario;
						$_SESSION["user_id_provedor"] = $id_provedor_usuario;
						$_SESSION["user_nome_provedor"] = $provedor_usuario;
						$_SESSION["user_auth"]= $authSession;
					}
				}else{
					$error.='Dados inválidos';
				}
			}else{
				$error.='<font color=blue>NF - Login e Senha </font>';
				$form_login='
					<center>
					    <form id="form1" name="form1" method="post" action="'.$home.'">
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
				'user_admin' => $admin_usuario,
				'user_id_provedor' => $id_provedor_usuario,
				'user_nome_provedor' => $provedor_usuario,
				'user_token' => $token,
				'url_atual' => $url_script_atual
		);
		$ip = $_SERVER['REMOTE_ADDR']; //função para pegar o ip do usuário
		$navegador = $_SERVER['HTTP_USER_AGENT']; //função para pegar o navegador do visitante
		//
		$insert_secretpp = mysql_query("INSERT INTO `nf_loguser` (`datatime_logusernf`, `session_id_logusernf`, `page_logusernf`, `menu_logusernf`, `cmd_logusernf`, `query_logusernf`, `tipo_logusernf`, `id_user_logusernf`, `nome_user_logusernf`, `id_provedor`) VALUES
			(NOW(),'".session_id()."','".$page."','".$menu."','".$cmd."','".$query."', '".$tipo."', '".$id_usuario."', '".$login_usuario."', '".$id_provedor_usuario."')") or die ("Nao foi possivel INSERIR linha 52");
		$id_loguserfc = mysql_insert_id();
	}
}

?>