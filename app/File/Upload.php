<?php

namespace App\File;

class Upload{

	private $name;
	private $extension;
	private $type;
	private $tmpname;
	private $error;	
	private $size;
	private $duplicates = 0;

	// metodo construtor da classe
	public function __construct($file){
		$this->type      = $file['type'];
		$this->tmpname   = $file['tmp_name'];
		$this->error     = $file['error'];
		$this->size      = $file['size'];

		$info            = pathinfo($file['name']);
		$this->name      = $info['filename'];
		$this->extension = $info['extension'];
	}


	// RETORNA O NOME DO ARQUIVO CONCATENADO COM A EXTENSAO
	public function getBasename(){
    //VALIDA EXTENSÃO
    $extension = strlen($this->extension) ? '.'.$this->extension : '';

    //VALIDA DUPLICAÇÃO
    $duplicates = $this->duplicates > 0 ? '-'.$this->duplicates : '';

    //RETORNA O NOME COMPLETO
    return $this->name.$duplicates.$extension;
  }

	

	private function getPossibleBasename($dir,$overwrite){
    //SOBRESCREVER ARQUIVO
    if($overwrite) return $this->getBasename();

    //NÃO PODE SOBRESCREVER ARQUIVO
    $basename = $this->getBasename();

    //VERIFICAR DUPLICAÇÃO
    if(!file_exists($dir.'/'.$basename)){
      return $basename;
    }

    //INCREMENTAR DUPLICAÇÕES
    $this->duplicates++;

    //RETORNO O PRÓPRIO MÉTODO
    return $this->getPossibleBasename($dir,$overwrite);
  }


	public function upload($dir, $overwrite = true){
		// verifica erro
		if ($this->error !=0) return false; 
		
		// caminho completo de destino
		$path = $dir.'/'.$this->getPossibleBasename($dir, $overwrite);
	// debug
		// echo '<pre>'; print_r($path); echo '</pre>'; exit;

		// move o arquivo para a pasta de destino
		return move_uploaded_file($this->tmpname, $path);
	}
}