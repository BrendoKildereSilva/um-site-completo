<?php

require '../../vendor/autoload.php';
header('Access-Control-Allow-Origin: *');

use app\database\Connection;

// verificando file enviado
if(isset($_FILES['foto_perfil']['name'])){

    $extensaoImg = strtolower(substr($_FILES['foto_perfil']['name'], -4));

    $array_extensoes_permitidas = ['.jpg', '.png'];

    if(!in_array($extensaoImg, $array_extensoes_permitidas)){
        die('Erro');
    }
}   

// 
$nome = htmlentities($_REQUEST['nome']);
$sobrenome = htmlentities($_REQUEST['sobrenome']);
$email = htmlentities($_REQUEST['email']);
$senha = htmlentities($_REQUEST['senha']);
// 
$cargo = htmlentities($_REQUEST['cargo']);
// 
$ddi = htmlentities($_REQUEST['ddi']);
$numero_contato = htmlentities($_REQUEST['numero_contato']);
$dia_nasc = htmlentities($_REQUEST['dia_nasc']);
$mes_nasc = htmlentities($_REQUEST['mes_nasc']);
$ano_nasc = htmlentities($_REQUEST['ano_nasc']);
$genero = htmlentities($_REQUEST['genero']);
// 

$diretorio_img = '../../banco-de-imagens/foto_perfil/';
$extensaoImg = strtolower(substr($_FILES['foto_perfil']['name'], -4));
$novo_nome_img = md5(time()) . $extensaoImg;



move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $diretorio_img.$novo_nome_img);



$pdo = Connection::conexao();
// 
$cod_mysql_inserir_dados = $pdo->prepare("INSERT INTO usuarios_info(nome, sobrenome, email, senha, cargo, ddi, numero_contato, dia_nasc, mes_nasc, ano_nasc, genero, foto_perfil)
VALUES('$nome','$sobrenome','$email','$senha','$cargo','$ddi','$numero_contato','$dia_nasc', '$mes_nasc','$ano_nasc','$genero','$novo_nome_img')");

$cod_mysql_inserir_dados->execute();



// Mandar dados para o banco








