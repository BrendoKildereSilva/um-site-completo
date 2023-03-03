<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    // 
    // 
    $dados =  json_decode(file_get_contents("php://input"),true);
    // 
    // 
    $jwt = strval($dados['token']);
    $key = 'password';
    // 
    require '../../vendor/autoload.php';
    // 
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    // 
    try{
        $decoded = JWT::decode($jwt, new key($key, 'HS256'));  
        print_r(json_encode($decoded));
    }
    catch(Throwable $e)
    {
        die('falha na verificação de token');
    }

