<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class HitesController extends Controller
{

    protected $products = [];
    
    //REVISAR  Vendor/Symfony/dom-crawler/Crawler.php; 
    
    public function index()
    {

        $url = 'https://www.hites.com/tienda/SearchDisplay?categoryId=&storeId=10151&catalogId=10051&langId=-5&sType=SimpleSearch&resultCatEntryType=2&showResultsPage=true&searchSource=Q&pageView=&beginIndex=0&pageSize=-1&searchTerm=smart+tv#facet:-7000000000000005744544839,-10027671&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&';

        $crawler = Goutte::request('GET', $url);

        //Filtrar los contenedores de los productos
        $crawler->filter('.grid_mode > li')->each(function ($node, $index) {
           
            //Buscando LINK del item --------------------
             $link = $node->filter('.product_name a')->each(function ($n, $index) {

               $link = $n->extract(array('href'));   

               return $link[0];

            });

            $this->products[$index]['linKProduct'] = $link[0]; 

            
            //Buscando NAME del item ---------------
            $name = $node->filter('.product_name a')->each(function ($n, $index) {

               $name = $n->text();   

               return $name;

            });

            $this->products[$index]['name'] = $name[0]; 


            //Buscando precio normal del item --------------
            $price = $node->filter('.precio_normal')->each(function ($n, $index) {

               $price = $n->text();   

               return preg_replace("/[^0-9]/", "", $price);

            });

            if(!isset($price[0])){
              $price[0] = null;
            }

            $this->products[$index]['price'] = $price[0]; 


            //Buscando precio oferta del item --------------
            $priceWithCard = $node->filter('.precio_hites')->each(function ($n, $index) {

               $priceWithCard = $n->text();   

               if($priceWithCard == ''){
                  $priceWithCard[0] = null;
                }

               return preg_replace("/[^0-9]/", "", $priceWithCard);

            });

            $this->products[$index]['priceWithCard'] = $priceWithCard[0]; 
            
            //Buscando descuento con tarjeta del item ---------------
            $this->products[$index]['discountPercentWithCard'] = null;
            //Buscando precio internet del item ---------------
            $this->products[$index]['priceInternet'] = null;
            //Buscando descuento por internet del item ---------------
            $this->products[$index]['discountPercentInternet'] = null;


            //Buscando imagen del item ---------------
            $img = $node->filter('.img-responsive')->each(function ($n, $index) {

               $img = $n->extract(array('data-original'));   

               return $img[0];

            });

            $this->products[$index]['img'] = $img[0];

          });//fin crawler

          //ESTRUCTURA DEL JSON COMPLETA
          $response = [
              'retail' => 'hites',
              'findBy' => $url,
              'products' => json_encode($this->products),
          ];

          dd($response);

        return view('welcome');
    }
}