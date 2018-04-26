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
        $nodes = $crawler->filter('.result__title .result__a')->each(function ($node, $index) {

           $title = $node->text();
           $this->products[$index]['title'] = $title; 

           return $title;

        });

        $links = $crawler->filter('.result__title .result__a')->each(function ($node, $index) {

            $link = $node->text();
            $this->products[$index]['link'] = $link;

            return $link;

        });
        
        $collection = collect($nodes);

        //$matrix = $collection->combine($links);
        
        dd($this->products);*/

        $url = 'https://www.hites.com/tienda/SearchDisplay?categoryId=&storeId=10151&catalogId=10051&langId=-5&sType=SimpleSearch&resultCatEntryType=2&showResultsPage=true&searchSource=Q&pageView=&beginIndex=0&pageSize=-1&searchTerm=smart+tv#facet:-7000000000000005744544839,-10027671&productBeginIndex:0&orderBy:&pageView:grid&minPrice:&maxPrice:&pageSize:&';

        $crawler = Goutte::request('GET', $url);

        //TITULO
        $titles = $crawler->filter('.product_name a')->each(function ($node, $index) {
           
           $title = $node->text();
           $this->products[$index]['title'] = $title;

           return $title;

        });

        //PRECIO
        $prices = $crawler->filter('.precio_hites')->each(function ($node, $index) {

           $price = $node->text();
           $price = preg_replace("/[^0-9]/", "",$price); //Dejar solo números

           $this->products[$index]['price'] = $price;

           return $price;

        });

        dd($this->products);

        $response = [
            'retail' => 'hites',
            'findBy' => $url,
            'products' => $this->products,
        ];

        dd($response);

        return view('welcome');
    }

}
