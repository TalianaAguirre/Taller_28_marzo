<?php
require_once 'Binario.php';

$resultado = null;
$pasos     = [];
$numero    = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = trim($_POST['numero'] ?? '');
    if (!preg_match('/^-?\d+$/', $raw)) {
        $error = 'Por favor ingresa un número entero válido.';
    } else {
        $numero = (int)$raw;
        $obj       = new Binario($numero);
        $resultado = $obj->convertir();
        $pasos     = $obj->getPasos();
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
    <div class="badge">APP 05</div>
    <h1>Conversor a <span>Binario</span></h1>
    <p class="subtitle">Convierte un número entero a su representación en binario.</p>

    <form method="POST" action="">
        <label for="numero">Número entero</label>
        <input type="number" id="numero" name="numero"
               placeholder="Ej: 42"
               value="<?= htmlspecialchars((string)$numero) ?>"
               autocomplete="off">
        <button type="submit">Convertir →</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label"><?= htmlspecialchars((string)$numero) ?> en binario</div>
            <div class="result-acronym"><?= htmlspecialchars($resultado) ?></div>

            <?php if (!empty($pasos)): ?>
                <table class="steps-table">
                    <thead>
                        <tr>
                            <th>Dividendo</th>
                            <th>Cociente</th>
                            <th>Residuo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pasos as $p): ?>
                            <tr>
                                <td><?= $p['dividendo'] ?></td>
                                <td><?= $p['cociente'] ?></td>
                                <td class="<?= $p['residuo'] === 1 ? 'residuo-1' : '' ?>">
                                    <?= $p['residuo'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<a class="nav-back" href="../index.php">← Volver al menú principal</a>

</body>
</html>