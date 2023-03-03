<?php
    
    require '../../vendor/autoload.php';    
    header('Access-Control-Allow-Origin: *');
    use app\database\Connection;
    // 
    $numero_contato = htmlentities($_REQUEST['numero_contato']);
    // 
    $pdo = Connection::conexao();
    // 
    $cod_mysql_buscar_numero_contato = $pdo->prepare("SELECT numero_contato FROM usuarios_info WHERE numero_contato = '$numero_contato'");
    $cod_mysql_buscar_numero_contato->execute();
    // 
    $resultado = $cod_mysql_buscar_numero_contato->rowCount();
    // 
    if($resultado >= 1){
        echo 'numero de contato em uso';
    }
    else
    {
        echo 'numero de contato não esta em uso';
    }

    