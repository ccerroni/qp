<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Inscripcion</title> <!-- Aquí va el título de la página -->

</head>

<body>
<?php

	error_reporting(0);

	require_once('config.php');
	
	$inscNombreTutor = $_POST['inscNombreTutor'];
	$inscDocTutor = $_POST['inscDocTutor'];
	$inscDireccionTutor = $_POST['inscDireccionTutor'];
	$inscTelefonoTutor = $_POST['inscTelefonoTutor'];
	$inscEmailTutor = $_POST['inscEmailTutor'];

	$inscNombreAl1 = $_POST['inscNombreAl1'];
	$inscDocAl1 = $_POST['inscDocAl1'];
	$inscFechaNAcAl1 = $_POST['inscFechaNAcAl1'];
	$tipoEscuelaAl1 = $_POST['tipoEscuelaAl1'];

	$inscNombreAl2 = $_POST['inscNombreAl2'];
	$inscDocAl2 = $_POST['inscDocAl2'];
	$inscFechaNAcAl2 = $_POST['inscFechaNAcAl2'];
	$tipoEscuelaAl2 = $_POST['tipoEscuelaAl2'];


	$inscNombreAl3 = $_POST['inscNombreAl3'];
	$inscDocAl3 = $_POST['inscDocAl3'];
	$inscFechaNAcAl3 = $_POST['inscFechaNAcAl3'];
	$tipoEscuelaAl3 = $_POST['tipoEscuelaAl3'];


	$inscNombreAl4 = $_POST['inscNombreAl4'];
	$inscDocAl4 = $_POST['inscDocAl4'];
	$inscFechaNAcAl4 = $_POST['inscFechaNAcAl4'];
	$tipoEscuelaAl4 = $_POST['tipoEscuelaAl4'];

	//Validate fields - TODO: Move this to a function
	$isValid = true;
	if (!$inscNombreTutor || !$inscDocTutor || !$inscDireccionTutor || !$inscTelefonoTutor || !$inscEmailTutor || !$inscNombreAl1 || !$inscDocAl1 || !$inscFechaNAcAl1 || !$tipoEscuelaAl1)
	{
		$isValid= false;
		echo "<script>alert('Complete los campos requeridos');location.href ='javascript:history.back()';</script>";
	}

	$hayAlumno2 = false;
	if ($inscNombreAl2 || $inscDocAl2 || $inscFechaNAcAl2)
	{
		if ($inscNombreAl2 && $inscDocAl2 && $inscFechaNAcAl2 && $tipoEscuelaAl2) {
			$hayAlumno2= true;
		}
		else
		{
			$isValid= false;
			echo "<script>alert('Complete los campos requeridos para el alumno numero 2');location.href ='javascript:history.back()';</script>";
		}
	}

	$hayAlumno3 = false;
	if ($inscNombreAl3 || $inscDocAl3 ||$inscFechaNAcAl3)
	{
		if ($inscNombreAl3 && $inscDocAl3 && $inscFechaNAcAl3 && $tipoEscuelaAl3) {
			$hayAlumno3= true;
		}
		else
		{
			$isValid= false;
			echo "<script>alert('Complete los campos requeridos para el alumno numero 3');location.href ='javascript:history.back()';</script>";
		}
	}

	$hayAlumno4 = false;
	if ($inscNombreAl4 || $inscDocAl4 ||$inscFechaNAcAl4)
	{
		if ($inscNombreAl4 && $inscDocAl4 && $inscFechaNAcAl4 && $tipoEscuelaAl4) {
			$hayAlumno4= true;
		}
		else
		{
			$isValid= false;
			echo "<script>alert('Complete los campos requeridos para el alumno numero 4');location.href ='javascript:history.back()';</script>";
		}
	}

	if ($isValid)
	{	
		try {
			$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 

			//save tutor in database
			$sql = "INSERT INTO tutores (Nombre, Direccion, Dni, Telefono, Email)
			VALUES ('$inscNombreTutor', '$inscDireccionTutor', '$inscDocTutor', '$inscTelefonoTutor', '$inscEmailTutor' )";
			

			if ($conn->query($sql) === TRUE) {
			    $tutorID = $conn->insert_id;
			    echo "New record created successfully. Last inserted ID is: " . $last_id;
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

			if($tutorID != '') {
				//guardar alumnos en la base de datos
				if ($hayAlumno4 == true) {
					$sql = "INSERT INTO alumnos (TutorId, Nombre, Dni, FechaNacimiento, TipoEscuela)
					VALUES ('$tutorID', '$inscNombreAl1', '$inscDocAl1', '$inscFechaNAcAl1', '$tipoEscuelaAl1'),
					('$tutorID', '$inscNombreAl2', '$inscDocAl2', '$inscFechaNAcAl2', '$tipoEscuelaAl2'),
					('$tutorID', '$inscNombreAl3', '$inscDocAl3', '$inscFechaNAcAl3', '$tipoEscuelaAl3'),
					('$tutorID', '$inscNombreAl4', '$inscDocAl4', '$inscFechaNAcAl4', '$tipoEscuelaAl4')";
					if ($conn->query($sql) === TRUE) {
					    echo "Los alumnos se han inscripto correctamente";
					} else {
					    echo "Error: " . $sql . "<br>" . $conn->error;
					}
					$conn->close();
				}
				else if ($hayAlumno3 == true) {
					$sql = "INSERT INTO alumnos (TutorId, Nombre, Dni, FechaNacimiento, TipoEscuela)
					VALUES ('$tutorID', '$inscNombreAl1', '$inscDocAl1', '$inscFechaNAcAl1', '$tipoEscuelaAl1'),
					('$tutorID', '$inscNombreAl2', '$inscDocAl2', '$inscFechaNAcAl2', '$tipoEscuelaAl2'),
					('$tutorID', '$inscNombreAl3', '$inscDocAl3', '$inscFechaNAcAl3', '$tipoEscuelaAl3')";

					if ($conn->query($sql) === TRUE) {
					    echo "Los alumnos se han inscripto correctamente";
					} else {
					    echo "Error: " . $sql . "<br>" . $conn->error;
					}
					$conn->close();
				}
				else if ($hayAlumno2 == true) {
					$sql = "INSERT INTO alumnos (TutorId, Nombre, Dni, FechaNacimiento, TipoEscuela)
					VALUES ('$tutorID', '$inscNombreAl1', '$inscDocAl1', '$inscFechaNAcAl1', '$tipoEscuelaAl1'),
					('$tutorID', '$inscNombreAl2', '$inscDocAl2', '$inscFechaNAcAl2', '$tipoEscuelaAl2')";

					if ($conn->query($sql) === TRUE) {
					    echo "Los alumnos se han inscripto correctamente";
					} else {
					    echo "Error: " . $sql . "<br>" . $conn->error;
					}
					$conn->close();
				}
				else{
					$sql = "INSERT INTO alumnos (TutorId, Nombre, Dni, FechaNacimiento, TipoEscuela)
					VALUES ('$tutorID', '$inscNombreAl1', '$inscDocAl1', '$inscFechaNAcAl1', '$tipoEscuelaAl1')";

					if ($conn->query($sql) === TRUE) {
					    echo "Los alumnos se han inscripto correctamente";
					} else {
					    echo "Error: " . $sql . "<br>" . $conn->error;
					}
					$conn->close();
				}
			}
			else{
				echo 'Error al guardar tutor, los alumnos no se han podido inscribir';
			}
			

			//Send Email
			date_default_timezone_set('America/Argentina/Buenos_Aires');
		    require("class.phpmailer.php");
		    include("class.smtp.php");
		    
		    
		    
		
			$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			
			$mail->IsSMTP(); // telling the class to use SMTP
			$cuerpo="Nueva Inscripcion: <br /><br /><br />
			Datos Tutor <br />Nombre: ".$inscNombreTutor."<br />
			Documento: ".$inscTelefonoTutor."<br />
			Email: ".$inscEmailTutor."<br /><br /><br />
			Datos Alumno 1 <br />Nombre: ".$inscNombreAl1."<br />
			Documento: ".$inscDocAl1."<br />
			Fecha de nacimiento: ".$inscFechaNAcAl1."<br />
			Inscripto a: ".$tipoEscuelaAl1."<br /><br /><br />
			Datos Alumno 2 <br />Nombre: ".$inscNombreAl2."<br />
			Documento: ".$inscDocAl2."<br />
			Fecha de nacimiento: ".$inscFechaNAcAl2."<br />
			Inscripto a: ".$tipoEscuelaAl2."<br /><br /><br />
			Datos Alumno 3 <br />Nombre: ".$inscNombreAl3."<br />
			Documento: ".$inscDocAl3."<br />
			Fecha de nacimiento: ".$inscFechaNAcAl3."<br />
			Inscripto a: ".$tipoEscuelaAl3."<br /><br /><br />
			Datos Alumno 4 <br />Nombre: ".$inscNombreAl4."<br />
			Documento: ".$inscDocAl4."<br />
			Fecha de nacimiento: ".$inscFechaNAcAl4."<br />
			Inscripto a: ".$tipoEscuelaAl4."<br /><br /><br />";
			try {
				$mail->Host       = "mail.quitapenas.com.ar"; // SMTP server
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = 26;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "info@quitapenas.com.ar"; // SMTP account username
				$mail->Password   = "a1!a1!a1!";        // SMTP account password
				$mail->AddReplyTo('', '');
				$mail->AddAddress('info@caminosdeuco.com', 'Quitapenas');
				//$mail->AddAddress('cerronic@gmail.com', 'Cristian');
				$mail->SetFrom("info@quitapenas.com.ar", 'Quitapenas');
				$mail->IsHTML(true);
				$mail->Subject = 'Nueva Inscripcion';
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


			echo "<script>alert('Muchas gracias por inscribirte! Pronto recibirás una respuesta');location.href ='javascript:history.back()';</script>";

		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
?>
</body>
</html>