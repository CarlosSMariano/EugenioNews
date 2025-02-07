<?php
class VSTCOUTN
{



    // conta usuarios online
    public static function updateUsersOnline()
    {
        if (isset($_SESSION['online'])) {
            $token = $_SESSION['online'];
            $dia = date('Y-m-d');
            $horario = date('H:i:s');
            $check = SQLCN::connectDB()->prepare('SELECT `id` FROM  `tb_painel_admin.online` WHERE token = ? ');
            $check->execute(array($token));

            if ($check->rowCount() == 1) {
                $sql = SQLCN::connectDB()->prepare("UPDATE `tb_painel_admin.online` SET dia = ? AND ultima_acao = ? WHERE token= ?");
                $sql->execute(array($dia, $horario, $token));
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
                $token = $_SESSION['online'];
                $dia = date('Y-m-d');
                $horario = date('H:i:s');
                $sql = SQLCN::connectDB()->prepare("INSERT INTO `tb_painel_admin.online` VALUES(null,?,?,?,?)");
                $sql->execute(array($ip, $dia, $horario, $token));
            }
        } else {
            $_SESSION['online'] = uniqid();
            $ip = $_SERVER['REMOTE_ADDR'];
            $token = $_SESSION['online'];
            $dia = date('Y-m-d');
            $horario = date('H:i:s');
            $sql = SQLCN::connectDB()->prepare("INSERT INTO `tb_painel_admin.online` VALUES(null,?,?,?,?)");
            $sql->execute(array($ip, $dia, $horario, $token));;
        }
    }

    // conta usuarios diferentes
    public static function countUser()
    {
        // setcookie('visit', 'true', time()-1);
        if (!isset($_COOKIE['visit'])) {
            setcookie('visit', 'true', time() + 60 * 60 * 24 * 1);
            $sql = SQLCN::connectDB()->prepare("INSERT INTO `tb_painel_admin.visits` VALUES (null, ?) ");
            $sql->execute(array(date('Y-m-d')));
        }
    }

    public static function popularCount($slug)
    {
        if (
            !isset($_COOKIE['noticia'])
        ) {
            setcookie('noticia', 'true', time() + 60 * 60 * 24 * 1 );

            $noticia = SQLCN::connectDB()->prepare("INSERT INTO `tb_painel_count.noticias` VALUES (null, ?,?,?)");
            $noticia->execute(array($_SERVER['REMOTE_ADDR'], date('Y-m-d'), $slug));
        } else {

            $noticia = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_count.noticias`");
            $noticia->execute();
            $noticia = $noticia->fetch();

            if ($_SERVER['REMOTE_ADDR'] === $noticia['ip'] && $slug !== $noticia['slug']) {
                $noticia = SQLCN::connectDB()->prepare("INSERT INTO `tb_painel_count.noticias` (ip, data, slug)
                    SELECT ?, ?, ?
                    WHERE NOT EXISTS (
                        SELECT 1 FROM `tb_painel_count.noticias` WHERE slug = ?
                    )
                ");
                $noticia->execute(array($_SERVER['REMOTE_ADDR'], date('Y-m-d'), $slug, $slug));
            }
        }
    }
}
