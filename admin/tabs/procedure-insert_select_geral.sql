-- `insert_select_geral`(IN `p_campo` VARCHAR(50), IN `p_tabela` VARCHAR(50), IN `p_condicao` VARCHAR(50), IN `p_valor` VARCHAR(50))
BEGIN
	declare VAR varchar(255);
	IF(p_campo='') THEN
    	SET @VAR = CONCAT("INSERT INTO bd_select SET md5_selectbd='",MD5(CONCAT(p_campo,p_tabela,p_condicao,p_valor)),"', valor_selectbd=(SELECT * from  ", p_tabela," WHERE ",p_condicao,"='",p_valor,"')");
    ELSE
		SET @VAR = CONCAT("INSERT INTO bd_select SET md5_selectbd='",MD5(CONCAT(p_campo,p_tabela,p_condicao,p_valor)),"', valor_selectbd=(SELECT ",p_campo," from  ",p_tabela," WHERE ",p_condicao,"='",p_valor,"')");
	END IF;
	PREPARE my_Statement FROM @VAR;
    EXECUTE my_Statement;
END