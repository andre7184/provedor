BEGIN
	declare text varchar(255);
  	declare done INT DEFAULT 0;
	declare NOME varchar(255);
	declare EXPD varchar(2);
	declare ano INT; 
	declare mes INT; 
	declare dia INT; 
    declare fPascoa date; 
    declare fPaixao date;
	declare fCinzas date;
	declare fCarnaval date;
	declare fCorpusChristi date;
	SET ano = SPLIT_STRING(datain , '-' , '1');
	SET mes = SPLIT_STRING(datain , '-' , '2');
	SET dia = SPLIT_STRING(datain , '-' , '3');
	SET fPascoa = DATA_PASCOA(ano);
	SET fPaixao = DATE_SUB(fPascoa, INTERVAL 2 DAY );
	SET fCinzas = DATE_SUB(fPascoa, INTERVAL 46 DAY );
	SET fCarnaval = DATE_SUB(fPascoa, INTERVAL 47 DAY );
	SET fCorpusChristi = DATE_ADD(fPascoa, INTERVAL 60 DAY );
	CASE datain
		WHEN fPascoa THEN 
			SET text='Pascoa;on';
		WHEN fPaixao THEN 
			SET text='Sexta-Feira da Paixao;on';
		WHEN fCinzas THEN 
			SET text='Quarta-Feira de Cinzas;on';
		WHEN fCarnaval THEN 
			SET text='Carnaval;on';
		WHEN fCorpusChristi THEN 
			SET text='Cospus Christi;on';
		ELSE
			BEGIN
				SET text='';
			END;
	END CASE;
    -- 
    IF ( text = '') THEN
    	SET text=(SELECT GROUP_CONCAT(CONCAT(`descricao_feriadosfc`,'|',`sem_expediente_feriadosfc`)) FROM `fc_feriados` WHERE `dia_feriadosfc` = dia AND `mes_feriadosfc` = mes AND `sem_expediente_feriadosfc`='on' group by `dia_feriadosfc`,`mes_feriadosfc`);
	END IF;
    -- SELECT text;
	RETURN text;
END