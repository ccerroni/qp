<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Formulario</title> <!-- Aquí va el título de la página -->

</head>

<body>
<?php
	error_reporting(0);
	
	$Nombre = $_POST['Nombre'];
	$Correo = $_POST['Email'];
	$Asunto = $_POST['Asunto'];
	$Mensaje = $_POST['Mensaje'];
	
	if ($Nombre=='' || $Correo=='' || $Mensaje==''){
	
		echo "<script>alert('Todos los campos son obligatorios');location.href ='javascript:history.back()';</script>";
	
	}else{
	
	    date_default_timezone_set('America/Argentina/Buenos_Aires');
	    require("class.phpmailer.php");
	    include("class.smtp.php");
	    
	    
	    
	
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$cuerpo="Nombre: ".$Nombre."<br />
		Email: ".$Correo."<br />
		Mensaje: ".$Mensaje."<br />";
		try {
			$mail->Host       = "mail.quitapenas.com.ar"; // SMTP server
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = 26;                    // set the SMTP port for the GMAIL server
			$mail->Username   = "info@quitapenas.com.ar"; // SMTP account username
			$mail->Password   = "a1!a1!a1!";        // SMTP account password
			$mail->AddReplyTo($Correo, $Nombre);
			$mail->AddAddress('info@caminosdeuco.com', 'Quitapenas');
			$mail->SetFrom("info@quitapenas.com.ar", $Nombre);
			$mail->IsHTML(true);
			$mail->Subject = 'Contacto Quitapenas.com.ar';
			$mail->SMTPDebug  = 1;
			
			$mail->MsgHTML($cuerpo);
			$mail->AltBody = 'Nombre: '.$Nombre.' \n<br />'.
			'Email: '.$Correo.' \n<br />'.
			'Mensaje: '.$Mensaje.' \n<br />';
			$mail->Send();
			echo "<script>alert('Muchas gracias por contactarnos! Pronto recibirás una respuesta');location.href ='javascript:history.back()';</script>";
		} catch (phpmailerException $e) {
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
	
?>
</body>
</html>