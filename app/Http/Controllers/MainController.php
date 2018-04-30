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
    protected function findStoreByName($name){
        $store = Store::where('name',$name)->get();
        if(count($store)==0){
            return false;
        }
        return $store[0];
    }
    
    /*
     * BUSCA LOS DATOS DEL RETAIL POR NOMBRE
     */
    protected function findStoreCategoryByLink($link){
        $storeCategory = StoreCategory::where('find_by_link',$link)->get();
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

}
