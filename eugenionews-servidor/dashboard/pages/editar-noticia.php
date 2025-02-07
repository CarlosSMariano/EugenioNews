<?php

verificaPermissaoPagina(1);

//todo verifica se noticia existe
?>

<?php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $not = DASH::selectTable('tb_painel_admin.noticias', 'id=?', array($id));
} else {
    DASH::alert('erro', 'você precisa passar o parametro ID');
    die();
}

if (isset($_POST['acao'])) {

    $_POST['postagem'] = date('Y-m-d');

    if (!empty($capa['name'])) {
        if (!IMG::validation($capa)) {
            DASH::alert('erro', 'O formato da imagem não é compatível');
        } else {
            $capa = IMG::uploadFile($capa);
            $_POST['capa'] = $capa;
            IMG::deleteFile($not['capa']);
        }
    }

    $slug = NWS::generateSlug($_POST['titulo']);
    $comp = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE slug = ? AND id != ?");
    $comp->execute(array($slug, $id));
    $com = $comp->fetchAll();
    if (count($com) == 1) {
        DASH::alert('erro', 'já existe uma noticia com este nome');
    } else {

        if(!empty($_POST['order_id'])){
            DASH::updateDestaque();
            if (DASH::update($_POST)) {
                DASH::alert('sucesso','Noticia atualizada com sucesso!');
                $not = DASH::selectTable('tb_painel_admin.noticias', 'id=?', array($id));
            }else{
                DASH::alert('erro','campos vazios não são permitido');    
                 
            }
        }else{
                if (DASH::update($_POST)) {
                    DASH::alert('sucesso','Noticia atualizada com sucesso!');
                    $not = DASH::selectTable('tb_painel_admin.noticias', 'id=?', array($id));
        }else{
                DASH::alert('erro','campos vazios não são permitido');
            }
        }
    }
}

if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
    
}

?>

<main>
    <!-- Estruturando página de cadastro de notícias -->
    <div class="center2">
        <div class="func-container flex">
            <div class="func-titulo">
                <h2>Atualizar Noticias</h2>
            </div> <!-- func-titulo -->
            <form method="post" enctype="multipart/form-data">

                <div class="cd-container flex">
                    <label for="4">Capa:</label>
                    <div class="news-bg edit-bg flex">
                        <img src="<?php echo INCLUDE_DASH ?>up/<?php echo $not['capa'] ?>">
                        <div class="arquivo edit-arquivo flex">
                            <input type="file" name="capa">
                            <i class="fa fa-camera" style="color:white;"></i>
                        </div> <!-- arquivo -->
                    </div> <!-- news-bg -->
                    <div class="titulo-data flex">
                        <div class="titulo flex">
                            <input class="input-padrao" type="text" name="titulo" id="4" value="<?php echo $not['titulo'] ?>">
                            <label for="4">Título:</label>
                        </div> <!-- titulo -->
                        <div class="data2 flex">
                            <select class="select-categoria" name="categoria_id">
                            <option value=" " disabled selected>Selecione a categoria</option>
                                <?php
                                $categorias = DASH::listTable('tb_painel_admin.categorias');

                                foreach ($categorias as $key => $value) {
                                ?>
                                    <option <?php if ($value['id'] == @$_POST['categoria_id']) echo 'selected' ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                            <label for="5">Categoria:</label>
                        </div> <!-- data -->
                    </div> <!-- titulo-data -->
                    <div class="escrever-noticia flex">
                        <textarea class="tinymce" name="conteudo" id="6"><?php echo $not['conteudo'] ?></textarea>
                        <label for="6">Escreva a notícia:</label>
                    </div>
                    <div class="autor flex">
                        <input class="input-padrao" type="text" name="autor" id="7" value="<?php echo $not['autor'] ?>">
                        <label for="7">Autor:</label>
                    </div> <!-- autor -->
                    <div class="radio">
                        <div class="radio-option">
                             <input type="radio" name="order_id" id="sim" value="1">
                             <label for="sim">Sim</label>
                    </div> <!-- radio-option -->
                    <div class="radio-item">
                            <input type="hidden" id="8">
                            <label for="8">Deseja destacar essa notícia?</label>
                    </div> <!-- radio-item -->
                    </div> <!--  radio -->
                    <div class="submit-cadastro flex">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="nome_tabela" value="tb_painel_admin.noticias">
                        <input type="submit" name="acao" value="Alterar">
                    </div> <!-- submit-cadastro -->
                </div> <!-- cd-container -->
            </form>
            <a title="Voltar" class="back back-categoria flex" href="<?php echo INCLUDE_DASH ?>listar-noticias">
                    <img src="./img/back-icon.svg" alt="Botão de voltar">
                    <p>Voltar</p>
                </a>
        </div>

    </div> <!-- center2 -->
    <!-- Fim da página de cadastro de notícias -->
</main>