<?php
require_once 'ArbolBinario.php';

$arbolData = null;
$recorridos = ['pre' => [], 'in' => [], 'post' => []];
$inputs     = ['pre' => '', 'in' => '', 'post' => ''];
$error      = '';

function parsearRecorrido(string $input): array {
    return preg_split('/[\s,>→\-]+/u', trim($input), -1, PREG_SPLIT_NO_EMPTY);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs['pre']  = trim($_POST['preorden']  ?? '');
    $inputs['in']   = trim($_POST['inorden']   ?? '');
    $inputs['post'] = trim($_POST['postorden'] ?? '');

    $tienePre  = $inputs['pre']  !== '';
    $tieneIn   = $inputs['in']   !== '';
    $tienePost = $inputs['post'] !== '';

    $conteo = (int)$tienePre + (int)$tieneIn + (int)$tienePost;

    if ($conteo < 2) {
        $error = 'Debes ingresar al menos dos recorridos.';
    } elseif (!$tieneIn && !($tienePre && $tienePost)) {
        $error = 'Para reconstruir el árbol se necesita el recorrido Inorden más Preorden o Postorden.';
    } else {
        $pre  = $tienePre  ? parsearRecorrido($inputs['pre'])  : [];
        $in   = $tieneIn   ? parsearRecorrido($inputs['in'])   : [];
        $post = $tienePost ? parsearRecorrido($inputs['post']) : [];

        $arbol = new ArbolBinario();
        if ($tienePre && $tieneIn) {
            $arbol->construirDesdePreInorden($pre, $in);
        } else {
            $arbol->construirDesdePostInorden($post, $in);
        }

        $arbolData = $arbol->toArray();
        $recorridos = [
            'pre'  => $arbol->preorden(),
            'in'   => $arbol->inorden(),
            'post' => $arbol->postorden(),
        ];
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
    <div class="badge">APP 06</div>
    <h1>Árbol <span>Binario</span></h1>
    <p class="subtitle">Ingresa mínimo 2 recorridos. Usa letras o números separados por comas, espacios o →.</p>

    <form method="POST" action="">
        <div class="two-col">
            <div>
                <label for="preorden">Preorden</label>
                <input type="text" id="preorden" name="preorden"
                       placeholder="A, B, D, E, C"
                       value="<?= htmlspecialchars($inputs['pre']) ?>" autocomplete="off">
            </div>
            <div>
                <label for="inorden">Inorden</label>
                <input type="text" id="inorden" name="inorden"
                       placeholder="D, B, E, A, C"
                       value="<?= htmlspecialchars($inputs['in']) ?>" autocomplete="off">
            </div>
            <div class="full">
                <label for="postorden">Postorden</label>
                <input type="text" id="postorden" name="postorden"
                       placeholder="D, E, B, C, A"
                       value="<?= htmlspecialchars($inputs['post']) ?>" autocomplete="off">
            </div>
        </div>
        <button type="submit">Construir árbol →</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($arbolData !== null): ?>
        <div class="result-box">
            <div class="result-label">Árbol construido</div>
            <canvas id="treeCanvas" height="320"></canvas>

            <div style="margin-top:1rem">
                <div class="traversal-row">
                    <span class="t-label">Preorden</span>
                    <span class="t-value"><?= implode(' → ', array_map('htmlspecialchars', $recorridos['pre'])) ?></span>
                </div>
                <div class="traversal-row">
                    <span class="t-label">Inorden</span>
                    <span class="t-value"><?= implode(' → ', array_map('htmlspecialchars', $recorridos['in'])) ?></span>
                </div>
                <div class="traversal-row">
                    <span class="t-label">Postorden</span>
                    <span class="t-value"><?= implode(' → ', array_map('htmlspecialchars', $recorridos['post'])) ?></span>
                </div>
            </div>
        </div>

        <script>
        const TREE = <?= json_encode($arbolData) ?>;

        function getDepth(node) {
            if (!node) return 0;
            return 1 + Math.max(getDepth(node.izquierdo), getDepth(node.derecho));
        }

        function drawTree() {
            const canvas  = document.getElementById('treeCanvas');
            const depth   = getDepth(TREE);
            const H       = Math.max(200, depth * 80 + 40);
            canvas.height = H;
            const W  = canvas.offsetWidth;
            canvas.width = W;
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, W, H);

            const ACCENT = '#e8ff47';
            const MUTED  = '#666';
            const TEXT   = '#f0f0f0';
            const R      = 22;

            function draw(node, x, y, xOffset) {
                if (!node) return;
                if (node.izquierdo) {
                    const cx = x - xOffset, cy = y + 80;
                    ctx.beginPath();
                    ctx.moveTo(x, y + R);
                    ctx.lineTo(cx, cy - R);
                    ctx.strokeStyle = MUTED;
                    ctx.lineWidth   = 1.5;
                    ctx.stroke();
                    draw(node.izquierdo, cx, cy, xOffset / 2);
                }
                if (node.derecho) {
                    const cx = x + xOffset, cy = y + 80;
                    ctx.beginPath();
                    ctx.moveTo(x, y + R);
                    ctx.lineTo(cx, cy - R);
                    ctx.strokeStyle = MUTED;
                    ctx.lineWidth   = 1.5;
                    ctx.stroke();
                    draw(node.derecho, cx, cy, xOffset / 2);
                }
                ctx.beginPath();
                ctx.arc(x, y, R, 0, Math.PI * 2);
                ctx.fillStyle   = '#1a1a1a';
                ctx.strokeStyle = ACCENT;
                ctx.lineWidth   = 2;
                ctx.fill();
                ctx.stroke();

                ctx.fillStyle  = TEXT;
                ctx.font       = 'bold 14px Space Mono, monospace';
                ctx.textAlign  = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(node.valor, x, y);
            }

            draw(TREE, W / 2, 36, W / 4);
        }

        drawTree();
        window.addEventListener('resize', drawTree);
        </script>
    <?php endif; ?>
</div>

<a class="nav-back" href="../index.php">← Volver al menú principal</a>

</body>
</html>