<?php

namespace App\Http;
// Método nativo do php
use \Closure;
use \Exception;

class Router
{   
    /** url do projeto */
    private $url = '';
    /** define o que é comum entre as rotas */
    private $prefix = '';
    /** guarda as rotas adicionadas no projeto */
    private $rotas = [];
    /** é uma estância de uma Request */
    private $request;

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url     = $url;
        $this->setPrefix();
    }
    /** Define o prefixo das rotas */
    private function setPrefix()
    {
        //Informa a url atual
        $parse = parse_url($this->url);

        //Define o prefix
        $this->prefix = $parse['path'] ?? '';
    }
    /** Adiciona uma nova rota */
    private function adicionarRota($metodo, $rota, $parametros = [])
    {
        //Validação dos parametros
        foreach ($parametros as $chave => $valor) {
            if ($valor instanceof Closure) {
                //passa o valor para uma possível controller
                $parametros['controller'] = $valor;
                //Mata o valor que está dento da chave
                unset($parametros[$chave]);
                //Segue o fluxo do loop
                continue;
            }
        }
        //informa um padrão para validação de rotas
        $padraoRota = '/^' . str_replace('/', '\/', $rota) . '$/';

        //Adiciona a rota dentro da classe;
        $this->rota[$padraoRota][$metodo] = $parametros;
    }
    /**
     * Define uma Rota de POST
     * @param string $rota
     * @param array $parametros
     */
    public function post($rota, $parametros = [])
    {
        return $this->adicionarRota('POST', $rota, $parametros);
    }
    /**
     * Define uma Rota de PUT
     * @param string $rota
     * @param array $parametros
     */
    public function put($rota, $parametros = [])
    {
        return $this->adicionarRota('PUT', $rota, $parametros);
    }
    /**
     * Define uma Rota de DELETE
     * @param string $rota
     * @param array $parametros
     */
    public function delete($rota, $parametros = [])
    {
        return $this->adicionarRota('DELETE', $rota, $parametros);
    }
    /**
     * Define uma Rota de GET
     * @param string $rota
     * @param array $parametros
     */
    public function get($rota, $parametros = [])
    {
        return $this->adicionarRota('GET', $rota, $parametros);
    }
    /** Executa uma chamada de uma possível rota atual */
    public function executar()
    {
        try {
            $rota = $this->getRota();
            //VERIFICA O CONTROLADOR.
            if(!isset($rota['controller']))
                throw new Exception("URL não pode ser precessada", 500);
            //Argumentos da função
            $args = [];
            // retorna executa o controlado    
            return call_user_func_array($rota['controller'],$args);   

        } catch (Exception $erro) {
            //Retorna o código do erro e a mensagem que origina o erro.
            return new Response($erro->getCode(), $erro->getMessage());
        }
    }
    /** Retota a rota atual */
    private function getRota()
    {

        //URI
        $uri = $this->getUri();
        //Recupera os métodos http.
        $metodo = $this->request->getHttpMetodos();
        
        //Valida as rotas
        foreach ($this->rotas as $padrao => $metodos) {

            //Verifica se a rota conside com o padrão de rotas.
            if (preg_match($padrao, $uri)) {
                
                //Verifica o método
                if ($metodos[$metodo]) {
                    //Retorna
                    return $metodos[$metodo];
                }
                throw new Exception("Método não permitido", 405);
            }
        }
        throw new Exception("URL não encontrada", 404);
    }
    /** Retota a uri atual sem prefixo */
    private function getUri()
    {

        //Uri
        $uri = $this->request->getUri();
        // Cria uma nova uri
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        // Retorna a uri sem o prefixo
        return end($xUri);
    }
}
