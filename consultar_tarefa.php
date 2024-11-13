<?php
include 'conexao.php';  // Inclui o arquivo de conexão

// Consulta todos os registros da tabela tbl_tarefas
$sql = "SELECT * FROM tbl_tarefas";
$stmt = $pdo->query($sql);

// Exibe os dados
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID Tarefa: " . $row['id_tarefas'] . "<br>";
    echo "Pendente: " . $row['pendente'] . "<br>";
    echo "Feita: " . $row['feita'] . "<br>";
    echo "Andamento: " . $row['andamento'] . "<br>";
    echo "ID Usuário: " . $row['id_usu'] . "<br><br>";
}
?>
