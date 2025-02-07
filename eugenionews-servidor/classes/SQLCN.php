<?php
    class SQLCN {
        private static $pdo; 

        public static function connectDB(){
            if(self::$pdo == null){
                try{
                    self::$pdo = new PDO('mysql:host='.HT.'; dbname='.NAMEDB,USR,PSW,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(Exception $e){
                    echo '<h2>ERROR TO CONNETED</h2>';
                }
            }
            
            return self::$pdo;

        }
    }
?>