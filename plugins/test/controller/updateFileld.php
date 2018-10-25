<?php
require __DIR__."/../../../core/All_One.php";
require __DIR__."/../../../config/prodect.php";
Security::checkAccess("test");

$action=Security::get("action");

switch ($action){
    case "update":
        $id   =Security::post("id");
        $field=Security::post("field");
        $value=Security::post("value");

        R::exec("UPDATE `prodect` SET `$field` = '$value' WHERE `prodect`.`id_` = $id;");
        R::exec("UPDATE `prodect` SET `need_update` = '1' WHERE `prodect`.`id_` = $id;");
        LogAction::Log("Update Filed $field =>$value  ID: $id table:prodect");
//        echo "UPDATE `prodect` SET `$field` = '$value' WHERE `prodect`.`id_` = $id;";
        echo "ok#". Languege::_("updated success")." ".$id;
        break;
}

