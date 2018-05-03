<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreCategory;
use App\Models\Store;

class MainController extends Controller {

    /**
     * Reemplaza los caracteres y letras retornando
     * solo numeros
     */
    protected function getJustNumbers($value) {
        return preg_replace("/[^0-9]/", "", $value);
    }

    /**
     * Con base en el precio original y el precio de descuento 
     * calcula el procentaje de descuento
     * $discountPercent = (($price - $priceWithDiscount)*100)/$price
     */
    protected function calculatePercentDiscount($price, $priceWithDiscount) {
        if (is_null($price) || is_null($priceWithDiscount)) {
            return null;
        }
        $discountPercent = (($price - $priceWithDiscount) * 100) / $price;
        return $discountPercent;
    }

    /*
     * BUSCA LOS DATOS DEL RETAIL POR NOMBRE
     */

    protected function findStoreByName($name) {
        $store = Store::where('name', $name)->get();
        if (count($store) == 0) {
            return false;
        }
        return $store[0];
    }

    /*
     * ACTUALIZA JSON DE CATEGORIAS Y SUBCATEGORIAS DE CADA RETAIL
     */

    protected function updateStoreLinks($links, $id) {
        if (Store::where('id', $id)->update(['json_category_link' => $links])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * VALIDA SI YA EXISTE UNA BUSQUEDA POR EL LINK SOLICITADO
     */

    protected function findStoreCategoryByLink($link) {
        $storeCategory = StoreCategory::where('find_by_link', $link)->get();
        return $storeCategory;
    }

    /*
     * GUARDAR NUEVA BUSQUEDA DE OFERTAS EN RETAIL
     */

    protected function saveStoresCategories($params) {
        $storeCategory = new StoreCategory();

        $storeCategory->find_by_link = $params['find_by_link'];
        $storeCategory->json_detail = $params['json_detail'];
        $storeCategory->store_id = $params['store_id'];

        $storeCategory->save();
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
     * BUSCA LOS PRODUCTOS ´POR NOMBRE DEL PRODUCTO
     */
    protected function findProductsByName($arrayFilter) {
        $this->findProductsBaseQuery();
    }

    /*
     * BUSCA LOS PRODUCTOS ´FILTRADO SOLO POR RETAIL
    */
    protected function findProductsByStore($arrayFilter) {
        $this->findProductsBaseQuery();
    }    
    
    /*
     * BUSCA LOS PRODUCTOS FILTRADOS´POR PRECIO
     */
    protected function findProductsByPrice($arrayFilter) {
        $this->findProductsBaseQuery();
    }    
    
    /*
     * BUSCA LOS PRODUCTOS ´FILTRADOS POR DESCUENTO DE INTERNET
     */
    protected function findProductsByInternetDiscount($arrayFilter) {
        $this->findProductsBaseQuery();
    }

    /*
     * BUSCA LOS PRODUCTOS ´FILTRADOS POR DESCUENTO DE TARJETA(CORRESPONDINTE A CADA RETAIL)
     */
    protected function findProductsByCardDiscount($arrayFilter) {        
        $this->findProductsBaseQuery();
    }

    /*
     * ESTE METODO SIRVE PARA FILTRAR POR CUALQUIER OTRO PARAMETRO QUE SE REQUIERA
    */    
    protected function findProductsBaseQuery(){
        
    }
    
    
}
