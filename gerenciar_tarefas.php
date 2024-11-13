<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'tarefas');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Alterar status
if (isset($_POST['alterar_status'])) {
    $id_tarefa = $_POST['id_tarefa'];
    $status = $_POST['pendente'];

    $sql_update = "UPDATE tbl_tarefas SET pendente = ? WHERE id_tarefas = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('si', $status, $id_tarefa);
    $stmt->execute();
    header('Location: gerenciar_tarefas.php'); // Redireciona após a atualização
}

// Excluir tarefa
if (isset($_GET['excluir'])) {
    $id_tarefa = $_GET['excluir'];

    $sql_delete = "DELETE FROM tbl_tarefas WHERE id_tarefas = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param('i', $id_tarefa);
    $stmt->execute();
    header('Location: gerenciar_tarefas.php'); // Redireciona após exclusão
}

// Buscar tarefas
$sql = "SELECT tbl_tarefas.*, tbl_usuario.nome_usu FROM tbl_tarefas
        LEFT JOIN tbl_usuario ON tbl_tarefas.id_usu = tbl_usuario.id_usu";
$result = $conn->query($sql);

$tarefas_a_fazer = [];
$tarefas_fazendo = [];
$tarefas_prontas = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['pendente'] == 'a_fazer') {
            $tarefas_a_fazer[] = $row;
        } elseif ($row['pendente'] == 'fazendo') {
            $tarefas_fazendo[] = $row;
        } else {
            $tarefas_prontas[] = $row;
        }
    }
} else {
    echo "Nenhuma tarefa encontrada.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
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
        .task-board {
            display: flex;
            justify-content: space-between;
        }
        .task-column {
            width: 30%;
            padding: 10px;
        }
        .task-column h3 {
            text-align: center;
            color: #333;
        }
        .task-card {
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .task-card p {
            margin: 5px 0;
            font-size: 14px;
        }
        .task-card .btn {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }
        .task-card .btn:hover {
            background-color: #0056b3;
        }
        .task-card select {
            padding: 5px;
            font-size: 12px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Cadastro de Usuários</a>
        <a href="cadastro_tarefas.php">Cadastro de Tarefas</a>
        <a href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
    </div>

    <div class="container">
        <h2>Gerenciamento de Tarefas</h2>
        <div class="task-board">
            <!-- A Fazer -->
            <div class="task-column">
                <h3>A Fazer</h3>
                <?php foreach ($tarefas_a_fazer as $tarefa): ?>
                    <div class="task-card">
                        <p><strong>Tarefa:</strong> <?php echo $tarefa['pendente']; ?></p>
                        <p><strong>Feita:</strong> <?php echo $tarefa['feita']; ?></p>
                        <p><strong>Andamento:</strong> <?php echo $tarefa['andamento']; ?></p>
                        <p><strong>Responsável:</strong> <?php echo $tarefa['nome_usu']; ?></p>
                        
                        <!-- Botão de Alterar Status -->
                        <form action="" method="POST">
                            <input type="hidden" name="id_tarefa" value="<?php echo $tarefa['id_tarefas']; ?>">
                            <select name="pendente">
                                <option value="a_fazer" <?php if($tarefa['pendente'] == 'a_fazer') echo 'selected'; ?>>A Fazer</option>
                                <option value="fazendo" <?php if($tarefa['pendente'] == 'fazendo') echo 'selected'; ?>>Fazendo</option>
                                <option value="pronto" <?php if($tarefa['pendente'] == 'pronto') echo 'selected'; ?>>Pronto</option>
                            </select>
                            <button type="submit" class="btn" name="alterar_status">Alterar Status</button>
                        </form>

                        <!-- Botões de Editar e Excluir -->
                        <a href="editar_tarefa.php?id=<?php echo $tarefa['id_tarefas']; ?>" class="btn">Editar</a>
                        <a href="?excluir=<?php echo $tarefa['id_tarefas']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Fazendo -->
            <div class="task-column">
                <h3>Fazendo</h3>
                <?php foreach ($tarefas_fazendo as $tarefa): ?>
                    <div class="task-card">
                        <p><strong>Tarefa:</strong> <?php echo $tarefa['pendente']; ?></p>
                        <p><strong>Feita:</strong> <?php echo $tarefa['feita']; ?></p>
                        <p><strong>Andamento:</strong> <?php echo $tarefa['andamento']; ?></p>
                        <p><strong>Responsável:</strong> <?php echo $tarefa['nome_usu']; ?></p>
                        
                        <!-- Botões de Editar e Excluir -->
                        <a href="editar_tarefa.php?id=<?php echo $tarefa['id_tarefas']; ?>" class="btn">Editar</a>
                        <a href="?excluir=<?php echo $tarefa['id_tarefas']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pronto -->
            <div class="task-column">
                <h3>Pronto</h3>
                <?php foreach ($tarefas_prontas as $tarefa): ?>
                    <div class="task-card">
                        <p><strong>Tarefa:</strong> <?php echo $tarefa['pendente']; ?></p>
                        <p><strong>Feita:</strong> <?php echo $tarefa['feita']; ?></p>
                        <p><strong>Andamento:</strong> <?php echo $tarefa['andamento']; ?></p>
                        <p><strong>Responsável:</strong> <?php echo $tarefa['nome_usu']; ?></p>
                        
                        <!-- Botões de Editar e Excluir -->
                        <a href="editar_tarefa.php?id=<?php echo $tarefa['id_tarefas']; ?>" class="btn">Editar</a>
                        <a href="?excluir=<?php echo $tarefa['id_tarefas']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
