<?php
class LOG
{
    public static function loggade()
    {
        return isset($_SESSION['login']) ? true : false;
    }

    public static function loggout()
    {
        setcookie('remind', 'true', time() - 1, '/');
        session_destroy();
        header('Location:' . INCLUDE_DASH);
    }
  
   

   
}
