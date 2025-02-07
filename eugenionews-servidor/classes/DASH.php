<?php
class DASH
{
    // globais: 
    public static $cargos =  [
        '0' => 'user',
        '1' => 'Sub Administrador',
        '2' => 'Administrador',
        '3' => 'Ultra Administrador'
    ];

    public static function pegaCargo($position)
    {
        return self::$cargos[$position];
    }

    public static function deleteTable($table, $id = false)
    {
        if ($id == false) {
            $sql = SQLCN::connectDB()->prepare("DELETE FROM `$table`");
        } else {
            $sql = SQLCN::connectDB()->prepare("DELETE FROM `$table` WHERE id = $id");
        }
        $sql->execute();
    }

    public static function redirect($url)
    {
        echo '<script>location.href="' . $url . '"</script>';
        die();
    }

    public static function renderPaginacao($totalPaginas, $pagina, $url)
    {

        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($totalPaginas > 5) {
                if ($i == 1 || $i == $totalPaginas || ($i >= $pagina - 1 && $i <= $pagina + 1)) {
                    if ($pagina == $i) {
                        echo '<a class="page-selected" href="' . INCLUDE_DASH . $url . '?pagina=' . $i . '">' . $i . '</a>';
                    } else {
                        echo '<a href="' . INCLUDE_DASH . $url . '?pagina=' . $i . '">' . $i . '</a>';
                    }
                } elseif ($i == 2 && $pagina > 4) {
                    echo '<span class="pontinho">...</span>';
                } elseif ($i == $totalPaginas - 1 && $pagina < $totalPaginas - 3) {
                    echo '<span class="pontinho">...</span>';
                }
            } else {
                if ($pagina == $i) {
                    echo '<a class="page-selected" href="' . INCLUDE_DASH . $url . '?pagina=' . $i . '">' . $i . '</a>';
                } else {
                    echo '<a href="' . INCLUDE_DASH . $url . '?pagina=' . $i . '">' . $i . '</a>';
                }
            }
        }
    }

    //editando tables
    public static function update($arr)
    {
        $certo = true;
        $first = false;
        $nome_tabela = $arr['nome_tabela'];

        $query = "UPDATE `$nome_tabela` SET ";
        foreach ($arr as $key => $value) {
            $nome = $key;
            if ($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
                continue;
            if ($value == '') {
                $certo = false;
                break;
            }

            if ($first == false) {
                $first = true;
                $query .= "$nome=?";
            } else {
                $query .= ",$nome=?";
            }
            $parametros[] = $value;
        }

        if ($certo) {
            $parametros[] = $arr['id'];
            $sql = SQLCN::connectDB()->prepare($query . 'WHERE id=?');
            $sql->execute($parametros);
        }
        return $certo;
    }



    ///

    //carregando pgs na main
    public static function carregarPagina()
    {
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if (file_exists('pages/' . $url[0] . '.php')) {
                include('pages/' . $url[0] . '.php');
            } else {
                //Quando a página não existe
                header('Location: ' . INCLUDE_DASH);
            }
        } else {
            include('pages/home.php');
        }
    }
    ///

    // "avisos"
    public static function alert($status, $msg)
    {
        if ($status === 'sucesso') {
            echo '<div class="box-alert sucesso"><i class="fa-solid fa-face-laugh-wink"></i>' . $msg . '</div>';
        } else if ($status === 'erro') {
            echo '<div class="box-alert erro"><i class="fa-solid fa-face-sad-tear"></i>' . $msg . '</div>';
        } else if ($status === 'inva') {
            echo '<div class="box-alert inva"><i class="fa-solid fa-face-angry"></i>' . $msg . '</div>';
        }
    }
    ///

    // para estatisticas

    public static function clearUsersOnline($table)
    {

        $sql = SQLCN::connectDB()->exec("DELETE FROM `$table` WHERE ultima_acao < NOW()  - INTERVAL 1 MINUTE");
    }

    public static function listUsersOnline($table)
    {
        self::clearUsersOnline($table);
        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table`");
        $sql->execute();
        return $sql->fetchAll();
    }

    public static function listVisit($table)
    {


        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` WHERE data = ?");
        $sql->execute(array(date('Y-m-d')));
        return $sql->rowCount();
    }

    public static function totalVisit($table, $date = null)
    {
        if (isset($date)) {
            $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` WHERE data >=DATE_SUB(CURDATE(), INTERVAL $date DAY)");
            $sql->execute();
            return $sql->rowCount();
        } else {
            $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` ");
            $sql->execute();
            return $sql->rowCount();
        }
    }

    ///


    public static function listTable($table, $start = null, $limit = null)
    {

        if ($start === null && $limit === null) {
            $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table`  ORDER BY name ");
        } else {
            $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` ORDER BY name  LIMIT :start, :limit");
            $sql->bindParam(':start', $start, PDO::PARAM_INT);
            $sql->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        $sql->execute();
        return $sql->fetchAll();
    }
    public static function listNoticia($table, $start = null, $limit = null)
    {

        if ($start === null && $limit === null) {
            $sql = SQLCN::connectDB()->prepare("(SELECT * FROM `$table` WHERE order_id = 1)UNION ALL (SELECT * FROM `$table` WHERE order_id = 2) ORDER BY CASE WHEN order_id = 1 THEN 0 ELSE 1 END, id DESC");
        } else {
            $sql = SQLCN::connectDB()->prepare("(SELECT * FROM `$table` WHERE order_id = 1)UNION ALL (SELECT * FROM `$table` WHERE order_id = 2) ORDER BY CASE WHEN order_id = 1 THEN 0 ELSE 1 END, id DESC LIMIT :start, :limit;
");
            $sql->bindParam(':start', $start, PDO::PARAM_INT);
            $sql->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        $sql->execute();
        return $sql->fetchAll();
    }

    public static function selectTable($table, $query, $arr)
    {
        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` WHERE $query ");
        $sql->execute($arr);
        return $sql->fetch();
    }
    ///

    public static function updateDestaque()
    {
        $sql = SQLCN::connectDB()->prepare("UPDATE `tb_painel_admin.noticias` SET order_id = 2 WHERE order_id = 1");
        $sql->execute();
    }
}
