BEGIN
	declare done INT DEFAULT 0;
  	declare DATA VARCHAR(20);
  	declare HORA VARCHAR(2);
  	declare MXTX INT;
  	declare MDTX INT;
  	declare MXRX INT;
  	declare MDRX INT;
  	declare PROVEDOR INT;
  	declare NAME VARCHAR(50);
  	declare TARGET VARCHAR(50);
  	declare MK VARCHAR(50);
	DECLARE curs CURSOR FOR (
		SELECT name_logqueue, target_logqueue, mk_logqueue, DATE_FORMAT(datatime_logqueue, "%Y-%m-%d") AS data, DATE_FORMAT(datatime_logqueue, "%H") AS hora, MAX(tx_logqueue) AS maior_tx, AVG(tx_logqueue) AS media_tx, MAX(rx_logqueue) AS maior_rx, AVG(rx_logqueue) AS media_rx, id_provedor FROM `mk_logqueue` WHERE datatime_logqueue >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND datatime_logqueue < CURDATE() GROUP BY name_logqueue,DATE_FORMAT(datatime_logqueue, "%Y-%m-%d %H")
	);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
 	OPEN curs;
	REPEAT FETCH curs INTO NAME, TARGET, MK, DATA, HORA, MXTX, MDTX, MXRX, MDRX, PROVEDOR;
		IF NOT done THEN 
			INSERT INTO `mk_logqueuel` (`id_logqueuel`, `date_logqueuel`, `hora_logqueuel`, `name_logqueuel`, `target_logqueuel`, `tx-med_logqueuel`, `tx-max_logqueuel`, `rx-med_logqueuel`, `rx-max_logqueuel`, `mk_logqueuel`, `id_provedor`) VALUES (MD5(CONCAT(DATA,HORA,NAME,MK,PROVEDOR)), DATA, HORA, TARGET, MDTX, MXTX, MDRX, MXRX, MK, PROVEDOR) ON DUPLICATE KEY UPDATE `date_logqueuel`=DATA,`hora_logqueuel`=HORA,`name_logqueuel`=NAME,`target_logqueuel`=TARGET,`tx-med_logqueuel`=MDTX,`tx-max_logqueuel`=MXTX,`rx-med_logqueuel`=MDRX,`rx-max_logqueuel`=MXRX,`mk_logqueuel`=MK,`id_provedor`=PROVEDOR;
		END IF;
	UNTIL done END REPEAT;
	CLOSE curs;
	INSERT INTO `fc_logbd` SET `datatime_logbdfc`=NOW(),`tabela_logbdfc`='cria_logqueuel()',`texto_logbdfc`='OK',`id_provedor`=''; 
END