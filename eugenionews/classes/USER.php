<?php

class USER
{

    public static function  updateUser($nome, $password, $img)
    {

        $sql = SQLCN::connectDB()->prepare("UPDATE `tb_painel_admin.users` SET password = ?, img = ?, name = ? WHERE user = ?");

        if ($sql->execute($password, $img, $nome, $_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function exist($user, $table)
    {
        $sql = SQLCN::connectDB()->prepare("SELECT * FROM `$table` WHERE user = ?");
        $sql->execute(array($user));

        if ($sql->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function register($user, $password, $img = null, $name, $cargo, $table)
    {
        if($img === null){
            $sql = SQLCN::connectDB()->prepare("INSERT INTO `$table` (id, user, password, name, cargo) VALUES (null, :user, :password, :name, :cargo)");
            $sql->bindParam(':user', $user);
            $sql->bindParam(':password', $password);
            $sql->bindParam(':name', $name);
            $sql->bindParam(':cargo', $cargo);
            $sql->execute();
        } else {
            $sql = SQLCN::connectDB()->prepare("INSERT INTO `$table` (id, user, password, img, name, cargo) VALUES (null, :user, :password, :img, :name, :cargo)");
            $sql->bindParam(':user', $user);
            $sql->bindParam(':password', $password);
            $sql->bindParam(':img', $img);
            $sql->bindParam(':name', $name);
            $sql->bindParam(':cargo', $cargo);
            $sql->execute();
        }
    }
    
}
