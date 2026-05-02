<?php
require_once 'secuencia.php';

$serie     = [];
$resultado = null;
$operacion = '';
$numero    = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero    = trim($_POST['numero'] ?? '');
    $operacion = trim($_POST['operacion'] ?? '');

    if ($numero === '' || !is_numeric($numero) || intval($numero) < 0) {
        $error = 'Ingresa un numero entero positivo valido.';
    } elseif ($operacion === '') {
        $error = 'Selecciona una operacion.';
    } else {
        $calc = new Secuencia(intval($numero));

        if ($operacion === 'fibonacci') {
            $serie = $calc->fibonacci();
        } else {
            $resultado = $calc->factorial();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci y Factorial</title>
    <link rel="stylesheet" href="../css/apps.css">
</head>
<body>

<div class="card">
    <div class="badge">App #2</div>
    <h1>Fibonacci y <span>Factorial</span></h1>
    <p class="subtitle">Ingresa un número y selecciona la operación.</p>

    <form method="POST" action="">
        <label for="numero">Número</label>
        <input type="number" id="numero" name="numero"
            min="0" placeholder="Ej: 10"
            value="<?= htmlspecialchars($numero) ?>">

        <label for="operacion">Operación</label>
        <select id="operacion" name="operacion">
            <option value="" disabled <?= $operacion === '' ? 'selected' : '' ?>>Selecciona...</option>
            <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
            <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Factorial</option>
        </select>

        <button type="submit">Calcular</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($operacion === 'fibonacci' && !empty($serie)): ?>
        <div class="result-box">
            <div class="result-label">Serie de Fibonacci (<?= count($serie) ?> terminos)</div>
            <div class="result-value"><?= implode(' → ', $serie) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($operacion === 'factorial' && $resultado !== null): ?>
        <div class="result-box">
            <div class="result-label"><?= htmlspecialchars($numero) ?>! =</div>
            <div class="result-value"><?= htmlspecialchars($resultado) ?></div>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php">Volver al menú</a>

</body>
</html>