<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class ParisController extends Controller {
    //C:\laragon\www\oferton\vendor\symfony\dom-crawler\Crawler.php

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $products = [];

    public function index() {
        $crawler = Goutte::request('GET', 'https://www.paris.cl/webapp/wcs/stores/servlet/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&orderBy=2&maxPrice=&showResultsPage=true&langId=-5&beginIndex=0&sType=SimpleSearch&metaData=bWZOYW1lX250a19jczoiSFAi&pageSize=&manufacturer=&resultCatEntryType=&catalogId=40000000629&pageView=image&searchTerm=&facet=ads_f21501_ntk_cs%253A%25228GB%2522&minPrice=&categoryId=51206207&storeId=10801');

        $node = $crawler->filter('.boxProduct')->each(function ($node, $index) {
            //PRODUCT NAME 
            $productName = $node->filter('p.sub > a')->each(function ($n, $j) {
                return $n->text();
            });
            //PRODUCT LINK
            $productLink = $node->filter('p.sub > a')->each(function ($n, $j) {
                return $n->extract(array('href'));
            });
            //PRODUCT PRICE
            $productPrice = $node->filter('div.itemPrice > p.normal > span')->each(function ($n, $j) {
                return preg_replace("/[^0-9]/", "",$n->text());
            });
            
            //PRODUCT PRICE WITH CARD
            $productPriceWithCard = $node->filter('div.itemPrice > p.price')->each(function ($n, $j) {
                return preg_replace("/[^0-9]/", "",$n->text());
            });
            
            //PRODUCT DISCOUNT PERCENT WITH CARD
            
            
            //PRODUCT PRICE INTERNET
            $productPriceInternet = $node->filter('div.itemPrice > p.internet')->each(function ($n, $j) {
                return $n->extract(array('data-internet-price'));
            });
            
            //PRODUCT DISCOUNT PERCENT INTERNET
            
            //PRODUCT IMAGE
            $productImage = $node->filter('a.pdp > img')->each(function ($n, $j) {
                
                dd($n->extract(array('src')));
                return $n->extract(array('src'));
            });

            
            
            $this->products[] = [
                "linKProduct" => (isset($productLink[0][0])) ? $productLink[0][0] : null,
                "name" => (isset($productName[0])) ? $productName[0] : null,
                "price" => (isset($productPrice[0])) ? $productPrice[0] : null,
                "priceWithCard" => (isset($productPriceWithCard[0])) ? $productPriceWithCard[0] : null,
                "discountPercentWithCard" => null,
                "priceInternet" => (isset($productPriceInternet[0][0])) ? $productPriceInternet[0][0] : null,
                "discountPercentInternet" => null,
                "image" => (isset($productImage[0][0])) ? $productImage[0][0] : null
            ];
        });
        
dd($this->products);        
        
        
//        $this->products = [
//            "retail" => "paris"
//            , "findBy" => "https://www.paris.cl/webapp/wcs/stores/servlet/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&orderBy=2&maxPrice=&showResultsPage=true&langId=-5&beginIndex=0&sType=SimpleSearch&metaData=bWZOYW1lX250a19jczoiSFAi&pageSize=&manufacturer=&resultCatEntryType=&catalogId=40000000629&pageView=image&searchTerm=&facet=ads_f21501_ntk_cs%253A%25228GB%2522&minPrice=&categoryId=51206207&storeId=10801"
//            , "products" => $products
//        ];
//        dd($this->products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
