-- `EXPLODE`(IN `pDelim` VARCHAR(32), IN `pStr` TEXT)
BEGIN                                
  DROP TABLE IF EXISTS temp_explode;
  CREATE TEMPORARY TABLE temp_explode (id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, word VARCHAR(40));                                
  SET @sql := CONCAT('INSERT INTO temp_explode (word) VALUES (', REPLACE(QUOTE(pStr), pDelim, ''), (''), ')');                                
  PREPARE myStmt FROM @sql;                                
  EXECUTE myStmt;                                
END