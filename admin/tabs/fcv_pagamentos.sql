CREATE VIEW `fcv_pagamentos` AS SELECT 
	`x`.id_cliente_caixafc AS id_pagamentosfc,
	`c`.nome_clientesfc AS nome_pagamentosfc,
	DATE_FORMAT(`x`.data_caixafc,"%Y-%m") AS mes_pagamentosfc,
	GROUP_CONCAT(`x`.data_pagamento_caixafc ORDER BY `x`.datatime_caixafc) AS datas_pagamentosfc,
	GROUP_CONCAT(`x`.data_credito_caixafc ORDER BY `x`.datatime_caixafc) AS datas_credito_pagamentosfc,
	ROUND(SUM(`x`.valor_caixafc),2) AS valor_pagamentosfc,
	GROUP_CONCAT(`x`.valor_caixafc ORDER BY `x`.datatime_caixafc DESC) AS valores_pagamentosfc,
	ROUND(SUM(`x`.valor_desconto_caixafc),2) AS desconto_pagamentosfc,
	GROUP_CONCAT(`x`.valor_desconto_caixafc ORDER BY `x`.datatime_caixafc DESC) AS descontos_pagamentosfc,
  	ROUND((SUM(`x`.valor_caixafc)+SUM(`x`.valor_desconto_caixafc)),2) AS total_pagamentosfc,
	ROUND(SUM(`x`.valor_taxa_caixafc),2) AS taxa_pagamentosfc,
	GROUP_CONCAT(`x`.valor_taxa_caixafc ORDER BY `x`.datatime_caixafc DESC) AS taxas_pagamentosfc,
	ROUND((SUM(`x`.valor_caixafc)-SUM(`x`.valor_taxa_caixafc)),2) AS saldo_pagamentosfc,
	GROUP_CONCAT(`x`.id_caixafc ORDER BY `x`.datatime_caixafc DESC) AS ids_pagamentosfc,
 	COUNT(*) AS itens_pagamentosfc,
	`x`.user_login AS user_pagamentosfc,
	`c`.grupo_parceria,
	MAX(`x`.data_pagamento_caixafc) AS dates_pagamentosfc, 
	`c`.email_clientesfc AS email_pagamentosfc,
	CONCAT(`c`.`tel1_clientesfc`,IF(`c`.`tel2_clientesfc`!='',CONCAT('|',`c`.`tel2_clientesfc`,IF(`c`.`tel3_clientesfc`!='',CONCAT('|',`c`.`tel3_clientesfc`),'')),'')) AS tels_pagamentosfc,
  	GROUP_CONCAT(`x`.datatime_caixafc ORDER BY `x`.datatime_caixafc) AS datatimes_pagamentosfc,
	`x`.id_provedor 
  	FROM `fc_caixa` AS `x` 
  	INNER JOIN fc_clientes AS `c` ON `c`.`id_clientesfc`=`x`.`id_cliente_caixafc`
  	WHERE `x`.tipo_caixafc='in' AND `x`.id_cliente_caixafc!=0 AND `x`.cancelado_caixafc!='on'
	GROUP BY `x`.id_cliente_caixafc,DATE_FORMAT(`x`.data_caixafc,"%Y-%m") 
	