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

    case "new_user":
        foreach ($_POST as $keu=>$value){
            $$keu=Security::post($keu);
        }
        $pass=md5($pass);
        R::exec("INSERT INTO `users` (`id`, `name`, `username`, `pass`, `email`, `departemt`, `enable`, `isadmin`, `last_pass`, `last_login`) VALUES (NULL, '$name', '$username', '$pass', '$email', '0', '0', '0', NULL, NULL);");
        echo R::getInsertID();
        LogAction::Log("insert new user: $name");
        break;

    case "departement":
        $id = Security::post("id");
        $val= Security::post("val");

        $sql="UPDATE `departman` SET `name` = '$val' WHERE `departman`.`group_code` = '$id';";
        R::exec($sql);
        LogAction::Log("Change name group: $id");
        echo "ok";
        break;



}