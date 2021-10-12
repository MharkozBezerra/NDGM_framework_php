<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{

    /**
     * Retorna uma view de um cabeçalho
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/cabecalho');
    }
    /**
     * Retorna uma view de um rodapé
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/rodape');
    }
    /**
     *  Retorna o conteúdo (view) de uma página genérica
     * @return string
     */
    public static function getPage($titulo = '', $conteudo = null)
    {
        return View::render('pages/page', [
            'titulo' => $titulo,
            'cabecalho' => self::getHeader(),
            'conteudo' => $conteudo,
            'rodape' => self::getFooter(),
        ]);
    }
}
