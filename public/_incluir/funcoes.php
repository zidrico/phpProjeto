<?php
    function real_format($valor) {
        $valor  = number_format($valor,2,",",".");
        return "R$ " . $valor;
    }

    function mostrarAviso($numero) {
        $array_erro = array(
            UPLOAD_ERR_OK => "Arquivo publicado com sucesso!.",
            UPLOAD_ERR_INI_SIZE => "O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.",
            UPLOAD_ERR_FORM_SIZE => "O arquivo excede o limite definido em 45kb no formulário HTML",
            UPLOAD_ERR_PARTIAL => "O upload do arquivo foi feito parcialmente.",
            UPLOAD_ERR_NO_FILE => "Nenhum arquivo foi enviado.",
            UPLOAD_ERR_NO_TMP_DIR => "Pasta temporária ausente.",
            UPLOAD_ERR_CANT_WRITE => "Falha em escrever o arquivo em disco.",
            UPLOAD_ERR_EXTENSION => "Uma extensão do PHP interrompeu o upload do arquivo."
        ); 

        return $array_erro[$numero];
    }

    function uploadArquivo($arquivoPublicado,$minha_pasta){

        if($arquivoPublicado["error"] == 0){
            $pasta_temporaria = $arquivoPublicado["tmp_name"]; 
            $arquivo          = alterarNome ($arquivoPublicado["name"]);
            $pasta            = $minha_pasta;
            $tipo             = $arquivoPublicado["type"];
            $extensao         = strrchr($arquivo,".");

                

                if ($tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/gif"){
                    if  (move_uploaded_file($pasta_temporaria, $pasta . "/" . $arquivo)){
                            $mensagem = mostrarAviso($arquivoPublicado["error"]);
                    } else {
                        $mensagem = "Erro na publicação";
                    }
                }else{
                    $mensagem = "Erro: Arquivo publicado não pode ter a extensão" . $extensao;
                }
                }else{
                    $mensagem = mostrarAviso($arquivoPublicado["error"]);
                } 

                return array($mensagem,$arquivo);
    }

    function alterarNome($arquivo) {
    
    $extensao         = strrchr($arquivo,".");    
    $alfabeto   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $tamanho    = "12";
    $codigo     = "";
    $resultado  = "";

    for ( $i = 1; $i < $tamanho; $i++) {
        $codigo = substr($alfabeto, rand(0, strlen($alfabeto)-1),1);
        $resultado .= $codigo;
    }

    $agora  = getdate();
    $ano_atual  = $agora["year"] . "_" . $agora["yday"];
    $codigo_data = $agora["hours"] . $agora["minutes"] . $agora["seconds"];

    return  "Arquivo_" . $resultado . "_" . $ano_atual . "_" . $codigo_data . $extensao;
    }

    function enviarMensagem($dados) {
        // Dafos do formulario
        $nome               =   $dados['nome'];
        $email              =   $dados['email'];
        $mensagem_usuario   =   $dados['mensagem'];

        // Criar variaveis de envio
        $destino            = "suport@imediabrasil.com.br";
        $remetente          = "imediabrasil@imediabrasil.com.br";
        $assunto            = "Mensagem do site";      
        
        //Montar corpo da mensagem

        $mensagem   = "O usuário " . $nome . " enviou uma mensagem. " . "<br>";
        $mensagem   .= "email do usuário: " . $email . "<br>";
        $mensagem   .= "mensagem: " . "<br>";
        $mensagem   .= $mensagem_usuario;

        return mail($destino, $assunto, $mensagem, $remetente);

        }
?>