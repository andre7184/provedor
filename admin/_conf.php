<?php
    //$pasta_home = '/home/provedor';
	#
    //require_once($pasta_home."/classes/funcoes_novas.php");
	#
    $conexao="";
    function conecta_mysql(){
       	global $conexao;
        $host = "localhost";
      	$database = "provedor_facil";
       	$user = "provedor_facil";
       	$pass = "amb8484";
       	$conexao = @mysql_pconnect($host,$user,$pass) or die ("Não foi possivel conectar-se ao banco de dados:<br>Verifique os dados da conexão!");
        mysql_select_db($database);
  	}
    function fecha_mysql(){
       	global $conexao;
       	$fecha1 = mysql_close($conexao);
    }
    $conexaoi="";
    function conecta_mysqli(){
    	global $conexaoi;
    	$host = "localhost";
    	$database = "provedor_facil";
    	$user = "provedor_facil";
    	$pass = "amb8484";
    	$conexaoi = mysqli_connect($host,$user,$pass) or die ("Não foi possivel conectar-se ao banco de dados:<br>Verifique os dados da conexão!");
    	mysqli_select_db($conexaoi, $database) or die(mysqli_error());
    }
    function fecha_mysqli(){
    	global $conexaoi;
    	$fecha1 = mysqli_close($conexaoi);
    }
    //$dados_conf = trim(shell_exec("cat /uvsat/conf/conf.sh"));
    date_default_timezone_set('America/Campo_Grande');
    #
    $key_google_mapas = 'ABQIAAAAxFzodemM0ddBObQaBWgEMxR8nj0BVJx4uKXVqFd3am9dWvD3NhSi22t4DWzCeXU2sVmDqY-zkLL-Zg';
    $host_server = 'http://mkfacil.tk';
    $host_seguro = 'http://mkfacil.tk';
    $URL_SERVIDOR = 'http://mkfacil.tk';
    $ip_servidor = '186.226.61.22';
    //
    $titulo = 'PagSeguro Fácil';
    $tempoGratis = '86400'; //Tempo gratis em segundos
    //CODIGOS DE LOG
	//usuario bloqueado
	$codLogIniciada="01";
	$codLogtempo="02";
	$codLogBloqueado="03";
	$codLogSenha="04";
	$codLogLogin="05";
	$codLogIp="06";
	$codLogFinalizada="07";
	$codLogDesconhecido="08";
	$codLogPendurada="09";
	// cPanel info
	//$cpuser = 'vendas'; // Nome de úsuario do cPanel
	//$cppass = 'amb8484'; // Senha do cPanel.
	//$cpdomain = 'vendas.uvsat.com'; // IP ou dominio do cPanel
	//$cpskin = 'x3';  // Skin do cPanel

	// E-mail padrão que vai receber informações das novas contas.
	// These will only be used if not passed via URL
	$edomain = 'mkfacil.tk'; // dominio do e-mail, o mesmo que o cPanel.
	$equotaPr = 200; // tamanho em MB
	$equotaSc = 100; // tamanho em MB
	$equotaAd = 1024 // tamanho em MB
?>