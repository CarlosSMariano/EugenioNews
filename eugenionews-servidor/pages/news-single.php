 <?php
    $url = explode('/', $_GET['url']);
    
    
    $verCat = SQLCN::connectDB()->prepare("SELECT * FROM  `tb_painel_admin.categorias` WHERE slug = ? ");
    $verCat->execute(array($url[1]));

    if ($verCat->rowCount()  == 0) {
        DASH::redirect(INCLUDE_PATH . 'news');
    }
    $info = $verCat->fetch();

    $post = SQLCN::connectDB()->prepare("SELECT * FROM  `tb_painel_admin.noticias` WHERE slug = ? AND categoria_id = ?");
    $post->execute(array($url[2], $info['id']));

    if ($post->rowCount() == 0) {
        DASH::redirect(INCLUDE_PATH . 'news');
    }
    $post = $post->fetch();
    
    VSTCOUTN::popularCount($url[2]);
    ?>

 <main>
     <section class="noticia-single">
         <header>

             <h1><?php echo $post['titulo'] ?></h1>
             <h6>Por <span><?php echo $post['autor'] ?></span> </h6>
             <p class="data">Publicado em: <?php echo date('d/m/Y', strtotime($post['postagem'])); ?></p>

         </header>

         <article>

             <?php
                echo $post['conteudo'];

                ?>
         </article>
     </section>
 </main>