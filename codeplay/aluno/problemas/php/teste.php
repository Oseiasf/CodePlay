<?php 

	session_start();
	include ('pontuar.php');
	include ($_SERVER["DOCUMENT_ROOT"].'/conexao.php');

	$resposta = $_POST["resposta"];
	$idAluno = $_SESSION["id"];
	
	$idProblema = $_POST["id"];
	$classificacao = $_POST["classificacao"];

	$inserirResposta = "insert into RespostaAluno (desc_resposta, id_aluno) values (?,?)";

	$stmt = $conexao->prepare($inserirResposta);

	
	$stmt->bindValue(1, $resposta);
	$stmt->bindValue(2, $idAluno);

	$stmt->execute();

	$query = $conexao->prepare("select desc_Gabarito from Gabarito where id_Problema = ?");

	$query->bindValue(1, $idProblema);
	$query->execute();

	$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach ($resultado as $linha) {
		
		if (strcasecmp($resposta, $linha["desc_Gabarito"]) == 0) {

			echo "<script> alert('Acertou, mizeravi!'); </script>";
			pontuar_aluno($conexao, $idAluno, $idProblema, 1, $classificacao);
			header("Location: /aluno/problemas/telas/sucesso.php");
			

		}else{

			echo "<script> alert('Errou playboy, tenta dinovo parça!'); </script>";
			
			header("Location: /aluno/problemas/telas/desgraca.php");
		}


	}











 ?>