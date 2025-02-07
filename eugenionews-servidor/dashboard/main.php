<?php
if (isset($_GET['loggout'])) {
    LOG::loggout();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo INCLUDE_DASH; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="./img/eugenionews.ico" type="image/x-ico">
    <title>Estação de controle</title>
</head>

<body>

    <div class="main-container">
        <!-- criando menu lateral -->
        <div class="button-menu">
            <button class="menu-botao flex" onclick="menuView()"><img class="icon" src="<?php echo INCLUDE_DASH ?>./img/menu.svg" alt=""></button>
        </div>
        <aside class="aside-responsivo flex">
            <div class="aside-container flex">
                <div class="perfil flex">
                    <?php 
                    if (empty($_SESSION['img'])) { ?>
                        <div class="avatar-user">
                            <img src="<?php echo INCLUDE_DASH?>./img/user-rounded-svgrepo-com.svg">
                        </div> <!--avataar-user-->
                    <?php } else { ?>
                        <div class="img-perfil">
                            <img src="<?php echo INCLUDE_DASH; ?>up/<?php echo $_SESSION['img']; ?> ">
                        </div> <!-- img-perfil -->
                    <?php } ?>
                    <div class="nome-perfil">
                        <p><?php echo $_SESSION['name']; ?></p>
                        <p><?php echo DASH::pegaCargo($_SESSION['cargo']); ?></p>
                    </div>
                </div> <!-- perfil -->
                <div class="btn-logout btn-main">
                    <a href="<?php echo INCLUDE_DASH ?>?loggout"><img src="<?php echo INCLUDE_DASH ?>./img/logout-icon.svg"
                            alt="Icone da para voltar sair do perfil de login" title="Sair"></a>
                </div> <!-- btn-home -->
                <div class="btn-home btn-main">
                    <a href="<?php echo INCLUDE_PATH ?>"><img src="<?php echo INCLUDE_DASH ?>./img/home.svg" alt="Icone da para voltar à página inicial" title="Início"></a>
                </div> <!-- btn-home -->
                <nav class="flex">
                    <div class="gestao nav-item flex">
                        <h2>gestão</h2>
                        <div class="item-child">
                            <ul class="flex">
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>estatisticas" <?php verificaPermissaoMenu(0) ?>>Estatísticas</a></li>
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>listar-categoria" <?php verificaPermissaoMenu(1) ?>>Categorias</a></li>
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>listar-noticias" <?php verificaPermissaoMenu(1) ?>>Notícias</a></li>
                            </ul>
                        </div> <!-- item-child -->
                    </div> <!-- gestao -->
                    <div class="noticias nav-item flex">
                        <h2>notícias</h2>
                        <div class="item-child">
                            <ul class="flex">
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>cadastrar-noticia" <?php verificaPermissaoMenu(0) ?>>Cd. Notícias</a></li>
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>cadastrar-categoria" <?php verificaPermissaoMenu(1) ?>>Cd. Categoria</a>
                            </ul>
                        </div> <!-- item-child -->
                    </div> <!-- noticias -->
                    <div <?php echo verificaPermissaoMenu(1) ?> class="admin nav-item flex">
                        <h2>admin</h2>
                        <div class="item-child">
                            <ul class="flex">
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>funcionarios">Funcionários</a></li>
                                <li><a class="marcacao" href="<?php echo INCLUDE_DASH ?>cadastrar-user">Cd. Usuário</a></li>
                            </ul>
                        </div> <!-- item-child -->
                    </div> <!-- admin -->
                </nav>
            </div> <!-- aside-container -->
        </aside>
        <!-- fim do menu lateral -->

        <!-- <div class="acoes">
        <a href="<?php echo INCLUDE_DASH ?>?loggout">loggout</a>
        <a href="<?php echo INCLUDE_DASH ?>">Página inicial</a>
    </div> -->


        <div class="cont">
            <!-- LOADING ALL PAGES -->
            <?php DASH::carregarPagina(); ?>

        </div> <!-- content -->

        <script src="<?php echo INCLUDE_DASH ?>js/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <script>
            function redirectToPage() {
                var select = document.getElementById('dias');
                var selectedValue = select.options[select.selectedIndex].value;
                localStorage.setItem('selectedOption', selectedValue);
                if (selectedValue) {
                    window.location.href = 'estatisticas?dias=' + selectedValue;
                } else {
                    window.location.href = 'estatisticas';
                }
            }

            window.onload = function() {
                var select = document.getElementById('dias');
                var selectedValue = localStorage.getItem('selectedOption');
                if (selectedValue) {
                    select.value = selectedValue;
                }
            };
        </script>

        <script>
            $('[actionBtn=delete]').click(function() {
                var txt;

                var r = confirm("Deseja excluir o item?");
                if (r == true) {
                    return true;
                } else {
                    return false;
                }
            })
        </script>
        <script src="https://cdn.tiny.cloud/1/h3ec8jgu2fv5wst95ilybwlx3farxk41ghvn7x1s2nunxhbd/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

        <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
        <script>
            tinymce.init({
                selector: '.tinymce',
                plugins: [
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'wordcount'
    ],
    toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    menubar: false,
         
               
            

                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
                exportpdf_converter_options: {
                    'format': 'Letter',
                    'margin_top': '1in',
                    'margin_right': '1in',
                    'margin_bottom': '1in',
                    'margin_left': '1in'
                },
                exportword_converter_options: {
                    'document': {
                        'size': 'Letter'
                    }
                },
                importword_converter_options: {
                    'formatting': {
                        'styles': 'inline',
                        'resets': 'inline',
                        'defaults': 'inline'
                    }
                },
            });
        </script>
</body>

</html>