<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;


class ExampleController extends Controller
{
    //EJEMPLO BASICO PARA TRAER LOS TITULOS DE LA PAGINA https://duckduckgo.com/html/?q=Laravel
    public function index(){
        $crawler = Goutte::request('GET', 'https://duckduckgo.com/html/?q=Laravel');
        $crawler->filter('.result__title .result__a')->each(function ($node) {
          dump($node->text());
        });
        return view('welcome');
    }
}
