<?php

class SITE
{

    public static function notPrincipais($order)
    {
        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `tb_painel_admin.noticias` WHERE order_id = $order");
        $sql->execute();
        if ($sql->rowCount() > 0)
            return $sql = $sql->fetch();
        else
            return false;
    }



    public static function clearNot()
    {
        $sql = SQLCN::connectDB()->prepare("DELETE FROM `tb_painel_count.noticias` WHERE `date` < NOW() - INTERVAL 1 MONTH");
    }

    public static function noticiaPopular()
    {
        self::clearNot();
        $sql = SQLCN::connectDB()->prepare("SELECT slug, COUNT(slug) AS quantidade FROM `tb_painel_count.noticias` GROUP BY slug HAVING COUNT(slug) > 1 ORDER BY quantidade DESC LIMIT 2");
        $sql->execute();
       

        if ($sql->rowCount() > 0)
            return  $resultados = $sql->fetchAll();
        else
            return false;
    }
    public static function popularOrdenado()
    {
        self::clearNot();
        $sql = SQLCN::connectDB()->prepare("SELECT slug, COUNT(slug) AS quantidade FROM `tb_painel_count.noticias` GROUP BY slug HAVING COUNT(slug) > 1 ORDER BY quantidade DESC LIMIT 2");
        $sql->execute();
        $resultados = $sql->fetchAll();

        if (count($resultados) ==  2) {
            $primeira = $resultados[0];
            $segunda = $resultados[1];
            return [
                'primeira' => $primeira,
                'segunda' => $segunda
            ];
        } elseif (count($resultados) == 1) {
            return [
                'primeira' => $resultados[0],
                'segunda' => null
            ];
        } else {
            return [
                'primeira' => null,
                'segunda' => null
            ];
        }
    }

    public static function cat($value)
    {
        $sql = SQLCN::connectDB()->prepare("SELECT `slug` FROM `tb_painel_admin.categorias` WHERE id = ?");
        $sql->execute(array($value));
        if ($sql->rowCount() > 0) {
            return $sql->fetch()['slug'];
        } else {
            return false;
        }
    }




    public static function renderPaginacao($totalPaginas, $pagina, $cat)
    {
        $catStr = (!empty($cat['name'])) ? '/' . $cat['slug'] : '';

        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($totalPaginas > 5) {
                if ($i == 1 || $i == $totalPaginas || ($i >= $pagina - 1 && $i <= $pagina + 1)) {
                    if ($pagina == $i) {
                        echo '<a class="page-selected" href="' . INCLUDE_PATH . 'news' . $catStr . '?pagina=' . $i . '">' . $i . '</a>';
                    } else {
                        echo '<a href="' . INCLUDE_PATH . 'news' . $catStr . '?pagina=' . $i . '">' . $i . '</a>';
                    }
                } elseif ($i == 2 && $pagina > 4) {
                    echo '<span class="pontinho">...</span>';
                } elseif ($i == $totalPaginas - 1 && $pagina < $totalPaginas - 3) {
                    echo '<span class="pontinho">...</span>';
                }
            } else {
                if ($pagina == $i) {
                    echo '<a class="page-selected" href="' . INCLUDE_PATH . 'news' . $catStr . '?pagina=' . $i . '">' . $i . '</a>';
                } else {
                    echo '<a href="' . INCLUDE_PATH . 'news' . $catStr . '?pagina=' . $i . '">' . $i . '</a>';
                }
            }
        }
    }
}
