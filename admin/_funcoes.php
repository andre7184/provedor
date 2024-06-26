<?php 
function toUtf8(&$item, $key) {
	$item = iconv("iso-8859-1","utf-8",$item);
}
//
function toVarUtf8($item) {
	return iconv("iso-8859-1","utf-8",$item);
}
//
function toVarIso88591($item) {
	return iconv("utf-8","iso-8859-1",$item);
}
//
function converterDataSimples($dat){
	$Ndata = explode("/", $dat);
	$dia = $Ndata[0];
	$mes = $Ndata[1];
	$ano = $Ndata[2];
	$data="$ano-$mes-$dia";
	return($data);
}
function converteUptimeMk($uptime){
	$uptimeArray = explode(":", $uptime);
	$segundos=($uptimeArray[0]*1)*3600+($uptimeArray[1]*1)*60+($uptimeArray[2]*1);
	return($segundos);
}
//
function converteDateMk($dat){
	$NdataArray = explode(" ", $dat);
	$Ndata = explode("/", $NdataArray[0]);
	$meses = array("jan"=>"01","feb"=>"02","mar"=>"03","apr"=>"04","may"=>"05","jun"=>"06","jul"=>"07","aug"=>"08","sep"=>"09","oct"=>"10","nov"=>"11","dec"=>"12");
	$dia = $Ndata[1];
	$mes = $meses[$Ndata[0]];
	$ano = $Ndata[2];
	if($NdataArray[1]!=''){
		$time=" ".$NdataArray[1];
	}
	$data="$ano-$mes-$dia".$time;
	return($data);
}
//
function mostrarDataSimples($dat,$mesD=false){
	$Ndata = explode("-", $dat);
	$dia = $Ndata[2];
	$mes = $Ndata[1];
	$ano = $Ndata[0];
	if($mesD){
		$ano = substr("$ano", 2, 4);
	}
	$data="$dia/$mes/$ano";
	return($data);
}
//CONVERTE A DATA PARA dd/mm/aaaa hh:mm:ss
function mostrarData($dat,$tipo=true){
	$dia = substr("$dat", 8, 2);
	$mes = substr("$dat", 5, 2);
	$ano = substr("$dat", 0, 4);
	//separa hora minuto e segundo
	$hora = substr("$dat",11, 2);
	$min = substr("$dat",14,2);
	$seg = substr("$dat",17,2);
	if($tipo){
		$data=	"$dia/$mes/$ano<br>$hora:$min:$seg";
	}else{
		$data=	"$dia/$mes/$ano $hora:$min:$seg";
	}
	return($data);
}
// MOSTRA TEMPO USADO
function mostrarTempoUsado($tempoUsado){
	if($tempoUsado>3600){
		$tempo=sprintf("%01.2f", ($tempoUsado/3600))."(Hs)";
	}else if($tempoUsado>60){
		$tempo=sprintf("%01.2f", ($tempoUsado/60))."(Mn)";
	}else{
		$tempo=sprintf("%01.2f", $tempoUsado)."(Ss)";
	}
	return $tempo;
}
//
function RemoveAcentos($Msg){
	//$palavra = ereg_replace("[^a-zA-Z0-9_]", "", strtr($Msg, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«", "aaaaeeiooouucAAAAEEIOOOUUC"));
	//return $palavra;
	return str_replace("«","C", $Msg ); 
}
//PEGA A DIFEREN«A DE DUAS DATAS COM HORAS MINUTOS E SEGUNDOS

