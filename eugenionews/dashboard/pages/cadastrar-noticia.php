<?php

verificaPermissaoPagina(0);

//todo verifica se noticia existe
?>

<?php
if (isset($_POST['acao'])) {

    $order_id = $_POST['order_id'];
    $categoria_id = $_POST['categoria_id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $conteudo = $_POST['conteudo'];
    $capa = $_FILES['capa'];
    $postagem = date('Y-m-d');


    $campos = [
        "titulo" => "O título está vazio",
        "autor" => "O autor está vazio",
        "conteudo" => "Ops! faltou o conteúdo",
        "categoria_id" => "Você precisa selecionar uma categoria!"
    ];

    $erro = false;

    foreach ($campos as $campo => $msg) {
        if (empty($$campo)) {
            DASH::alert('erro', $msg);
            $erro = true;
        }
    }

    if (!empty($capa['tmp_name'])) {
        if (IMG::validation($capa) == false) {
            DASH::alert('erro', 'O formato da imagem não é compativél');
            $erro = true;
        } else {
            $capa = IMG::uploadFile($capa);
        }
    } else {
        DASH::alert('erro', 'A capa precisa ser selecionada');
        $erro = true;
    }

    if (!$erro) {
        $comp = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE titulo = :titulo OR conteudo = :conteudo");
        $comp->bindParam(':titulo', $_POST['titulo']);
        $comp->bindParam(':conteudo', $_POST['conteudo']);
        $comp->execute();
        if ($comp->rowCount() == 1) {
            DASH::alert('erro', 'Noticia ou Título já existentes!');
        } else {
            $slug = NWS::generateSlug($titulo);
            if (!empty($order_id)) {
                DASH::updateDestaque();
                $arr = ['categoria_id' => $categoria_id, 'titulo' => $titulo, 'autor' => $autor, 'conteudo' => $conteudo, 'capa' => $capa, 'slug' => $slug, 'postagem' => $postagem, 'order_id' => $order_id, 'tabela' => 'tb_painel_admin.noticias'];
            } else {
                $arr = ['categoria_id' => $categoria_id, 'titulo' => $titulo, 'autor' => $autor, 'conteudo' => $conteudo, 'capa' => $capa, 'slug' => $slug, 'postagem' => $postagem, 'order_id' => 0, 'tabela' => 'tb_painel_admin.noticias'];
            }
            NWS::insert($arr);
            DASH::redirect(INCLUDE_DASH . 'cadastrar-noticia?sucesso');
        }
    }
}

if (isset($_GET['sucesso']) && !isset($_POST['acao'])) {
    DASH::alert('sucesso', 'Notícia publicada com sucesso!');
}

?>

<main>
    <!-- Estruturando página de cadastro de notícias -->
    <div class="center2">
        <div class="func-container flex">
            <div class="func-titulo">
                <h2>Publicar Noticias</h2>
            </div> <!-- func-titulo -->
            <form method="post" enctype="multipart/form-data">

                <div class="cd-container flex">
                    <label for="4">Capa:</label>
                    <div class="news-bg flex">
                        <div class="arquivo flex">
                            <input type="file" name="capa" value="<?php recoverImg('capa');?>" >
                            <i class="fa fa-camera" style="color:white;"></i>
                        </div> <!-- arquivo -->
                    </div> <!-- news-bg -->
                    <div class="titulo-data flex">
                        <div class="titulo flex">
                            <input class="input-padrao" type="text" name="titulo" id="4" value="<?php recoverPost('titulo'); ?>">
                            <label for="4">Título:</label>
                        </div> <!-- titulo -->
                        <div class="data2 flex">
                            <select class="select-categoria" name="categoria_id">
                                <option value="" disabled selected>Selecione a categoria</option>
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
                        <textarea class="tinymce" name="conteudo" id="6"><?php recoverPost('conteudo'); ?></textarea>
                        <label for="6">Escreva a notícia:</label>
                    </div>
                    <div class="autor flex">
                        <input class="input-padrao" type="text" name="autor" id="7" value="<?php recoverPost('autor'); ?>">
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
                        <input type="submit" name="acao" value="Publicar">
                    </div> <!-- submit-cadastro -->
                </div> <!-- cd-container -->
            </form>
        </div>
    </div> <!-- center2 -->
    <!-- Fim da página de cadastro de notícias -->
</main>