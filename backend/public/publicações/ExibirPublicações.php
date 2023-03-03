<?php

    require '../../vendor/autoload.php';
    // 
    use app\database\Connection;
    // 
    header('Access-Control-Allow-Origin: *');

    
    $Array_dados = [];



    if(empty($_REQUEST['NumeroDaPagina']) || $_REQUEST['NumeroDaPagina'] == 'undefined'){
        $NumeroDaPagina = 1;
    }
    else
    {
        $NumeroDaPagina = $_REQUEST['NumeroDaPagina'];
    }

    // calculando o inicio da visualização
    $qnt_publicacao_pg = 8;
    $inicio = ($NumeroDaPagina * $qnt_publicacao_pg) - $qnt_publicacao_pg;



    $pdo = Connection::conexao();

    $cod_mysql_resgatar_publicacoes = 
    $pdo->prepare("SELECT publicações.id, email_user, link, frete, nome_publicação, data_minuto, data_hora, data_dia, data_mes, data_ano, preço_valor_1, diretorio, foto_capa 
    FROM publicações
    INNER JOIN imagens_publicações ON imagens_publicações.id_publicação = publicações.id
    INNER JOIN preço_publicações ON preço_publicações.id_publicação = publicações.id
    ORDER BY id DESC LIMIT $inicio, $qnt_publicacao_pg");
    $cod_mysql_resgatar_publicacoes->execute(); 

    $cod_countar_numeros_de_publicações = $pdo->prepare("SELECT COUNT(publicações.id) as total_public
    FROM publicações
    ");
    $cod_countar_numeros_de_publicações->execute();
    $total_public = $cod_countar_numeros_de_publicações->fetch(PDO::FETCH_ASSOC);


    while($Dados = $cod_mysql_resgatar_publicacoes->fetch(PDO::FETCH_ASSOC)){
        $obj_dados['todos_os_dados'] = $Dados;
        $data_public_ano = $Dados['data_ano'] ;
        $data_public_mes = $Dados['data_mes'] ;
        $data_public_dia = $Dados['data_dia'] ;
        $data_public_hora = $Dados['data_hora'] ;
        $data_public_minuto = $Dados['data_minuto'] ;
        

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
            $obj_dados['data_publicada'] = 'publicado há '.$intervalo_ano.' ano';
        }
        else if($intervalo_mes != 0)
        {
            $obj_dados['data_publicada'] = 'publicado há '.$intervalo_mes.' mês';
        }
        else if($intervalo_dia != 0)
        {
            $obj_dados['data_publicada'] = 'publicado há '.$intervalo_dia .' dia';   
        }
        else if($intervalo_hora != 0)
        {
            $obj_dados['data_publicada'] = 'publicado há '.$intervalo_hora.' hora';
        }
        else
        {
            $obj_dados['data_publicada'] = 'publicado há '.$intervalo_minuto. ' mninuto';
        }

       
        $obj_dados['nome_publicação'] =  html_entity_decode($Dados['nome_publicação']);
        $obj_dados['email_user'] = $Dados['email_user'];
        $obj_dados['preço_valor'] = 'R$ '.$Dados['preço_valor_1'];
        $obj_dados['link'] = $Dados['link'];
        $obj_dados['frete'] = $Dados['frete'];
        

        $obj_dados['imagem_src'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/fotos_publicações/' . $Dados['diretorio'] . '/' . $Dados['foto_capa'];


        // Dados do usuario
        $email_user = $Dados['email_user'];
        // 
        $cod_mysql_resgatar_dados_user = $pdo->prepare("SELECT foto_perfil, nome FROM usuarios_Info WHERE email = '$email_user'");
        $cod_mysql_resgatar_dados_user->execute();
        $usuario_dados = $cod_mysql_resgatar_dados_user->fetch(PDO::FETCH_ASSOC);


        if(empty($usuario_dados['foto_perfil'])){
            $obj_dados['src_imagem_perfil_user'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/perfil_sem_foto.png';
        }
        else
        {
            $obj_dados['src_imagem_perfil_user'] = 'http://localhost/projetos/ex01/backend/banco-de-imagens/foto_perfil/' . $usuario_dados['foto_perfil'];
        }
       
        
        
        $obj_dados['nome_user'] = $usuario_dados['nome'];
        
        Array_push($Array_dados, $obj_dados);
    }

echo json_encode($Array_dados);


    


