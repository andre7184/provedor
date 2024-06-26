BEGIN
    declare NEW VARCHAR(255);
    declare ID INT DEFAULT 0;
    SET NEW=(SELECT SPLIT_STRING(new.comment_secretpp,'#',1));
    IF(NEW="0" AND new.id_cliente_secretpp=0 AND new.tipo_secretpp='') THEN
	 	CALL new_cadastro(new.comment_secretpp,new.id_secretpp,new.id_provedor,new.profile_secretpp,@id);
        -- 
        SET ID=(SELECT @id);
        IF(ID > 0) THEN
         	SET new.id_cliente_secretpp=ID;
          	SET new.comment_secretpp=NEW_COMMENT(new.id_cliente_secretpp,new.id_secretpp);
            IF(new.salvo_secretpp='on') THEN
            	CALL new_comand_mk('set-comment-secrets-pppoe',new.id_secretpp,new.mk_secretpp,new.id_provedor,new.comment_secretpp);
           END IF;
        END IF;
        -- 
    END IF;
    IF(NEW="0" OR new.comment_secretpp='' AND new.id_cliente_secretpp > 0) THEN
     	SET	new.comment_secretpp=NEW_COMMENT(new.id_cliente_secretpp,new.id_secretpp);
    END IF;
END