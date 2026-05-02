<?php

class Estadistica {

    private array $numeros;

    public function __construct(array $numeros) {
        $this->numeros = $numeros;
    }

    public function getNumeros(): array {
        return $this->numeros;
    }

  
    public function promedio(): float {
        return array_sum($this->numeros) / count($this->numeros);
    }

   
    public function media(): float {
        $ordenados = $this->numeros;
        sort($ordenados);
        $n     = count($ordenados);
        $mitad = intdiv($n, 2);

        if ($n % 2 === 0) {
            return ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2;
        }
        return $ordenados[$mitad];
    }

   
    public function moda(): array {
        $comoStrings = array_map('strval', $this->numeros);
        $frecuencias = array_count_values($comoStrings);

        if (empty($frecuencias)) return [];

        $maxFrecuencia = max($frecuencias);

        if ($maxFrecuencia === 1) {
            return [];
        }

        $modas = [];
        foreach ($frecuencias as $valor => $frecuencia) {
            if ($frecuencia === $maxFrecuencia) {
                $modas[] = $valor;
            }
        }
        return $modas;
    }
}