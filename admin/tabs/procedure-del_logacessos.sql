BEGIN
	DELETE FROM `mk_logacessos` WHERE datatime_logacessos < DATE_SUB(CURDATE(), INTERVAL 90 DAY);
END