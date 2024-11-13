<?php
include 'conexao.php';  // Inclui o arquivo de conexão

// Inserção de dados na tabela tbl_tarefas
$pendente = 'Tarefa 1';
$feita = '';
$andamento = 'Em andamento';
$id_usu = 1; // Suponha que o usuário com id_usu = 1 já existe

// Prepare a consulta SQL
$sql = "INSERT INTO tbl_tarefas (pendente, feita, andamento, id_usu) VALUES (:pendente, :feita, :andamento, :id_usu)";

// Prepare a execução da query
$stmt = $pdo->prepare($sql);

// Bind dos parâmetros
$stmt->bindParam(':pendente', $pendente);
$stmt->bindParam(':feita', $feita);
$stmt->bindParam(':andamento', $andamento);
$stmt->bindParam(':id_usu', $id_usu);

// Execute a consulta
if ($stmt->execute()) {
    echo "Tarefa inserida com sucesso!";
} else {
    echo "Erro ao inserir tarefa.";
}
?>
