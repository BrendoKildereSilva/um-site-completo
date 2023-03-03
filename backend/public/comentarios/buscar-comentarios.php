<?php
    require '../../vendor/autoload.php';
    header('Access-Control-Allow-Origin: *');

    use app\database\Connection;


    $link_public = $_REQUEST['link_public'];


    $pdo = Connection::conexao();
    $cod_mysql_buscar_comentarios = $pdo->prepare("SELECT * FROM comentarios_public WHERE link_public = '$link_public'
    ORDER BY id DESC");
    $cod_mysql_buscar_comentarios->execute();

    $Array_comentarios = [];
    while($Dados = $cod_mysql_buscar_comentarios->fetch(PDO::FETCH_ASSOC)){
        $info_comentario['comentario'] = $Dados['comentario'];
        $info_comentario['id_da_public'] = $Dados['id'];
        date_default_timezone_set('America/Sao_Paulo');
        $data_atual = new DateTime('now');

        $data_publicado = new DateTime($Dados['data_ano'] .'-'.$Dados['data_mes'].'-'.$Dados['data_dia'].' '.$Dados['data_hora'].':'.$Dados['data_minuto'].':00');

        $intervalo = $data_publicado->diff($data_atual);
        
        $intervalo_ano = $intervalo->y;
        $intervalo_mes = $intervalo->m;
        $intervalo_dia = $intervalo->d;
        $intervalo_hora = $intervalo->h;
        $intervalo_minuto = $intervalo->i;

        if($intervalo_ano != 0)
        {
            $info_comentario['data_publicada'] = 'Há '.$intervalo_ano.' ano atrás';
        }
        else if($intervalo_mes != 0)
        {
            $info_comentario['data_publicada'] = 'Há '.$intervalo_mes.' mês atrás';
        }
        else if($intervalo_dia != 0)
        {
            $info_comentario['data_publicada'] = 'Há '.$intervalo_dia .' dia atrás';   
        }
        else if($intervalo_hora == 1){
            $info_comentario['data_publicada'] = 'Há '.$intervalo_hora.' hora atrás';
        }
        else if($intervalo_hora != 0)
        {
            $info_comentario['data_publicada'] = 'Há '.$intervalo_hora.' horas atrás';
        }
        else if($intervalo_minuto != 0 ){
            $info_comentario['data_publicada'] = 'Há '.$intervalo_minuto. ' minuto atrás';
        }
        else
        {
            $info_comentario['data_publicada'] = ' agora mesmo';
        }

        $email_user = $Dados['email_user'];
        $cod_mysql_buscar_info_user = $pdo->prepare("SELECT nome, foto_perfil from usuarios_info where email = '$email_user'");
        $cod_mysql_buscar_info_user->execute();  
        $info_user = $cod_mysql_buscar_info_user->fetch(PDO::FETCH_ASSOC);

        if(empty($info_user['foto_perfil'])){
            $info_comentario['foto_perfil_user'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/perfil_sem_foto.png';

















        }
        else
        {
            $info_comentario['foto_perfil_user'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/' . $info_user['foto_perfil'];
        }

        $info_comentario['nome_user'] = $info_user['nome'];


        Array_push($Array_comentarios, $info_comentario);
    

    }

    echo json_encode($Array_comentarios);