<?php

verificaPermissaoPagina(1);

//se existir o Get [id], pega o id do usuário, busca suas informações, pega o nome do arquivo img, apaga da up e dps apaga ele do DB
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $func = DASH::selectTable('tb_painel_admin.users', 'id=?', array($id));
    $img = $func['img'];
    IMG::deleteFile($img);
    DASH::deleteTable('tb_painel_admin.users', $id);
    DASH::redirect(INCLUDE_DASH . 'funcionarios');
}

//Verifica em que página esta, para atualizar a paginação
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$porPg = 4;
$start = ($pagina - 1) * $porPg;
$func = DASH::listTable('tb_painel_admin.users', $start, $porPg)


?>

<main>
    <!-- Estruturando página de funcionários -->
    <div class="center2">
        <div class="func-container flex">
            <div class="func-titulo">
                <h2>Membros da nossa equipe</h2>
            </div> <!-- func-titulo -->

            <div class="func-list flex">
                <?php


                foreach ($func as $key => $value) {
                    if ($_SESSION['cargo'] >= $value['cargo']) {
                ?>
                        <div class="func-item flex">
                            <div class="func-img">
                                <?php
                                $img = $value['img'];
                                if (isset($value['img']) && !empty($value['img'])) {
                                    $filePath = './up/' . $value['img'];
                                    clearstatcache();
                                    if (file_exists($filePath)) { ?>
                                        <img src="<?php echo INCLUDE_DASH; ?>up/<?php echo $value['img']; ?>">
                                    <?php } else { ?>
                                        <img src="./img/user-rounded-svgrepo-com.svg">
                                    <?php }
                                } else { ?>
                                    <img src="./img/user-rounded-svgrepo-com.svg">
                                <?php } ?>
                            </div> <!-- func-img -->
                            <div class="func-cargo flex">
                                <p>
                                    <?php echo $value['name']; ?>
                                </p>
                                <p>
                                    <?php
                                    $cargo = $value['cargo'];
                                    echo DASH::pegaCargo($cargo);
                                    ?>
                                </p>
                            </div> <!-- func-cargo -->
                            <div class="func-funcoes flex">
                                <?php if ($_SESSION['cargo'] > $value['cargo'] || $_SESSION['id'] == $value['id']) { ?>
                                    <a href="<?php echo INCLUDE_DASH ?>editar-user?id=<?php echo $value["id"]; ?>"><i title="Editar"
                                            class="fa-solid fa-pen"></i></a>
                                            <?php 
                                                if($_SESSION['id'] !== $value['id']){
                                            ?>
                                    <a actionBtn="delete" href="<?php echo INCLUDE_DASH ?>funcionarios?excluir=<?php echo $value['id']; ?>"><i
                                            title="Excluir" class="fa-solid fa-trash"></i></a>
                                <?php }}?>
                            </div> <!-- func-funcoes -->
                        </div> <!-- func-item -->
                <?php }
                } ?>
            </div> <!-- func-list -->
        </div> <!-- func-container -->

        <?php



        $totalPaginas = count(DASH::listTable('tb_painel_admin.users'));
        $totalPaginas = ceil($totalPaginas / $porPg);

        ?>
        <div class="paginacao">
            <?php DASH::renderPaginacao($totalPaginas, $pagina, 'funcionarios'); ?>
        </div>
    </div> <!-- center2 -->
    <!-- Fim da página de funcionários -->
</main>