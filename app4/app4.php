<?php
require_once 'Conjunto.php';

$resultado = null;
$inputA    = '';
$inputB    = '';
$error     = '';

function parsearConjunto(string $input): ?array {
    $partes = preg_split('/[\s,;]+/', trim($input), -1, PREG_SPLIT_NO_EMPTY);
    $nums   = [];
    foreach ($partes as $p) {
        if (!preg_match('/^-?\d+$/', $p)) return null;
        $nums[] = (int)$p;
    }
    return $nums;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputA = trim($_POST['conjuntoA'] ?? '');
    $inputB = trim($_POST['conjuntoB'] ?? '');

    $numsA = parsearConjunto($inputA);
    $numsB = parsearConjunto($inputB);

    if ($numsA === null || count($numsA) === 0) {
        $error = 'El conjunto A debe contener números enteros válidos.';
    } elseif ($numsB === null || count($numsB) === 0) {
        $error = 'El conjunto B debe contener números enteros válidos.';
    } else {
        $A = new Conjunto($numsA);
        $B = new Conjunto($numsB);
        $resultado = [
            'A'            => $A,
            'B'            => $B,
            'union'        => $A->union($B),
            'interseccion' => $A->interseccion($B),
            'difAB'        => $A->diferencia($B),
            'difBA'        => $B->diferencia($A),
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones de Conjuntos</title>
    <link rel="stylesheet" href="../css/apps.css">
 
</head>
<body>

<div class="card" style="max-width:600px">
    <div class="badge">APP 04</div>
    <h1>Operaciones de <span>Conjuntos</span></h1>
    <p class="subtitle">Ingresa dos conjuntos de números enteros separados por comas.</p>

    <form method="POST" action="">
        <label for="conjuntoA">Conjunto A</label>
        <input type="text" id="conjuntoA" name="conjuntoA"
               placeholder="Ej: 1, 2, 3, 4, 5"
               value="<?= htmlspecialchars($inputA) ?>" autocomplete="off">

        <label for="conjuntoB">Conjunto B</label>
        <input type="text" id="conjuntoB" name="conjuntoB"
               placeholder="Ej: 3, 4, 5, 6, 7"
               value="<?= htmlspecialchars($inputB) ?>" autocomplete="off">

        <button type="submit">Calcular →</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($resultado !== null): ?>
        <div class="result-box" style="text-align:left">
            <div class="result-label" style="text-align:center;margin-bottom:0.8rem">Resultados</div>
            <div class="op-row">
                <span class="op-name">A</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['A']) ?></span>
            </div>
            <div class="op-row">
                <span class="op-name">B</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['B']) ?></span>
            </div>
            <div class="op-row">
                <span class="op-name">A ∪ B</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['union']) ?></span>
            </div>
            <div class="op-row">
                <span class="op-name">A ∩ B</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['interseccion']) ?></span>
            </div>
            <div class="op-row">
                <span class="op-name">A − B</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['difAB']) ?></span>
            </div>
            <div class="op-row">
                <span class="op-name">B − A</span>
                <span class="op-value"><?= htmlspecialchars((string)$resultado['difBA']) ?></span>
            </div>
        </div>
    <?php endif; ?>
</div>

<a class="nav-back" href="../index.php">← Volver al menú principal</a>

</body>
</html>