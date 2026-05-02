<?php
require_once 'Estadistica.php';

$promedio  = null;
$media     = null;
$moda      = null;
$numeros   = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeros = trim($_POST['numeros'] ?? '');

    if ($numeros === '') {
        $error = 'Por favor ingresa al menos un numero.';
    } else {
        $partes = preg_split('/[\s,;]+/', $numeros, -1, PREG_SPLIT_NO_EMPTY);
        $lista  = [];

        foreach ($partes as $p) {
            if (!is_numeric($p)) {
                $error = "El valor \"$p\" no es un numero valido.";
                break;
            }
            $lista[] = (float)$p;
        }

        if ($error === '' && count($lista) < 1) {
            $error = 'Ingresa al menos un numero.';
        }

        if ($error === '') {
            $est      = new Estadistica($lista);
            $promedio = $est->promedio();
            $media    = $est->media();
            $moda     = $est->moda();
        }
    }
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
    <div class="badge">App #3</div>
    <h1>Promedio, Media y <span>Moda</span></h1>
    <p class="subtitle">Ingresa los números separados por coma o espacio.</p>

    <form method="POST" action="">
        <label for="numeros">Números</label>
        <input type="text" id="numeros" name="numeros"
            placeholder="Ej: 4, 7, 2, 9, 7, 3"
            value="<?= htmlspecialchars($numeros) ?>"
            autocomplete="off">
        <button type="submit">Calcular</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($promedio !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultados</div>

            <table class="result-table">
                <tr>
                    <td>Promedio</td>
                    <td><?= round($promedio, 4) ?></td>
                </tr>
                <tr>
                    <td>Media (Mediana)</td>
                    <td><?= round($media, 4) ?></td>
                </tr>
                <tr>
                    <td>Moda</td>
                    <td>
                        <?php if (empty($moda)): ?>
                            Sin moda (todos los valores son distintos)
                        <?php else: ?>
                            <?= implode(', ', $moda) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php">Volver al menú</a>

</body>
</html>