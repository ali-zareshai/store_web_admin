<?php
require_once __DIR__."/../core/All_One.php";

Security::checkAccess("manager");

$action = Security::get("action");

switch ($action){
    case "deleth":
        $plugin = Security::post('plugin');
        if (deleteDir(__DIR__."/../plugins/$plugin")){
            R::exec("DELETE FROM `departement` WHERE `departement`.`page` = $plugin;");
            LogAction::Log("remove plugin $plugin");
            echo "ok";
        }else{
            LogAction::Log("error in Deleth Plugin $plugin");
            echo "error";
        }
        break;
    case "install":
//        var_dump($_FILES);
            if (@$_FILES['file']['type']!="application/x-zip-compressed"){
                echo Languege::_("file format not support");
            }else{
                if (!move_uploaded_file($_FILES['file']['tmp_name'],__DIR__."/../plugins/".$_FILES['file']['name'])){
                   echo Languege::_("Error in upload file");
                }else{
                   installPackage($_FILES['file']['name']);
                }
            }
            break;
}

function installPackage($filename){
    $zip = new ZipArchive;
    $res = @$zip->open(__DIR__."/../plugins/".$filename);
    if ($res === TRUE) {
        @$zip->extractTo(__DIR__."/../plugins/");
        $zip->close();
        unlink(__DIR__."/../plugins/".$filename);
        configDB($filename);
    } else {
        echo Languege::_("Error in install file");
    }
}

function configDB($filename){
    $filename = str_replace(".zip","",$filename);
    $sql_dir = __DIR__."/../plugins/".$filename."/DB.sql";
    if (file_exists($sql_dir)){
        $query=@file_get_contents($sql_dir);
        @R::exec($query);
        echo "ok";
    }else{
        echo "ok";
    }
    LogAction::Log("install new Plugin");

}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
    return true;
}