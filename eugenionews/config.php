<?php

//TIMEZONE
date_default_timezone_set('America/Sao_Paulo');
// START SESSIONS
session_start();

// DEFINE DIRECTORYS
define('INCLUDE_PATH', 'http://localhost/eugenionews/');
define('INCLUDE_DASH', INCLUDE_PATH . 'dashboard/');
define('BASE_DIR_DASH', __DIR__ . '/dashboard');

// LOADING CLASSES

$autoload = function ($class) {
    include('classes/' . $class . '.php');
};

spl_autoload_register($autoload);

// CONNECTING DB
define('HT', 'localhost');
define('NAMEDB', 'eg-nws');
define('USR', 'root');
define('PSW', '');

// FUNTIONS BASIC

function inconHomeVerif($url)
{
    switch ($url) {
        case 'home':
            break;
        default:
            echo '<img class="icon-home" src="'.INCLUDE_PATH.'img/home-icon.svg" alt="Início">';
            break;
    }
}

function nomePag($url, $pag, $nome = null)
{
    if ($url == $pag) {
        echo 'Início';
    } else {
        echo $nome;
    }
}

function directionPag($url, $pag)
{
    if ($url == $pag) {
        echo 'home';
    } else {
        echo $pag;
    }
}

//FUNCTIONS DASH

function verificaPermissaoMenu($permission)
{
    if ($_SESSION['cargo'] >= $permission) {
        return;
    } else {
        echo 'style="display:none;"';
    }
}
function verificaPermissaoPagina($permissao)
{
    if ($_SESSION['cargo'] >= $permissao) {
        return;
    } else {
        include('dashboard/pages/permissao_negada.php');
        die();
    }
}

function recoverPost($post)
{
    if (isset($_POST[$post])) {
        echo $_POST[$post];
    }
}
function recoverImg($files)
{
    if (isset($_FILES[$files])) {
        echo $_FILES[$files];
    }
}
