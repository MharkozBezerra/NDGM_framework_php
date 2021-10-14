<?php

namespace App\Http;

class Response
{
    private int $httpCode = 200;
    private $cabecalho = [];
    private $tipoConteudo = 'text/html';
    private $conteudo;


    public function __construct($httpcode, $conteudo, $contentType = 'text/html')
    {
     $this->httpCode = $httpcode;
     $this->conteudo = $conteudo;
     $this->setTipoConteudo($contentType);
    }

    /** Método que altera o content type de um response */
    public function setTipoConteudo($tipo)
    {
        $this->tipoConteudo = $tipo;
        $this->addCabecalho('Content-Type',$tipo);
    }
    /** Adiciona um registro no cabeçalho do response */
    public function addCabecalho($chave,$valor)
    {
        $this->cabecalho[$chave] = $valor;
    }
    /** Envia o cabeçalho da requisição */
    public function enviarCabecalho()
    {
        //Status http
        http_response_code($this->httpCode);

        //Envia os cabecalhos
        foreach($this->cabecalho as $key=>$value){
            header($key.':'.$value);
        }

    }
    /** Envia resposta para o usuário */
    public function enviarResposta()
    {
       //Envia os cabelhaos da página 
       $this->enviarCabecalho();
       //Imprime o conteúdo
       switch($this->tipoConteudo){
           case 'text/html':
            echo $this->conteudo;
            exit;
       }
    }

}
