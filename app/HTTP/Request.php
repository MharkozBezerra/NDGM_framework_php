<?php

namespace App\Http;

class Request
{

    /**Método http da requisição */
    private $httpMetodos;
    /** URI da página */
    private $uri;
    /** Parametro da URL [$_GET] */
    private $queryParametros = [];
    /** Variáveis recebidas no POST da página [$_POST] */
    private $postVars = [];

    /** Cabecalho da requisição */
    private $cabecalho = [];

    public function __construct()
    {
        $this->queryParametros   = $_GET ?? [];
        $this->postVars          = $_POST ?? [];
        $this->cabecalho         = getallheaders();
        $this->httpMetodos       = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri               = $_SERVER['REQUEST_URI'] ?? '';
    }
    /**Retorna o método Http da requisição */
    public function getHttpMetodos()
    {
        return $this->httpMetodos;
    }
   /**Retorna o URI da requisição */
   public function getUri()
   {
       return $this->uri;
   }
   /**Retorna o Cabeçalho da requisição Http*/
   public function getCabecalho()
   {
       return $this->cabecalho;
   }
   /**Retorna o POST da requisição Http*/
   public function getPost()
   {
       return $this->postVars;
   }
    /**Retorna o query parametros da requisição Http*/
    public function getQueryParametros()
    {
        return $this->queryParametros;
    }
    
   
}
