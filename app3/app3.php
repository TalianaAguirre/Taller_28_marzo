<?php
require_once 'Estadistica.php';

$resultado = null;
$input     = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['numeros'] ?? '');
    $partes = preg_split('/[\s,;]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
    $numeros = [];
    $valido  = true;
    foreach ($partes as $p) {
        if (!is_numeric($p)) { $valido = false; break; }
        $numeros[] = (float)$p;
    }
    if (!$valido || count($numeros) < 2) {
        $error = 'Ingresa al menos 2 números reales separados por comas o espacios.';
    } else {
        $obj       = new Estadistica($numeros);
        $resultado = [
            'promedio' => $obj->promedio(),
            'media'    => $obj->media(),
            'moda'     => $obj->moda(),
        ];
    }
}

function fmt(float $n): string {
    return rtrim(rtrim(number_format($n, 4, '.', ''), '0'), '.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promedio, Media y Moda</title>
    <link rel="stylesheet" href="../css/apps.css">
    
</head>
<body>

<div class="card">
    <div class="badge">APP 03</div>
    <h1>Promedio, Media <span>y Moda</span></h1>
    <p class="subtitle">Ingresa una serie de números reales separados por comas o espacios.</p>

    <form method="POST" action="">
        <label for="numeros">Números</label>
        <textarea id="numeros" name="numeros"
                  placeholder="Ej: 4, 7, 2, 9, 4, 1, 7, 4"><?= htmlspecialchars($input) ?></textarea>
        <button type="submit">Calcular →</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultados</div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-label">Promedio</div>
                    <div class="stat-value"><?= fmt($resultado['promedio']) ?></div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Mediana</div>
                    <div class="stat-value"><?= fmt($resultado['media']) ?></div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Moda</div>
                    <div class="stat-value">
                        <?php if (empty($resultado['moda'])): ?>
                            <span style="font-size:0.9rem;color:var(--muted)">Sin moda</span>
                        <?php else: ?>
                            <?= implode(', ', array_map('fmt', $resultado['moda'])) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<a class="nav-back" href="../index.php">← Volver al menú principal</a>

</body>
</html>