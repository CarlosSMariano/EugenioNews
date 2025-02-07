<?php

verificaPermissaoPagina(1);

?>

<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $cat = DASH::selectTable('tb_painel_admin.categorias', 'id=?', array($id));
} else {
    DASH::alert('erro', 'você precisa passar o parametro ID');
    die();
}

if (isset($_POST['acao'])) {
    $slug = NWS::generateSlug($_POST['name']);
    $arr = array_merge($_POST, array('slug' => $slug));
    $comp = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.categorias` WHERE name = ? AND id != ? ");
    $comp->execute(array($_POST['name'], $id));
    if ($comp->rowCount() == 1) {
        DASH::alert('erro', 'já existe uma categoria com este nome');
    } else {

        if (DASH::update($arr)) {
            DASH::alert('sucesso', 'Categoria atualizada com sucesso!');
            $cat = DASH::selectTable('tb_painel_admin.categorias', 'id=?', array($id));
        } else {
            DASH::alert('erro', ' Campos vazios não são permitidos');
        }
    }
}

?>

<main>
    <!-- Estruturando página de cadastrar categorias -->
    <div class="center2">

        <form class="form-categoria" method="post">
            <div class="categoria-container flex">
                <div class="logo-categoria flex">
                    <img src="./img/logo2.png" alt="Logo do Eugênio News">
                </div> <!-- logo-categoria -->

                <div class="nova-categoria flex">
                    <input class="input-padrao" type="text" name="name" value="<?php echo $cat['name']; ?>" id="8">
                    <label for="8">Categoria:</label>
                </div> <!-- nova-categoria -->
                <div class="submit-categoria flex">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="nome_tabela" value="tb_painel_admin.categorias">
                    <input type="submit" name="acao" value="Alterar">
                </div> <!-- submit-categoria -->
                <a title="Voltar" class="back back-categoria flex" href="<?php echo INCLUDE_DASH ?>listar-categoria">
                    <img src="./img/back-icon.svg" alt="Botão de voltar">
                    <p>Voltar</p>
                </a>
            </div> <!-- categoria-container -->
        </form>
    </div> <!-- center2 -->
    <!-- Fim da página de cadastrar categorias -->
</main>