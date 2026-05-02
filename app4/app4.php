<?php
require_once 'Conjunto.php';

$union        = null;
$interseccion = null;
$difAB        = null;
$difBA        = null;
$inputA       = '';
$inputB       = '';
$error        = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputA = trim($_POST['conjuntoA'] ?? '');
    $inputB = trim($_POST['conjuntoB'] ?? '');

    if ($inputA === '' || $inputB === '') {
        $error = 'Ingresa ambos conjuntos.';
    } else {
        $partesA = preg_split('/[\s,;]+/', $inputA, -1, PREG_SPLIT_NO_EMPTY);
        $partesB = preg_split('/[\s,;]+/', $inputB, -1, PREG_SPLIT_NO_EMPTY);

        $listaA = [];
        $listaB = [];

        foreach ($partesA as $p) {
            if (!is_numeric($p)) { $error = "\"$p\" no es un entero valido en A."; break; }
            $listaA[] = (int)$p;
        }

        if ($error === '') {
            foreach ($partesB as $p) {
                if (!is_numeric($p)) { $error = "\"$p\" no es un entero valido en B."; break; }
                $listaB[] = (int)$p;
            }
        }

        if ($error === '') {
            $conj         = new Conjunto($listaA, $listaB);
            $union        = $conj->union();
            $interseccion = $conj->interseccion();
            $difAB        = $conj->diferenciaAB();
            $difBA        = $conj->diferenciaBA();
        }
    }
}

function formatSet(array $arr): string {
    if (empty($arr)) return '{ }';
    return '{ ' . implode(', ', $arr) . ' }';
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

<div class="card">
    <div class="badge">App #4</div>
    <h1>Operaciones de <span>Conjuntos</span></h1>
    <p class="subtitle">Ingresa los elementos de cada conjunto separados por coma o espacio.</p>

    <form method="POST" action="">
        <label for="conjuntoA">Conjunto A</label>
        <input type="text" id="conjuntoA" name="conjuntoA"
            placeholder="Ej: 1, 2, 3, 4"
            value="<?= htmlspecialchars($inputA) ?>"
            autocomplete="off">

        <label for="conjuntoB">Conjunto B</label>
        <input type="text" id="conjuntoB" name="conjuntoB"
            placeholder="Ej: 3, 4, 5, 6"
            value="<?= htmlspecialchars($inputB) ?>"
            autocomplete="off">

        <button type="submit">Calcular</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($union !== null): ?>
        <div class="result-box">
            <div class="result-label">Resultados</div>
            <table class="result-table">
                <tr>
                    <td>A</td>
                    <td><?= formatSet($conj->getA()) ?></td>
                </tr>
                <tr>
                    <td>B</td>
                    <td><?= formatSet($conj->getB()) ?></td>
                </tr>
                <tr>
                    <td>A &cup; B (Union)</td>
                    <td><?= formatSet($union) ?></td>
                </tr>
                <tr>
                    <td>A &cap; B (Interseccion)</td>
                    <td><?= formatSet($interseccion) ?></td>
                </tr>
                <tr>
                    <td>A &minus; B</td>
                    <td><?= formatSet($difAB) ?></td>
                </tr>
                <tr>
                    <td>B &minus; A</td>
                    <td><?= formatSet($difBA) ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php">Volver al menú</a>

</body>
</html>