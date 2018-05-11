<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreCategory;
use App\Models\Store;
use Illuminate\Support\Str;

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
     * BUSCA LOS PRODUCTOS FILTRADO SOLO POR RETAIL
     */

    protected function findProductsByStore($store) {
        $arrayFilter = [['store_id', '=', $store]];
        $result = $this->findProductsBaseQuery($arrayFilter);
        $customResult = [];
        foreach ($result as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                $customResult[] = $product;
            }
        }
        return $customResult;
    }

    /*
     * BUSCA LOS PRODUCTOS ´POR NOMBRE DEL PRODUCTO
     */

    protected function findProductsByName($store, $name) {
        $name = strtolower($name);
        $arrayFilter = [['store_id', '=', $store]];
        $result = $this->findProductsBaseQuery($arrayFilter);
        $customResult = [];
        foreach ($result as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                if (strpos(strtolower($product->name), $name) !== false) {
                    $customResult[] = $product;
                }
            }
        }
        $customResult = collect($customResult)->sortBy('name');
        return $customResult;
    }

    /*
     * BUSCA LOS PRODUCTOS FILTRADOS´POR PRECIO
     */

    protected function findProductsByPrice($store, $price) {
        $arrayFilter = [['store_id', '=', $store]];
        $result = $this->findProductsBaseQuery($arrayFilter);
        $customResult = [];
        foreach ($result as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                if ($product->price >= $price) {
                    $customResult[] = $product;
                }
            }
        }
        $customResult = collect($customResult)->sortBy('price')->reverse()->toArray();
        return $customResult;
    }

    /*
     * BUSCA LOS PRODUCTOS ´FILTRADOS POR DESCUENTO DE INTERNET
     */

    protected function findProductsByInternetDiscount($store, $internetDiscount) {
        $arrayFilter = [['store_id', '=', $store]];
        $result = $this->findProductsBaseQuery($arrayFilter);
        $customResult = [];
        foreach ($result as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                if ($product->discountPercentInternet >= $internetDiscount) {
                    $customResult[] = $product;
                }
            }
        }
        $customResult = collect($customResult)->sortBy('discountPercentInternet')->reverse()->toArray();
        return $customResult;
    }

    /*
     * BUSCA LOS PRODUCTOS ´FILTRADOS POR DESCUENTO DE TARJETA(CORRESPONDINTE A CADA RETAIL)
     */

    protected function findProductsByCardDiscount($store, $cardDiscount) {
        $arrayFilter = [['store_id', '=', $store]];
        $result = $this->findProductsBaseQuery($arrayFilter);
        $customResult = [];
        foreach ($result as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                if ($product->discountPercentWithCard >= $cardDiscount) {
                    $customResult[] = $product;
                }
            }
        }
        
        $customResult = collect($customResult)->sortBy('discountPercentWithCard')->reverse()->toArray();
        return $customResult;
    }

    /*
     * ESTE METODO SIRVE PARA FILTRAR POR CUALQUIER OTRO PARAMETRO QUE SE REQUIERA
     */

    protected function findProductsBaseQuery($arrayFilters) {
        $storeCategory = StoreCategory::where($arrayFilters)->get();
        return $storeCategory;
    }


    /*
     * ESTE METODO SIRVE PARA ARMAR EL ARRAY DE PRODUCTOS
     */    
    private function formatArrayProducts($array){
        $customResult = [];
        foreach ($array as $value) {
            $jsonDetail = json_decode($value['json_detail']);
            foreach ($jsonDetail->products as $product) {
                $customResult[] = $product;
            }
        }
        return $customResult;
    }
    
}





