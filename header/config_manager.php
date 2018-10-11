<?php
require __DIR__."/../core/All_One.php";
require __DIR__."/../config/prodect.php";
Security::checkAccess("setting");

$action=Security::get("action");

switch ($action){
    case "config":
        $field = Security::post("id");
        $val   = Security::post("val");

        $sql="UPDATE `config` SET `setting` = '$val' WHERE `config`.`title` = '$field';";
        R::exec($sql);
        LogAction::Log("change config $field to $val");

        echo "ok";
        break;
}