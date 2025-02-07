<?php

verificaPermissaoPagina(1);

//TODO, Usuarios 0 só podem editar, mas, não podem excluir nada

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $Not = DASH::selectTable('tb_painel_admin.noticias', 'id=?', array($id));
    $img = $Not['capa'];
    IMG::deleteFile($img);
    DASH::deleteTable('tb_painel_admin.noticias', $id);
    DASH::redirect(INCLUDE_DASH . 'listar-noticias');
}



?>

<main>
    <!-- Estruturando página de índice -->
    <div class="center2">
        <div class="listar-container flex">
            <div class="func-titulo">
                <h2>Gerenciar Notícias</h2>
            </div> <!-- func-titulo -->

            <div class="search search-desktop">
                <div class="input-item">
                    <?php
                    $query = "SELECT * FROM `tb_painel_admin.noticias` ";

                    if (isset($_POST['pesquisa'])) {
                        $search = $_POST['pesquisa'];

                        $query.= " WHERE titulo LIKE '%$search%' ";
                    }

                    $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
                    $porPagina = 1;
                    $start = ($pagina - 1) * $porPagina;
                    
                    if (!empty($search)) {
                        $sql = SQLCN::connectDB()->prepare($query);
                        $sql->execute();
                        $news = $sql->fetchAll();
                    } else {
                        $news = DASH::listNoticia('tb_painel_admin.noticias', $start, $porPagina);
                    }


                    ?>
                    <form method="post">
                        <input type="text" name="pesquisa" placeholder="Pesquisar...">
                        <button type="submit" name="buscar" class="button-icon-search"><i class="fa-solid fa-magnifying-glass"
                                style="color: #203e51;"></i></button>
                    </form>


                </div> <!-- input-item -->
            </div> <!-- search -->
            <div class="listar-box flex">
                <div class="listar-item flex listar-none">
                    <div class="listar-titulo listar-atr">
                        <p>Título</p>
                    </div> <!-- listar-titulo -->

                    <div class="listar-autor listar-atr">
                        <p>Autor</p>
                    </div> <!-- listar-autor -->

                    <div class="listar-data listar-atr">
                        <p>Categoria</p>
                    </div> <!-- listar-autor -->

                    <div class="listar-editar listar-atr">
                        <p>Editar</p>
                    </div> <!-- listar-editar -->
                    <div class="listar-excluir listar-atr">
                        <p>Excluir</p>
                    </div> <!-- listar-excluir -->
                </div> <!-- listar-item -->
            </div> <!-- listar-box -->
            <?php
            foreach ($news as $key => $value) {
                $sql = SQLCN::connectDB()->prepare("SELECT `name` FROM `tb_painel_admin.categorias` WHERE id = ? ");
                $sql->execute(array($value['categoria_id']));
                $categoria = $sql->fetch()['name'];
            ?>
                <div class="listar-item2 flex listar-none">
                    <div class="listar-autoria listar-titulo listar-atr">
                        <img class="capa" src="<?php echo INCLUDE_DASH ?>up/<?php echo $value['capa'] ?>" alt="">
                        <h3><?php echo substr(strip_tags($value['titulo']), 0, 10) . '...' ?></h3>
                    </div>
                    <div class="listar-autor listar-atr">
                        <h3><?php echo substr(strip_tags($value['autor']), 0, 10) . '...' ?></h3>
                    </div>
                    <div class="listar-data listar-atr">
                        <h3><?php echo $categoria ?></h3>
                    </div>
                    <div class="editar-funcoes2">
                        <div class="editar-funcoes editar-funcoes-noticias flex">
                            <a href="<?php echo INCLUDE_DASH ?>editar-noticia?id=<?php echo $value['id'] ?>"><i title="Editar" class="fa-solid fa-pen"></i></a>
                        </div> <!-- editar-funcoes -->
                        <div class="editar-funcoes editar-funcoes-noticias flex">
                            <a actionBtn="delete" href="<?php echo INCLUDE_DASH ?>listar-noticias?excluir=<?php echo $value['id'] ?>"><i title="Excluir" class="fa-solid fa-trash"></i></a>
                        </div> <!-- editar-funcoes -->
                    </div>
                </div> <!-- listar-item -->
            <?php } ?>
        </div> <!-- listar-container -->

        <?php


        $totalPaginas = count(DASH::listNoticia('tb_painel_admin.noticias'));
        $totalPaginas = ceil($totalPaginas / $porPagina);

        ?>
        <div class="paginacao">

            <?php
            if (empty($search)) {
                DASH::renderPaginacao($totalPaginas, $pagina, 'listar-noticias');
            }
            ?>
        </div>

    </div> <!-- center2 -->
    <!-- Fim da página de índice -->
</main>