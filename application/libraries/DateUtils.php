<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DateUtils {

    function __construct() {
        
    }
    
    static function getThaiYear() {
        return date("Y") + 543;
    }

    function date_thai($in_date)
    {
        $in_date = date("Ymd"); 
//        setlocale(LC_ALL, "thai");
        $tyear = $in_date->getYear() + 543; 
        return $in_date->format("%A %e %B")." $tyear";
//        echo "<br/>\n";

    }

}