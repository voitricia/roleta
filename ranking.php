<?php
include 'includes/db.php';

// --- QUERY ATUALIZADA para buscar a foto_perfil ---
$stmt_ranking = $pdo->query("
    SELECT 
        u.nome AS nome_usuario, 
        u.foto_perfil,
        SUM(p.pontos) AS score_total
    FROM 
        historico_giros h
    JOIN 
        usuarios u ON h.usuario_id = u.id
    JOIN 
        premios p ON h.premio_id = p.id
    GROUP BY 
        h.usuario_id, u.nome, u.foto_perfil
    HAVING 
        score_total > 0
    ORDER BY 
        score_total DESC
");
$ranking = $stmt_ranking->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>
<div class="container" style="max-width: 800px;">
    <h2>🏆 Ranking de Jogadores</h2>
    <p>Veja os jogadores com as maiores pontuações!</p>
    <?php if (empty($ranking)): ?>
        <p>Ainda não há jogadores com pontuação.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">#</th>
                    <th>Jogador</th>
                    <th style="text-align: right;">Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ranking as $posicao => $jogador): ?>
                <tr>
                    <td style="text-align: center; font-weight: bold; font-size: 1.2em;"><?= $posicao + 1 ?></td>
                    <td>
                        <div class="ranking-user-cell">
                            <?php if ($jogador['foto_perfil']): ?>
                                <img src="/projeto_roleta/uploads/fotos_perfil/<?= htmlspecialchars($jogador['foto_perfil']) ?>" alt="Foto de <?= htmlspecialchars($jogador['nome_usuario']) ?>" class="ranking-pic">
                            <?php else: ?>
                                <div class="ranking-pic-placeholder"></div>
                            <?php endif; ?>
                            <span><?= htmlspecialchars($jogador['nome_usuario']) ?></span>
                        </div>
                    </td>
                    <td style="text-align: right; font-weight: bold; color: var(--cor-secundaria-neon);"><?= $jogador['score_total'] ?> Pontos</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>