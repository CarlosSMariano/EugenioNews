<?php

verificaPermissaoPagina(1);

?>

<?php

if (isset($_POST['acao'])) {
    $cat = $_POST['cat'];

    if (empty($cat)) {
        DASH::alert('erro', 'O campo não pode ficar vazio');
    } else {
        $comp = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.categorias` WHERE name = ?");
        $comp->execute(array($cat));
        if ($comp->rowCount() == 0) {
            $slug = NWS::generateSlug($cat);
            $arr = ['name' => $cat, 'slug' => $slug, 'tabela' => 'tb_painel_admin.categorias'];
            NWS::insert($arr);
            DASH::redirect(INCLUDE_DASH . 'cadastrar-categoria?sucesso');
        }else{
            DASH::alert('erro', 'Essa categoria já existe');
        }
    }
}
if (isset($_GET['sucesso']) && !isset($_POST['acao'])) {
    DASH::alert('sucesso', 'Categoria cadastrada com sucesso!');
}
?>

<main>
    <!-- Estruturando página de cadastrar categorias -->
    <div class="center2">
        <div class="func-container flex">
            <div class="func-titulo">
                <h2>Cadastrar Categorias</h2>
            </div> <!-- func-titulo -->
            <form method="post">
                <div class="categoria-container flex">
                    <div class="logo-categoria flex">
                        <img src="./img/logo2.png" alt="Logo do Eugênio News">
                    </div> <!-- logo-categoria -->

                    <div class="nova-categoria flex">

                        <input class="input-padrao" type="text" name="cat" id="8">
                        <label for="8">Nova Categoria:</label>
                    </div> <!-- nova-categoria -->
                    <div class="submit-categoria flex">
                        <input type="submit" name="acao" value="Cadastrar">
                    </div> <!-- submit-categoria -->

                </div> <!-- categoria-container -->
            </form>
        </div> <!-- func-container -->
    </div> <!-- center2 -->
    <!-- Fim da página de cadastrar categorias -->
</main>