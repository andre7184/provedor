SELECT 
SUM(valor_faturafc+valor_encarcos_faturafc) AS valor_total, 
SUM(pagamentos_creditos_faturafc) AS valor_pago, 
SUM(valor_faturafc+valor_encarcos_faturafc)-SUM(pagamentos_creditos_faturafc) AS valor_restante 
FROM `fcv_faturas` GROUP BY grupo_parceria 