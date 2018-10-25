<?php

require __DIR__."/../../../core/All_One.php";

class WebService
{
    private $key_presha;
    private $api_url;
    private $url_customers;
    private $url_prodect;
    public function __construct()
    {
        $this->api_url   =Config::getConfig("url_api");
        $this->key_presha=Config::getConfig("presh_key_api");
        $this->url_customers=$this->api_url."customers?&ws_key=".$this->key_presha;
        $this->url_prodect  =$this->api_url."products?&ws_key=".$this->key_presha;
    }

    public function getAddressProdect(){
        return $this->url_prodect;
    }

    public function Post_Data($service,array $data=null){
        if ($service=="customer"){
            $Xml     = $this->getCustomers($data);
            $address =  $this->url_customers;
            $put=false;
        }elseif ($service=="prodect"){
//            $Xml     =$this->getChangesProdect();
//            file_put_contents("xml_prodect.txt",$Xml);
            $address =$this->url_prodect;
            $put=true;
        }


//        $Xml = simplexml_load_string($Xml);
//        return $Xml;
//        if (!$this->isXML($Xml)){
//            die("error in xml");
//        }

        $ch = curl_init();
        $timeout = 15;
        curl_setopt($ch, CURLOPT_VERBOSE, true); // set url to post to
        curl_setopt($ch, CURLOPT_URL,$address);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        if ($put){
            curl_setopt($ch, CURLOPT_PUT, 1);
        }else{
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS,$Xml);
        $data = curl_exec($ch);
        if (curl_error($ch)){
            $data=curl_error($ch);
        }
        curl_close($ch);
        return $data;

    }

    public function clearChane(){
        $sql="UPDATE `prodect` SET `need_update` = '0';";
        R::exec($sql);
        return "ok";
    }



    public function getChangesProdect(){
        $sql="SELECT * FROM `prodect` WHERE need_update=1;";
        $changes=R::getAll($sql);
        return $changes;
    }

    public function getChangeXml(){
        return $this->getProdect($this->getChangesProdect());
    }

    private function getProdect($prodects){
        $xml=array();
        foreach ($prodects as $prodect){
            $x="<product>";
            foreach ($prodect as $item=>$value){
                if (in_array($item,['id_','reference','wholesale_price','price','weight','active'])){
                    $item=str_replace(['id_'],['id'],$item);
                    $x .= "<$item>".str_replace(',','',$value)."</$item>";
                }
            }
            $x .= "</product>";
            $xml[] = $x;
        }
        return "<prestashop>".implode("",$xml)."</prestashop>";
    }

    public function getCustomers(array $customers=null){
        $id=$id_default_group=$newsletter_date_add=$ip_registration_newsletter=$last_passwd_gen=$secure_key=$deleted=$passwd=$lastname=$firstname=$email=$note=$id_gender=null;
        $birthday=$newsletter_date_add=$newsletter=$optin=$active=$is_guest=$associations=null;
        foreach ($customers as $key=>$value){
            $$key=$value;
        }
        $raw="
        <prestashop xmlns:xlink=\"http://www.w3.org/1999/xlink\">
        <customer>
        <id>$id</id>
        <id_default_group>$id_default_group</id_default_group>
        <newsletter_date_add>$newsletter_date_add</newsletter_date_add>
        <ip_registration_newsletter>$ip_registration_newsletter</ip_registration_newsletter>
        <last_passwd_gen>$last_passwd_gen</last_passwd_gen>
        <secure_key>$secure_key</secure_key>
        <deleted>$deleted</deleted>
        <passwd>$passwd</passwd>
        <lastname>$lastname</lastname>
        <firstname>$firstname</firstname>
        <email>$email</email>
        <note>$note</note>
        <id_gender>$id_gender</id_gender>
        <birthday>$birthday</birthday>
        <newsletter>$newsletter</newsletter>
        <optin>$optin</optin>
        <active>$active</active>
        <is_guest>$is_guest</is_guest>
        <associations>$associations</associations>
    </customer>
</prestashop>
        ";
        return trim($raw);
    }



}