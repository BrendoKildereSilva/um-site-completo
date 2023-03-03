<?php

    namespace app\database;

    use PDO;

    class Connection
    {
        static public function conexao()
        {
            return new PDO('mysql:host=localhost;dbname=bkprodutos','root','');
        }
    }

    



