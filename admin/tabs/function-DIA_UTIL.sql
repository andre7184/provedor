BEGIN
	declare textout boolean DEFAULT false;
	declare ano INT; 
	declare mes INT; 
	declare dia INT; 
	declare dPascoa date; 
    IF (datain = '') THEN 
       SET datain=CURDATE();
    END IF;
	IF ( DAYOFWEEK(datain) > 1 AND DAYOFWEEK(datain) < 7 ) THEN
		SET ano = SPLIT_STRING(datain , '-' , '1');
        SET mes = SPLIT_STRING(datain , '-' , '2');
        SET dia = SPLIT_STRING(datain , '-' , '3');
        SET textout=(SELECT IF((SELECT COUNT(*) FROM `fc_feriados` WHERE `dia_feriadosfc` = dia AND `mes_feriadosfc` = mes AND `sem_expediente_feriadosfc`='on')>0,false,true));
        IF(textout) THEN 
            SET dPascoa = DATA_PASCOA(ano);
            IF (datain < dPascoa) THEN
            	IF (datain = DATE_SUB(dPascoa, INTERVAL 2 DAY )) THEN -- SEXTA FEIRA SANTA
                	SET textout=false;
                ELSEIF (datain = DATE_SUB(dPascoa, INTERVAL 46 DAY )) THEN -- QUARTA FEIRA CINZAS
                	SET textout=false;
                ELSEIF (datain = DATE_SUB(dPascoa, INTERVAL 47 DAY )) THEN -- CARNAVAL
                	SET textout=false;
                ELSE
                 	SET textout=true;               
 				END IF;              
            ELSEIF (datain = DATE_ADD(dPascoa, INTERVAL 60 DAY )) THEN -- CORPUS CRISTIS
                SET textout=false;
          	ELSE
                SET textout=true;  
 			END IF; 
      	END IF;
 	END IF;
	RETURN textout;
END