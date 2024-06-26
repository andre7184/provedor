<?php 
$host_server="http://provedor.uvsat.com";
$url = $_REQUEST["url"];
$arg = $_REQUEST["arg"];
?>
<html>
     <head>
          <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
          <meta http-equiv="pragma" content="no-cache" />
          <meta http-equiv="expires" content="-10" />
     </head>
     </head>
     <body>
		<center>
			<div style="width: 700;">
				<div style="width: 400;color:blue;">
					<img src="<? echo $host_server;?>/facil/bloqueio/alerta.png" border="0"/><br>
					<h2>Acesso Bloqueado</h2>
				</div>
				<h3>Olá, Seu cadastro pussui pendências, para maiores informações ligue em nossa central <B>(67)3354-7927</B> ou envie msg para whatsapp <B>6791397194</B> e Email:<B>contato@uvsat.com</B></h3>
				<h4>Caso deseje imprimir o boleto para pagamento acesse:<br>
				<center><a href="http://provedor.uvsat.com/facil/cob">http://provedor.uvsat.com/facil/boleto</a></center></h4>
				<font color=red>
				<h5>
					<img src="<? echo $host_server;?>/facil/aviso/warning.png" border="0"/> 05 dias úteis após o vencimento seu aceso será bloqueado!<br>
					<img src="<? echo $host_server;?>/facil/aviso/warning.png" border="0"/> Pague em dia e evite suspensão ou bloqueio definitivo do serviço!<br>
					<img src="<? echo $host_server;?>/facil/aviso/warning.png" border="0"/> Antenas em comodato poderá ser retirada após 30 dias bloqueado.</h5>
				</font>
			</div>
		</center>
     </body>
</html>