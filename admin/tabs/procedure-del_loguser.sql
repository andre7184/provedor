BEGIN
	DELETE FROM `fc_loguser` WHERE datatime_loguserfc < DATE_SUB(CURDATE(), INTERVAL 90 DAY);
END