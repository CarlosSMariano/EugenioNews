<?php 
    include('../config.php');

    if(LOG::loggade() == false){
        include('login.php');
    }else{
        include('main.php');
    }
?>