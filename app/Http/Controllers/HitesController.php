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


            //Buscando precio con tarjeta del item --------------
            $priceWithCard = $node->filter('.precio_hites')->each(function ($n, $index) {

               $priceWithCard = $n->text();   

               if($priceWithCard == ''){
                  $priceWithCard[0] = null;
                }

               return preg_replace("/[^0-9]/", "", $priceWithCard);

            });

                $this->products[$index]['priceWithCard'] = $priceWithCard[0]; 

            //Buscando precio internet del item --------------
            $priceInternet = $node->filter('.price-medium')->each(function ($n, $index) {

               $priceInternet = $n->text();   

               if(!isset($priceInternet[0])){
                  $priceInternet[0] = null;
                }
               return preg_replace("/[^0-9]/", "", $priceInternet);

            });

            if(isset($priceInternet[0])){
              $this->products[$index]['priceInternet'] = $priceInternet[0];
            }else{
              $this->products[$index]['priceInternet'] = $this->products[$index]['priceWithCard'];
              $this->products[$index]['priceWithCard'] = null;
            }

            //Buscando imagen del item ---------------
            $img = $node->filter('.img-responsive')->each(function ($n, $index) {

               $img = $n->extract(array('data-original'));   

               return $img[0];

            });

            $this->products[$index]['img'] = $img[0];


            //Standars
            if($this->products[$index]['price'] == null){
               $this->products[$index]['price'] = $this->products[$index]['priceInternet'];
               $this->products[$index]['priceInternet'] = $this->products[$index]['priceWithCard'];
               $this->products[$index]['priceWithCard'] = null;
            }

            $price = $this->products[$index]['price'];
            $priceInternet = $this->products[$index]['priceInternet'];
            $priceWithCard = $this->products[$index]['priceWithCard'];
            
            if($priceInternet != null && $price > 0){
              $discount = ($priceInternet * 100) / $price;
              $this->products[$index]['discountPercentInternet'] = 100 - intval($discount);
            }else{
              $this->products[$index]['discountPercentInternet'] = null;
            }

            //Calculando porcentajes de descuento con tarjeta ---------------
            if($priceWithCard != null && $price > 0){
              $discount = ($priceWithCard * 100) / $price;
              $this->products[$index]['discountPercentWithCard'] = 100 - intval($discount);
            }else{
              $this->products[$index]['discountPercentWithCard'] = null;
            }

          });//fin crawler

          //ESTRUCTURA DEL JSON COMPLETA
          $response = [
              'retail' => 'hites',
              'findBy' => $url,
              'products' => json_encode($this->products),
          ];

          dd(json_encode($this->products));

        return view('welcome');
    }
}