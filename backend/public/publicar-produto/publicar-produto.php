<?php

    require '../../vendor/autoload.php';    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    use app\database\Connection;
    // 
    $email_user = htmlentities($_REQUEST['email_user']);
    $nome_publicaçao = htmlentities($_REQUEST['nome_publicação']);
    $descricao_publicaçao = htmlentities($_REQUEST['descricao_publicação']);
    $Link = bin2hex(random_bytes(10));
    // // 
    $pdo = Connection::conexao();
    // // 
    date_default_timezone_set('America/Sao_Paulo');
    $data_dia = date('d');
    $data_mes = date('m');
    $data_ano = date('Y');
    $data_hora = date('H');
    $data_minuto = date('i');
    //


    // VERIFICANDO SE A EXTENSÃO DE TODAS AS FOTOS SÃO DIFERENTES DE PNG OU JPG
    // Foto principal...
    $nome_foto_principal = strtolower($_FILES['foto_capa']['name']);
    $regex_extensao_png_jpg_webp = "/.jpg$|.png$|.webp$/";
    
    $VerificarExtensao_foto_principal = preg_match_all($regex_extensao_png_jpg_webp, $nome_foto_principal);

    if($VerificarExtensao_foto_principal != 0)
    {
        $BuscarExtensaoPng = StrPos($nome_foto_principal, '.png');
        $BuscarExtensaoJpg = StrPos($nome_foto_principal, '.jpg');
        $BuscarExtensaoWebp = StrPos($nome_foto_principal, '.webp');

        if($BuscarExtensaoPng != 0)
        {
            $extensao_foto_capa = substr($nome_foto_principal, $BuscarExtensaoPng);
        }
        else if($BuscarExtensaoJpg != 0)
        {
            $extensao_foto_capa = substr($nome_foto_principal, $BuscarExtensaoJpg);
        }
        else if($BuscarExtensaoWebp != 0)
        {
            $extensao_foto_capa = substr($nome_foto_principal, $BuscarExtensaoWebp);
        }
    }
    else
    {
        die('Apenas fotos png ou jpg');

    }


    // seperando as fotos da publicação da foto principal
    for($i = 0; $i <= 10; $i++){
        
        if(!isset($_FILES['foto_' . $i])){
            break;
        }
        else
        {
            $obj_imgs['foto_' . $i] = $_FILES['foto_' . $i];
        }

    }


    for($i = 0; $i < count($obj_imgs); $i++){
        
        $foto_public = strtolower($obj_imgs['foto_' . $i]['name']);
        $VerificarExtensao_foto = preg_match_all($regex_extensao_png_jpg_webp, $foto_public);

        if($VerificarExtensao_foto != 0)
        {
            $BuscarExtensaoPng = StrPos($foto_public, '.png');
            $BuscarExtensaoJpg = StrPos($foto_public, '.jpg');
            $BuscarExtensaoWebp = StrPos($foto_public,'.webp');

            if($BuscarExtensaoPng != 0)
            {
                $extensao_fotos_public['foto_' . $i] =  substr($foto_public ,$BuscarExtensaoPng);
            }
            else if($BuscarExtensaoJpg != 0)
            {
                $extensao_fotos_public['foto_' . $i] = substr($foto_public ,$BuscarExtensaoJpg);
            }
            else if($BuscarExtensaoWebp != 0)
            {
                $extensao_fotos_public['foto_' . $i] = substr($foto_public ,$BuscarExtensaoWebp);
            }
        }
        else
        {
            die('Apenas fotos png ou jpg');
        }
    }


    // ////////////////////////////////////////////////////////////

    
    //  INSERINDO OS DADOS NAS TABELAS !
    $cod_mysql_inserir_dados_publicacao = $pdo->prepare("INSERT INTO publicações(link, data_dia, data_mes, data_ano, data_hora, data_minuto, email_user, nome_publicação, descricao_publicação)
    VALUES('$Link', '$data_dia', '$data_mes', '$data_ano', '$data_hora', '$data_minuto', '$email_user', '$nome_publicaçao', '$descricao_publicaçao' )
    ");
    
    $cod_mysql_inserir_dados_publicacao->execute();
    $id_publicacao = $pdo->lastInsertId();


    $preço_nome_1 = htmlentities( $_REQUEST['preço_nome_0']);
    $preço_nome_2 = htmlentities($_REQUEST['preço_nome_1']);
    $preço_nome_3 = htmlentities($_REQUEST['preço_nome_2']);
    $preço_nome_4 = htmlentities($_REQUEST['preço_nome_3']);
    $preço_nome_5 = htmlentities($_REQUEST['preço_nome_4']);
    $preço_nome_6 = htmlentities($_REQUEST['preço_nome_5']);
    $preço_nome_7 = htmlentities($_REQUEST['preço_nome_6']);
    $preço_nome_8 = htmlentities($_REQUEST['preço_nome_7']);
    $preço_nome_9 = htmlentities($_REQUEST['preço_nome_8']);
    $preço_nome_10 = htmlentities($_REQUEST['preço_nome_9']);
    // 
    $preço_valor_1 = htmlentities($_REQUEST['preço_valor_0']);
    $preço_valor_2 = htmlentities($_REQUEST['preço_valor_1']);
    $preço_valor_3 = htmlentities($_REQUEST['preço_valor_2']);
    $preço_valor_4 = htmlentities($_REQUEST['preço_valor_3']);
    $preço_valor_5 = htmlentities($_REQUEST['preço_valor_4']);
    $preço_valor_6 = htmlentities($_REQUEST['preço_valor_5']);
    $preço_valor_7 = htmlentities($_REQUEST['preço_valor_6']);
    $preço_valor_8 = htmlentities($_REQUEST['preço_valor_7']);
    $preço_valor_9 = htmlentities($_REQUEST['preço_valor_8']);
    $preço_valor_10 = htmlentities($_REQUEST['preço_valor_9']);
    // 
    $frete= htmlentities($_REQUEST['preço_frete']);

    $cod_mysql_inserir_precos_publicação = $pdo->prepare("INSERT INTO preço_publicações(id_publicação, frete, preço_nome_1, preço_nome_2, preço_nome_3, preço_nome_4, preço_nome_5, preço_nome_6, preço_nome_7, preço_nome_8, preço_nome_9, preço_nome_10, preço_valor_1, preço_valor_2, preço_valor_3, preço_valor_4, preço_valor_5, preço_valor_6, preço_valor_7, preço_valor_8, preço_valor_9, preço_valor_10 )
    VALUES('$id_publicacao', '$frete', '$preço_nome_1',  '$preço_nome_2', '$preço_nome_3', '$preço_nome_4', '$preço_nome_5', '$preço_nome_6', '$preço_nome_7', '$preço_nome_8', '$preço_nome_9', '$preço_nome_10', '$preço_valor_1', '$preço_valor_2', '$preço_valor_3', '$preço_valor_4', '$preço_valor_5', '$preço_valor_6', '$preço_valor_7', '$preço_valor_8', '$preço_valor_9', '$preço_valor_10')
    ");

    $cod_mysql_inserir_precos_publicação->execute();

    // // CRIANDO DIRETORIO PARAR AS IMAGENS

    $diretorio = '../../banco-de-imagens/fotos_publicações/';
    $nome_pasta = bin2hex(random_bytes(10));
    $criar_pasta = mkdir($diretorio.$nome_pasta, 0777, true);

    // // INSERINDO FOTO PRINCIPAL
    
    $nome_foto_capa = 'foto_capa' . $extensao_foto_capa;
    move_uploaded_file($_FILES['foto_capa']['tmp_name'], $diretorio.$nome_pasta.'/'.$nome_foto_capa);
    
    // // INSERINDO FOTOS da publicação

    for($i = 0; $i < count($obj_imgs); $i++){

        $nome_foto = 'foto_' . $i + 1 . $extensao_fotos_public['foto_' . $i];
        $obg_fotos_nomes['foto_' .$i + 1] = $nome_foto;
        move_uploaded_file($obj_imgs['foto_' . $i]['tmp_name'], $diretorio.$nome_pasta.'/'.$nome_foto);
    }

    
    $nome_foto_1 = $obg_fotos_nomes['foto_1'];
    $nome_foto_2 = $obg_fotos_nomes['foto_2'];
    $nome_foto_3 = $obg_fotos_nomes['foto_3'];
    $nome_foto_4 = $obg_fotos_nomes['foto_4'];
    $nome_foto_5 = $obg_fotos_nomes['foto_5'];
    $nome_foto_6 = $obg_fotos_nomes['foto_6'];
    $nome_foto_7 = $obg_fotos_nomes['foto_7'];
    $nome_foto_8 = $obg_fotos_nomes['foto_8'];
    $nome_foto_9 = $obg_fotos_nomes['foto_9'];
    $nome_foto_10 = $obg_fotos_nomes['foto_10'];

    $cod_mysql_inserir_imagens_publicação = $pdo->prepare("INSERT INTO imagens_publicações(id_publicação, diretorio, foto_capa, foto_01, foto_02, foto_03, foto_04, foto_05, foto_06, foto_07, foto_08, foto_09, foto_10)
    VALUES('$id_publicacao', '$nome_pasta', '$nome_foto_capa', '$nome_foto_1', '$nome_foto_2', '$nome_foto_3', '$nome_foto_4', '$nome_foto_5', '$nome_foto_6', '$nome_foto_7', '$nome_foto_8', '$nome_foto_9', '$nome_foto_10')
    ");

    $cod_mysql_inserir_imagens_publicação->execute();
    echo '//////////////////////////////////////////';
    echo $nome_foto_capa;

    








   
    
    


    
    