function Diferenca($data1, $data2="",$tipo=""){
    //echo $data1." - ".$data2;
	if($data2==""){
		$data2 = date('Y-m-d H:i:s');//trim(shell_exec("date \"+%Y/%m/%d %H:%M:%S\""));
	}
	if($tipo==""){
		$tipo = "h";
	}
	for($i=1;$i<=2;$i++){
		${"dia".$i} =  substr(${"data".$i},8,2);
		${"mes".$i} = substr(${"data".$i},5,2);
		${"ano".$i} = substr(${"data".$i},0,4);
		${"horas".$i} = substr(${"data".$i},11,2);
		${"minutos".$i} = substr(${"data".$i},14,2);
		${"segundos".$i} = substr(${"data".$i},17,2);
	}
	//echo "$horas1,$minutos1,$segundos1,$mes1,$dia1,$ano1 - $horas2,$minutos2,$segundos2,$mes2,$dia2,$ano2";
	$segundos = mktime($horas2,$minutos2,$segundos2,$mes2,$dia2,$ano2) - mktime($horas1,$minutos1,$segundos1,$mes1,$dia1,$ano1);
	switch($tipo){
		 case "s": $difere = $segundos;    break;
		 case "M": $difere = $segundos/60;    break;
		 case "m": $difere = round($segundos/60);    break;
		 case "H": $difere = $segundos/3600;    break;
		 case "h": $difere = round($segundos/3600);    break;
		 case "D": $difere = $segundos/86400;    break;
		 case "d": $difere = round($segundos/86400);    break;
	}
	return $difere;
} 
// A $DATA2 DEVER¡ SER MAIOR QUE A $DATA1
// O FORMATO DAS DATAS DEVEM SER DD/MM/AAAA
function DiferencaMeses($data1, $data2='') {
	if($data2==''){
		$data2 = date('Y-m-d H:i:s');//trim(shell_exec("date \"+%Y/%m/%d %H:%M:%S\""));
	}
	if($data1 && $data2) {
		$vetorData1 = explode("-", $data1);
		$vetorData2 = explode("-", $data2);
		$resultado = ($vetorData2[0] - $vetorData1[0])*12;
		if ($vetorData1[1] > $vetorData2[1]) {
			$resultado -= ($vetorData1[1] - $vetorData2[1]);
		}else if ($vetorData2[1] > $vetorData1[1]) {
			$resultado += ($vetorData2[1] - $vetorData1[1]);
		}
	}else {
		$resultado = 0;
	}
	return $resultado;
}
//SOMA HORAS, MINUTOS, SEGUNDOS, DIAS, MESES OU ANOS A UMA DATA
function SomarDataTime($data, $s=0, $i=0, $h=0, $d=0, $m=0, $y=0){
	//passe a data no formato (yyyy-mm-dd hh:mm:ss)
	//echo "$data=$s-$i-$h-$d-$m-$y";
	$dataArray = explode(" ", $data);
	$data = explode("-", $dataArray[0]);
	$hora = explode(":", $dataArray[1]);
	$newData = date("Y-m-d H:i:s", mktime($hora[0] + $h, $hora[1] + $i, $hora[2] + $s, $data[1] + $m, $data[2] + $d, $data[0] + $y) );
	return $newData;
} 
//SOMA DIAS, MESES OU ANOS A UMA DATA
function SomarData($data, $dias, $meses, $ano){
     //passe a data no formato dd/mm/yyyy
     $data = explode("/", $data);
     if($data[0]==""){
          $dataDia=01;
     }else{
          $dataDia=$data[0];
     }
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $dataDia + $dias, $data[2] + $ano) );
   return $newData;
}
//VALOR POR EXTENSO
function valorPorExtenso($valor=0) {
	$singular = array("centavo", "real", "mil", "milh„o", "bilh„o", "trilh„o", "quatrilh„o");
	$plural = array("centavos", "reais", "mil", "milhıes", "bilhıes", "trilhıes",
"quatrilhıes");

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
"sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
"dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "trÍs", "quatro", "cinco", "seis",
"sete", "oito", "nove");

	$z=0;

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];

	// $fim identifica onde que deve se dar junÁ„o de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++) {
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}

	return($rt ? $rt : "zero");
}
//DATA POR EXTENSO
function dataPorExtenso($data) {
	$dataArray=explode("/",$data);
	$dia=$dataArray[0];
	$mes=$dataArray[1];
	$ano=$dataArray[2];
			switch ($mes){
				case 1:
					$mesExt="Janeiro";
					break;
				case 2:
					$mesExt="Fevereiro";
					break;
				case 3:
					$mesExt="MarÁo";
					break;
				case 4:
					$mesExt="Abril";
					break;
				case 5:
					$mesExt="Maio";
					break;
				case 6:
					$mesExt="Junho";
					break;
				case 7:
					$mesExt="Julho";
					break;
				case 8:
					$mesExt="Agosto";
					break;
				case 9:
					$mesExt="Setembro";
					break;
				case 10:
					$mesExt="Outubro";
					break;
				case 11:
					$mesExt="Novembro";
					break;
				case 12:
					$mesExt="Dezembro";
					break;
			}
	return "Campo Grande - MS $dia de $mesExt de $ano";
}
// CONVERTE VEL DO TRAFEGO MK
function converteVelMk($vel){
	$tipo = eregi_replace('[.\0-9\-]','',$vel);
	$val = intval(preg_replace("/[^0-9]/","", $vel));
	switch ($tipo){ 
		case "bps":
			$bytes=$val;
		break;
		case "kbps":
			$bytes=$vel*1024;
		break;
		case "Mbps":
			$bytes=$vel*1024*1024;
		break;
		case "Gbps": 
			$bytes=$vel*1024*1024*1024;
		break;
		case "Tbps":
			$bytes=$vel*1024*1024*1024*1024;
		break;
	}
	return ($bytes);
}
// CONVERTE DADOS DO TRAFEGO
function converteDados($Bytes,$tipo){
     if(!$tipo){
     	if($Bytes<1000){
     		$dados=$Bytes;
     		$texto="By";
     	}else if($Bytes<(1000*1000)){
     		$dados=round(($Bytes/1024), 3);
     		$texto="Kb";
     	}else if($Bytes<(1000*1000*1000)){
     		$dados=round(((($Bytes/1024)/1024)), 3);
     		$texto="Mb";
     	}else if($Bytes<(1000*1000*1000*1000)){
     		$dados=round((((($Bytes/1024)/1024)/1024)), 3);
     		$texto="Gb";
     	}else if($Bytes<(1000*1000*1000*1000*1000)){
     		$dados=round(((((($Bytes/1024)/1024)/1024)/1024)), 3);
     		$texto="Tb";
     	}
     }else{
     	if(($Bytes*8)<(1000*1000)){
     		$dados=round((($Bytes*8)/1024), 3);
     		$texto="Kbps";
     	}else if(($Bytes*8)<(1000*1000*1000)){
     		$dados=round((((($Bytes*8)/1024)/1024)), 3);
     		$texto="Mbps";
          }
     	//$dados=round((($Bytes*8)/1024), 3);
     	//$texto="Kb/s";
     }
     if($dados>0 && $dados != ""){
	    $dados=number_format($dados, 2, '.', '.');
     }
	if($dados==""){
          $dados="";
     }else{
    		$dados=$dados." ".$texto."";
     }
	return ($dados);
}
//CONVERTE O TEMPO DE segundos PARA (hh:mm:ss)
function converteTempo($tempoUsado,$tipo=false){
	if($tempoUsado>3600){
		$hora=floor($tempoUsado/3600);
		$resto=($tempoUsado%3600);
		$dias='';
		if($hora<10){
			$hora="0".$hora;
		}else if($hora>24){
			if($tipo){
				$dias=floor($hora/24).' d - ';
				$hora=($hora%24);
			}
		}
	}else{
		$dias='';
		$hora="00";
		$resto=$tempoUsado;
	}
	if($resto>60){
		$minuto=floor($resto/60);
		$resto=($resto%60);
		if($minuto<10){
			$minuto="0".$minuto;
		}
	}else{
		$minuto="00";
	}
	$segundo=$resto;
	if($segundo<10){
		$segundo="0".$segundo;
	}
	if($tipo){
		if($hora*1>0){
			$hora=$hora." h - ";
		}else{
			$hora='';
		}
		if($minuto*1>0){
			$minuto=$minuto." m - ";
		}else{
			$minuto='';
		}
		$tempo=$dias.$hora.$minuto.$segundo." s";
	}else{
		$tempo=$hora.":".$minuto.":".$segundo;
	}
	return $tempo;
}
//VALIDA CPF
function validaCPF($cpf) {
     /*
     */
     $nulos = array("12345678909","11111111111","22222222222","33333333333","44444444444","55555555555","66666666666","77777777777","88888888888","99999999999","00000000000");
     /* Retira todos os caracteres que nao sejam 0-9 */
     $cpf = ereg_replace("[^0-9]", "", $cpf);

     /*Retorna falso se houver letras no cpf */
     if (!(ereg("[0-9]",$cpf)))
          return false;

     /* Retorna falso se o cpf for nulo */
     if( in_array($cpf, $nulos) )
          return false;

     /*Calcula o pen˙ltimo dÌgito verificador*/
     $acum=0;
     for($i=0; $i<9; $i++) {
       $acum+= $cpf[$i]*(10-$i);
     }

     $x=$acum % 11;
     $acum = ($x>1) ? (11 - $x) : 0;
     /* Retorna falso se o digito calculado eh diferente do passado na string */
     if ($acum != $cpf[9]){
          return false;
     }
     /*Calcula o ˙ltimo dÌgito verificador*/
     $acum=0;
     for ($i=0; $i<10; $i++){
       $acum+= $cpf[$i]*(11-$i);
     }

     $x=$acum % 11;
     $acum = ($x > 1) ? (11-$x) : 0;
     /* Retorna falso se o digito calculado eh diferente do passado na string */
     if ( $acum != $cpf[10]){
          return false;
     }
     /* Retorna verdadeiro se o cpf eh valido */
     return true;
}
//VALIDA CNPJ
function validaCNPJ($cnpj) {
     if (strlen($cnpj) <> 14)
          return false;

     $soma = 0;

     $soma += ($cnpj[0] * 5);
     $soma += ($cnpj[1] * 4);
     $soma += ($cnpj[2] * 3);
     $soma += ($cnpj[3] * 2);
     $soma += ($cnpj[4] * 9);
     $soma += ($cnpj[5] * 8);
     $soma += ($cnpj[6] * 7);
     $soma += ($cnpj[7] * 6);
     $soma += ($cnpj[8] * 5);
     $soma += ($cnpj[9] * 4);
     $soma += ($cnpj[10] * 3);
     $soma += ($cnpj[11] * 2);

     $d1 = $soma % 11;
     $d1 = $d1 < 2 ? 0 : 11 - $d1;

     $soma = 0;
     $soma += ($cnpj[0] * 6);
     $soma += ($cnpj[1] * 5);
     $soma += ($cnpj[2] * 4);
     $soma += ($cnpj[3] * 3);
     $soma += ($cnpj[4] * 2);
     $soma += ($cnpj[5] * 9);
     $soma += ($cnpj[6] * 8);
     $soma += ($cnpj[7] * 7);
     $soma += ($cnpj[8] * 6);
     $soma += ($cnpj[9] * 5);
     $soma += ($cnpj[10] * 4);
     $soma += ($cnpj[11] * 3);
     $soma += ($cnpj[12] * 2);


     $d2 = $soma % 11;
     $d2 = $d2 < 2 ? 0 : 11 - $d2;

     if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
          return true;
     }
     else {
          return false;
     }
}
// CHEKA EMAIL
function checkEmail($eMailAddress) {
    	if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$", $eMailAddress, $check)) {
		return true;
    	}
    	return false;
}
// Retorna o nome do mes portugues
function mes_nome($nmes){
     $meses = array('','Janeiro','Fevereiro','MarÁo','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
     return $meses[$nmes*1];
} 
// RETORNA MAC FORMATADO
function formatMac($Mac){
	//caso tenha ":" tira
	$Mac = str_replace(":" , "", $Mac );
	//caso tenha "-" tira
	$Mac = str_replace("-" , "", $Mac );
	//conta o tamanho da string
	$tipo=strlen($Mac);
	//verifica se √© maior que 1
	if($tipo!=1){
		//verifica se e par
		if($tipo%2==0){
			$endMac=$Mac;
		//verifica se e impar
		}else {
			//separa o primeiro caractere
			$endMac=substr("$Mac", 1, $tipo);
		}
		//pega o tamanho da string modificada
		$tam=strlen($endMac);
		$j=0;
		$newMac="";
		$losMac="";
		//la√ßo para organizar o mac
		for($i=0;$i<$tam/2;$i++){
			$par[$i] = substr("$endMac", $j, 2);
			$losMac=$par[$i]."".$losMac;
			$j=$j+2;
		}
		$j=0;
		//la√ßo para montar o mac
		for($l=$i-1;$l>=0;$l--){
			$par[$l] = substr("$losMac", $j, 2);
			$newMac=$par[$l].":".$newMac;
			$j=$j+2;
		}
		//pega novamente o tamanho atual do mac
		$newTam=strlen($newMac);
		//separa o novo mac
		$newMac=substr("$newMac", 0, $newTam-1);
		//verifica se eh par
		if($tipo%2==0){
			//para par o mac esta pronto
			$novoMac=$newMac;
		}else{
			//para impar separa o primeiro caractere.
			$novoMac=substr("$Mac", 0, 1).":".$newMac;
		}
	}else{
		//caso tenha somente um numero monta o novo mac
		$novoMac=$Mac;
	}
	//retorna o novo resultado
	return($novoMac);
}
// Validate a date
function validaData($data, $formato = 'AAAA-DD-MM') {
	switch($formato) {
		case 'DD-MM-AAAA':
		case 'DD/MM/AAAA':
			$a = substr($data, 5, 4);
			$m = substr($data, 3, 2);
			$d = substr($data, 0, 2);
		break;
		case 'AAAA/MM/DD':
		case 'AAAA-MM-DD':
			$a = substr($data, 0, 4);
			$m = substr($data, 5, 2);
			$d = substr($data, 8, 2);
		break;
		case 'AAAA/DD/MM':
		case 'AAAA-DD-MM':
			$a = substr($data, 0, 4);
			$m = substr($data, 8, 2);
			$d = substr($data, 5, 2);
		break;
		case 'MM-DD-AAAA':
		case 'MM/DD/AAAA':
			$a = substr($data, 5, 4);
			$m = substr($data, 0, 2);
			$d = substr($data, 3, 2);
		break;
		case 'AAAAMMDD':
			$a = substr($data, 0, 4);
			$m = substr($data, 4, 2);
			$d = substr($data, 6, 2);
		break;
		case 'AAAADDMM':
			$a = substr($data, 0, 4);
			$d = substr($data, 4, 2);
			$m = substr($data, 6, 2);
		break;
		
		default:
			throw new Exception( "Formato de data inv·lido");
		break;
	}
	return checkdate(($m*1), ($d*1), ($a*1));
}
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	$rand = mt_rand(1, $len);
	$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}
