<?php

    require '../../vendor/autoload.php';
    // 
    use app\database\Connection;
    // 
    header('Access-Control-Allow-Origin: *');

    
    $Array_dados = [];
    $pdo = Connection::conexao();


    $cod_contar_numeros_de_publicações = $pdo->prepare("SELECT COUNT(publicações.id) as total_public
    FROM publicações
    ");
    $cod_contar_numeros_de_publicações->execute();

    $total_public = $cod_contar_numeros_de_publicações->fetch(PDO::FETCH_ASSOC);
    $qnt_de_pg_exibida = 8;
    $qnt_pg = ceil($total_public['total_public'] / $qnt_de_pg_exibida);

    // Retona quantas paginas existe
    echo json_encode($qnt_pg);
