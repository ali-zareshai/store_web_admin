<?php
require __DIR__."/../../../core/Login.php";

$count = R::getRow("SELECT COUNT(*) as count FROM `prodect`;");
echo $count['count'];