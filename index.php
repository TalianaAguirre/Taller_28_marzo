<?php
$apps = [
    ['numero' => 'APP 01', 'titulo' => 'Conversor de Acronimos',  'desc' => 'Convierte cualquier frase en su acronimo usando los espacios y guiones como separadores.', 'ruta' => 'app1/app1.php'],
    ['numero' => 'APP 02', 'titulo' => 'Fibonacci y Factorial',    'desc' => 'Calcula la sucesion de Fibonacci o el factorial de un numero dado.',                         'ruta' => 'app2/app2.php'],
    ['numero' => 'APP 03', 'titulo' => 'Promedio, Media y Moda',   'desc' => 'Calcula el promedio, la media y la moda de una serie de numeros reales.',                      'ruta' => 'app3/app3.php'],
    ['numero' => 'APP 04', 'titulo' => 'Operaciones de Conjuntos', 'desc' => 'Union, interseccion y diferencias entre dos conjuntos A y B ingresados por el usuario.',       'ruta' => 'app4/app4.php'],
    ['numero' => 'APP 05', 'titulo' => 'Conversor a Binario',      'desc' => 'Convierte un numero entero a su representacion en sistema binario.',                           'ruta' => 'app5/app5.php'],
    ['numero' => 'APP 06', 'titulo' => 'Arbol Binario',            'desc' => 'Construye un arbol binario desde sus recorridos preorden, inorden y postorden.',               'ruta' => 'app6/app6.php'],
    ['numero' => 'APP 07', 'titulo' => 'Calculadora',              'desc' => 'Calculadora con operaciones basicas e historial de operaciones.',                               'ruta' => 'app7/app7.php'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller PHP - Menu Principal</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<nav>
    <span class="nav-title">Taller PHP</span>
    <span class="nav-sub">Programacion Orientada a Objetos</span>
</nav>

<div class="wrapper">
    <header>
        <h1>Menu Principal</h1>
        <p>Selecciona una aplicacion para continuar</p>
    </header>
    <hr class="divider">

    <main class="app-list">
        <?php foreach ($apps as $app): ?>
            <a href="<?= htmlspecialchars($app['ruta']) ?>" class="app-card">
                <span class="app-number"><?= $app['numero'] ?></span>
                <div class="app-info">
                    <div class="app-title"><?= htmlspecialchars($app['titulo']) ?></div>
                    <div class="app-desc"><?= htmlspecialchars($app['desc']) ?></div>
                </div>
                <span class="arrow">&#8594;</span>
            </a>
        <?php endforeach; ?>
    </main>


</div>

</body>
</html>