function gerarUser($texto = "", $tmletras = 1, $tmnum = 5, $maiusculas = true){
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890'; 
	$retorno = '';
	$caracteres = $lmin;
	$letras = $lmin;
	if ($maiusculas) {
		$caracteres .= $lmai;
		$letras = $lmai;
	}
	$lenL = strlen($letras);
	for ($n = 1; $n <= $tmletras; $n++) {
		$rand = mt_rand(1, $lenL);
		$retorno .= $letras[$rand-1];
	}
	$lenN = strlen($num);
	for ($n = 1; $n <= $tmnum; $n++) {
		$rand = mt_rand(1, $lenN);
		$retorno .= $num[$rand-1];
	}
	return $texto."".$retorno;
}
## Envio de Emails pelo SMTP Autenticado usando PEAR
function sendMail($host,$username,$password,$de,$Reply,$Errors,$Priority,$para,$mensagem,$assunto,$anexos){
	if($host==''){
		$host = 'mail.provedor.uvsat.com';
	}
	//
	if($port==''){
		$port = '25';
	}
	//
	if($username==''){
		$username = 'contato@provedor.uvsat.com';
	}
	//
	if($de==''){
	$de = 'contato@provedor.uvsat.com';
	}
	//
	if($de_nome==''){
	$de_nome = 'Provedor UvSat';
	}
	//
	if($password==''){
	$password = 'amb8484';
	}
	
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	include_once("_phpmailer/PHPMailerAutoload.php");
	
	// Inicia a classe PHPMailer
	$mail = new PHPMailer;
	
	// Inicia a classe PHPMailer
	$mail = new PHPMailer;
	
	// Define os dados do servidor e tipo de conex√£o
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->isSMTP();// Define que a mensagem ser√° SMTP
	//$mail->SMTPDebug = 2;
	//$mail->Debugoutput = 'html';
	$mail->Host = $host; // Endere√ßo do servidor SMTP
	$mail->Port = $port;
	$mail->SMTPAuth = true; // Usa autentica√ß√£o SMTP? (opcional)
	$mail->Username = $username; // Usu√°rio do servidor SMTP
	$mail->Password = $password; // Senha do servidor SMTP
	
	// Define o remetente
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->setFrom($de, $de_nome);
	
	// Define os destinat√°rio(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->addAddress($para);
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C√≥pia Oculta
	
	// Define os dados t√©cnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsHTML(true); // Define que o e-mail ser√° enviado como HTML
	//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
	
	// Define a mensagem (Texto e Assunto)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->Subject  = $assunto; // Assunto da mensagem
	$mail->Body = $mensagem;
	$mail->AltBody = $mensagem;
	
	// Define os anexos (opcional)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	if($anexos && $anexos!=''){
		$arrayAnexos=explode(";",$anexos);
		for ($i = 0; $i < count($arrayAnexos); $i++) {
			$mail->addAttachment($arrayAnexos[$i]);
		}
	}
	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");¬  // Insere um anexo
	
	// Envia o e-mail
	if (!$mail->send()) {
		return "Mailer Error: " . $mail->ErrorInfo;
	} else {
		return true;
	}
}
//
function apagar($dir){
	if(is_dir($dir)){  // verifica se realmente È uma pasta
		if($handle = opendir($dir)){
			while(false !== ($file = readdir($handle))){  // varre cada um dos arquivos da pasta
				if(($file == ".") or ($file == "..")){
					continue;
				}
				if(is_dir($dir.$file)){  // verifica se o arquivo atual È uma pasta
					// caso seja uma pasta, faz a chamada para a funcao novamente
					apagar($dir.$file);
				} else {
					// caso seja um arquivo, exclui ele
					unlink($dir.$file);
				}
			}
		} else{
			//print("nao foi possivel abrir o arquivo.");
			return false;
		}
		// fecha a pasta aberta
		closedir($handle);
		// apaga a pasta, que agora esta vazia
		rmdir($dir);
	} else{
		//print("diretorio informado invalido");
		return false;
	}
}
//
function setSessionSistema(){
	$session=array();
	$session["user_auth"]=true;
	$session["user_login"]='sistema';
	$session["user_id"]='1';
	$session["user_id_provedor"]='';
	$session["user_nome_provedor"]='';
	$session["user_codigo_provedor"]='';
	$session["user_senha"]='';
	return $session;
}
?>