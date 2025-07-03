<?php
// api/girar_roleta.php

// Inicia a sessão e inclui a conexão com o banco.
// A sessão já é iniciada dentro de db.php de forma segura.
include '../includes/db.php'; 

header('Content-Type: application/json');

// Resposta padrão de erro
$response = ['success' => false, 'error' => 'Ocorreu um erro inesperado.'];

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Usuário não autenticado. Por favor, faça o login novamente.';
    echo json_encode($response);
    exit();
}

$userId = $_SESSION['user_id'];
$hoje = date('Y-m-d');

// 2. Verificar se o usuário já girou hoje
// Usando DATE() na coluna data_giro (que é um timestamp) para comparar apenas a data.
$stmt = $pdo->prepare("SELECT id FROM historico_giros WHERE usuario_id = ? AND DATE(data_giro) = ?");
$stmt->execute([$userId, $hoje]);
if ($stmt->fetch()) {
    $response['error'] = 'Você já girou a roleta hoje. Volte amanhã!';
    echo json_encode($response);
    exit();
}

// ------------------- INÍCIO DA CORREÇÃO -------------------

// 3. Sortear um prêmio usando SORTEIO PONDERADO
// Buscamos todos os prêmios disponíveis, incluindo a coluna 'chance'.
$stmt_premios = $pdo->query("SELECT id, nome, chance FROM premios");
$premios = $stmt_premios->fetchAll(PDO::FETCH_ASSOC);

if (empty($premios)) {
    $response['error'] = 'Não há prêmios cadastrados para sortear.';
    echo json_encode($response);
    exit();
}

// Criar a "piscina de sorteio" ponderada
$piscinaSorteio = [];
foreach ($premios as $premio) {
    // Para cada prêmio, adiciona seu ID na piscina um número de vezes igual à sua 'chance'
    for ($i = 0; $i < $premio['chance']; $i++) {
        $piscinaSorteio[] = $premio;
    }
}

// Se a piscina estiver vazia (todos os prêmios com chance 0), evitamos um erro.
if (empty($piscinaSorteio)) {
    $response['error'] = 'Nenhum prêmio disponível para sorteio (verifique as chances).';
    echo json_encode($response);
    exit();
}


// Sortear um item aleatório da piscina ponderada
$premioSorteado = $piscinaSorteio[array_rand($piscinaSorteio)];

// ------------------- FIM DA CORREÇÃO -------------------

$premioId = $premioSorteado['id'];
$premioNome = $premioSorteado['nome'];

// 4. Salvar o resultado no banco de dados
try {
    // Usamos NOW() para inserir o timestamp atual.
    $stmt_insert = $pdo->prepare("INSERT INTO historico_giros (usuario_id, premio_id, data_giro) VALUES (?, ?, NOW())");
    $stmt_insert->execute([$userId, $premioId]);
    
    // 5. Se tudo deu certo, retornar o nome do prêmio para a animação do JavaScript
    $response = [
        'success' => true,
        'premio_nome' => $premioNome
    ];

} catch (PDOException $e) {
    // Em produção, é bom logar o erro em vez de exibi-lo
    // error_log("Erro no sorteio: " . $e->getMessage());
    $response['error'] = 'Erro ao salvar o seu prêmio no banco de dados.';
}

echo json_encode($response);
?>