<?php

verificaPermissaoPagina(1);

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $cat = DASH::selectTable('tb_painel_admin.categorias', 'id=?', array($id));
    $noticias = SQLCN::connectDB()->prepare("SELECT * FROM  `tb_painel_admin.noticias` WHERE categoria_id = ? ");
    $noticias->execute(array($id));
    $noticias = $noticias->fetchAll();
    foreach ($noticias as $key => $value) {
        $imgDelete = $value['capa'];
        IMG::deleteFile($imgDelete);
    }
    $noticias = SQLCN::connectDB()->prepare("DELETE FROM  `tb_painel_admin.noticias` WHERE categoria_id = ? ");
    $noticias->execute(array($id));
    DASH::deleteTable('tb_painel_admin.categorias', $id);
    DASH::redirect(INCLUDE_DASH . 'listar-categoria');
}

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$porPg = 1;
$start = ($pagina - 1) * $porPg;

?>

<main>
    <!-- Estruturando página de índice -->
    <div class="center2">
        <div class="listar-container flex">
            <div class="func-titulo">
                <h2>Gerenciar Categorias</h2>
            </div> <!-- func-titulo -->
            <div class="search search-desktop">
                    <div class="input-item">
                    <?php
                    $query = "SELECT * FROM `tb_painel_admin.categorias` ";

                    if (isset($_POST['pesquisa'])) {
                        $search = $_POST['pesquisa'];

                        $query.= " WHERE name LIKE '%$search%' ";
                    }

                    $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
                    $porPagina = 1;
                    $start = ($pagina - 1) * $porPagina;
                    
                    if (!empty($search)) {
                        $sql = SQLCN::connectDB()->prepare($query);
                        $sql->execute();
                        $categorias = $sql->fetchAll();
                    } else {
                        $categorias = DASH::listTable('tb_painel_admin.categorias', $start, $porPg);
                    } ?>
                       
                        <form method="post">
                            <input type="text" name="pesquisa" placeholder="Pesquisar...">
                            <button type="submit" name="buscar" class="button-icon-search"><i class="fa-solid fa-magnifying-glass"
                                    style="color: #203e51;"></i></button>
                        </form>


                    </div> <!-- input-item -->
                </div> <!-- search -->
            <div class="listar-item flex listar-none">
                <div class="listar-nome listar-atr">
                    <p>Nome</p>
                </div> <!-- listar-nome -->
                <div class="listar-editar listar-atr">
                    <p>Editar</p>
                </div> <!-- listar-editar -->
                <div class="listar-excluir listar-atr">
                    <p>Excluir</p>
                </div> <!-- listar-excluir -->
            </div> <!-- listar-item -->
            <?php
            foreach ($categorias as $key => $value) {
            ?>
                <div class="listar-item flex">
                    <div class="editar-container flex">

                        <div class="editar-item flex">
                            <h3><?php echo $value['name'] ?></h3>
                            <div class="editar-funcoes flex">
                                <a href="<?php echo INCLUDE_DASH ?>editar-categoria?id=<?php echo $value['id'] ?>"><i title="Editar" class="fa-solid fa-pen"></i></a>
                                <a actionBtn="delete" href="<?php echo INCLUDE_DASH ?>listar-categoria?excluir=<?php echo $value['id'] ?>"><i title="Excluir" class="fa-solid fa-trash"></i></a>
                            </div> <!-- editar-funcoes -->
                        </div> <!-- editar-item -->

                    </div> <!-- editar-container -->
                </div> <!-- listar-item -->
            <?php } ?>
        </div> <!-- listar-container -->

        <?php
    


    $totalPaginas = count(DASH::listTable('tb_painel_admin.categorias'));
    $totalPaginas = ceil($totalPaginas/ $porPg);

    ?>
    <div class="paginacao">
        <?php 
        if(empty($search)){
            DASH::renderPaginacao($totalPaginas, $pagina, 'listar-categoria');
         } ?>
    </div>
        </div>
    </div> <!-- center2 -->
    <!-- Fim da página de índice -->
</main>