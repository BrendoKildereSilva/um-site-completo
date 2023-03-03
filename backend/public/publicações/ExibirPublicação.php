<?php


require '../../vendor/autoload.php';
// 
use app\database\Connection;
// 
header('Access-Control-Allow-Origin: *');


$link_public = $_REQUEST['link_public'];

$pdo = Connection::conexao();
// 
$cod_mysql_buscar_public = $pdo->prepare("SELECT Link, nome_publicação, descricao_publicação, email, frete, foto_perfil, nome,  data_minuto, data_hora, data_dia, data_mes, data_ano, diretorio, foto_01, foto_02, foto_03, foto_04, foto_05, foto_06, foto_07, foto_08, foto_09, foto_10, preço_valor_1, preço_valor_2, preço_valor_3, preço_valor_4, preço_valor_5, preço_valor_6, preço_valor_7, preço_valor_8, preço_valor_9, preço_valor_10, preço_nome_1, preço_nome_2, preço_nome_3, preço_nome_4, preço_nome_5, preço_nome_6, preço_nome_7, preço_nome_8, preço_nome_9, preço_nome_10 FROM publicações 
INNER JOIN usuarios_info ON usuarios_info.email = publicações.email_user
INNER JOIN imagens_publicações ON imagens_publicações.id_publicação = publicações.id
INNER JOIN preço_publicações ON preço_publicações.id_publicação = publicações.id
WHERE Link = '$link_public'
");
$cod_mysql_buscar_public->execute();
// 
$resultado = $cod_mysql_buscar_public->fetch(PDO::FETCH_ASSOC);
// 
$info_public['nome_publicação'] = html_entity_decode($resultado['nome_publicação']);
$info_public['descricao_publicação'] = html_entity_decode($resultado['descricao_publicação']);

// Calcular data publicada...
$data_public_ano = $resultado['data_ano'] ;
$data_public_mes = $resultado['data_mes'] ;
$data_public_dia = $resultado['data_dia'] ;
$data_public_hora = $resultado['data_hora'] ;
$data_public_minuto = $resultado['data_minuto'] ;


date_default_timezone_set('America/Sao_Paulo');
$data_atual = new DateTime('now');
$data_publicado = new DateTime($data_public_ano .'-'.$data_public_mes.'-'.$data_public_dia.' '.$data_public_hora.':'.$data_public_minuto.':00');

$intervalo = $data_publicado->diff($data_atual);
$intervalo_ano = $intervalo->y;
$intervalo_mes = $intervalo->m;
$intervalo_dia = $intervalo->d;
$intervalo_hora = $intervalo->h;
$intervalo_minuto = $intervalo->i;

if($intervalo_ano != 0)
{
    $info_public['data_publicada'] = 'publicado há '.$intervalo_ano.' ano atrás';
}
else if($intervalo_mes != 0)
{
    $info_public['data_publicada'] = 'publicado há '.$intervalo_mes.' mês atrás';
}
else if($intervalo_dia != 0)
{
    $info_public['data_publicada'] = 'publicado há '.$intervalo_dia .' dia atrás';   
}
else if($intervalo_hora != 0)
{
    $info_public['data_publicada'] = 'publicado há '.$intervalo_hora.' hora atrás';
}
else
{
    $info_public['data_publicada'] = 'publicado há '.$intervalo_minuto. ' mninuto atrás';
}

// 
$info_user['nome_user'] = html_entity_decode($resultado['nome']);
$info_user['email'] = html_entity_decode($resultado['email']);

if(empty($resultado['foto_perfil'])){
    $info_user['foto_perfil'] = 'perfil_sem_foto.png';
}
else{
    $info_user['foto_perfil'] = html_entity_decode($resultado['foto_perfil']);
}

$info_user['local_imagem'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/';
// 
$preço_nome['nome_preço_01'] = html_entity_decode($resultado['preço_nome_1']);
$preço_nome['nome_preço_02'] = html_entity_decode($resultado['preço_nome_2']);
$preço_nome['nome_preço_03'] = html_entity_decode($resultado['preço_nome_3']);
$preço_nome['nome_preço_04'] = html_entity_decode($resultado['preço_nome_4']);
$preço_nome['nome_preço_05'] = html_entity_decode($resultado['preço_nome_5']);
$preço_nome['nome_preço_06'] = html_entity_decode($resultado['preço_nome_6']);
$preço_nome['nome_preço_07'] = html_entity_decode($resultado['preço_nome_7']);
$preço_nome['nome_preço_08'] = html_entity_decode($resultado['preço_nome_8']);
$preço_nome['nome_preço_09'] = html_entity_decode($resultado['preço_nome_9']);
$preço_nome['nome_preço_10'] = html_entity_decode($resultado['preço_nome_10']);
// 
$preço_valor['nome_valor_01'] = html_entity_decode($resultado['preço_valor_1']);
$preço_valor['nome_valor_02'] = html_entity_decode($resultado['preço_valor_2']);
$preço_valor['nome_valor_03'] = html_entity_decode($resultado['preço_valor_3']);
$preço_valor['nome_valor_04'] = html_entity_decode($resultado['preço_valor_4']);
$preço_valor['nome_valor_05'] = html_entity_decode($resultado['preço_valor_5']);
$preço_valor['nome_valor_06'] = html_entity_decode($resultado['preço_valor_6']);
$preço_valor['nome_valor_07'] = html_entity_decode($resultado['preço_valor_7']);
$preço_valor['nome_valor_08'] = html_entity_decode($resultado['preço_valor_8']);
$preço_valor['nome_valor_09'] = html_entity_decode($resultado['preço_valor_9']);
$preço_valor['nome_valor_10'] = html_entity_decode($resultado['preço_valor_10']);
// 
$preços['nomes_preços'] = $preço_nome;
$preços['valores_preços'] = $preço_valor;

$imagens_public['foto_01'] = $resultado['foto_01'];
$imagens_public['foto_02'] = $resultado['foto_02'];
$imagens_public['foto_03'] = $resultado['foto_03'];
$imagens_public['foto_04'] = $resultado['foto_04'];
$imagens_public['foto_05'] = $resultado['foto_05'];
$imagens_public['foto_06'] = $resultado['foto_06'];
$imagens_public['foto_07'] = $resultado['foto_07'];
$imagens_public['foto_08'] = $resultado['foto_08'];
$imagens_public['foto_09'] = $resultado['foto_09'];
$imagens_public['foto_10'] = $resultado['foto_10'];
$imagens_public['diretorio'] = $resultado['diretorio'];
$imagens_public['local_imagem'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/fotos_publicações/';


$Dados['infos_public'] = $info_public;
$Dados['infos_user'] = $info_user;
$Dados['imagens_public'] = $imagens_public;
$Dados['preços'] = $preços;
$Dados['frete'] = $resultado['frete'];

echo json_encode($Dados);

