<?php


    header('Access-Control-Allow-Origin: *');
    require '../../vendor/autoload.php';

    use app\database\Connection;
    // 
    $email = htmlentities($_REQUEST['email']);
    // 
    $pdo = Connection::conexao();
    // 
    $cod_mysql_buscar_email = $pdo->prepare("SELECT email FROM usuarios_info WHERE email = '$email'");
    $cod_mysql_buscar_email->execute();
    // 
    $resultado = $cod_mysql_buscar_email->rowCount();
    // 
    if($resultado >= 1){
        echo 'já tem uma conta registrada com esse email';
    }
    else
    {
        echo 'não tem uma conta registrada com esse email';
    }

    



