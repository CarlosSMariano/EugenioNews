<?php
verificaPermissaoPagina(1);
?>

<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $func = DASH::selectTable('tb_painel_admin.users', 'id=?', array($id));
} else {
    DASH::alert('erro', 'você precisa passar o parametro ID');
    die();
}

if (isset($_POST['acao'])) {

    $img = $_FILES['img'];

    if (!empty($img['name'])) {
        if (!IMG::validation($img)) {
            DASH::alert('erro', 'O formato da imagem não é compatível');
        } else {
            $img = IMG::uploadFile($img);
            $_POST['img'] = $img;
            IMG::deleteFile($func['img']);
        }
    }

    if (DASH::update($_POST)) {
        DASH::alert('sucesso', 'Atualizado com sucesso');
        $func = DASH::selectTable('tb_painel_admin.users', 'id=?', array($id));

        if ($_SESSION['id'] == $func['id']) {
            @session_regenerate_id(true);
            $_SESSION['name'] = $func['name'];
            $_SESSION['img'] = $func['img'];
        }
       
    } else {
        DASH::alert('erro', ' Campos vazios não são permitidos');
    }
}


?>

<main>
    <!-- Estruturando página de cad     astro de usuários -->
    <div class="center2 center-usuario">
        <div class="func-titulo">
            <h2>Editar Membros</h2>
        </div> <!-- func-titulo -->
        <div class="user-form flex user-form2">

            <form class="usuario flex" method="post" enctype="multipart/form-data">
                <div class="usuario-img">
                    <img src="<?php echo INCLUDE_DASH ?>up/<?php echo $func['img'] ?>">
                </div> <!-- usuario-img -->
                <div class="usuario-item flex">
                    <label>Nome:</label>
                    <input class="input-padrao" type="text" name="name" value="<?php echo $func['name']; ?>">
                </div> <!-- usuario-item -->
                <div class="usuario-item flex">
                    <label>Senha:</label>
                    <input class="input-padrao" type="password" name="password" value="<?php echo $func['password']; ?>">
                </div> <!-- usuario-item -->
                <div class="usuario-item flex">
                    <label>Login:</label>
                    <input class="input-padrao" type="text" name="user" value="<?php echo $func['user']; ?>">
                </div> <!-- usuario-item -->
                <?php if ($_SESSION['cargo'] == $func['cargo']) {

                ?>
                <?php } else { ?>
                    <div class="usuario-item flex">
                        <label>Cargo</label>
                        <select name="cargo">
                        <option value=" " disabled selected>Selecione o cargo</option>
                            <?php
                            foreach (DASH::$cargos as $key => $value) {
                                if ($key < $_SESSION['cargo']) {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div> <!-- usuario-item -->
                <?php } ?>
                <div class="usuario-file-img">
                    <i class="fa fa-camera" style="color:white;"></i>
                    <input type="file" name="img" value="<?php echo $func['img']; ?>">
                </div> <!-- usuario-file-img -->
                <div class="usuario-item item-submit flex item-submit-editar">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="nome_tabela" value="tb_painel_admin.users">
                    <input type="submit" name="acao" value="Atualizar">
                </div> <!-- usuario-item -->
                <div class="usuario-item item-submit2 flex">
                <a title="Voltar" class="back flex" href="<?php echo INCLUDE_DASH ?>funcionarios">
                    <img src="./img/back-icon.svg" alt="Botão de voltar">
                    <p>Voltar</p>
                </a>
                </div> <!-- usuario-item -->
            </form>
        </div> <!-- user-form -->
    </div> <!-- center2 -->
    <!-- Fim da página de cadastro de usuários -->
</main>