<?php
session_start(); // Inicia a sessão

// Configuração da conexão com o banco de dados
$host = 'localhost';
$dbname = 'educacional';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Processamento do cadastro (quando o formulário for enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);
    $confirma_senha = trim($_POST['confirma_senha']);
    $endereco = trim($_POST['endereco']);
    $tipo = trim($_POST['tipo']);

    // Verificar se as senhas coincidem
    if ($senha !== $confirma_senha) {
        $_SESSION['erro_cadastro'] = 'As senhas não coincidem.';
        header("Location: cadastro.php");
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar SQL para inserir o novo usuário
    $sql = "INSERT INTO usuarios (login, senha, nome, endereco, tipo) 
            VALUES (:usuario, :senha, :nome, :endereco, :tipo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':senha', $senha_hash);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':tipo', $tipo);

    try {
        $stmt->execute();
        $_SESSION['sucesso_cadastro'] = 'Cadastro realizado com sucesso!';
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erro_cadastro'] = 'Erro ao cadastrar usuário: ' . $e->getMessage();
        header("Location: cadastro.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro - Website Educacional</title>
</head>
<body>
    <header>
        <h1>Cadastro de Usuário</h1>
    </header>
    <main>
        <form action="cadastro.php" method="POST">
            <div class="input-field">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" required>
            </div>
            <div class="input-field">
                <label for="usuario">Login:</label>
                <input type="text" name="usuario" id="usuario" required>
            </div>
            <div class="input-field">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
            </div>
            <div class="input-field">
                <label for="confirma_senha">Confirme a Senha:</label>
                <input type="password" name="confirma_senha" id="confirma_senha" required>
            </div>
            <div class="input-field">
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco">
            </div>
            <div class="input-field">
                <label for="tipo">Tipo:</label>
                <select name="tipo" id="tipo" required>
                    <option value="usuario">Usuário</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
        <?php if (isset($_SESSION['erro_cadastro'])): ?>
            <p><?php echo $_SESSION['erro_cadastro']; unset($_SESSION['erro_cadastro']); ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
