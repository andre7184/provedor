CREATE VIEW `fcv_debitos` AS SELECT 
	`i`.`id_cliente_itensfc` AS id_debitosfc,
	`c`.`sit_clientesfc` AS sit_debitosfc,
	`i`.`datatime_itensfc` AS datatime_debitosfc,
	`c`.`nome_clientesfc` AS cliente_debitosfc,
	`c`.`cpf_cnpj_clientesfc` AS doc_debitosfc,
	`c`.`email_clientesfc` AS email_debitosfc,
	CONCAT(`c`.`tel1_clientesfc`,'|',`c`.`tel2_clientesfc`,'|',`c`.`tel3_clientesfc`) AS telefones_debitosfc,
	`c`.`end1_clientesfc` AS end_debitosfc,
	`c`.`num1_clientesfc` AS end_num_debitosfc,
	`c`.`bar1_clientesfc` AS end_bar_debitosfc,
	`c`.`cep1_clientesfc` AS end_cep_debitosfc,
	`c`.`cid1_clientesfc` AS cidade_debitosfc,
	`c`.`uf1_clientesfc` AS uf_debitosfc,
	`c`.`comp1_clientesfc` AS end_comp_debitosfc,
	`c`.`bol_clientesfc` AS bol_debitosfc,
	`c`.`sendsms_clientesfc` AS sendsms_debitosfc,
	`c`.`sendemail_clientesfc` AS sendemail_debitosfc,
	`c`.`venc_clientesfc` AS vc_cliente_debitosfc,
	DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") AS mes_debitosfc,
	GROUP_CONCAT(`i`.`nome_itensfc` SEPARATOR ';') AS nome_debitosfc,
	GROUP_CONCAT(`i`.`inicio_periodo_itensfc`,'|',`i`.`fim_periodo_itensfc` SEPARATOR ';') AS periodo_debitosfc,
 	GROUP_CONCAT(`i`.`descricao_itensfc` SEPARATOR ';') AS descricao_debitosfc,
  	ROUND(SUM(`i`.`valor_total_itensfc`),2) AS total_debitosfc,
  	`c`.`grupo_parceria`,
  	`i`.`id_provedor` AS id_provedor
  	FROM `fc_itens` AS `i`
  	INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`i`.`id_cliente_itensfc`
  	WHERE `c`.`sit_clientesfc`!='inativo' AND `i`.`tipo_itensfc`='+' AND `i`.`id_vendas_itensfc`=0 AND `i`.`cancelado_itensfc`!='on'
	GROUP BY `i`.`id_cliente_itensfc`,DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") 

