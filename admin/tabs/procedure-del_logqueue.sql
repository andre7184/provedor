BEGIN
	DELETE FROM `mk_logqueue` WHERE datatime_logqueue < DATE_SUB(CURDATE(), INTERVAL 3 DAY);
END