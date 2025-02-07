<main>
    <section>
        <div class="barra"></div> <!-- barra -->
    </section>

    <section class="section-slider">
        <div class="slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1">
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <input type="radio" name="radio-btn" id="radio4">

                <div class="slide first">
                    <img src="./img/eugenio11.jpg" alt="">
                </div> <!-- slide -->
                <div class="slide">
                    <img src="./img/eugenio2.jpg" alt="">
                </div> <!-- slide -->
                <div class="slide">
                    <img src="./img/eugenio3.jpg" alt="">
                </div> <!-- slide -->
                <div class="slide">
                    <img src="./img/eugenio4.jpg" alt="">
                </div> <!-- slide -->

                <div class="nav-auto">
                    <div class="auto-btn1"></div> <!-- auto-btn1 -->
                    <div class="auto-btn2"></div> <!-- auto-btn2 -->
                    <div class="auto-btn3"></div> <!-- auto-btn3 -->
                    <div class="auto-btn4"></div> <!-- auto-btn3 -->
                </div> <!-- nav-auto -->

            </div> <!-- slides -->

            <div class="nav-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
                <label for="radio4" class="manual-btn"></label>
            </div> <!-- nav-manual -->

        </div> <!-- slider -->
    </section> <!-- section-slider -->

    <section>
        <div class="news">
            <h1>Principais Notícias</h1>
        </div> <!-- news -->
        <div class="center">
            <div class="news-container">
                <div class="news-box">
                    <?php
                    $popular = SITE::popularOrdenado();
                    $primeria   = $popular['primeira'];
                    $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = :slug ");
                    $sql->bindParam(':slug', $primeria['slug']);
                    $sql->execute();
                    if (!empty($primeria['slug']) && $sql->rowCount() == 1) {
                        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = ? ");
                        $sql->execute(array($primeria['slug']));
                        $noticiaUm = $sql->fetch();
                        $categoriaPopular = SITE::cat($noticiaUm['categoria_id']);
                    ?>
                        <div class="news-title">
                            <h2> <?php echo substr(strip_tags($noticiaUm['titulo']), 0, 16) ?></h2>
                        </div> <!-- news-title -->

                        <div class="news-content">
                            <div class="news-img">
                                <a href="<?php echo INCLUDE_PATH?>news/<?php echo $categoriaPopular?>/<?php echo $noticiaUm['slug']?>">
                                    <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $noticiaUm['capa'] ?>">
                                </a>
                         
                            </div><!-- news-img -->
                            <div class="news-text">
                                <p><?php echo substr(strip_tags($noticiaUm['conteudo']), 0, 400) . '...' ?></p>
                            </div> <!-- news-text -->
                        </div><!-- news-content -->
                    <?php } else { ?>

                        <div class="news-title">
                            <h2>Nada por aqui...</h2>
                        </div> <!-- news-title -->

                        <div class="news-content">
                            <div class="news-img">
                                <img src="<?php echo INCLUDE_PATH ?>img/main-one-bg.jpg">
                            </div><!-- news-img -->
                            <div class="news-text">
                                <p>Nada por aqui...</p>
                            </div> <!-- news-text -->
                        </div><!-- news-content -->
                    <?php } ?>
                </div> <!-- news-box -->






                <div class="news-box news-middle">
                    <?php
                    $notUm = SITE::notPrincipais(1);

                    if (!$notUm) {

                    ?>

                        <div class="news-title">
                            <h2>Nada por aqui...</h2>
                        </div> <!-- news-title -->

                        <div class="news-content">

                            <div class="news-img">
                                <img src="<?php echo INCLUDE_PATH; ?>img/main-one-bg.jpg" alt="">
                            </div><!-- news-img -->
                            <div class="news-text">
                                <p>Nada por aqui...</p>
                            </div> <!-- news-text -->
                        </div><!-- news-content -->
                    <?php } else {
                        $categoria_Principal = SITE::cat($notUm['categoria_id']); ?>
                        <div class="news-title">
                        
                            <h2><?php echo substr(strip_tags($notUm['titulo']), 0, 16)  ?></h2>
                        </div> <!-- news-title -->

                        <div class="news-content">
                            <div class="news-img">
<a href="<?php echo INCLUDE_PATH?>news/<?php echo $categoria_Principal?>/<?php echo $notUm['slug']?>">
                                <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $notUm['capa'] ?>" alt="">
                                </a>

                            </div><!-- news-img -->
                            <div class="news-text">
                                <p><?php echo substr(strip_tags($notUm['conteudo']), 0, 400) . '...' ?></p>
                            </div> <!-- news-text -->
                        </div><!-- news-content -->
                    <?php } ?>
                </div>
                <div class="news-box">
                    <?php
                    $segunda = $popular['segunda'];
                    $sql2 = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = :slug ");
                    $sql2->bindParam(':slug', $segunda['slug']);
                    $sql2->execute();
                    if (!empty($segunda['slug']) && $sql2->rowCount() == 1) {
                        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = ? ");
                        $sql->execute(array($segunda['slug']));
                        $noticiaDois = $sql->fetch();
                        $categoriaMenosPopular = SITE::cat($noticiaDois['categoria_id']);
                    ?>
                        <div class="news-title">
                            <h2><?php echo substr(strip_tags($noticiaDois['titulo']), 0, 16) ?></h2>
                        </div> <!-- news-title -->

                        <div class="news-content">
                            <div class="news-img">
                            <a href="<?php echo INCLUDE_PATH?>news/<?php echo $categoriaMenosPopular?>/<?php echo $noticiaDois['slug']?>">
                                <img src="<?php echo INCLUDE_PATH ?>dashboard/up/<?php echo $noticiaDois['capa'] ?>">
</a>
                            </div><!-- news-img -->
                            <div class="news-text">
                                <p><?php echo substr(strip_tags($noticiaDois['conteudo']), 0, 400) . '...' ?></p>
                            </div> <!-- news-text -->
                        </div>
                    <?php } else { ?>
                        <div class="news-title">
                            <h2>Nada por aqui...</h2>
                        </div> <!-- news-title -->

                        <div class="news-content">
                            <div class="news-img">
                                <img src="<?php echo INCLUDE_PATH; ?>img/main-one-bg.jpg">
                            </div><!-- news-img -->
                            <img src="" alt="">
                            <div class="news-text">
                                <p>Nada por aqui...</p>
                            </div> <!-- news-text -->
                        </div><!-- news-content -->
                    <?php } ?>
                </div> <!-- news-box -->
            </div>
    </section>
</main>