(function($){
    /**
     * M�todo que ir� setar os valores nos campos do Form referente ao Object passado
     * via par�metro.
     * @author Weslley Alves
     * @email wesshead@gmail.com
     * @version v0.0.2
     * @date 2011-12-19
     * @param {Object} data Obejto com os dados para os campos do Formul�rio
     * @return {Wrapped} Retorna o Elemento do Formul�rio
     * @use O atributo do Object ("nome") seja igual ao valor do atributo "name" do campo.
     * @example
     * HTML: <input id="nome" name="nome" type="text">
     * Chamada: $('form').loadData({'nome':'Weslley Alves'});
     */
    $.fn.loadData = function(data){
        // Interando sobre o Object passado e setando os valores nos campos
        for(var campo in data){
            // Recuperando o elemento do campo
            var el = $(this).find('[name="'+ campo +'"]');
             
            // Verificando se foi resgatado mais de um Objeto
            if(el.length > 1){
                // LOOP para verificar se deve ser setado o valor
                $(el).each(function(i,v){
                    // Setando o valor no Elemento
                    $(this).setValue(data[campo]);
                });
            } else{
                // Setando o valor no Elemento
                $(el).setValue(data[campo]);
            }
        } // Fim da intera��o no Objeto com os dados
         
        // Retornando o Elemento do Formul�rio
        return this;
    }
 
    /**
     * M�todo que ir� setar o valor passado via par�metro no Elemento refer�nciado
     * @author Weslley Alves
     * @email wesshead@gmail.com
     * @version v0.0.1
     * @date 2011-12-19
     * @param {Number/String} value Valor a ser setado no Elemento refer�nciado
     * @return {Element} Retorna o Elemento refer�nciado
     * @use Deve ser chamado este m�todo atrav�s do Elemento HTML.
     * @example
     * HTML: <input id="nome" name="nome" type="text">
     * Chamada: $('#nome').setValue('Weslley Alves');
     */
    $.fn.setValue = function(value){
        // Campo "checkbox" ou "radio"
        if($(this).is('input[type=checkbox]') || $(this).is('input[type=radio]')){
            // Verificando se o valor do elemento � igual ao passado no Object
            if($(this).is('input[value='+ value +']')){
                $(this).attr('checked', true);
            }
        } else { // Demais campos
            $(this).val(value);
        }
 
        // Retornando o Elemento refer�nciado
        return this;
    }
})(jQuery);