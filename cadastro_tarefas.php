<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'tarefas'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Buscar os usuários cadastrados
$stmt = $pdo->prepare("SELECT id_usu, nome_usu FROM tbl_usuario");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inserir tarefa no banco
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $usuario = $_POST['usuario'];
    $prioridade = $_POST['prioridade'];

    // Inserir a tarefa
    $stmt = $pdo->prepare("INSERT INTO tbl_tarefas (pendente, feita, andamento, id_usu) VALUES (?, ?, ?, ?)");
    $stmt->execute([$descricao, $setor, $prioridade, $usuario]);

    echo "<p>Tarefa cadastrada com sucesso!</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefas</title>
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
            display: block;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group select {
            width: 25%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        h2 {
            color: #333;
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
        <h2>Cadastro de Tarefas</h2>
        <form action="cadastro_tarefas.php" method="post">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" required>
            </div>
            <div class="form-group">
                <label for="setor">Setor</label>
                <input type="text" id="setor" name="setor" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <select id="usuario" name="usuario">
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id_usu']; ?>"><?php echo $usuario['nome_usu']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prioridade">Prioridade</label>
                <select id="prioridade" name="prioridade">
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </div>
</body>
</html>
