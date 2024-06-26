-- FUNCTION `NEW_COMMENT`(`id_cliente` INT, `id_secret` INT)
BEGIN
	declare COMENTATIO LONGTEXT;
	SET COMENTATIO=(SELECT CONCAT(id_secret,'# ',`grupo_idadosfc`,' - ',`nome_idadosfc`,' - ',venc_idadosfc,' - ',`sit_idadosfc`,'-',IF(`vencido_idadosfc`='on',CONCAT('vc(',`dias_dividas_idadosfc`,'dias)'),'pg')) FROM `fcv_idados` WHERE `id_idadosfc`=id_cliente);
	RETURN COMENTATIO;
END