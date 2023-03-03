<?php


require '../../vendor/autoload.php';
// 
use app\database\Connection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
// 
header('Access-Control-Allow-Origin: *');
// 
$email = htmlentities($_REQUEST['email']);
$senha = htmlentities($_REQUEST['senha']);
// 
// 
// 
$pdo = Connection::conexao();
// 
$mysql_cod_conferir_dados = $pdo->prepare("SELECT nome, sobrenome, email, senha, cargo, foto_perfil FROM usuarios_info WHERE email = '$email' AND senha = '$senha'");
$mysql_cod_conferir_dados->execute();
$resultado_busca_dados = $mysql_cod_conferir_dados->rowCount();
// 
// 
// 
$mysql_cod_email = $pdo->prepare("SELECT email FROM usuarios_info WHERE email = '$email'");
$mysql_cod_email->execute();
$resultado_busca_email = $mysql_cod_email->rowCount();
// 
// 
// 
if($resultado_busca_dados >= 1){
    $usuario = $mysql_cod_conferir_dados->fetch(PDO::FETCH_ASSOC);
    $key = 'password';

    if(empty($usuario['foto_perfil'])){
        // 
        $usuario['foto_perfil'] = 'perfil_sem_foto.png';
    }

    $payload = [
        'iat' => time(),
        'email' => $usuario['email'],
        'cargo' => $usuario['cargo'],
        'nome' => $usuario['nome'],
        'sobrenome' => $usuario['sobrenome'],
        'foto_perfil' => 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/' . $usuario['foto_perfil']
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $resposta['mensagem'] = 'Dados validos';
    $resposta['token'] = $jwt;
}
else if($resultado_busca_email >= 1)
{
    $mysql_cod_buscar_foto_perfil = $pdo->prepare("SELECT foto_perfil FROM usuarios_info WHERE email = '$email'");
    $mysql_cod_buscar_foto_perfil->execute();
    $foto_perfil = $mysql_cod_buscar_foto_perfil->fetch(PDO::FETCH_ASSOC);

    $resposta['mensagem'] = 'Apenas o Email valido';
    $resposta['email'] = $email;
    $resposta['foto_perfil'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/' . $foto_perfil['foto_perfil'];

}
else
{
    $resposta['mensagem'] = 'Dados invalidos';
}


echo json_encode($resposta);

