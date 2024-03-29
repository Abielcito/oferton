<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class ParisController_ORIGINAL extends MainController {
    //C:\laragon\www\oferton\vendor\symfony\dom-crawler\Crawler.php

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $products = [];

    public function index() {

        $store = $this->findStoreByName('paris');
        if (!$store) {
            die('no se encontro el retail');
        }

        $findByLink = 'https://www.paris.cl/webapp/wcs/stores/servlet/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&orderBy=2&maxPrice=&showResultsPage=true&langId=-5&beginIndex=0&sType=SimpleSearch&metaData=bWZOYW1lX250a19jczoiSFAi&pageSize=&manufacturer=&resultCatEntryType=&catalogId=40000000629&pageView=image&searchTerm=&facet=ads_f21501_ntk_cs%253A%25228GB%2522&minPrice=&categoryId=51206207&storeId=10801';

        $storeCategory = $this->findStoreCategoryByLink($findByLink);
        if(count($storeCategory)>0){
            dd('Ya fue realizada una busqueda por el link solicitado');
        }

        $crawler = Goutte::request('GET', $findByLink);
        $node = $crawler->filter('.boxProduct')->each(function ($node, $index) {
            //PRODUCT NAME 
            $productName = $node->filter('p.sub > a')->each(function ($n, $j) {
                return $n->text();
            });
            $productName = (isset($productName[0])) ? $productName[0] : null;


            //PRODUCT LINK
            $productLink = $node->filter('p.sub > a')->each(function ($n, $j) {
                return $n->extract(array('href'));
            });
            $productLink = (isset($productLink[0][0])) ? $productLink[0][0] : null;


            //PRODUCT PRICE
            $productPrice = $node->filter('div.itemPrice > p.normal > span')->each(function ($n, $j) {
                //return preg_replace("/[^0-9]/", "",$n->text());
                return $this->getJustNumbers($n->text());
            });
            $productPrice = (isset($productPrice[0])) ? $productPrice[0] : null;

            //PRODUCT PRICE WITH CARD
            $productPriceWithCard = $node->filter('div.itemPrice > p.price')->each(function ($n, $j) {
                //return preg_replace("/[^0-9]/", "",$n->text());
                return $this->getJustNumbers($n->text());
            });
            $productPriceWithCard = (isset($productPriceWithCard[0])) ? $productPriceWithCard[0] : null;

            //PRODUCT DISCOUNT PERCENT WITH CARD
            $productDiscountWithCard = $this->calculatePercentDiscount($productPrice, $productPriceWithCard);


            //PRODUCT PRICE INTERNET
            $productPriceInternet = $node->filter('div.itemPrice > p.internet')->each(function ($n, $j) {
                return $n->extract(array('data-internet-price'));
            });
            $productPriceInternet = (isset($productPriceInternet[0][0])) ? $productPriceInternet[0][0] : null;

            //PRODUCT DISCOUNT PERCENT INTERNET
            $productDiscountInternet = $this->calculatePercentDiscount($productPrice, $productPriceInternet);


            //PRODUCT IMAGE
            $productImage = $node->filter('div.item > a.pdp > img')->each(function ($n, $j) {
                return $n->extract(array('data-src'));
            });
            $productImage = (isset($productImage[0][0])) ? trim($productImage[0][0], '?$plp_moda$') : null;


            $this->products[] = [
                "linKProduct" => $productLink,
                "name" => $productName,
                "price" => $productPrice,
                "priceWithCard" => $productPriceWithCard,
                "discountPercentWithCard" => $productDiscountWithCard,
                "priceInternet" => $productPriceInternet,
                "discountPercentInternet" => $productDiscountInternet,
                "image" => $productImage
            ];
        });


        $this->products = [
            "retail" => "paris"
            , "findBy" => "https://www.paris.cl/webapp/wcs/stores/servlet/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&orderBy=2&maxPrice=&showResultsPage=true&langId=-5&beginIndex=0&sType=SimpleSearch&metaData=bWZOYW1lX250a19jczoiSFAi&pageSize=&manufacturer=&resultCatEntryType=&catalogId=40000000629&pageView=image&searchTerm=&facet=ads_f21501_ntk_cs%253A%25228GB%2522&minPrice=&categoryId=51206207&storeId=10801"
            , "products" => $this->products
        ];


        $params = [
            'find_by_link' => $findByLink
            , 'json_detail' => json_encode($this->products)
            , 'store_id' => $store->id
        ];
        $this->saveStoresCategories($params);

        dd($this->products);
    }

}
