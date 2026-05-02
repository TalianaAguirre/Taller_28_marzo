<?php
$fila1 = [
    ['num' => 'App #1', 'titulo' => 'Conversor de Acronimos',  'desc' => 'Convierte cualquier frase en su acrónimo usando espacios y guiones como separadores.', 'ruta' => 'app1/app1.php'],
    ['num' => 'App #2', 'titulo' => 'Fibonacci y Factorial',    'desc' => 'Calcula la sucesión de Fibonacci o el factorial de un número .',                    'ruta' => 'app2/app2.php'],
    ['num' => 'App #3', 'titulo' => 'Promedio, Media y Moda',   'desc' => 'Calcula el promedio, la media y la moda de una serie de números reales.',               'ruta' => 'app3/app3.php'],
    ['num' => 'App #4', 'titulo' => 'Operaciones de Conjuntos', 'desc' => 'Unión, intersección y diferencias entre dos conjuntos A y B.',                          'ruta' => 'app4/app4.php'],
];

$fila2 = [
    ['num' => 'App #5', 'titulo' => 'Conversor a Binario', 'desc' => 'Convierte un número entero a su representación en sistema binario.',              'ruta' => 'app5/app5.php'],
    ['num' => 'App #6', 'titulo' => 'Arbol Binario',       'desc' => 'Construye un árbol binario desde sus recorridos preorden, inorden y postorden.', 'ruta' => 'app6/app6.php'],
    ['num' => 'App #7', 'titulo' => 'Calculadora',         'desc' => 'Calculadora con operaciones básicas e historial de operaciones.',                 'ruta' => 'app7/app7.php'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<nav>
    <span class="nav-title">Taller PHP</span>
</nav>

<div class="wrapper">
    <header>
        <h1>Menú Principal</h1>
        <p>Selecciona una aplicación para continuar</p>
    </header>
   

    <main>
      
        <div class="fila4">
            <?php foreach ($fila1 as $app): ?>
                <a href="<?= htmlspecialchars($app['ruta']) ?>" class="tarjeta">
                    <span class="app-number"><?= $app['num'] ?></span>
                    <div class="app-title"><?= htmlspecialchars($app['titulo']) ?></div>
                    <div class="app-desc"><?= htmlspecialchars($app['desc']) ?></div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="fila3">
            <?php foreach ($fila2 as $app): ?>
                <a href="<?= htmlspecialchars($app['ruta']) ?>" class="tarjeta">
                    <span class="app-number"><?= $app['num'] ?></span>
                    <div class="app-title"><?= htmlspecialchars($app['titulo']) ?></div>
                    <div class="app-desc"><?= htmlspecialchars($app['desc']) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>Taller PHP</p>
    </footer>
</div>

</body>
</html>