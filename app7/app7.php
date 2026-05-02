<?php
require_once 'Calculadora.php';

session_start();

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

$resultado  = null;
$num1       = '';
$num2       = '';
$operacion  = '';
$error      = '';

if (isset($_POST['borrar_historial'])) {
    $_SESSION['historial'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
    $num1      = trim($_POST['num1']      ?? '');
    $num2      = trim($_POST['num2']      ?? '');
    $operacion = trim($_POST['operacion'] ?? '');

    if (!is_numeric($num1) || !is_numeric($num2)) {
        $error = 'Ingresa numeros validos.';
    } elseif ($operacion === '') {
        $error = 'Selecciona una operacion.';
    } else {
        $calc = new Calculadora((float)$num1, (float)$num2);

        switch ($operacion) {
            case 'suma':
                $resultado = $calc->sumar();
                $simbolo   = '+';
                break;
            case 'resta':
                $resultado = $calc->restar();
                $simbolo   = '-';
                break;
            case 'mult':
                $resultado = $calc->multiplicar();
                $simbolo   = 'x';
                break;
            case 'div':
                $resultado = $calc->dividir();
                $simbolo   = '/';
                if ($resultado === null) {
                    $error = 'No se puede dividir entre cero.';
                }
                break;
            case 'porcent':
                $resultado = $calc->porcentaje();
                $simbolo   = '%';
                break;
        }

        if ($error === '' && $resultado !== null) {
            $_SESSION['historial'][] = "$num1 $simbolo $num2 = $resultado";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="../css/apps.css">
</head>
<body>

<div class="card">
    <div class="badge">App #7</div>
    <h1>Calcula<span>dora</span></h1>
    <p class="subtitle">Operaciones básicas con historial.</p>

    <form method="POST" action="">
        <label for="num1">Número 1</label>
        <input type="number" id="num1" name="num1"
            step="any" placeholder="Ej: 10"
            value="<?= htmlspecialchars($num1) ?>">

        <label for="operacion">Operación</label>
        <select id="operacion" name="operacion">
            <option value="" disabled <?= $operacion === '' ? 'selected' : '' ?>>Selecciona...</option>
            <option value="suma"           <?= $operacion === 'suma'           ? 'selected' : '' ?>>Suma (+)</option>
            <option value="resta"          <?= $operacion === 'resta'          ? 'selected' : '' ?>>Resta (-)</option>
            <option value="mult"           <?= $operacion === 'mult'           ? 'selected' : '' ?>>Multiplicación (x)</option>
            <option value="div"            <?= $operacion === 'div'            ? 'selected' : '' ?>>División (/)</option>
            <option value="porcent"        <?= $operacion === 'porcent'        ? 'selected' : '' ?>>Porcentaje (%)</option>
        </select>

        <label for="num2">Número 2</label>
        <input type="number" id="num2" name="num2"
            step="any" placeholder="Ej: 5"
            value="<?= htmlspecialchars($num2) ?>">

        <button type="submit" name="calcular">Calcular</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultado</div>
            <div class="result-value"><?= $resultado ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['historial'])): ?>
        <div class="result-box">
            <div class="result-label">Historial</div>
            <?php foreach (array_reverse($_SESSION['historial']) as $item): ?>
                <p><?= htmlspecialchars($item) ?></p>
            <?php endforeach; ?>

            <form method="POST" action="" style="margin-top: 1rem;">
                <button type="submit" name="borrar_historial">Borrar historial</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php">Volver al menú</a>

</body>
</html>