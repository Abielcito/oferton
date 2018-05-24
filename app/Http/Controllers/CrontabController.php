<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;
use App\Models\TestCrontab;

class CrontabController extends MainController
{
    
    
    protected $products = [];
    protected $filtersCrawler = [];
    protected $linksCategories = [];
    
    public function index() {
        
    }
    
    
    //PRUEBA DE CRONTAB
    public function deleteRow() {
        TestCrontab::find(2)->delete();
        TestCrontab::find(3)->delete();
    }
    
    
    
    public function getProductsParis(){
        
        die("FECHA = ".date('Y-m-d H:i:s'));
        
        $store = $this->findStoreByName('paris');
        if (!$store) {
            //die('no se encontro el retail');
        }else{
            $this->filtersCrawler = json_decode($store->json_filter);
            $jsonCategoryLink = json_decode($store->json_category_link, true);
            
            //---------------------------------------------------------------------------------------------------
            //CATEGORIAS QUE ME INTERESAN POR AHORA
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'electro-television');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
            
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, '-hifi-');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
            
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'electro-tv');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'electro-drones');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'electro-instrumentos-musicales');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'ofertas-tv-');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'electro-ofertas-audio-');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-computadores');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-celulares');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'gamer-');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-fotografia-');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-accesorios-computacion');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-accesorios-celulares');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-accesorios-fotografia');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'tecnologia-videojuegos');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'ofertas-computacion');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'ofertas-celulares');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'Ofertas-Videojuegos');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'ofertas-fotografia');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'Ofertas-impresoras');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'linea-blanca');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			/*
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'perfumes-mujer');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'perfumes-hombre');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'hombre-zapatos-zapatillas');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'hombre-bototos-y-botines');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'hombre-zapatos-de-vestir');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'top-calzado-infantil-zapatos-ninas');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'top-calzado-infantil-zapatos-ninos');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'top-calzado-infantil-zapatillas');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'top-calzadp-infantil-zapatillas-escolares');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'top-calzadp-infantil-zapatis-escolares');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'calzado-mujer-botas-botines');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'zapatillas-urbanas-calzado-mujer');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'zapatos-mujer-zuecos-y-babuchas');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'zapatos-mujer-sandalias');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'mujer-zapatos-vestir');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
			
            $subCategoryLinks = $this->getSubCategoriesLink($jsonCategoryLink, 'zapato-casual-mujer-calzado');
            $this->saveProductsLinkRequestParis($store->id,$subCategoryLinks);
            */
            //---------------------------------------------------------------------------------------------------
            
        }
    }
    
    
    
    /*
     * A PARTIR DE UN JSON TRAE LOS LINK DE LAS SUBCATEGORIAS
     */
    protected function getSubCategoriesLink($jsonCategoryLink, $filterBy = null) {
        $subcategories = [];
        //SI EL FILTRO ES NULL
        if (is_null($filterBy)) {
            foreach ($jsonCategoryLink as $row) {
                foreach ($row as $row1) {
                    foreach ($row1['subCategory'] as $link) {
                        $subcategories[] = $link;
                    }
                }
            }
        } else {
            //SI EL FILTRO NO ES NULL
            foreach ($jsonCategoryLink as $row) {
                foreach ($row as $row1) {
                    foreach ($row1['subCategory'] as $link) {
                        //VALIDA SI LA PALABRA SE ENCUENTRA EN EL LINK
                        if (strpos($link, $filterBy) !== false) {
                            $subcategories[] = $link;
                        }
                    }
                }
            }
        }
        return $subcategories;
    }

    
    /*
    * PROCESA LOS PRODUCTOS DE LOS LINKS QUE SE QUIEREN BUSCAR Y LOS GUARDA EN LA BASE DE DATOS
    */
    protected function saveProductsLinkRequestParis($storeId,$subCategoryLinks){
        $dateFrom = date('Y-m-d');
        $dateTo = date('Y-m-d H:i:s');
        foreach ($subCategoryLinks as $findByLink) {
            $storeCategory = $this->findStoreCategoryByLinkByDateRange($findByLink,$dateFrom,$dateTo);
            if (count($storeCategory) > 0) {
                //dd('Ya fue realizada una busqueda por el link solicitado');
            }else{
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
                    , 'store_id' => $storeId
                ];
                $this->saveStoresCategories($params);
            }
        }
    }
    
}
