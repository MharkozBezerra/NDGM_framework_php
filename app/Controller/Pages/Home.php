<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entidades\Empresa;
//Home é uma página
class Home extends Page
{
    /**
     *  Retorna o conteúdo (view) de uma página
     * @return string
     */
    public static function getHome()
    {

        $empresa = new Empresa();

        //Renderiza o home
        $conteudo = View::render('pages/home', [
            'nome'      => $empresa->nome,
            'descricao' => $empresa->sobre,
            'site'      => $empresa->site
        ]);
        //Retorna a view da página.
        return parent::getPage('NDMG Soluções | Telecom', $conteudo);
    }
}
