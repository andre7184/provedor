<?php
include("_conf.php");
//
if(!isset($_SESSION['id_userfc'])){
  	if(isset($_POST['login']) && $_POST['login']!='' && isset($_POST['password']) && $_POST['password']!=''){
  		$logar = new PDO_instruction();
  		$logar->con_pdo();
  		$result = $logar->select_pdo('SELECT id_userfc FROM fc_user WHERE login_userfc = ?', array($_POST['login']))[0];
  		if($result['id_userfc']>0){
  			$dados=$logar->select_pdo('SELECT login_userfc,email_userfc,admin_userfc,grupo_userfc,id_provedor,senhar_userfc FROM fc_user WHERE id_userfc = ?', array($result['id_userfc']))[0];
  			if(md5($_POST['password']) == md5($dados['senhar_userfc'])){
  				$_SESSION['id_userfc']=$result['id_userfc'];
  				$_SESSION['login_userfc']=$dados['login_userfc'];
  				$_SESSION['email_userfc']=$dados['email_userfc'];
  				$_SESSION['admin_userfc']=$dados['admin_userfc'];
  				$_SESSION['grupo_userfc']=$dados['grupo_userfc'];
  				$_SESSION['grupo']=$dados['grupo_userfc'];
  				$_SESSION['id_provedor']=$dados['id_provedor'];
  				if($dados['admin_userfc']!=''){
  					$gruposArray=explode(",",$dados['admin_userfc']);
  				}else{
	  				$grupos=$logar->select_pdo('SELECT group_concat(`grupo_userfc`) AS grupos FROM fc_user WHERE id_provedor = ?', array($dados['id_provedor']))[0];
	  				$gruposArray=explode(",",$grupos['grupos']);
  				}
  				$_SESSION['grupos']=array_unique($gruposArray);
  				$logar->end_con_pdo();
  				//
  			}else{
  				$logar->end_con_pdo();
  				$_SESSION['process_result'] = 'Senha incorreta!';
  				header("Location: " . $_SERVER['HTTP_REFERER']."?page=$page");
  			}
  		}else{
  			$logar->end_con_pdo();
  			$_SESSION['process_result'] = 'Usuário não existe';
  			header("Location: " . $_SERVER['HTTP_REFERER']."?page=$page");
  		}
  	}else{
  		$_SESSION['process_result'] = 'Preencha corretamente Login e Senha';
  		header("Location: " . $_SERVER['HTTP_REFERER']."?page=$page");
  	}
}else{
	if(isset($_REQUEST['logout'])){
		$_SESSION['id_userfc']=false;
		session_destroy();
	}
}
//echo $_SERVER['HTTP_REFERER'];
if($page=='caixa.php' or $page=='recebimentos.php' or $page=='inadimplentes.php' or $page=='cadastrar.php'){
	header("Location: ".$_SERVER['HTTP_REFERER']);
}else{
	header("Location: index.php?page=$page");
}
?>