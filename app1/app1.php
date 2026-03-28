<?php
require_once 'Acronimo.php';
 
$resultado = null;
$frase = '';
$error = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
    if ($frase === '') {
        $error = 'Por favor ingresa una frase.';
    } else {
        $obj = new Acronimo($frase);
        $resultado = $obj->convertir();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Acrónimos</title>
    <link rel="stylesheet" href="../css/apps.css">
</head>
<body>
 
<div class="card">
    <div class="badge">APP 01</div>
    <h1>Conversor de <span>Acrónimos</span></h1>
    <p class="subtitle">Ingresa una frase y obtén su acrónimo al instante.</p>
 
    <form method="POST" action="">
        <label for="frase">Frase</label>
        <input
            type="text"
            id="frase"
            name="frase"
            placeholder="Ej: Portable Network Graphics"
            value="<?= htmlspecialchars($frase) ?>"
            autocomplete="off"
        >
        <button type="submit">Convertir →</button>
    </form>
 
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
 
    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultado</div>
            <div class="result-phrase">"<?= htmlspecialchars($frase) ?>"</div>
            <div class="result-acronym"><?= htmlspecialchars($resultado) ?></div>
        </div>
    <?php endif; ?>
</div>
 
<a class="nav-back" href="../menu.php">← Volver al menú principal</a>
 
</body>
</html>