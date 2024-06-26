CREATE VIEW `fcv_recebiveis` AS SELECT 
	`x`.id_cliente_caixafc AS id_recebiveisfc,
	`c`.nome_clientesfc AS nome_recebiveisfc,
	DATE_FORMAT(`x`.data_credito_caixafc,"%Y-%m") AS mes_recebiveisfc,
	GROUP_CONCAT(`x`.data_credito_caixafc ORDER BY `x`.datatime_caixafc) AS datas_credito_recebiveisfc,
	GROUP_CONCAT(`x`.data_pagamento_caixafc ORDER BY `x`.datatime_caixafc) AS datas_registro_recebiveisfc,
	ROUND(SUM(`x`.valor_caixafc),2) AS valor_pagamentosfc,
	GROUP_CONCAT(`x`.valor_caixafc ORDER BY `x`.datatime_caixafc DESC) AS valores_recebiveisfc,
	ROUND(SUM(`x`.valor_desconto_caixafc),2) AS desconto_recebiveisfc,
	GROUP_CONCAT(`x`.valor_desconto_caixafc ORDER BY `x`.datatime_caixafc DESC) AS descontos_recebiveisfc,
  	ROUND((SUM(`x`.valor_caixafc)+SUM(`x`.valor_desconto_caixafc)),2) AS total_recebiveisfc,
	ROUND(SUM(`x`.valor_taxa_caixafc),2) AS taxa_recebiveisfc,
	GROUP_CONCAT(`x`.valor_taxa_caixafc ORDER BY `x`.datatime_caixafc DESC) AS taxas_recebiveisfc,
	ROUND((SUM(`x`.valor_caixafc)-SUM(`x`.valor_taxa_caixafc)),2) AS saldo_recebiveisfc,
	GROUP_CONCAT(`x`.id_caixafc ORDER BY `x`.datatime_caixafc DESC) AS ids_recebiveisfc,
 	COUNT(*) AS itens_recebiveisfc,
	`x`.user_login AS user_recebiveisfc,
	`c`.grupo_parceria,
	MAX(`x`.data_pagamento_caixafc) AS dates_recebiveisfc, 
	`c`.email_clientesfc AS email_recebiveisfc,
	CONCAT(`c`.`tel1_clientesfc`,IF(`c`.`tel2_clientesfc`!='',CONCAT('|',`c`.`tel2_clientesfc`,IF(`c`.`tel3_clientesfc`!='',CONCAT('|',`c`.`tel3_clientesfc`),'')),'')) AS tels_recebiveisfc,
  	`x`.id_provedor 
  	FROM `fc_caixa` AS `x` 
  	INNER JOIN fc_clientes AS `c` ON `c`.`id_clientesfc`=`x`.`id_cliente_caixafc`
  	WHERE `x`.tipo_caixafc='in' AND `x`.id_cliente_caixafc!=0 AND `x`.cancelado_caixafc!='on'
	GROUP BY `x`.id_cliente_caixafc,DATE_FORMAT(`x`.data_credito_caixafc,"%Y-%m") 
	
	SELECT nome_clientesfc as NOME,DATE_FORMAT(datatime_clientesfc,"%m/%Y") AS INSTALACAO,sit_clientesfc as SIT,ROUND((SUM(`x`.valor_caixafc)-SUM(`x`.valor_taxa_caixafc)),2) AS PAGAMENTOS FROM fc_clientes AS `c`
INNER JOIN fc_caixa AS `x` ON `c`.`id_clientesfc`=`x`.`id_cliente_caixafc` 
WHERE `c`.`grupo_parceria`='lisboa'
GROUP BY `c`.`id_clientesfc`  
ORDER BY `c`.`nome_clientesfc` ASC