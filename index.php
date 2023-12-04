<?php

require __DIR__. '/vendor/autoload.php';

use \App\File\Upload;

if (isset($_FILES['arquivo'])) {
	
	$obUpload = new Upload($_FILES['arquivo']);

	$sucesso = $obUpload->upload(__DIR__.'/files',false);
	if ($sucesso) {
		
		echo "Arquivo <strong>".$obUpload->getBasename(). " </strong>enviado com sucesso!";
		exit;
	}

	die('Problema ao enviar o arquivo');
// echo "<pre>"; print_r($obUpload); echo"</pre>"; exit;
}
 
include __DIR__.'/includes/formulario.php';