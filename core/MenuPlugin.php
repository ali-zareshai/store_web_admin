<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 16/09/2018
 * Time: 10:13 PM
 */

class MenuPlugin
{
    public static function getListPlugin(){
        $list_plugin=scandir(__DIR__."/../plugins/",0);
        unset($list_plugin[0]);
        unset($list_plugin[1]);
        return $list_plugin;
    }

    public static function showListPlugin(){
        $menu="";
        foreach (self::getListPlugin() as $k=>$val){
            if (is_dir(__DIR__."/../plugins/$val")){
                $json=file_get_contents(__DIR__."/../plugins/$val/etc/version.json");
                $arr=json_decode($json);
                $addres="plugins/".$val."/index.php";
                $menu.="<li  onclick=\"replacepage('".$addres. "')\" class='has-sub'><a><span>".$arr->name ."</span></a></li>";
            }
        }
        return $menu;
    }

}