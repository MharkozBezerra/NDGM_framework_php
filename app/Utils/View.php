<?php

namespace App\Utils;

class View
{
    /**
     * Método responsável por  retornar  conteúdos de um view 
     * @param string $view
     * @return string 
     */
    private static function getContentView($view)
    {
       $arquivo = __DIR__.'/../../resources/view/'.$view.'.html';
       return file_exists($arquivo) ? file_get_contents($arquivo): '';
    }
    /**
     * Método responsável por renderizar conteúdos de um view 
     * @param string $view
     * @param array $vars (string ou numericos)
     * @return string 
     */
    public static function render($view,$vars =[])
    {
        $conteudoView = self::getContentView($view);

        //Chaves que serão passadas pelos variáveis
        $chaves = array_keys($vars);
        //Mapea as chaves que foram informadas
        $chaves = array_map( function($item){
            return '{{'.$item.'}}';
        },$chaves);

        //Retorna o conteúdo renderizado
        return str_replace($chaves,array_values($vars),$conteudoView);
    }
}
