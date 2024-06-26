CREATE VIEW `fcv_recibos` AS SELECT 
	`cl`.`grupo_parceria` AS grupo_recibofc,
	`ca`.`id_caixafc` AS numero_recibofc,
	`pr`.`nome_provedorfc` AS provedornome_recibofc,
	CONCAT(`pr`.`endereco1_provedorfc`,', ',`pr`.`numero1_provedorfc`,'-',`pr`.`bairro1_provedorfc`) AS provedorend_recibofc,
	`pr`.`cpf_cnpj_provedorfc` AS provedorcnpj_recibofc,
	`pr`.`telefone_provedorfc` AS provedortel1_recibofc,
	`pr`.`email_provedorfc` AS provedoremail_recibofc,
	`pr`.`site_provedorfc` AS provedorsite_recibofc,
	REPLACE(REPLACE(REPLACE(FORMAT(ROUND(IFNULL(`ca`.`valor_caixafc`,'0'),2), 2),'.',';'),',','.'),';',',') AS valor_recibofc,
	`ca`.`mes_caixafc` AS mes_recibofc,
	IF(`ca`.`text_mes_caixafc` IS NULL,'Título avulso.',CONCAT('Cobrança(s) mês(es): ',`ca`.`text_mes_caixafc`)) AS referente_recibofc,
	`cl`.`nome_clientesfc` AS nomecliente_recibofc,
	`cl`.`cpf_cnpj_clientesfc` AS cpfcnpjcliente_recibofc,
	DATE_FORMAT(`ca`.`data_pagamento_caixafc`,"%d/%m/%Y") AS data_recibofc,
	DATE_FORMAT(`ca`.`data_credito_caixafc`,"%d/%m/%Y") AS data_credito_recibofc,
	`ca`.`especie_caixafc` AS tiporecebimento_recibofc,
	`ca`.`origem_caixafc` AS localrecebimento_recibofc,
	`ca`.`user_login` AS nomerecebedor_recibofc,
	`ca`.`id_provedor` AS id_provedor,
	`pr`.`texto_recibo_provedorfc` AS provedorlayout_recibofc,
	MD5(CONCAT(`ca`.`id_caixafc`,`ca`.`valor_caixafc`,`ca`.`data_pagamento_caixafc`,`cl`.`id_clientesfc`,`cl`.`grupo_parceria`,`ca`.`id_provedor`)) AS md5recibo_recibofc
  	FROM `fc_caixa` AS `ca`
  	INNER JOIN `fc_clientes` AS `cl` ON `cl`.`id_clientesfc`=`ca`.`id_cliente_caixafc`
   	INNER JOIN `fc_provedor` AS `pr` ON `pr`.`id_provedorfc`=`ca`.`id_provedor`
  	WHERE `ca`.`tipo_caixafc`='in' AND `ca`.`valor_caixafc` > 0
	ORDER BY `ca`.`id_caixafc` DESC
