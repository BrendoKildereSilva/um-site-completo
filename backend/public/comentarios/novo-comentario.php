<?php

    require '../../vendor/autoload.php';
    header('Access-Control-Allow-Origin: *');

    use app\database\Connection;


    $comentario = $_REQUEST['comentario'];
    $email_user = $_REQUEST['email_user'];
    $link_public = $_REQUEST['link_public'];

    date_default_timezone_set('America/Sao_Paulo');
    $data_dia = date('d');
    $data_mes = date('m');
    $data_ano = date('Y');
    $data_hora = date('H');
    $data_minuto = date('i');




    $pdo = Connection::conexao();

    $cod_mysql_novo_comentario = $pdo->prepare("INSERT INTO comentarios_public(link_public, email_user, comentario, data_ano, data_mes, data_dia, data_hora, data_minuto)
    VALUES('$link_public', '$email_user', '$comentario', '$data_ano', '$data_mes', '$data_dia', '$data_hora', '$data_minuto')
    
    ");

    $cod_mysql_novo_comentario->execute();

