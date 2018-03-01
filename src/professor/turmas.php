<!DOCTYPE html>
<html lang="pt" >

<head>
  <meta charset="UTF-8">
  <title>Problemas</title>
  <script type="text/javascript">
    function confirme(){
      var a = prompt("Você tem certeza que quer excluir essa turma? 1 - SIM / 2 - NÃO");
      if (a = 1) {
        return true;
      }else{
        return false;
      }
    }
  </script>
</head>

<body>

  <?php 

    require ($_SERVER["DOCUMENT_ROOT"].'/verifica.php');
    require ($_SERVER["DOCUMENT_ROOT"].'/imports.php');

   ?>
<br><br><br><br><br>
  <div class="table-users">
   <div class="header">Turmas Cadastradas</div>

      <table cellspacing="0" class="table table-bordered">
      <tr>
         <th>Descrição</th>
         <th>Quantidade de Alunos</th>
         <th>Opções</th>
      </tr>
   <?php

  require ($_SERVER["DOCUMENT_ROOT"].'/conexao.php');

   $resultado = $conexao->prepare("select * from Turma where id_Professor = ?");
   $resultado->bindValue(1, $_SESSION["id"]);
   $resultado->execute();

  foreach($resultado as $linha){ 
    $sql = "select count(*) from Alunos where id_turma = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(1, $linha["id"]);

    $quantidade;

    foreach ($stmt as $key) {
        $quantidade = $key["count(*)"];
    }

?>
      <tr>
         <td><?=$linha['desc_Turma'];?></td>
         <td><?=$quantidade;?></td>
         <td>
            <form action="/professor/listarAlunosTurma.php" action="GET">
             <input type="hidden" name="idturma" value="<?=$linha["id"];?>">
             <button type="submit" class="btn btn-sm btn-warning">Editar Turma</button>
           </form>
           <form action="/professor/deletarTurma.php" action="GET" onsubmit="return confirme()">
             <input type="hidden" name="idturma" value="<?=$linha["id"];?>">
             <button type="submit" class="btn btn-sm btn-danger"> Deletar Turma </button>
           </form>
         </td>
<?php } ?>
      </tr>
      <tr>
        <td colspan="3">
        <center>
          <button class="btn btn-success btn-sm">
            <a href="/professor/criarTurma.php" style="color: #fff">Criar nova turma</a>
          </button>
        </center>
        </td>
      </tr>
   </table>
</div>
  
  

</body>

</html>
