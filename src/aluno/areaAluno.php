<?php

// PARAMETROS
const PENALIZACAO_ERRO = 100;
const PONTUACAO_PADRAO_FACIL = 500;
const PONTUACAO_PADRAO_MEDIO = 1000;
const PONTUACAO_PADRAO_DIFICIL = 1500;

function obterNivel($ordem){
	if ($ordem <= 3){
		return 'F';
	} else if ($ordem == 4 || $ordem == 5){
		return 'M';
	} else {
		return 'D';
	}
}

abstract class Entity {
	public $id;
}
class Aluno extends Entity {
	public $nome;
	public $email;
	public $pontuacao;
	public $matricula;
	public function Aluno($id){
		$this->id = $id;
	}
}

class Problema extends Entity {
	public $desc_Problema;
	public $professor;
	public $assunto;
	public $classificacao;
}

class Assunto extends Entity {
	public $descricao;
}

class AreaAluno extends Entity {

	// atributos
	public $blocos; // BlocoArea blocos[];
	public $aluno; // Aluno aluno;

	public function __constructor(){
		$this->aluno = new Aluno();
		$this->blocos = array();
	}

	function criar($con){
		try {
			$sql = "insert into AreaAluno (id_aluno) values (?)";
			$stmt = $conexao->prepare($sql);
			$stmt->bindValue(1, $aluno->id);
			$stmt->execute();			
			return true;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}

	function pesquisar($con, $aluno){
		try {
			$sql = "select * from AreaAluno where id_aluno = ?";
			$stmt = $conexao->prepare($sql);
			$stmt->bindValue(1, $aluno->id);
			$stmt->execute();			
			return true;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
			
	}

}

class BlocoArea extends Entity {
	public $assunto; // Assunto assunto;
	public $itens; // ItemBlocoAluno[]; 

	// public function __constructor(){
	// 	$this->itens = array();
	// }

	public function BlocoArea($assunto = NULL){
		$this->assunto = $assunto;
		$this->itens = array();
	}

}

class ItemBlocoAluno extends Entity {

	public $problema; // Problema problema;
	public $situacao; // SituacaoItemBloco situacaoItem;
	public $ordem; // [1..6]

	public function __constructor($problema, $situacao, $ordem){
		$this->problema = $problema;
		$this->situacao = $situacao;
		$this->ordem = $ordem;
	}

}

class SituacaoItemBloco{

	public $status; // int status: // 0 - Inativo, 1 - Habilitado, 2 - ResolvidoSucesso, 3 - ResolvidoErro
	public $quantidade_tentativas; // int quantidadeTentativas;
	public $pontuacao_possivel; // int pontuacaoPossivel;
	public $pontuacao_obtida; // int pontuacaoObtida;
	public $dataUltimaSubmissao; // Date dataUltimaSubmissao;

	public function definirPontuacao($ordem){
		switch ($ordem) {
			case 1:
			case 2:
			case 3: 
				$this->pontuacao_possivel = PONTUACAO_PADRAO_FACIL;
				break;
			case 4:
			case 5: 
				$this->pontuacao_possivel = PONTUACAO_PADRAO_MEDIO;
				break;
			case 6: 
				$this->pontuacao_possivel = PONTUACAO_PADRAO_DIFICIL;
			default:
				break;
		}
	}

	public function registrarSucesso(){
		$this->status = 2;
		$this->quantidade_tentativas++;
		$this->pontuacao_obtida = $this->pontuacao_possivel;
	}
	public function registrarFalha(){
		$this->status = 3;
		$this->quantidade_tentativas++;
		$this->pontuacao_obtida -= PENALIZACAO_ERRO;
	}
}

class RespostaAluno extends Entity{
	public $desc_resposta;
	public $aluno;
	public $problema;

	public function RespostaAluno($descricao, $aluno, $problema){
		$this->desc_resposta = $descricao;
		$this->aluno = $aluno;
		$this->problema = $problema;
	}
}
?>