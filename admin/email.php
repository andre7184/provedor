<?php
// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
include_once( "../../classes/phpmailer/PHPMailerAutoload.php");

// Inicia a classe PHPMailer
$mail = new PHPMailer;

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->isSMTP();// Define que a mensagem será SMTP
//$mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';
$mail->Host = "mail.provedor.uvsat.com "; // Endereço do servidor SMTP
$mail->Port = 25;
$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
$mail->Username = 'contato@provedor.uvsat.com'; // Usuário do servidor SMTP
$mail->Password = 'amb8484'; // Senha do servidor SMTP

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->setFrom('contato@provedor.uvsat.com', 'Provedor UvSat');

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->addAddress('amb84@ig.com.br', 'Andr� Brand�o');
$mail->AddAddress('amb7184@gmail.com');
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
$mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>!  :)";
$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->addAttachment('../../classes/phpmailer/images/phpmailer_mini.png');
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");�  // Insere um anexo

// Envia o e-mail
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>