<?php

require __DIR__."/../../../core/All_One.php";

class DownData
{
    private $key_presha;
    private $api_url;
    private static $id=0;
    public function __construct()
    {
        $this->api_url   =Config::getConfig("url_api");
        $this->key_presha=Config::getConfig("presh_key_api");

    }
    public function getProdects(){
        $id       = $this->getprodectids();
        $category = $this->getCatgetory();
        $this->resetProdect();

        for ($x=0;$x<sizeof($id);$x=$x+10){
            $split=array_slice($id,$x,10);
            $s=implode("|",$split);

            $url = $this->api_url."products?&ws_key=".$this->key_presha."&sort=[id_ASC]&output_format=JSON&filter[id]=[".$s."]&display=full";
            $data=json_decode($this->execCurl($url));
//            var_dump($data);
            if (!isset($data->products)){
                continue;
            }
            $prodects = $data->products;
            $mozodi = $this->getMozodi($prodects);
            foreach ($prodects as $prodect){
                $this->saveProdect($prodect,$mozodi,$category);
            }

        }

        return "ok";
    }

    public function getTotalProdect(){
        return sizeof($this->getprodectids());
    }

    private function getprodectids(){
        $url=$this->api_url."products?&ws_key=".$this->key_presha."&sort=[id_DESC]&output_format=JSON&display=[id]";
        $data=json_decode($this->execCurl($url));
        $data=$data->products;
        $id=array();
        foreach ($data as $val){
            $id[]=$val->id;
        }
        return $id;
    }

    private function getMozodi($prodects){
        $ids="";
        foreach ($prodects as $prodect){
            $ids .= $prodect->id."|";
        }
        $url= $this->api_url."stock_availables?&ws_key=".$this->key_presha."&output_format=JSON&filter[id_product]=[$ids]&display=[id_product,quantity]";
        $data= json_decode($this->execCurl($url));
        $mozodis = $data->stock_availables;
        $moz=array();
        foreach ($mozodis as $m){
            $moz[$m->id_product]=$m->quantity;
        }
        return $moz;
    }

    private function saveProdect($prodect,$mozodi,$category){
        $pro['id']=$prodect->id;
        $pro['category']=@$category[$prodect->id_category_default];
        $pro['image']=$prodect->id_default_image;
        $pro['reference']=$prodect->reference;
        $pro['price']=$this->vazehnagh($prodect->price);
        $pro['wholesale_price']=$this->vazehnagh($prodect->wholesale_price);
        $pro['available_for_order']=$prodect->available_for_order;
        $pro['show_price']=$prodect->show_price;
        $pro['meta_description']=$prodect->meta_description;
        $pro['active']=$prodect->active;
        $pro['weight']=$prodect->weight;
        $pro['mojodi']=(isset($mozodi[$prodect->id]))?$mozodi[$prodect->id]:0;
        $pro['update']=str_replace(":",".",$prodect->date_upd);
        $pro['combine']=(isset($prodect->associations->product_option_values))?"1":"0";
        $com="";
        if (isset($prodect->associations->product_option_values)){
            $combine=$prodect->associations->product_option_values;
            for ($x=0;$x<count($combine);$x++){
                $item=$combine[$x];
                $id=$item->id;
                $com.=$id."|";
            }
        }
        $pro['combine_id']=$com;

        $this->saveToDb($pro);

    }

    private function saveToDb($prodect){

        foreach ($prodect as $key=>$value){
            $$key=$value;
        }

        $sql_insert="INSERT INTO `prodect` (`id`, `id_`, `category`, `image`, `reference`, `price`, `wholesale_price`, `available_for_order`, `show_price`, `meta_description`, `mojodi`, `update_`, `combine`, `combine_id`,`weight`,`active`) VALUES
(null,'$id' ,'$category' , '$image', '$reference','$price' , '$wholesale_price', '$available_for_order','$show_price', '$meta_description', '$mojodi','$update' , '$combine', '$combine_id', '$weight','$active')";

        R::exec($sql_insert);
//        echo $sql_insert;
//        die();

    }

    private function resetProdect(){
        $sql="DROP TABLE IF EXISTS `prodect`;
CREATE TABLE IF NOT EXISTS `prodect` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `wholesale_price` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `available_for_order` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `show_price` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `mojodi` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `update_` date NOT NULL,
  `combine` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `combine_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `tracknumber` varchar(60) COLLATE utf8_persian_ci DEFAULT NULL,
  `des` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `need_update` int(1) DEFAULT '0',
  `weight` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `active` VARCHAR(1) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=615 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;";

        R::exec($sql);
    }

    private function vazehnagh($pool){
        $arr = explode(".", $pool);
//    setlocale(LC_MONETARY, 'fa-IR');
        $arr=number_format($arr[0],3,".",",");
        $arr=explode(".",$arr);
        return $arr[0];
    }



    private function getCatgetory(){
        $url_customers=$this->api_url."categories?&ws_key=".$this->key_presha."&output_format=JSON&display=[id,name]";
        $data=json_decode($this->execCurl($url_customers));
        $arr_2=$data->categories;
        $category=array();
        foreach ($arr_2 as $value){
            $category[$value->id]=$value->name;
        }
        return $category;

    }


    private function execCurl($url){
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_error($ch)){
            $data=curl_error($ch);
        }
        curl_close($ch);

        return $data;
    }

}