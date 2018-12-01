<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Trabaja con nosotros</title> <!-- Aquí va el título de la página -->

</head>

<body>
<?php

	error_reporting(0);

	require_once('config.php');
	
	$wwuNombre = $_POST['wwuNombre'];
	$wwuDocumento = $_POST['wwuDocumento'];
	$wwuFechaNac = $_POST['wwuFechaNac'];
	$wwuDomicilio = $_POST['wwuDomicilio'];
	$wwuEstadoCivil = $_POST['wwuEstadoCivil'];
	$wwuEmail = $_POST['wwuEmail'];
	$wwuTelefono = $_POST['wwuTelefono'];
	$wwuAreas = $_POST['wwuAreas'];
	$cvFile = $_POST['cvFile'];
	$propFile = $_POST['propFile'];

	$cvFinalName = '';
	$propFinalName = '';

	$wwuCV = $_POST['wwuCV'];
	$wwuPropuesta = $_POST['wwuPropuesta'];

	//Validate fields - TODO: Move this to a function
	$isValid = true;
	if ($wwuNombre == '')
	{
		$isValid= false;
		echo "<script>alert('El Nombre es requerido');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuDocumento == '')
	{
		$isValid= false;
		echo "<script>alert('El Número de documento es requerido');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuFechaNac == '')
	{
		$isValid= false;
		echo "<script>alert('Ingrese su fecha de nacimiento');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuDomicilio == '')
	{
		$isValid= false;
		echo "<script>alert('Ingrese su domicilio');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuEstadoCivil == '')
	{
		$isValid= false;
		echo "<script>alert('Ingrese su estado civil');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuEmail == '')
	{
		$isValid= false;
		echo "<script>alert('Ingrese su dirección de correo electrónico');location.href ='javascript:history.back()';</script>";
	}
	if ($wwuTelefono == '')
	{
		$isValid= false;
		echo "<script>alert('Ingrese su número de teléfono');location.href ='javascript:history.back()';</script>";
	}

	if ($isValid)
	{	
		$toBasePath = PATHFILEUPLOAD;
		
		//Upload CV - TODO: move this to a function
		try {
	    	if(isset($_FILES['cvFile']) && $_FILES['cvFile']['name'])
			{
				// Creates the Variables needed to upload the file
				
				$UploadName = $_FILES['cvFile']['name'];
				$UploadName = mt_rand(100000, 999999).$UploadName;
				$UploadTmp = $_FILES['cvFile']['tmp_name'];
				$UploadType = $_FILES['cvFile']['type'];
				$FileSize = $_FILES['cvFile']['size'];
				
				// Removes Unwanted Spaces and characters from the files names of the files being uploaded
				
				$UploadName = preg_replace("#[^a-z0-9.]#i", "", $UploadName);
				
				// Upload File Size Limit 
				
				if(($FileSize > 125000)){
					
					die("Error - File to Big");
					
				}
				
				// Checks a File has been Selected and Uploads them into a Directory on your Server
				
				if(!$UploadTmp)
				{
					die("No has cargado un CV, por favor intentalo de nuevo");
				}
				else
				{
					$target_path = $toBasePath . $UploadName;             
	    			// preserve file from temporary directory
				    $success = move_uploaded_file($_FILES["cvFile"]["tmp_name"], $target_path);
				    if (!$success) { 
				        echo "<p>Unable to save file.</p> <br />";
						echo "Error: " . $_FILES["cvFile"]["error"] . "<br />";
				        exit;
				    }

				    $cvFinalName = $UploadName;
				    // set proper permissions on the new file
	    			//chmod(UPLOAD_DIR . $name, 0644);
				}
			}
		}
		catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}

		//Upload propuesta - TODO: move this to a function
		try {
			if(isset($_FILES['propFile']) && $_FILES['propFile']['name'])
			{
				// Creates the Variables needed to upload the file
				
				$UploadPropName = $_FILES['propFile']['name'];
				$UploadPropName = mt_rand(100000, 999999).$UploadPropName;
				$UploadPropTmp = $_FILES['propFile']['tmp_name'];
				$UploadPropType = $_FILES['propFile']['type'];
				$FilePropSize = $_FILES['propFile']['size'];
				
				// Removes Unwanted Spaces and characters from the files names of the files being uploaded
				
				$UploadPropName = preg_replace("#[^a-z0-9.]#i", "", $UploadPropName);
				
				// Upload File Size Limit 
				
				if(($FilePropSize > 125000)){
					
					die("Error - File to Big");
					
				}
				
				// Checks a File has been Selected and Uploads them into a Directory on your Server
				
				if(!$UploadPropTmp)
				{
					die("No has cargado una propuesta, por favor intentalo de nuevo");
				}
				else
				{
					$target_path = $toBasePath . $UploadPropName;               
	    			// preserve file from temporary directory
				    $successProp = move_uploaded_file($_FILES["propFile"]["tmp_name"], $target_path);
				    if (!$successProp) { 
				        echo "<p>Unable to save file.</p> <br />";
						echo "Error: " . $_FILES["propFile"]["error"] . "<br />";
				        exit;
				    }
				    $propFinalName = $UploadPropName;
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}

		//Save data in database - TODO: move this to a function
		try {
			$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 

			$sql = "INSERT INTO candidatos (AreasInteres, CVNameFile, Direccion, Documento, Email, EstadoCivil, FechaNacimiento, Nombre, PropuestaNameFile, Telefono)
			VALUES ('$wwuAreas', '$cvFinalName', '$wwuDomicilio', '$wwuDocumento', '$wwuEmail', '$wwuEstadoCivil', '$wwuFechaNac', '$wwuNombre', '$propFinalName', '$wwuTelefono')";

			if ($conn->query($sql) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages from anything else!
		}

		//Send Email



		

		echo "<script>alert('Muchas gracias por enviarnos tus datos! Pronto recibirás una respuesta');location.href ='javascript:history.back()';</script>";
	}

?>
</body>
</html>