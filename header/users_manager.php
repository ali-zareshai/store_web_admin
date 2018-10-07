<?php
require __DIR__."/../core/All_One.php";
require __DIR__."/../config/prodect.php";
Security::checkAccess("users");

$action=Security::get("action");

switch ($action){
    case "update":
        $id   =Security::post("id");
        $field=Security::post("field");
        $value=Security::post("value");

        if ($field=="enable" || $field=="isadmin"){
            if ($value=="true"){
                $value=1;
            }else{
                $value=0;
            }
        }
        $sql="UPDATE `users` SET `$field` = '$value' WHERE `users`.`id` = $id;";
        R::exec($sql);
        LogAction::Log("Update user $field =>$value  ID: $id table:users");
        echo "ok";

        break;
}