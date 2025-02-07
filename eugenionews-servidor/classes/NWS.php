<?php

    class NWS{
           
    // Inserindo na tabela
    public static function generateSlug($str){

        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/[áàâãäå]/u', 'a', $str);
        $str = preg_replace('/[éèêë]/u', 'e', $str);
        $str = preg_replace('/[íìîï]/u', 'i', $str);
        $str = preg_replace('/[óòôõö]/u', 'o', $str);
        $str = preg_replace('/[úùûü]/u', 'u', $str);
        $str = preg_replace('/[ç]/u', 'c', $str);
        $str = preg_replace('/[^\w\s-]/', '', $str);
        $str = preg_replace('/[\s-]+/', '-', $str);
        $str = trim($str, '-');
        return $str;
    }

    public static function insert($arr){
        $certo = true; 
        $tabela = $arr['tabela'];
        $query = "INSERT INTO `$tabela` VALUES (null";
        foreach($arr as $key => $value){
            $name = $key;

            if($name == 'acao' || $name == 'tabela')
                continue;
            if($value == ''){
                $certo = false;
                break;
            }
            
            $query.=",?";
            $parametros[] = $value;
        }
        $query.=")";

        if($certo){
            $sql = SQLCN::connectDB()->prepare($query);
            $sql->execute($parametros);
        }
        return $certo;
    }
    }
?>