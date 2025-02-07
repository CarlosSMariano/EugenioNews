<!-- cookiees -->
<?php
if (isset($_COOKIE['remind'])) {
    $user = $_COOKIE['user'];
    $password = $_COOKIE['password'];
    $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.users` WHERE user = ? AND password = ?");
    $sql->execute(array($user, $password));

    if ($sql->rowCount() == 1) {
        $inf = $sql->fetch();
        
        $_SESSION['login'] = true;
        $_SESSION['img'] =  $inf['img'];
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
        $_SESSION['name'] =  $inf['name'];
        $_SESSION['cargo'] =  $inf['cargo'];
        $_SESSION['id'] = $inf['id'];
        header('Location:' . INCLUDE_DASH);
        die();
    }
}
?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo INCLUDE_DASH; ?>css/style.css">
    <link rel="shortcut icon" href="./img/eugenionews.ico" type="image/x-icon">
    <title>Bem-vindo</title>
</head>

<body>

    <!-- Estruturando formulário de login  -->
    <div class="container-login flex">
        <div class="form flex">
            <!-- Login -->
            <?php

            if (isset($_POST['acao'])) {
                $user = $_POST['user'];
                $password = $_POST['password'];
                $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.users` WHERE user = ? AND password = ?");
                $sql->execute(array($user, $password));

                if ($sql->rowCount() == 1) {
                    $inf = $sql->fetch();

                    $_SESSION['login'] = true;
                    $_SESSION['user'] = $user;
                    $_SESSION['password'] = $password;
                    $_SESSION['img'] =  $inf['img'];
                    $_SESSION['name'] =  $inf['name'];
                    $_SESSION['cargo'] =  $inf['cargo'];
                    $_SESSION['id'] = $inf['id'];
                    if (isset($_POST['remind'])) {
                        setcookie('remind', 'true', time() + (60 * 60 * 24), '/');
                        setcookie('user', $user, time() + (60 * 60 * 24), '/');
                        setcookie('password', $password, time() + (60 * 60  * 24), '/');
                    }
                    header('Location:' . INCLUDE_DASH);
                    die();
                } else {
                    echo '<h1>Usuario ou senha incorretos</h1>';
                }
            }
            ?>
            <form class="flex" method="post">
                <div class="item-login flex">
                    <div class="img-login">
                        <img src="<?php echo INCLUDE_DASH; ?>./img/logo2.png" alt="Logo Eugênio News">
                    </div> <!-- img-login -->
                </div> <!-- item-login -->

                <div class="input-login-container flex">
                    <div class="login-input flex">
                        <input class="input-padrao" type="text" name="user" id="1" require>
                        <label for="1">Usuário</label>
                    </div> <!-- login-input -->
                    <div class="login-input flex">
                        <input class="input-padrao" type="password" name="password" id="password" require>
                        <button type="button" id="viewPassword"><i class="fas fa-eye" style="color: #203E51;"></i></button>
                        <label for="password">Senha</label>
                    </div> <!-- login-input -->
                    <div class="login-input login-break flex">
                        <input type="submit" name="acao" value="Login">
                    </div> <!-- login-input -->
                    <div class="login-input check flex">
                        <input type="checkbox" name="remind" id="3">
                        <label for="3">Lembrar meus dados</label>
                    </div> <!-- login-input -->
                </div> <!-- input-login-container -->
            </form>
        </div> <!-- form -->
    </div> <!-- container-login -->
    <!-- Fim do formulário de login -->

    <script src="<?php echo INCLUDE_DASH; ?>js/script.js"></script>
</body>

</html>