<?php
$Name		= $_POST["Name"];	// Pega o valor do campo Nome
$Phone		= $_POST["Phone"];	// Pega o valor do campo Telefone
$Email		= $_POST["Email"];	// Pega o valor do campo Email
$Message	= $_POST["Message"];	// Pega os valores do campo Mensagem

// Variável que junta os valores acima e monta o corpo do email

$Val 		= "Nome: $Name\n\nE-mail: $Email\n\nTelefone: $Phone\n\nMensagem: $Message\n";

require_once("phpmailer/class.phpmailer.php");

define('GUSER', 'enviador@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 'senha');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

 if (smtpmailer('recebedor@dominio.com.br', 'enviador@gmail.com', 'Nome do Enviador', 'Assunto do Email', $Vai)) {

	Header("location:http://www.dominio.com.br/obrigado.html"); // Redireciona para uma página de obrigado.

}
if (!empty($error)) echo $error;
?>