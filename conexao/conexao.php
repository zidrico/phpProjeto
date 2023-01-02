<?php 
    //passo1 connecta o banco
    $servidor = "localhost";
    $usuario  = "root";
    $senha    = "";
    $banco    = "andes";
    $conecta = mysqli_connect($servidor,$usuario,$senha,$banco);

    // passo 2 verificar se há erros na conexao
    if( mysqli_connect_errno() ){
        die("Falha na conexão: " . mysqli_connect_errno());
    }

?>