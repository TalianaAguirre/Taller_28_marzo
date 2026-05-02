<?php
require_once 'ArbolBinario.php';

$arbolHTML  = null;
$preRes     = [];
$inRes      = [];
$postRes    = [];
$error      = '';

$preInput   = '';
$inInput    = '';
$postInput  = '';

function parsearRecorrido(string $input): array {
    $limpio = preg_replace('/[-–—>→]+/', ' ', $input);
    $partes = preg_split('/[\s,;]+/', trim($limpio), -1, PREG_SPLIT_NO_EMPTY);
    return array_map('strtoupper', $partes);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preInput  = trim($_POST['preorden']  ?? '');
    $inInput   = trim($_POST['inorden']   ?? '');
    $postInput = trim($_POST['postorden'] ?? '');

    $tienesPre  = $preInput  !== '';
    $tienesIn   = $inInput   !== '';
    $tienesPost = $postInput !== '';

    $cantidad = (int)$tienesPre + (int)$tienesIn + (int)$tienesPost;

    if ($cantidad < 2) {
        $error = 'Debes ingresar al menos dos recorridos.';
    } elseif (!$tienesIn) {
        $error = 'El recorrido inorden es obligatorio para construir el arbol.';
    } else {
        $pre  = $tienesPre  ? parsearRecorrido($preInput)  : [];
        $in   = parsearRecorrido($inInput);
        $post = $tienesPost ? parsearRecorrido($postInput) : [];

        $referencia = $in;
        sort($referencia);

        if ($tienesPre) {
            $copia = $pre; sort($copia);
            if ($copia !== $referencia) $error = 'Los nodos del preorden y el inorden no coinciden.';
        }
        if ($error === '' && $tienesPost) {
            $copia = $post; sort($copia);
            if ($copia !== $referencia) $error = 'Los nodos del postorden y el inorden no coinciden.';
        }

        if ($error === '') {
            $arbol = new ArbolBinario();

            if ($tienesPre) {
                $arbol->construirDesdePreInorden($pre, $in);
            } else {
                $arbol->construirDesdePostInorden($post, $in);
            }

            $arbolHTML = $arbol->generarHTML();
            $preRes    = $arbol->preorden();
            $inRes     = $arbol->inorden();
            $postRes   = $arbol->postorden();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="../css/apps.css">
</head>
<body>

<div class="card">
    <div class="badge">App #6</div>
    <h1>Arbol <span>Binario</span></h1>
    <p class="subtitle">Ingresa al menos dos recorridos. El inorden es obligatorio.</p>

    <form method="POST" action="">
        <label for="preorden">Preorden (opcional)</label>
        <input type="text" id="preorden" name="preorden"
            placeholder="Ej: A, B, D, E, C"
            value="<?= htmlspecialchars($preInput) ?>"
            autocomplete="off">

        <label for="inorden">Inorden (obligatorio)</label>
        <input type="text" id="inorden" name="inorden"
            placeholder="Ej: D, B, E, A, C"
            value="<?= htmlspecialchars($inInput) ?>"
            autocomplete="off">

        <label for="postorden">Postorden (opcional)</label>
        <input type="text" id="postorden" name="postorden"
            placeholder="Ej: D, E, B, C, A"
            value="<?= htmlspecialchars($postInput) ?>"
            autocomplete="off">

        <button type="submit">Construir árbol</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($arbolHTML !== null): ?>
        <div class="result-box">
            <div class="result-label">Árbol construido</div>
            <?= $arbolHTML ?>
        </div>

        <div class="result-box">
            <div class="result-label">Recorridos</div>
            <p>Preorden: <?= implode(' - ', $preRes) ?></p>
            <p>Inorden: <?= implode(' - ', $inRes) ?></p>
            <p>Postorden: <?= implode(' - ', $postRes) ?></p>
        </div>
    <?php endif; ?>
</div>

<a class="nav" href="../index.php">Volver al menú</a>

</body>
</html>