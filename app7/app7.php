<?php
session_start();
require_once 'Calculadora.php';

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

$resultado  = null;
$expresion  = '';
$a          = '';
$b          = '';
$operacion  = '+';
$error      = '';


if (isset($_POST['borrar_historial'])) {
    $_SESSION['historial'] = [];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['borrar_historial'])) {
    $rawA      = trim($_POST['a']         ?? '');
    $rawB      = trim($_POST['b']         ?? '');
    $operacion = $_POST['operacion']      ?? '+';

    if (!is_numeric($rawA) || !is_numeric($rawB)) {
        $error = 'Por favor ingresa dos números válidos.';
    } else {
        $a   = (float)$rawA;
        $b   = (float)$rawB;
        $calc = new Calculadora($a, $b, $operacion);
        $res  = $calc->calcular();

        if (is_string($res)) {
            $error = $res;
        } else {
            $resultado = $res;
            $expresion = $calc->getExpresion();
            $fmtRes    = $calc->formatNumero($res);
            array_unshift($_SESSION['historial'], [
                'expr'   => $expresion,
                'result' => $fmtRes,
            ]);
            if (count($_SESSION['historial']) > 20) {
                array_pop($_SESSION['historial']);
            }
        }
    }
}

function fmtNum(float $n): string {
    return rtrim(rtrim(number_format($n, 10, '.', ''), '0'), '.');
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
    <div class="badge">APP 07</div>
    <h1><span>Calculadora</span></h1>
    <p class="subtitle">Operaciones básicas con historial.</p>

    <form method="POST" action="" id="calcForm">
        <div class="two-col">
            <div>
                <label for="a">Número A</label>
                <input type="text" id="a" name="a"
                       placeholder="Ej: 12.5"
                       value="<?= htmlspecialchars((string)$a) ?>" autocomplete="off">
            </div>
            <div>
                <label for="b">Número B</label>
                <input type="text" id="b" name="b"
                       placeholder="Ej: 4"
                       value="<?= htmlspecialchars((string)$b) ?>" autocomplete="off">
            </div>
        </div>

        <label>Operación</label>
        <input type="hidden" name="operacion" id="operacionHidden" value="<?= htmlspecialchars($operacion) ?>">
        <div class="ops-grid">
            <?php foreach (['+', '-', '*', '/', '%'] as $op): ?>
                <button type="button" class="op-btn <?= $operacion === $op ? 'selected' : '' ?>"
                        data-op="<?= $op ?>"><?= htmlspecialchars($op) ?></button>
            <?php endforeach; ?>
        </div>

        <button type="submit">Calcular →</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultado</div>
            <div class="result-phrase"><?= htmlspecialchars($expresion) ?></div>
            <div class="result-value"><?= htmlspecialchars(fmtNum($resultado)) ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['historial'])): ?>
        <div style="margin-top:1.5rem">
            <div class="result-label">Historial</div>
            <ul class="hist-list">
                <?php foreach ($_SESSION['historial'] as $item): ?>
                    <li class="hist-item">
                        <span class="hist-expr"><?= htmlspecialchars($item['expr']) ?> =</span>
                        <span class="hist-result"><?= htmlspecialchars($item['result']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form method="POST" action="">
                <button type="submit" name="borrar_historial" class="btn-clear">✕ Borrar historial</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<a class="nav-back" href="../index.php">← Volver al menú principal</a>

<script>
document.querySelectorAll('.op-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.op-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        document.getElementById('operacionHidden').value = btn.dataset.op;
    });
});
</script>

</body>
</html>