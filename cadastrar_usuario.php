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

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Inserir usuário no banco de dados
    $stmt = $pdo->prepare("INSERT INTO tbl_usuario (nome_usu, email_usu) VALUES (?, ?)");
    $stmt->execute([$nome, $email]);

    echo "Usuário cadastrado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .navbar { background-color: #007bff; padding: 15px; display: flex; justify-content: flex-end; }
        .navbar button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .navbar button:hover { background-color: #0056b3; }
        .container { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: bold; }
        .form-group input { width: 25%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
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
        <h2>Cadastro de Usuários</h2>
        <form action="cadastrar_usuario.php" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </div>
</body>
</html>
