<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'tarefas');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id_tarefa = $_GET['id'];

    // Buscar os dados da tarefa
    $sql = "SELECT * FROM tbl_tarefas WHERE id_tarefas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_tarefa);
    $stmt->execute();
    $result = $stmt->get_result();
    $tarefa = $result->fetch_assoc();

    // Verificar se a tarefa foi encontrada
    if (!$tarefa) {
        echo "Tarefa não encontrada!";
        exit;
    }
} else {
    echo "ID da tarefa não fornecido!";
    exit;
}

// Atualizar tarefa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pendente = $_POST['pendente'];
    $feita = $_POST['feita'];
    $andamento = $_POST['andamento'];

    $sql_update = "UPDATE tbl_tarefas SET pendente = ?, feita = ?, andamento = ? WHERE id_tarefas = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('sssi', $pendente, $feita, $andamento, $id_tarefa);
    $stmt->execute();
    
    header('Location: gerenciar_tarefas.php'); // Redirecionar após a atualização
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007bff;
            padding: 15px;
        }
        .navbar a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
    </div>

    <div class="container">
        <h2>Editar Tarefa</h2>
        <form action="editar_tarefa.php?id=<?php echo $tarefa['id_tarefas']; ?>" method="POST">
            <div class="form-group">
                <label for="pendente">Status:</label>
                <select name="pendente" id="pendente">
                    <option value="a_fazer" <?php echo ($tarefa['pendente'] == 'a_fazer') ? 'selected' : ''; ?>>A Fazer</option>
                    <option value="fazendo" <?php echo ($tarefa['pendente'] == 'fazendo') ? 'selected' : ''; ?>>Fazendo</option>
                    <option value="pronto" <?php echo ($tarefa['pendente'] == 'pronto') ? 'selected' : ''; ?>>Pronto</option>
                </select>
            </div>

            <div class="form-group">
                <label for="feita">Feita:</label>
                <input type="text" name="feita" value="<?php echo $tarefa['feita']; ?>" required>
            </div>

            <div class="form-group">
                <label for="andamento">Andamento:</label>
                <input type="text" name="andamento" value="<?php echo $tarefa['andamento']; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
        <a href="gerenciar_tarefas.php">Voltar</a>
    </div>
</body>
</html>
