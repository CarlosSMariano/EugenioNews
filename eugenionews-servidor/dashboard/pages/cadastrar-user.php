<?php
verificaPermissaoPagina(1);
?>
<?php
if (isset($_POST['acao'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $user = $_POST['user'];
    $cargo = $_POST['cargo'];
    $img = isset($_FILES['img']) && !empty($_FILES['img']['name']) ? $_FILES['img'] : null;



    $campos = [
        "name" => "O campo nome está vazio",
        "password" => "O campo senha está vazio'",
        "user" => "O campo longin está vazio"
    ];

    $erros = false;

    foreach ($campos as $campo => $mensagem) {
        if (empty($$campo)) {
            DASH::alert('erro', $mensagem);
            $erros = true;
        }
    }

    if ($cargo >= $_SESSION['cargo']) {
        DASH::alert('erro', ' Você só pode atribuir um cargo menor que o seu!');
        $erros = true;
    }

    if ($img !== null) {
        if (IMG::validation($img) == false) {
            DASH::alert('erro', 'O formato da imagem não é compativél');
            $erros = true;
        } else {
            $img = IMG::uploadFile($img);
        }
    }

    if (USER::exist($user, 'tb_painel_admin.users')) {
        DASH::alert('erro', 'Este usuário já existe');
        $erros = true;
    }

    if (!$erros) {
        USER::register($user, $password, $img ?? null, $name, $cargo, 'tb_painel_admin.users');
        DASH::redirect(INCLUDE_DASH.'cadastrar-user?sucesso');
    }
}
if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
    DASH::alert('sucesso', 'Membro cadastrado com sucesso!');
}

?>

<main>
    <!-- Estruturando página de cadastro de usuários -->
    <div class="center2 center-membro">

        <div class="func-titulo">
            <h2>Cadastrar Membros</h2>
        </div>
        <div class="user-form flex">

            <form class="usuario flex" method="post" enctype="multipart/form-data">

                <div class="usuario-img">

                </div> <!-- usuario-img -->
                <div class="usuario-item flex">
                    <label>Nome:</label>
                    <input class="input-padrao" type="text" name="name" value="<?php recoverPost('name') ?>">
                </div> <!-- usuario-item -->
                <div class="usuario-item flex">
                    <label>Senha:</label>
                    <input class="input-padrao" type="password" name="password" value="<?php recoverPost('password') ?>">
                </div> <!-- usuario-item -->
                <div class="usuario-item flex">
                    <label>Login:</label>
                    <input class="input-padrao" type="text" name="user" value="<?php recoverPost('user') ?>">
                </div> <!-- usuario-item -->
                <div class="usuario-item flex">
                    <label>Cargo</label>
                    <select name="cargo">
                        <?php
                        foreach (DASH::$cargos as $key => $value) {
                            if ($key < $_SESSION['cargo']) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div> <!-- usuario-item -->
                <div class="usuario-file-img">
                    <i class="fa fa-camera" style="color:white;"></i>
                    <input type="file" name="img" value="<?php recoverPost('img') ?>">
                </div> <!-- usuario-file-img -->
                <div class="usuario-item item-submit flex">
                    <input type="submit" name="acao" value="Cadastrar">
                </div> <!-- usuario-item -->
            </form>
        </div> <!-- user-form -->

    </div> <!-- center2 -->
    <!-- Fim da página de cadastro de usuários -->
</main>