<?php

class Binario {
    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function getNumero(): int { return $this->numero; }

    public function convertir(): string {
        if ($this->numero === 0) return '0';
        $n      = abs($this->numero);
        $bits   = [];
        $pasos  = [];
        while ($n > 0) {
            $residuo = $n % 2;
            $bits[]  = $residuo;
            $pasos[] = ['cociente' => (int)($n / 2), 'residuo' => $residuo, 'dividendo' => $n];
            $n       = (int)($n / 2);
        }
        $bin = implode('', array_reverse($bits));
        return $this->numero < 0 ? '-' . $bin : $bin;
    }

    public function getPasos(): array {
        $n     = abs($this->numero);
        $pasos = [];
        while ($n > 0) {
            $pasos[] = ['dividendo' => $n, 'cociente' => (int)($n / 2), 'residuo' => $n % 2];
            $n       = (int)($n / 2);
        }
        return $pasos;
    }
}