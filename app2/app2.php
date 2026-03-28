<?php
require_once 'Secuencia.php';
 
$resultado  = null;
$numero     = '';
$operacion  = 'fibonacci';
$error      = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw       = trim($_POST['numero'] ?? '');
    $operacion = $_POST['operacion'] ?? 'fibonacci';
    if ($raw === '' || !ctype_digit($raw)) {
        $error = 'Por favor ingresa un número entero positivo.';
    } else {
        $numero = (int)$raw;
        if ($numero < 0 || $numero > 80) {
            $error = 'Ingresa un número entre 0 y 80.';
        } else {
            $obj       = new Secuencia($numero, $operacion);
            $resultado = $obj->calcular();
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
    <div class="badge">APP 02</div>
    <h1>Fibonacci y <span>Factorial</span></h1>
    <p class="subtitle">Genera la serie según la operación elegida.</p>
 
    <form method="POST" action="">
        <label for="numero">Número</label>
        <input type="number" id="numero" name="numero" min="0" max="80"
               placeholder="Ej: 10"
               value="<?= htmlspecialchars((string)$numero) ?>"
               autocomplete="off">
 
        <label for="operacion">Operación</label>
        <select id="operacion" name="operacion">
            <option value="fibonacci" <?= $operacion === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
            <option value="factorial" <?= $operacion === 'factorial' ? 'selected' : '' ?>>Factorial</option>
        </select>
 
        <button type="submit">Calcular →</button>
    </form>
 
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
 
    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label">
                <?= $operacion === 'fibonacci' ? "Fibonacci de $numero términos" : "Factorial de $numero" ?>
            </div>
            <?php if (empty($resultado)): ?>
                <div class="result-value">—</div>
            <?php else: ?>
                <div class="serie">
                    <?php foreach ($resultado as $i => $val): ?>
                        <span class="serie-item <?= $i === array_key_last($resultado) ? 'last' : '' ?>">
                            <?= number_format($val, 0, '.', '') ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <div class="result-value" style="margin-top:1rem">
                    <?= number_format(end($resultado), 0, '.', '') ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
 
<a class="nav-back" href="../index.php">← Volver al menú principal</a>
 
</body>
</html>