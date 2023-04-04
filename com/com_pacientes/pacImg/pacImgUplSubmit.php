<?php require('../../../init.php');
function imagename_savedatabase($codpac, $filename)
{

	$qryIM = sprintf(
		'INSERT INTO db_media (file, estado) VALUES (%s,%s)',
		SSQL($filename, 'text'),
		SSQL('1', 'int')
	);
	mysqli_query(conn, $qryIM) or die(mysqli_error(conn));
	$idm = mysqli_insert_id(conn);

	$qryIP = sprintf(
		'INSERT INTO db_pacientes_media (cod_pac, id_med) VALUES (%s,%s)',
		SSQL($codpac, 'int'),
		SSQL($idm, 'int')
	);
	mysqli_query(conn, $qryIP) or die(mysqli_error(conn));
}
/* 
Description: 
- The script receives some data with method="post". 
- One of this data may be a path of an image that was previously uploaded 
  to a temporary directory in the server. If this datum exists, the script 
  move the image from the temporary directory to a final one. 
- The script process the rest of the data and produces some output.  
*/
$pathToMove = "../../../data/db/pac/";

$imagePathParameterName = "uploadedImagePath";
$imageDescriptionParameterName = "imageDescription";

$imagePath = $_POST[$imagePathParameterName];
$description = $_POST[$imageDescriptionParameterName];

// the funtion file_exists doesn't find files whose name has special 
// characters, like tildes 
if (($imagePath != null) && (file_exists($imagePath))) {
	$imagePathToMove = $pathToMove . basename($imagePath);
	// if(file_exists($imagePathToMove)) unlink($imagePathToMove);
	imagename_savedatabase($description, basename($imagePath));
	/*
  if(rename($imagePath, $imagePathToMove)){
	  echo "<h2>Imagen Guardada!</h2>";
	  //imagename_savedatabase($description, basename($imagePath));
	  echo "<img src='".$imagePathToMove."'/>";
  }*/
	//else echo "There was an error moving the file " . $imagePath . " to " . $imagePathToMove;
} else echo "No se ha cargado la imagen";
