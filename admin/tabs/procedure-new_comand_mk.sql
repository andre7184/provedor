-- `new_comand_mk`(IN `acao` VARCHAR(50), IN `id` INT, IN `mk` VARCHAR(50), IN `provedor` INT)
BEGIN
	-- declare N int(5) default 0;
	declare COMANDOS LONGTEXT;
	declare DADOSMD5 VARCHAR(32);
    SET COMANDOS=RETURN_COMANDOS_MK(acao,id);
	INSERT INTO mk_comandos (md5_comandos_mk, data_comandos_mk, router_comandos_mk, linha_comandos_mk, motivo_comandos_mk, sit_comandos_mk, id_provedor) SELECT MD5(CONCAT(provedor,mk,COMANDOS)), NOW(), mk, COMANDOS, acao, 'pronto', provedor FROM DUAL WHERE NOT EXISTS (SELECT md5_comandos_mk, data_comandos_mk, router_comandos_mk, linha_comandos_mk, motivo_comandos_mk, sit_comandos_mk, id_provedor FROM mk_comandos WHERE sit_comandos_mk = 'pronto' AND md5_comandos_mk=MD5(CONCAT(provedor,mk,COMANDOS)));
    -- 
END