<?php

include('config.php');
$url = isset($_GET['url']) ? $_GET['url'] : 'home';

// contadores 
VSTCOUTN::updateUsersOnline();
VSTCOUTN::countUser();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site oficial para informar sobre a Escola Estadual Eugênio Mariz de Oliveira Netto - PEI, com notícias e informações relevantes para a comunidade escolar.">
    <meta name="keywords" content="Escola Estadual Eugênio Mariz de Oliveira Netto, educação, notícias escolares, ensino público, escola, alunos, professores, educação de qualidade">
    <meta name="author" content="Gustavo Arruda, Carlos Sanches">  
    <meta property="og:title" content="Escola Estadual Eugênio Mariz de Oliveira Netto - PEI">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="<?php echo INCLUDE_PATH?>./img/eugenionews.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css">

    <title>Eg_News</title>
</head>

<body>
    <!-- Estruturando cabeçalho da página -->
    <base base="<?php echo INCLUDE_PATH; ?>"/>
    <header>
        <div class="center">
            <nav>
                <div class="logo">
                    <a href="<?php echo INCLUDE_PATH; ?>home"><img src="<?php echo INCLUDE_PATH; ?>./img/logo2.png" alt="logo"></a>
                </div> <!-- logo -->

                <div class="search search-desktop">
                    <div class="input-item">
                        <?php

                        $query = "SELECT * FROM `tb_painel_admin.noticias` ";
                        if (isset($_POST['pesquisa'])) {
                            $search = $_POST['pesquisa'];
                            header("Location: news?pesquisa=" . urlencode($search));
                            exit();
                        }


                        ?>
                        <form method="post">
                            <input type="text" name="pesquisa" placeholder="Pesquisar...">
                            <button type="submit" name="buscar" class="button-icon-search"><i class="fa-solid fa-magnifying-glass"
                                    style="color: #203e51;"></i></button>
                        </form>


                    </div> <!-- input-item -->
                    <div class="filter">
                        <a href="<?php echo INCLUDE_PATH; ?>home"><?php inconHomeVerif($url); ?></a>
                    </div><!-- filter -->
                </div> <!-- search -->

                <div class="menu-desktop">
                    <ul class="ul-desktop ul-desktop-two">
                        <li><a href="<?php echo INCLUDE_PATH; ?><?php directionPag($url, 'news') ?>"><?php nomePag($url, 'news', 'Notícias') ?></a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?><?php directionPag($url, 'school') ?>"><?php nomePag($url, 'school', 'Escola') ?>
                            </a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?><?php directionPag($url, 'about') ?>"><?php nomePag($url, 'about', 'Sobre ') ?></a></li>
                    </ul>
                </div><!-- menu-desktop -->

                <div class="button-menu-mobile">
                    <button class="button-menu-mobile" onclick="menuView()"><img class="icon" src="<?php echo INCLUDE_PATH ?>img\menu-mobile-icon.svg" alt="icon menu"></button>
                </div> <!-- button-menu-mobile -->
            </nav>

            <div class="mobile-menu">
                <ul class="ul-mobile">
                    <li><a href="<?php echo INCLUDE_PATH; ?>school">Escola</a></li>
                    <li><a href="<?php echo INCLUDE_PATH; ?>news">Notícias</a></li>
                    <li><a href="<?php echo INCLUDE_PATH; ?>about">Sobre</a></li>
                </ul> <!-- ul-mobile -->
            </div> <!-- mobile-menu -->
        </div> <!-- center -->
    </header>
    <!-- Fim do cabeçalho -->
    <?php


    if (file_exists('pages/' . $url . '.php')) {
        include('pages/' . $url . '.php');
    } else {
        if ($url != 'about' && $url != 'scholl') {
            $urlPar = explode('/', $url)[0];
            if ($urlPar != 'news') {
                $pagina404 = true;
                include('pages/404.php');
            } else {
                include('pages/news.php');
            }
        } else {

            include('pages/home.php');
        }
    }
    ?>

    <!-- Estruturando rodapé -->
    <footer>
        <div class="center">
            <div class="footer-container">
                <div class="social-escola">
                    <div class="escola1">
                        <h2>Siga a escola</h2>
                        <div class="social-icon-container">
                            <div class="social-icon-escola">
                                <a href="https://www.facebook.com/share/C81nbbPZQXWXopvE/"><i class="fa-brands fa-facebook"></i></a>
                            </div> <!-- social-icon-->
                            <div class="social-icon-escola">
                                <a href="https://www.instagram.com/eugenio.mariz_connected?igsh=MTZranRmZ2hqdmV3ag=="><i class="fa-brands fa-instagram"></i></a>
                            </div> <!-- social-icon-->
                        </div> <!-- social-icon-container -->

                        <div class="descricao">
                            <header>
                                <h2>Sobre</h2>
                            </header>
                            <p>A Escola Estadual Eugênio Mariz de Oliveira Netto - PEI é uma instituição de ensino que se destaca pela alta qualidade pedagógica e pelo compromisso com o crescimento integral de seus alunos. Localizada em uma região de fácil acesso, oferece um ambiente que combina acolhimento e desafios, favorecendo o desenvolvimento intelectual, emocional e social de crianças e jovens.</p>
                        </div> <!-- descricao -->
                    </div> <!--escola1 -->

                </div> <!--social-escola-->

                <div class="escola2">
                    <h2>Faça uma visita!</h2>
                    <div class="mapouter">
                        <div class="gmap_canvas"><iframe id="gmap_canvas"
                                src="https://maps.google.com/maps?q=eugenio+mariz+de+oli&t=k&z=17&ie=UTF8&iwloc=&output=embed"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                    </div>
                </div><!-- escola -->
 
                <div class="logo">
                    <img src="<?php echo INCLUDE_PATH?>img/logo2.png" alt="">
                </div> <!-- logo -->
            </div> <!-- footer-container -->
            <div class="direitos">
                <p>Todos os direitos reservados - E.E. Eugênio Mariz de Oliveira Netto - PEI</p>
            </div>
        </div> <!-- center -->
    </footer>
    <!-- Fim do rodapé-->

    <div class="coockies" id="coockies">
        <div class="coockies-text">
            <p class="texto-coockie">Queremos te oferecer a melhor experiência de leitura! Para isso, utilizamos cookies. Ao aceitar os cookies, você nos ajuda a entender suas preferências e mostrar as notícias que mais te interessam. Ao clicar em prosseguir, você concorda com o uso de cookies.</p>

            <div class="coockies-btn">
                <button class="cookie-button" onclick="aparecerCoockie()">Prosseguir</button>
            </div> <!-- coockies-btn -->
        </div> <!-- coockies-text -->
    </div> <!-- coockies -->

    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

    <script src="<?php echo INCLUDE_PATH?>js/constantes.js"></script>
    <?php
    if (is_array($url) && strstr($url[0], 'news') !== false) {
    ?>
        <script>
            $(function(){
                $('select').change(function(){
                    location.href='news/'+$(this).val();
                }) 
            })
        </script>
    <?php } ?>

    <script src="<?php echo INCLUDE_PATH; ?>js/script.js"></script>
</body>

</html>