CREATE VIEW `fca_clientes` AS SELECT 
`c`.`nome_clientesfc` AS Nome,
`c`.`sit_clientesfc` AS Sit,
IF(`m`.`tempo_mensalfc`>0,'on','') AS Vc,
CONCAT(`c`.`end1_clientesfc`,', ',`c`.`num1_clientesfc`,' - ',`c`.`bar1_clientesfc`,' - ',`c`.`cid1_clientesfc`,'-',`c`.`uf1_clientesfc`) AS End,
`c`.`comp1_clientesfc` AS Comp,
`c`.`lat1_clientesfc` AS Lat, 
`c`.`long1_clientesfc` AS Lon, 
IF(`c`.`nome1_clientesfc`!='',CONCAT(`c`.`tel1_clientesfc`,'(',`c`.`nome1_clientesfc`,')'),`c`.`tel1_clientesfc`) AS Tel1, 
IF(`c`.`nome2_clientesfc`!='',CONCAT(`c`.`tel2_clientesfc`,'(',`c`.`nome2_clientesfc`,')'),`c`.`tel2_clientesfc`) AS Tel2, 
IF(`c`.`nome3_clientesfc`!='',CONCAT(`c`.`tel3_clientesfc`,'(',`c`.`nome3_clientesfc`,')'),`c`.`tel3_clientesfc`) AS Tel3, 
`c`.`email_clientesfc` AS Email, 
`c`.`venc_clientesfc` AS Venc,
`c`.`grupo_parceria` AS Grupo,
SUM(IF(`s`.`ponto_sevmensalfc`='on','1','0')) AS Pontos,
COUNT(`s`.`id_mensalfc`) AS Serv,
IF((SELECT COUNT(*) FROM `fc_sevmensal` AS `sm` WHERE `sm`.`id_cliente_mensalfc`=`c`.`id_clientesfc` AND DATE_FORMAT(`sm`.`data_ativado_mensalfc`,"%Y-%m-02")<=DATE_SUB(DATE_FORMAT(CURDATE(),"%Y-%m-02"),INTERVAL 1 MONTH))>0,'OK','ERROR(Sem Fatura)') AS Cd,
REPLACE(REPLACE(REPLACE(FORMAT(ROUND(SUM(IFNULL(`s`.`valor_sevmensalfc`,'0')) - SUM(IFNULL(`s`.`valor_desconto_mensalfc`,'0')) + SUM(IFNULL(`s`.`valor_acrescimo_mensalfc`,'0')),2), 2),'.',';'),',','.'),';',',') AS Mensalidade,
GROUP_CONCAT(`u`.`name_secretpp`) AS Secrets,
GROUP_CONCAT(`u`.`mk_secretpp`) AS Mk,
GROUP_CONCAT(`u`.`profile_secretpp`) AS Profile,
REPLACE(REPLACE(REPLACE(FORMAT(ROUND(IFNULL(`m`.`valor_mensalfc`,'0'),2), 2),'.',';'),',','.'),';',',') AS Divida,
IFNULL(`m`.`qtd_mensalfc`,'0') AS `Qtd_divida`,
`m`.`tempo_mensalfc` AS `Tempo_divida`,
`m`.`data_mensalfc` AS `Datas_dividas`,
`m`.`mes_mensalfc` AS `Meses_dividas`,
`m`.`md5_mensalfc` AS `Md5_dividas`,
`m`.`valores_mensalfc` AS `Valores_dividas`,
`m`.`encargos_mensalfc` AS `Encargos_dividas`,
`m`.`dias_mensalfc` AS `Dias_dividas`,
`c`.`cpf_cnpj_clientesfc` AS Doc,
`c`.`bar1_clientesfc` AS Bairro,
`c`.`end1_clientesfc` AS Rua,
`c`.`cid1_clientesfc` AS Cidade,
`c`.`id_clientesfc` AS Id,
(SELECT CONCAT(`id_bloqueiosfc`,'|',DATE_FORMAT(`data_bloqueiosfc`,"%d/%m/%Y"),'|',`motivo_bloqueiosfc`,'|',`data_fim_bloqueiosfc`,'|',`motivo_fim_bloqueiosfc`) FROM `fc_bloqueios` WHERE `id_cliente_bloqueiosfc`=`c`.`id_clientesfc` ORDER BY id_bloqueiosfc DESC LIMIT 1) AS Bloqueio,
`c`.`id_provedor` AS Provedor
FROM `fc_clientes` AS `c` 
LEFT JOIN `fca_mensalidades` AS `m` ON `m`.`id_mensalfc`=`c`.`id_clientesfc`
LEFT JOIN `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
LEFT JOIN `mk_secretpp` AS `u` on `u`.`id_secretpp`=`s`.`id_user_sevmensalfc` and  `u`.`id_cliente_secretpp`=`c`.`id_clientesfc`
GROUP BY `c`.`id_clientesfc`
//
CREATE VIEW `fca_clientes` AS SELECT 
`c`.`nome_clientesfc` AS Nome,
`c`.`sit_clientesfc` AS Sit,
IF(`m`.`valor_atual_cobrancasfc` IS NULL,'','on') AS Vc,
CONCAT(`c`.`end1_clientesfc`,', ',`c`.`num1_clientesfc`,' - ',`c`.`bar1_clientesfc`,' - ',`c`.`cid1_clientesfc`,'-',`c`.`uf1_clientesfc`) AS End,
`c`.`comp1_clientesfc` AS Comp,
`c`.`lat1_clientesfc` AS Lat, 
`c`.`long1_clientesfc` AS Lon, 
IF(`c`.`nome1_clientesfc`!='',CONCAT(`c`.`tel1_clientesfc`,'(',`c`.`nome1_clientesfc`,')'),`c`.`tel1_clientesfc`) AS Tel1, 
IF(`c`.`nome2_clientesfc`!='',CONCAT(`c`.`tel2_clientesfc`,'(',`c`.`nome2_clientesfc`,')'),`c`.`tel2_clientesfc`) AS Tel2, 
IF(`c`.`nome3_clientesfc`!='',CONCAT(`c`.`tel3_clientesfc`,'(',`c`.`nome3_clientesfc`,')'),`c`.`tel3_clientesfc`) AS Tel3, 
`c`.`email_clientesfc` AS Email, 
`c`.`venc_clientesfc` AS Venc,
`c`.`grupo_parceria` AS Grupo,
SUM(IF(`s`.`ponto_sevmensalfc`='on','1','0')) AS Pontos,
COUNT(`s`.`id_mensalfc`) AS Serv,
'' AS Cd,
REPLACE(REPLACE(REPLACE(FORMAT(ROUND(SUM(IFNULL(`s`.`valor_sevmensalfc`,'0')) - SUM(IFNULL(`s`.`valor_desconto_mensalfc`,'0')) + SUM(IFNULL(`s`.`valor_acrescimo_mensalfc`,'0')),2), 2),'.',';'),',','.'),';',',') AS Mensalidade,
GROUP_CONCAT(`u`.`name_secretpp`) AS Secrets,
GROUP_CONCAT(`u`.`mk_secretpp`) AS Mk,
GROUP_CONCAT(`u`.`profile_secretpp`) AS Profile,
SUM(`m`.`valor_atual_cobrancasfc`) AS Divida,
COUNT(`m`.`mes_cobrancasfc`) AS `Qtd_divida`,
MAX(DATEDIFF(CURDATE(),SPLIT_STRING(`m`.`vencimento_cobrancasfc`,',',1))) AS `Tempo_divida`,
GROUP_CONCAT(`m`.`vencimento_cobrancasfc`) AS `Datas_dividas`,
GROUP_CONCAT(`m`.`mes_cobrancasfc`) AS `Meses_dividas`,
'' AS `Md5_dividas`,
GROUP_CONCAT(`m`.`valor_atual_cobrancasfc`) AS `Valores_dividas`,
SUM(`m`.`valor_encargos_cobrancasfc`) AS `Encargos_dividas`,
'' AS `Dias_dividas`,
`c`.`cpf_cnpj_clientesfc` AS Doc,
`c`.`bar1_clientesfc` AS Bairro,
`c`.`end1_clientesfc` AS Rua,
`c`.`cid1_clientesfc` AS Cidade,
`c`.`id_clientesfc` AS Id,
'' AS Bloqueio,
`c`.`id_provedor` AS Provedor
FROM `fc_clientes` AS `c` 
LEFT JOIN `fcv_cobrancas` AS `m` ON `m`.`id_cobrancasfc`=`c`.`id_clientesfc` AND `m`.`valor_atual_cobrancasfc` > 0 AND `m`.`vencimento_cobrancasfc` < CURDATE()
LEFT JOIN `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
LEFT JOIN `mk_secretpp` AS `u` on `u`.`id_secretpp`=`s`.`id_user_sevmensalfc` and  `u`.`id_cliente_secretpp`=`c`.`id_clientesfc`
GROUP BY `c`.`id_clientesfc`


