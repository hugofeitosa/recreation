<?php
session_start();
include_once("conexao.php");
?>
<!DOCTYPE html>
<html> 
<head>
		<meta charset="utf-8">
		<title>ReCreation - ADM</title>
    <style>
        body {
            background-color: lightgray;
        }
    </style>
</head>
<body>
    <h1> Página Administrativa </h1>
    <a href="usuarios.php">Listagem de Usuários</a><br>
    <h3> Listagem das Denúncias </h3>
    <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        //Receber o numero da pagina
        $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
        $pagina  = (!empty($pagina_atual)) ? $pagina_atual : 1;

        //Setar a quantidade de denuncias por pagina
        $qnt_result_pg = 1;

        //calcular o inicio visualizacao
        $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

        $result_denuncia = "SELECT * FROM denuncia LIMIT $inicio, $qnt_result_pg";
        $resultado_denuncia = mysqli_query($conn, $result_denuncia);
        while($row_denuncia = mysqli_fetch_assoc($resultado_denuncia)){
            echo "ID: " . $row_denuncia['id']."<br>";
            echo "Assunto: " . $row_denuncia['assunto']."<br>";
            echo "Descrição: " . $row_denuncia['descricao']."<br>";
            echo "Imagem: " . $row_denuncia['arquivo']."<br><hr>";
        }

        //Paginação
        $result_pg = "SELECT COUNT(id) AS num_result FROM denuncia";
        $resultado_pg = mysqli_query($conn, $result_pg);
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //echo $row_pg['num_result'];
        //Qtd de paginas
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

        //Limitar os link antes depois
        $max_links = 2;
        echo "<a href='index.php?pagina=1'> Primeira </a>";

        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
			if($pag_ant >= 1){
				echo "<a href='index.php?pagina=$pag_ant'>$pag_ant</a> ";
			}
		}

        echo "$pagina";

        for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++){
			if($pag_dep <= $quantidade_pg){
				echo "<a href='index.php?pagina=$pag_dep'>$pag_dep</a> ";
			}
		}

        echo "<a href='index.php?pagina=$quantidade_pg'>Ultima </a>";
    ?>

</body>
</html>