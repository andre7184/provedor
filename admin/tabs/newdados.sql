SELECT 
	`d`.`codigo_clientes` AS codigo,
	`d`.`datatime_clientes` AS datatime_clientesfc,
	`c`.`nome_pessoais` AS nome_clientesfc,
	REPLACE(REPLACE(`c`.`cpf_cnpj_pessoais`,'.',''),'-','') AS cpf_cnpj_clientesfc,
	CONCAT(`c`.`rg_numero_pessoais`,`c`.`rg_org_pessoais`,'/',`c`.`rg_uf_pessoais`) AS rg_ie_clientesfc,
	`c`.`data_nascimento_pessoais` AS data_nascimento_clientesfc,
	CONCAT(`e`.`tipo_logradouro_enderecos`,' ',`e`.`logradouro_enderecos`) AS end1_clientesfc,
	`e`.`numero_enderecos` AS num1_clientesfc,
	`e`.`bairro_enderecos` AS bar1_clientesfc,
	`e`.`cep_enderecos` AS cep1_clientesfc,
	`e`.`cidade_enderecos` AS cid1_clientesfc,
	`e`.`uf_enderecos` AS uf1_clientesfc,
	`e`.`complementos_enderecos` AS comp1_clientesfc,
	`e`.`latitude_enderecos` AS lat1_clientesfc,
	`e`.`longitude_enderecos` AS long1_clientesfc,
	'on' AS cob1_clientesfc,
	`c`.`telefone1_numero_pessoais` AS tel1_clientesfc,
	'' AS op1_clientesfc,
	`c`.`telefone1_nome_pessoais` AS nome1_clientesfc,
	`c`.`telefone2_numero_pessoais` AS tel2_clientesfc,
	'' AS op2_clientesfc,
	`c`.`telefone2_nome_pessoais` AS nome2_clientesfc,
	`c`.`telefone3_numero_pessoais` AS tel3_clientesfc,
	'' AS op3_clientesfc,
	`c`.`telefone3_nome_pessoais` AS nome3_clientesfc,
	`c`.`email_1_pessoais` AS email_clientesfc,
	IF(`d`.`dia_vencimento_clientes` < '5','5',`d`.`dia_vencimento_clientes`) AS venc_clientesfc,
	`d`.`acesso_gratis_clientes` AS acesso_gratis_clientesfc,
	`d`.`desativar_encargos_clientes` AS desativar_juros_clientesfc,
	`d`.`desativar_bloqueio_clientes` AS destivar_bloqueio_clientesfc,
	'50' AS valor_bloqueio_clientesfc,
	'0' AS porcentagem_cobrar_bloqueio_clientesfc,
	IF(`d`.`sit_clientes`='AT','ativo','bloqueado') AS sit_clientesfc,
	`c`.`obs_pessoais` AS obs_clientesfc,
	CONCAT('MENSALIDADE ',`p`.`nome_servicos`) AS descricao_mensalfc,
	'2017-02-02' AS data_ativado_mensalfc,
	`p`.`valor_servicos` AS valor_sevmensalfc,
	`d`.`valor_desconto_clientes` AS valor_desconto_mensalfc,
	'on' AS ponto_sevmensalfc,
	'on' AS end_cob_sevmensalfc,
	'pppoe' AS tipo_auth_sevmensalfc,
	`a`.`equipamento_receptor_pontos` AS equipamentos_sevmensalfc,
	IF(`a`.`tipo_equipamento_pontos`='alugado','on','') AS comodato_sevmensalfc,
	`u`.`login_user` AS user_sevmensalfc,
	'ativo' AS sit_mensalfc,
	GROUP_CONCAT(`b`.`vencimento_cobdeb` SEPARATOR ';') AS datas_debitos_anterior,
	ROUND(SUM(`b`.`valor_cobdeb`),2) AS valor_debitos_anterior,
	'tecnet' AS grupo_parceria,
	'2' AS id_provedor
 	FROM `sis_dados_pessoais` AS `c`
  	INNER JOIN `sis_clientes_dados` AS `d` ON `d`.`codigo_clientes`=`c`.`codigo_pessoais`
  	INNER JOIN `sis_dados_enderecos` AS `e` ON `e`.`codigo_enderecos`=`c`.`codigo_pessoais` AND `e`.`padrao_enderecos`='on'
  	INNER JOIN `sis_servicos_alocados` AS `s` ON `s`.`codigo_clientes_alocados`=`c`.`codigo_pessoais` AND `s`.`sit_servicos_alocados`='ATIVO'
  	INNER JOIN `sis_servicos` AS `p` ON `p`.`id_servicos`=`s`.`cod_servicos_alocados`
  	left JOIN `sis_cobrancas_debitos` AS `b` ON `b`.`codigo_conta_cobdeb`=`c`.`codigo_pessoais` AND `b`.`sit_cobdeb`='vc'
  	left JOIN `sis_dados_pontos` AS `a` ON `a`.`codigo_pontos`=`c`.`codigo_pessoais`
  	left JOIN `sis_dados_user` AS `u` ON `u`.`codigo_user`=`c`.`codigo_pessoais`
  	WHERE `c`.`codigo_provedor`='66665770' AND `d`.`sit_clientes`='AT' OR (`d`.`data_bloqueio_clientes` > DATE_SUB(curdate(),INTERVAL 2 MONTH))
  	 group by `c`.`codigo_pessoais`
  	 
  	 
  	 INSERT INTO `fc_itens` (`id_itensfc`, `datatime_itensfc`, `nome_itensfc`, `tipo_itensfc`, `inicio_periodo_itensfc`, `fim_periodo_itensfc`, `descricao_itensfc`, `data_itensfc`, `data_origem_itensfc`, `id_pagamento_itensfc`, `dif_itensfc`, `desconto_itensfc`, `acrescimo_itensfc`, `valor_itensfc`, `qtd_itensfc`, `valor_total_itensfc`, `cancelado_itensfc`, `id_cliente_itensfc`, `id_vendas_itensfc`, `user_registro_item`, `id_parceria_itensfc`, `id_provedor`) VALUES (NULL, '2017-02-09 11:18:29', 'DEBITO', '+', '0000-00-00', '0000-00-00', 'DEBITO MES 01/2017 OU ANTERIOR', '2017-02-25', '2017-02-25', '0', '', '0', '0', '10', '1', '10', '', '1', '0', 'sistema', '0', '2');
  	 
  	 