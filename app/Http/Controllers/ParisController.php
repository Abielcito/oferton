<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class ParisController extends MainController {
    //C:\laragon\www\oferton\vendor\symfony\dom-crawler\Crawler.php

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $products = [];
    protected $filtersCrawler = [];
    protected $linksCategories = [];

    public function index() {

        $store = $this->findStoreByName('paris');
        if (!$store) {
            die('no se encontro el retail');
        }

        $this->filtersCrawler = json_decode($store->json_filter);

        $jsonCategoryLink = json_decode($store->json_category_link, true);
        $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'computadores');

        foreach ($subCategoryLinks as $findByLink) {
            //$findByLink = 'https://www.paris.cl/webapp/wcs/stores/servlet/SearchDisplay?searchTermScope=&searchType=1000&filterTerm=&orderBy=2&maxPrice=&showResultsPage=true&langId=-5&beginIndex=0&sType=SimpleSearch&metaData=bWZOYW1lX250a19jczoiSFAi&pageSize=&manufacturer=&resultCatEntryType=&catalogId=40000000629&pageView=image&searchTerm=&facet=ads_f21501_ntk_cs%253A%25228GB%2522&minPrice=&categoryId=51206207&storeId=10801';
            $storeCategory = $this->findStoreCategoryByLink($findByLink);
            if (count($storeCategory) > 0) {
                dd('Ya fue realizada una busqueda por el link solicitado');
            }

            $this->products = [];

            $crawler = Goutte::request('GET', $findByLink);
            $node = $crawler->filter($this->filtersCrawler->productBox)->each(function ($node, $index) {
                //PRODUCT NAME 
                $productName = $node->filter($this->filtersCrawler->productName)->each(function ($n, $j) {
                    return $n->text();
                });
                $productName = (isset($productName[0])) ? $productName[0] : null;


                //PRODUCT LINK
                $productLink = $node->filter($this->filtersCrawler->productLink)->each(function ($n, $j) {
                    return $n->extract(array('href'));
                });
                $productLink = (isset($productLink[0][0])) ? $productLink[0][0] : null;


                //PRODUCT PRICE
                $productPrice = $node->filter($this->filtersCrawler->productPrice)->each(function ($n, $j) {
                    //return preg_replace("/[^0-9]/", "",$n->text());
                    return $this->getJustNumbers($n->text());
                });
                $productPrice = (isset($productPrice[0])) ? $productPrice[0] : null;

                //PRODUCT PRICE WITH CARD
                $productPriceWithCard = $node->filter($this->filtersCrawler->productPriceWithCard)->each(function ($n, $j) {
                    //return preg_replace("/[^0-9]/", "",$n->text());
                    return $this->getJustNumbers($n->text());
                });
                $productPriceWithCard = (isset($productPriceWithCard[0])) ? $productPriceWithCard[0] : null;

                //PRODUCT DISCOUNT PERCENT WITH CARD
                $productDiscountWithCard = $this->calculatePercentDiscount($productPrice, $productPriceWithCard);


                //PRODUCT PRICE INTERNET
                $productPriceInternet = $node->filter($this->filtersCrawler->productPriceInternet)->each(function ($n, $j) {
                    return $n->extract(array('data-internet-price'));
                });
                $productPriceInternet = (isset($productPriceInternet[0][0])) ? $productPriceInternet[0][0] : null;

                //PRODUCT DISCOUNT PERCENT INTERNET
                $productDiscountInternet = $this->calculatePercentDiscount($productPrice, $productPriceInternet);


                //PRODUCT IMAGE
                $productImage = $node->filter($this->filtersCrawler->productImage)->each(function ($n, $j) {
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
                , "findBy" => $findByLink
                , "products" => $this->products
            ];


            $params = [
                'find_by_link' => $findByLink
                , 'json_detail' => json_encode($this->products)
                , 'store_id' => $store->id
            ];
            $this->saveStoresCategories($params);
        }
        dd('HOLA MUNDO LLEGO HASTA AQUI');
        //dd($this->products);
    }

    public function getLinksParis() {
        $store = $this->findStoreByName('paris');
        if (!$store) {
            die('no se encontro el retail');
        }
        $findByLink = 'https://www.paris.cl/tienda/es/paris';
        $crawler = Goutte::request('GET', $findByLink);
        $node = $crawler->filter('div.row-despliegue')->each(function ($node, $index) {
            $category = $node->filter('ul.nivel-2 > li > a')->each(function ($nodeCategory, $j) {
                //CATEGORIA
                $categoryName = $nodeCategory->text();
                $categoryLink = $nodeCategory->extract(array('href'));
                $categoryLink = $categoryLink[0];
                //SUBCATEGORIA
                $subCategory = $nodeCategory->siblings();
                $subCategoryArray = $subCategory->filter('ul.nivel-3 > li.menu-item > a')->each(function ($n, $j) {
                    return $n->extract(array('href'));
                });

                $subCategoryLink = [];
                foreach ($subCategoryArray as $row) {
                    $subCategoryLink[] = $row[0];
                }

                //RETORNA ARRAY FORMATEADO
                return [
                    'categoryName' => trim($categoryName)
                    , 'category' => $categoryLink
                    , 'subCategory' => $subCategoryLink
                ];
            });

            $this->linksCategories[] = $category;
        });

        //$this->updateStoreLinks(json_encode($this->linksCategories), $store->id);

        dd($this->linksCategories);
    }

}
