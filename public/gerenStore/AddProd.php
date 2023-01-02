<?php require_once("../../conexao/conexao.php"); ?>
<?php include_once("../_incluir/funcoes.php"); ?> 
    <?php

        if( isset($_POST["enviar"])){
            $resposta =uploadArquivo($_FILES["upload_file"],"images/product_images");    
            print_r($resposta);

            $mensagem = $resposta[0];
            $nome_arquivo = $resposta[1];
        
        }
    ?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
        <style>
            input {
                display:block;
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <?php include_once("../_incluir/topo.php"); ?>
        <li><a href="listagemProd.php">Voltar para lista</a></li> 
        
        <main> 
        
            <div id="janela_formulario">
                
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">

                    <input type="file" name="upload_file" accept="image/png, image/jpeg, image/gif">
                    <input type="submit" name="enviar">

                </form>

                <?php 
                    if( isset($mensagem)) {
                        echo $mensagem;
                    }
                ?>
            </div>
        </main>

        <?php include_once("../_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>