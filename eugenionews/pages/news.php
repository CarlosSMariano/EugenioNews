<?php
$url = explode('/', $_GET['url']);
if (!isset($url[2])) {
?>

    <main>
        <section>
            <div class="barra"></div> <!-- barra -->
        </section>


        <!-- Estruturando as seção de notícias principais -->
        <section>
            <div class="main-news">
                <div class="center">
                    <div class="main-news-content">
                        <?php
                        $notUm = SITE::notPrincipais(1);


                        if (!$notUm) {

                        ?>

                            <div class="main-one main-one-news">
                                <div class="main-one-img">
                                    <img src="<?php echo INCLUDE_PATH ?>img/main-one-bg.jpg" alt="">
                                </div>

                                <div class="main-one-content">
                                    <h2>Nada por aqui...</h2>
                                    <p>Nada por aqui...</p>
                                </div>
                            </div> <!-- main-one -->

                        <?php } else {
                            $categoria_Principal = SITE::cat($notUm['categoria_id']); ?>
                            <div class="main-one main-one-news">
                                <div class="main-one-img">
                                    <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $notUm['capa'] ?>" alt="">
                                </div>

                                <div class="main-one-content">

                                    <h2>
                                        <a href="<?php echo INCLUDE_PATH; ?>news/<?php echo $categoria_Principal ?>/<?php echo $notUm['slug'] ?>">
                                            <?php echo $notUm['titulo'] ?>
                                        </a>
                                    </h2>
                                    <p>
                                        <a href="<?php echo INCLUDE_PATH; ?>news/<?php echo $categoria_Principal ?>/<?php echo $notUm['slug'] ?>">
                                            <?php echo substr(strip_tags($notUm['conteudo']), 0, 400) . '...' ?>
                                        </a>
                                    </p>

                                </div>
                            </div> <!-- main-one -->
                        <?php } ?>

                        <div class="main-news-wraper">
                            <?php
                            $populares = SITE::noticiaPopular();

                            if ($populares) {
                                if (is_array($populares) && count($populares) > 0) {
                                    foreach ($populares as $slug) {
                                        $noticia = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = ?");
                                        $noticia->execute(array($slug['slug']));
                                        foreach ($noticia as $key => $value) {
                                            $catName = SITE::cat($value['categoria_id']);

                            ?>

                                            <div class="main-two main-two-news">

                                                <div class="main-two-img">
                                                    <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $value['capa'] ?>" alt="">
                                                </div>



                                                <div class="main-two-content">

                                                    <h2><a href="<?php echo INCLUDE_PATH; ?>news/<?php echo $catName ?>/<?php echo $value['slug'] ?>"><?php echo $value['titulo'] ?></a></h2>


                                                    <p><?php echo substr(strip_tags($value['conteudo']), 0, 400) . '...' ?></p>

                                                </div>

                                            </div> <!-- main-two -->


                                <?php }
                                    }
                                }
                            } else { ?>

                                <div class="main-two main-two-news">
                                    <div class="main-two-img">
                                        <img src="<?php echo INCLUDE_PATH ?>img/main-one-bg.jpg" alt="">
                                    </div>

                                    <div class="main-two-content">
                                        <h2>Nada por aqui...</h2>
                                        <p>Nada por aqui...</p>
                                    </div>
                                </div> <!-- main-two -->

                                <div class="main-two main-two-news">

                                    <div class="main-two-img">
                                        <img src="<?php echo INCLUDE_PATH ?>img/main-one-bg.jpg" alt="">
                                    </div>

                                    <div class="main-two-content">
                                        <h2>Nada por aqui...</h2>
                                        <p>Nada por aqui...</p>
                                    </div>
                                </div> <!-- main-two -->

                            <?php } ?>
                        </div> <!-- main-news-wraper -->
                    </div> <!-- main-news content -->
                </div> <!-- center -->
            </div> <!-- main news -->
        </section>
        <!-- Fim da seção de notícias principais -->

        <section>
            <div class="barra"></div> <!-- barra -->
        </section>

        <!-- Estruturando a segunda seção de notícias-->
        <?php
        $cat = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.categorias` WHERE slug = ?");
        $cat->execute(array(@$url[1]));
        $cat = $cat->fetch();
 
        $porPagina = 4;

        $query = "SELECT * FROM `tb_painel_admin.noticias` ";
        if (!empty($cat['name'])) {
            $query .= " WHERE categoria_id = $cat[id] ";
        }

        $search = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
        if (!empty($search)) {
            $query .= " WHERE titulo LIKE '%$search%' ";
        }

        if (isset($_GET['pagina'])) {
            $pagina = (int)$_GET['pagina'];
            $queryPg = ($pagina - 1) * $porPagina;
            $query .= " ORDER BY id DESC LIMIT $queryPg,$porPagina";
        } else {
            $pagina = 1;
            $query .= " ORDER BY id DESC LIMIT 0,$porPagina";
        }


        $sql = SQLCN::connectDB()->prepare($query);
        $sql->execute();
        $news = $sql->fetchAll();
        ?>
        <section>
            <div class="other-news">
                <div class="center">
                    <div class="other-contents">
                        <div class="ntc-atual">
                            <?php
                            if (empty($cat['name'])) {
                            ?>
                                <p>Vizualizando todas as noticias</p>
                            <?php } else { ?>
                                <p>Vizualizando em: <?php echo $cat['name'] ?></p>
                            <?php } ?>
                        </div> <!-- ntc-atual -->
                        <div class="other-wrap">
                            <?php
                            foreach ($news as $key => $value) {
                                $categoria = SITE::cat($value['categoria_id']);
                            ?>

                                <div class="other-item">
                                    <div class="other-bg">
                                        <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $value['capa'] ?>">
                                    </div>
                                    <div class="other-text">
                                        <div class="other-main">
                                            <a href="<?php echo INCLUDE_PATH; ?>news/<?php echo $categoria ?>/<?php echo $value['slug'] ?>">
                                                <h2><?php echo $value['titulo'] ?> - <?php echo date('d/m/Y', strtotime($value['postagem'])) ?></h2>
                                            </a>
                                            <p><?php echo substr(strip_tags($value['conteudo']), 0, 400) . '...' ?></p>
                                        </div> <!-- other-main -->
                                    </div><!-- othe r-text -->
                                </div> <!-- other-item -->
                            <?php } ?>
                            <div class="other-select">

                                <form>
                                    <label for="">Categorias:</label>
                                    <select>
                                        <option value="" selected=""> Todas as categorias</option>
                                        <?php
                                        $listarCat = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.categorias` ORDER BY name ASC");
                                        $listarCat->execute();
                                        $listarCat = $listarCat->fetchAll();
                                        ?>


                                        <?php
                                        foreach ($listarCat as $key => $value) {
                                        ?>

                                            <option <?php if ($value['slug'] == @$url[1]) echo 'selected' ?> value="<?php echo $value['slug'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </form>
                            
                            </div> <!-- other-wrap -->
                        </div> <!-- other-wrap -->
                    </div> <!-- other-wrap -->
                </div> <!-- other-wrap -->
                <?php

                $query2 = "SELECT * FROM `tb_painel_admin.noticias` ";

                if (!empty($cat['name'])) {
                    $query2 .= " WHERE categoria_id = $cat[id] ";
                }

                $totalPaginas = SQLCN::connectDB()->prepare($query2);
                $totalPaginas->execute();
                $totalPaginas = ceil($totalPaginas->rowCount() / $porPagina);
                if (!empty($search)) {
                    $query2 .= " WHERE titulo LIKE '%$search%' ";
                }
                if (!empty($search)) {

                    if (isset($_GET['pagina'])) {
                        $pagina = (int)$_GET['pagina'];
                        if ($pagina > $totalPaginas) {
                            $pagina = 1;
                        }
                        $queryPg = ($pagina - 1) * $porPagina;
                        $query .= " ORDER BY id DESC LIMIT $queryPg,$porPagina";
                    } else {
                        $pagina = 1;
                        $query .= " ORDER BY id DESC LIMIT 0,$porPagina";
                    }
                } else {
                    $query .= " ORDER BY id DESC ";
                }
                ?>
                <div class="paginacao">

                    <?php
                    if (empty($search)) {
                        SITE::renderPaginacao($totalPaginas, $pagina, $cat);
                    }
                    ?>
                </div>
            </div> <!-- center -->
            </div> <!-- other-news -->

        </section>
        <!-- Fim da segunda seção de notícias-->


    </main>

<?php
} else {
    include('news-single.php');
}
?>