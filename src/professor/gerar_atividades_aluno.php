<?php
  require ($_SERVER["DOCUMENT_ROOT"].'/verifica.php');
  require ($_SERVER["DOCUMENT_ROOT"].'/conexao.php');

  require ($_SERVER["DOCUMENT_ROOT"].'/professor/carregarDadosAlunos.php');

if(isset($_POST['id_turma'])){
	gerarProblemasTurma($conexao, $_POST['id_turma'], NULL);
} elseif (isset($_POST['alunos'])){
	gerarProblemasTurma($conexao, NULL, $_POST['alunos']);
}

function gerarProblemasTurma($con, $turma, $selecao){
	$problemaDAO = new ProblemaDAO($con);
	$blocoAreaDAO = new BlocoAreaDAO($con);
	$itemBlocoDAO = new ItemBlocoDAO($con);
	$id_assunto = 1;

	// selecionar os alunos da turma
	if (isset($turma)){
		$alunos = pesquisarAlunos($con, NULL, $turma);
		foreach($alunos as $aluno){
			$id_aluno = $aluno->id;
			$itemBlocoDAO->createNextProblem($id_aluno, $id_assunto, 0);
		}
	} else if (isset($selecao)){
		// para cada aluno
		//   escolher um problema aleatorio de nivel F
		//   gerar um item de bloco de ordem 1
		echo "Quantidade: " . count($selecao);
		foreach($selecao as $id_aluno){
			echo "<br/>Aluno: $id_aluno";
			$itemBlocoDAO->createNextProblem($id_aluno, $id_assunto, 0);
		}		
	}

}
?>
<!DOCTYPE html>
<html lang="pt" >
	<head>
		<meta charset="UTF-8">
		<title>Code && Play - Geração de atividades para os alunos</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> 
	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	</head>
	<body>
		<div class="table-users">
	  	<div class="header">Geração de atividades</div>
		<div class="table-users">
  			<div class="table-users">
	      		<table cellspacing="0">

	      		</table>
	      	</div>
	     </div>
	 </div>
	</body>
</html>
