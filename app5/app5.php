<?php
require_once 'Binario.php';

$resultado = null;
$numero    = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');

    if ($numero === '' || !is_numeric($numero) || intval($numero) < 0) {
        $error = 'Ingresa un número entero positivo .';
    } else {
        $obj       = new Binario(intval($numero));
        $resultado = $obj->convertir();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor a Binario</title>
    <link rel="stylesheet" href="../css/apps.css">
</head>
<body>

<div class="card">
    <div class="badge">App #5</div>
    <h1>Conversor a <span>Binario</span></h1>
    <p class="subtitle">Ingresa un número entero y obtén su representación en binario.</p>

    <form method="POST" action="">
        <label for="numero">Número entero</label>
        <input type="number" id="numero" name="numero"
            min="0" placeholder="Ej: 25"
            value="<?= htmlspecialchars($numero) ?>">
        <button type="submit">Convertir</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label"><?= htmlspecialchars($numero) ?> en binario</div>
            <div class="result-value"><?= htmlspecialchars($resultado) ?></div>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php"> Volver al menú</a>

</body>
</html>