
<?php
 //require 'verifica.php';

  $email = $_POST["email"];
  $senha = $_POST["senha"];
  $professor = $_POST["tipoUsuario"];

  try{

	include ($_SERVER['HTTP_HOST'].'/conexao.php');



	if ($professor == 1) {
		# code...
	
	$stmt =$conexao->prepare("select email, senha from Professor where email = ? ");

	}else{
		$stmt =$conexao->prepare("select email, senha from Aluno where email = ? ");		
	}

	$stmt->bindParam(1, $email);

	$stmt->execute();	

	$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($resultado as $linha){
	
		if(strcasecmp($senha, $linha["senha"]) == 0){
			
			session_start();
			$_SESSION["email"]=$email;
			$_SESSION["email"]=$linha["email"];
			$_SESSION["USUARIO_LOGADO"];

			if ($professor == 1) {
				$_SESSION["USUARIO_LOGADO"] = 'P';
			}else{
				$_SESSION["USUARIO_LOGADO"] = 'A';
			}
			


			header("Location: ".'/index.php');

		}else{
			echo "Email ou senha incorreto(s)";
			header("Location: Login/index.php");
		}
	}
	}	catch(PDOException $e){
		echo $e->getMessage();
	}
?>
