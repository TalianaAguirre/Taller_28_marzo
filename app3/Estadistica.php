<?php

class Estadistica {
    private array $numeros;

    public function __construct(array $numeros) {
        $this->numeros = $numeros;
    }

    public function getNumeros(): array { return $this->numeros; }

    public function promedio(): float {
        return array_sum($this->numeros) / count($this->numeros);
    }

    public function media(): float {
        $sorted = $this->numeros;
        sort($sorted);
        $n = count($sorted);
        if ($n % 2 === 0) {
            return ($sorted[$n / 2 - 1] + $sorted[$n / 2]) / 2;
        }
        return $sorted[(int)($n / 2)];
    }

    public function moda(): array {
        $freq = array_count_values(array_map('strval', $this->numeros));
        $max  = max($freq);
        if ($max === 1) return []; // sin moda
        $modas = array_keys(array_filter($freq, fn($v) => $v === $max));
        return array_map('floatval', $modas);
    }
}