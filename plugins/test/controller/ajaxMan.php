<?php
require __DIR__."/../../../core/All_One.php";
require_once __DIR__."/DownData.php";
require_once __DIR__."/WebService.php";

Security::checkAccess("test");

$action=Security::get("action");

switch ($action){
    case "down":
        $down=new DownData();
        echo $down->getProdects();
        break;
    case "clear":
        $webservice=new WebService();
        echo $webservice->clearChane();

}