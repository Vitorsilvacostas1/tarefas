<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'tarefas'; // Substitua pelo seu nome de banco de dados
$username = 'root'; // Ou outro usuário que você tenha configurado
$password = ''; // Ou a senha do seu banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Buscar usuários e tarefas para exibir nos selects
$usuarios = $pdo->query("SELECT id_usu, nome_usu FROM tbl_usuario")->fetchAll(PDO::FETCH_ASSOC);
$tarefas = $pdo->query("SELECT id_tarefas, pendente FROM tbl_tarefas")->fetchAll(PDO::FETCH_ASSOC);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_tarefa = $_POST['id_tarefa'];

    // Associar o usuário à tarefa
    $stmt = $pdo->prepare("UPDATE tbl_tarefas SET id_usu = ? WHERE id_tarefas = ?");
    $stmt->execute([$id_usuario, $id_tarefa]);

    echo "Usuário associado à tarefa com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associar Usuário a Tarefa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .navbar { background-color: #007bff; padding: 15px; display: flex; justify-content: flex-end; }
        .navbar button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .navbar button:hover { background-color: #0056b3; }
        .container { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: bold; }
        .form-group select { width: 25%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="navbar">
        <button onclick="window.location.href='cadastro_tarefas.php'">Cadastro de Tarefas</button>
        <button onclick="window.location.href='gerenciar_tarefas.php'">Gerenciar Tarefas</button>
    </div>

    <div class="container">
        <h2>Associar Usuário a Tarefa</h2>
        <form action="associar_usuario_tarefa.php" method="post">
            <div class="form-group">
                <label for="id_usuario">Selecione o Usuário</label>
                <select id="id_usuario" name="id_usuario" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id_usu']; ?>"><?php echo $usuario['nome_usu']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_tarefa">Selecione a Tarefa</label>
                <select id="id_tarefa" name="id_tarefa" required>
                    <?php foreach ($tarefas as $tarefa): ?>
                        <option value="<?php echo $tarefa['id_tarefas']; ?>"><?php echo $tarefa['pendente']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">Associar</button>
        </form>
    </div>
</body>
</html>
