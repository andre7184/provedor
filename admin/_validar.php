<?php
if (isset($_REQUEST["error"]))
	$error=isset($_REQUEST["error"]) ? $_REQUEST["error"] : false;
// 
$logout=isset($_REQUEST["logout"]) ? $_REQUEST["logout"] : false;
$new=isset($_REQUEST["new"]) ? $_REQUEST["new"] : false;
$grupo=isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
$home = strstr(end(explode("/", $_SERVER['PHP_SELF'])), '.', true).".php";
//
if($logout){
	// inicializa a sessуo
	$nomeSession='authAdminMk'; 
	session_name($nomeSession);
	// Inicia sessѕes
	session_start($nomeSession);
	session_destroy();
	//header('Refresh: 0; url=login.php');
}else{
	$session = isset($_REQUEST["session"]) ? $_REQUEST["session"] : false;
	if($session){
		$authSession = $session["user_auth"];
		if($authSession){
			$login_usuario = $session["user_login"];
			$id_usuario = $session["user_id"];
			$grupo_usuario = $session["grupo_userfc"];
			$grupo_session = isset($session["grupo"]) ? $session["grupo"]: false;
			$id_provedor_usuario = $session["user_id_provedor"];
			$provedor_usuario = $session["user_nome_provedor"];
			$cod_provedor_usuario = $session["user_codigo_provedor"];
			$senha_usuario = $session["user_senha"];
			$token = $session["user_token"];
			$url_script_atual = $session["url_atual"];
			if($grupo_usuario=='admin'){
				if(!$grupo && $grupo_session)
					$grupo=$grupo_session;
			}else{
				if($grupo_session)
					$grupo=$grupo_session;
			}
		}
	}else{
		$nomeSession='authAdminMk';
		session_name($nomeSession);
		session_start($nomeSession);
		$authSession = $_SESSION["user_auth"];
		if($authSession){
			$login_usuario = $_SESSION["user_login"];
			$id_usuario = $_SESSION["user_id"];
			$grupo_usuario = $_SESSION["grupo_userfc"];
			$id_provedor_usuario = $_SESSION["user_id_provedor"];
			$cod_provedor_usuario = $_SESSION["user_codigo_provedor"];
			$provedor_usuario = $_SESSION["user_nome_provedor"];
			$senha_usuario = $_SESSION["user_senha"];
			$token = $_SESSION["user_token"];
			$url_script_atual = $_SESSION["url_atual"];
			if($grupo_usuario=='admin'){
				//echo '-grupos:'.$grupo;
				if(!isset($_SESSION["grupo"]) or empty($_SESSION["grupo"])){
					//echo '-igrupos:'.isset($_SESSION["grupo"]).'-or-'.empty($_SESSION["grupo"]);
					if ($grupo){
						//echo '-igrupos:OK';
						$_SESSION["grupo"]=$grupo;
					}
				}else{
					if($grupo)
						$_SESSION["grupo"]=$grupo;
					else
						$grupo=$_SESSION["grupo"];
					//
				}
			}else{
				if(!isset($_SESSION["grupo"]) or empty($_SESSION["grupo"]))
					$_SESSION["grupo"]=$grupo_usuario;
				else
					$grupo=$_SESSION["grupo"];
			}
			include_once("_funcoes.php");
			require_once("_conf.php");
			conecta_mysql();	//concecta no banco myslq
			//fc_loguser
			//
		}
	}
	if($authSession){
		//
		$session_array=array(
				'user_auth' => $authSession,
				'user_login' => $login_usuario,
				'user_id' => $id_usuario,
				'grupo_userfc' => $grupo_usuario,
				'grupo_session' => $grupo,
				'user_id_provedor' => $id_provedor_usuario,
				'user_nome_provedor' => $provedor_usuario,
				'user_codigo_provedor' => $cod_provedor_usuario,
				'user_senha' => $senha_usuario,
				'user_token' => $token,
				'url_atual' => $url_script_atual
		);
		$ip = $_SERVER['REMOTE_ADDR']; //funчуo para pegar o ip do usuсrio
		$navegador = $_SERVER['HTTP_USER_AGENT']; //funчуo para pegar o navegador do visitante
		//
		$dados_post = "";
		foreach($_POST as $key => $value){
			$dados_post .= "campo: ".$key." => valor: ".$value.", ";
		}
		$insert_secretpp = mysql_query("INSERT INTO `fc_loguser` (`datatime_loguserfc`, `session_id_loguserfc`, `page_loguserfc`, `menu_loguserfc`, `cmd_loguserfc`, `query_loguserfc`, `tipo_loguserfc`, `dados_loguserfc`, `id_user_loguserfc`, `nome_user_loguserfc`, `id_provedor`) VALUES
			(NOW(),'".session_id()."','".$page."','".$menu."','".$cmd."','".$query."', '".$tipo."', '".$dados_post."', '".$id_usuario."', '".$login_usuario."', '".$id_provedor_usuario."')") or die ("Nao foi possivel INSERIR linha 99");
		$id_loguserfc = mysql_insert_id();
	}
}

?>