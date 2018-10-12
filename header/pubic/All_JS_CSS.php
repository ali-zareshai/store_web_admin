<?php
//@session_start();
function getALLcss()
{
    $dir= "\adminPortal\header\pubic\\";
    echo "<meta charset='utf-8'>";
    echo "<meta name=\"{$dir}viewport\" content=\"width=device-width, initial-scale=1\">";
    echo "<script src=\"{$dir}jquery-3.3.1.min.js\"></script>";
    echo "<script src=\"{$dir}bootstrap.min.js\"></script>";
    echo "<script src=\"{$dir}jquery-ui.min.js\"></script>";
    echo "<script src=\"{$dir}tabulator.min.js\"></script>";
    echo "<script src=\"{$dir}notify.min.js\"></script>";
    echo "<script src=\"{$dir}sweetalert.min.js\"></script>";
    echo "<script src=\"{$dir}jspdf.min.js\"></script>";
    echo "<script src=\"{$dir}jspdf.plugin.autotable.js\"></script>";
    echo "<script src=\"{$dir}xlsx.full.min.js\"></script>";
    echo "<script src=\"{$dir}jquery.fancybox.min.jsa\"></script>";
    echo "<script src=\"{$dir}all.js\"></script>";

    //_____________________________________________________________________________

    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}tabulator.min.css\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}style.css\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}font.css\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}bootstrap.min.css\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}jquery.fancybox.min.css\">";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}all.css\">";

    if (!isset($_SESSION['lang']) || is_null($_SESSION['lang']) || $_SESSION['lang'] == "fa") {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}bootstrap.rtl.css\">";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$dir}bootstrap.rtl.min.css\">";
    }
}