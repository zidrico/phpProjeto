<?php require_once("../../conexao/conexao.php"); ?>
<?php
//Iniciar variavel de sessao
            session_start();

            if (isset($_POST["usuario"])) {
            $usuario    = $_POST["usuario"];
            $senha      = $_POST["senha"];

            $login  =   "SELECT * ";
            $login .=   " FROM clientes ";
            $login .=   " WHERE usuario = '{$usuario}' and senha = '{$senha}' ";

            $acesso = mysqli_query($conecta,$login);

            if (!$acesso){
                die("Falha na conexão!");
            }

            $informacao = mysqli_fetch_assoc($acesso);

            if ( empty($informacao)) {
                $mensagem = "Usuário ou senha não encontrados";
            } else {
                $_SESSION["user_portal"] = $informacao["clienteID"];
                header("location:login.php");
            }
        }
        
    ?>
             
<?php
    // Determinar localidade BR
    setlocale(LC_ALL, 'pt_BR');

    // Consulta ao banco de dados
    $produtos = "SELECT produtoID, nomeproduto, tempoentrega, precounitario, imagempequena ";
    $produtos .= " FROM produtos ";
    if ( isset($_GET["produto"])){
        $nome_produto =$_GET["produto"];
        $produtos .= " WHERE nomeproduto LIKE '%{$nome_produto}%'";
    }
    $resultado = mysqli_query($conecta, $produtos);
    if(!$resultado) {
        die("Falha na consulta ao banco");   
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Curso PHP Integração com MySQL</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css"            rel="stylesheet">
        <link href="_css/produtos.css"          rel="stylesheet">
        <link href="_css/produto_pesquisa.css"  rel="stylesheet">
    </head>

    <body>
                
        <?php include_once("../_incluir/topo.php"); ?>
        <?php include_once("../_incluir/funcoes.php"); ?>  
        
        
        <main> 
        <div id="header_central">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="HeaderNavbar">
                    <ul class="navbar-nav">
                        <li><a href="login.php">Voltar pagina de login</a></li>
                        <li><a href="listagemProd.php">Voltar para lista de produtos</a></li>
                        <li><a href="logout.php">Encerrar seção</a></li>
                    </ul>
                </div>  
            </nav>
        <?php 
            if ( isset($_SESSION["user_portal"])) {
                
                $user = $_SESSION["user_portal"];
         
                $saudacao        = "SELECT nomecompleto ";
                $saudacao       .= " FROM clientes ";
                $saudacao       .= " WHERE clienteID = {$user}";
                $saudacao_login  = mysqli_query($conecta,$saudacao);
                if(!$saudacao_login) {
                    die("Falha no banco de dados");
                }

                $saudacao_login = mysqli_fetch_assoc($saudacao_login);
                $nome = $saudacao_login["nomecompleto"];
        ?>
            
    
            <div id="header_saudacao">
                <h5>Seja bem vindo, <?php echo $nome ?></h5>
            </div>
            <?php    
            }
             ?>            
        </div>
    </div> 
            
            <div id="janela_pesquisa">
                <form action="listagemProd.php" method="get">
                    <input type="text" name="produto" placeholder="Pesquisa do produto">
                    <input type="image" name="pesquisa" src="../_assets/botao-search.png">
                </form>
            </div> 
            
            <div id="listagem_produtos"> 
                <?php
                    while($linha = mysqli_fetch_assoc($resultado)) {
                ?>
                    <ul>
                        <li class="imagem">
                            <a href="detalheProd.php?codigo=<?php echo $linha["produtoID"] ?> ">
                                <img src="<?php echo  $linha["imagempequena"] ?>">
                            </a>
                        </li>
                        <li><h3><?php echo $linha["nomeproduto"] ?></h3></li>
                        <li>Tempo de Entrega : <?php echo $linha["tempoentrega"] ?></li>
                        <li>Preço unitário : <?php echo real_format($linha["precounitario"]) ?></li>
                    </ul>
                <?php
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