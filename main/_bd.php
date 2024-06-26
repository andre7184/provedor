<style>
 .tela { width: 650px;margin: auto;border: solid 1px #000; }
 .cabecalho { width:100%;line-height:13px;text-align:right;padding: 2px 3px 1px 2px; }
 .end { width: 300px;margin: auto; }
 .ff_A { font-family: Arial, Verdana, Times; }
 .ff_B { font-family: Verdana, Arial, Times; }
 .sf_P { font-size:8px; }
 .sf_M { font-size:11px; }
 .sf_G { font-size:16px;margin: 0; }
 .wf_B { font-weight: bold; }
 .wf_N { font-weight: normal; }
 .at_R { text-align:right; }
 .at_C { text-align:center; }
 .at_L { text-align:left; }
 .float_L { float:left; }
 .autenticacao { margin-top: 15px;width: 100%; }
 .cell_1A { padding: 0 3px 0 3px;border-left: solid 1px #000;border-top: solid 1px #000; }
 .cell_3A { padding: 0 3px 0 3px;border-left: solid 1px #000; }
 .cell_5 { border-top: solid 1px #000; }
 .cell_7 { padding: 1px 3px 1px 3px;border-left: solid 2px #2F589B;border-right: solid 2px #2F589B;border-bottom: solid 1px #000; }
 .corte_1 { line-height:16px; border-bottom:1px dashed #000;margin: 2px; }
</style>
	<!-- numero,provedornome,provedorend,provedorcnpj,provedortel1,provedortel2,provedoremail,provedorsite,nome,valor,nomecliente,cpfcnpjcliente,valorextenso,descricao,data,tiporecebimento,md5recibo,nomerecebedor -->
	<div class="tela">
		<div class="cabecalho ff_A sf_M">
			<img src="../data/grupo.php?g=%grupo%" height="50px" class="float_L" />
			<b>%provedornome%</b> - %provedorcnpj%<br><font class="end">%provedorend1%<br>Tels:%provedortel1%</font><br>E-mail:%provedoremail%			
		</div>
		<table border=0 cellpading="0" cellspacing="0" width="100%">
			<tr>
				<td class="ff_A sf_P cell_5">Via Cliente</td>
				<td class="ff_A sf_P cell_5 at_R" >N° %numero%</td>
			</tr>
			<tr>
				<td class="ff_A sf_G wf_B  at_R" width="60%">%nome%<Br><Br></td>
				<td class="ff_A sf_G wf_B at_R" ><br>R$ %valor%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">Recebemos de</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" colspan="2">%nomecliente% - %cpfcnpjcliente%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">A importância de</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" colspan="2">%valorextenso%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">Referente à (Informações dos Titulos):</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" valign="top" colspan="2">
					<table cellspacing="0" cellspacing="0" border="0" width="100%">
						<tr>
							<th class="ff_A sf_M wf_B at_L" colspan="2">%descricao%</th>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5">Em Data</td>
				<td class="ff_A sf_P cell_1A">Tipo do pagamento</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B">%data%</td>
				<td class="ff_A sf_M cell_3A wf_B">%tiporecebimento%</td>
			</tr>
			<tr>
				<td class="ff_B sf_M cell_5 at_C" colspan="2">
					<font class="wf_B">%md5recibo%</font><br>Autenticação/Assinatura
				</td>
			</tr>
		</table>
	</div>
	<div class="corte_1 ff_B sf_P">Corte na linha pontilhada</div>
	<div class="tela">
		<table border=0 cellpading="0" cellspacing="0" width="100%">
			<tr>
				<td class="ff_A sf_P">Via Empresa</td>
				<td class="ff_A sf_P cell_3A">Empresa</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B">%nome% - (%grupo%)</td>
				<td class="ff_A sf_M cell_3A wf_B">%provedornome%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">Cliente</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" colspan="2">%nomecliente% - %cpfcnpjcliente%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5">Local de Recebimento</td>
				<td class="ff_A sf_P cell_1A">Valor do Recibo</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B">%nomerecebedor%</td>
				<td class="ff_A sf_M cell_3A wf_B">R$ %valor%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5">Em Data</td>
				<td class="ff_A sf_P cell_1A">Tipo do pagamento</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B">%data%</td>
				<td class="ff_A sf_M cell_3A wf_B">%tiporecebimento%</td>
			</tr>
			<tr>
				<td class="ff_B sf_M cell_5 at_C">
				Data Recebido do Antendente:______/_____/_______
				</td>
				<td class="ff_B sf_M cell_5 at_R">
				N° %numero%
				</td>
			</tr>
		</table>
	</div>
	<div class="corte_1 ff_B sf_P">Corte na linha pontilhada</div>
	<div class="tela">
		<table border=0 cellpading="0" cellspacing="0" width="100%">
			<tr>
				<td class="ff_A sf_P">Via Antendente (Nome Empresa)</td>
				<td class="ff_A sf_P cell_3A" width="70px" colspan="2">Data Movimentação</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B">%provedornome% - (%grupo%)</td>
				<td class="ff_A sf_M cell_3A wf_B" colspan="2">%data%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">Cliente</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" colspan="2">%nomecliente% - %cpfcnpjcliente%</td>
			</tr>
			<tr>
				<td class="ff_A sf_P cell_5" colspan="2">Informações da Movimentação:</td>
			</tr>
			<tr>
				<td class="ff_A sf_M wf_B" valign="top">
					<table cellspacing="0" cellspacing="0" border="0" width="100%">
						<tr>
							<th class="ff_A sf_M at_L wf_B">Valor: <font class="wf_N">%valor%</font></th>
							<th class="ff_A sf_M at_L wf_B">Tipo: <font class="wf_N">%tiporecebimento%</font></th>
						</tr>
					</table>
				</td>
				<td class="ff_B sf_M at_R">
				N° %numero%
				</td>
			</tr>
			<tr>
				<td class="ff_B sf_M cell_5 at_C" colspan="2">
				Pago p/ Empresa Em:______/_____/_______		Valor R$ ______________		Ass:________________________
				</td>
			</tr>
		</table>
	</div>