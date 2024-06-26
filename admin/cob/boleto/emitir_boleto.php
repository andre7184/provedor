<?php

include_once('../../api/vendor/autoload.php');  

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$clientId = 'Client_Id_4473be3def8b8c13476d1bf5dbf53008f67a02bb'; // informe seu Client_Id
$clientSecret = 'Client_Secret_26f105ad66b25485cd527fcb9cc8a8c6f860a44b'; // informe seu Client_Secret

$options = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'sandbox' => true // altere conforme o ambiente (true = desenvolvimento e false = produção)
];

if (isset($_POST)) {

    $item_1 = [
        'name' => $_POST["descricao"],
        'amount' => (int) $_POST["quantidade"],
        'value' => (int) $_POST["valor"]
    ];

    $items = [
        $item_1
    ];

    $body = ['items' => $items];

    try {
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);
        if ($charge["code"] == 200) {

            $params = ['id' => $charge["data"]["charge_id"]];
            $customer = [
                'name' => $_POST["nome_cliente"],
                'cpf' => $_POST["cpf"],
                'phone_number' => $_POST["telefone"]
            ];

            // Formatando a data, convertendo do estino brasileiro para americano.
           // $data_brasil = DateTime::createFromFormat('d/m/Y', $_POST["vencimento"]);
		   // 'expire_at' => $data_brasil->format('Y-m-d'),

            $bankingBillet = [
                'expire_at' => $_POST["vencimento"],
                'customer' => $customer
            ];
            $payment = ['banking_billet' => $bankingBillet];
            $body = ['payment' => $payment];

            $api = new Gerencianet($options);
            $pay_charge = $api->payCharge($params, $body);
            echo json_encode($pay_charge);
        } else {

        }
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}