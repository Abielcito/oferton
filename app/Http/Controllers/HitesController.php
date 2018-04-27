<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class HitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $products = [];
    
    //REVIAR  Symfony\Component\DomCrawler; 
    
    public function index()
    {
        /*$crawler = Goutte::request('GET', 'https://duckduckgo.com/html/?q=Laravel');
        
        $nodes = $crawler->filter('.links_main')->each(function ($node, $index) {

            $title = $node->filter('.result__title .result__a')->each(function ($n, $index) {

               $title = $n->text();   

               return $title;

            });

            $this->products[$index]['title'] = $title[0]; 

        });
        
        dd($this->products);*/

        $url = 'https://www.hites.com/tienda/SearchDisplay?categoryId=&storeId=10151&catalogId=10051&langId=-5&sType=SimpleSearch&resultCatEntryType=2&showResultsPage=true&searchSource=Q&pageView=&beginIndex=0&pageSize=-1&searchTerm=smart+tv#facet:-7000000000000005744544839,-10027671&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&';

        $crawler = Goutte::request('GET', $url);

        //TITULO

        $crawler->filter('.grid_mode > li')->each(function ($node, $index) {
           
            //Buscando link del item
            
             $link = $node->filter('.product_name a')->each(function ($n, $index) {

               $link = $n->extract(array('href'));   

               return $link[0];

            });

            $this->products[$index]['link'] = $link[0]; 

            
            //Buscando titulo del item ---------------
            $title = $node->filter('.product_name a')->each(function ($n, $index) {

               $title = $n->text();   

               return $title;

            });

            $this->products[$index]['title'] = $title[0]; 


            //Buscando precio normal del item --------------
            $price = $node->filter('.precio_normal')->each(function ($n, $index) {

               $price = $n->text();   

               return preg_replace("/[^0-9]/", "",$price);

            });

            if(!isset($price[0])){
              $price[0] = null;
            }

            $this->products[$index]['price'] = $price[0]; 


            //Buscando precio oferta del item --------------
            $priceWithCard = $node->filter('.precio_hites')->each(function ($n, $index) {

               $priceWithCard = $n->text();   

               return preg_replace("/[^0-9]/", "", $priceWithCard[0]);

            });

            if(isset($priceWithCard[0])){
              if($priceWithCard[0] != null && $priceWithCard[0] != ''){
                 $this->products[$index]['priceWithCard'] = $priceWithCard[0]; 
              }
            }else{
              $priceWithCard[0] = null;
              $this->products[$index]['priceWithCard'] = $priceWithCard[0]; 
            }


            //Buscando precio oferta del item --------------
        });

        $response = [
            'retail' => 'hites',
            'findBy' => $url,
            'products' => $this->products,
        ];

        dd($response);

        return view('welcome');
    }

}
