<?php
    function p($val){
        echo "<pre>";
        print_r($val);
        echo "</pre>";
    }
    function dd($val){
        echo "<pre>";
        var_dump($val);
        echo "</pre>";
        die();
    }