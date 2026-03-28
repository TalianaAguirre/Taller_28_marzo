<?php

class Secuencia {
    private int $numero;
    private string $operacion;

    public function __construct(int $numero, string $operacion) {
        $this->numero    = $numero;
        $this->operacion = $operacion;
    }

    public function getNumero(): int    { return $this->numero; }
    public function getOperacion(): string { return $this->operacion; }

    public function calcular(): array {
        return $this->operacion === 'fibonacci'
            ? $this->fibonacci()
            : $this->factorial();
    }

    private function fibonacci(): array {
        if ($this->numero <= 0) return [];
        if ($this->numero === 1) return [0];
        $serie = [0, 1];
        for ($i = 2; $i < $this->numero; $i++) {
            $serie[] = $serie[$i - 1] + $serie[$i - 2];
        }
        return $serie;
    }

    private function factorial(): array {
        if ($this->numero < 0) return [];
        $pasos = [];
        $resultado = 1;
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado *= $i;
            $pasos[]    = $resultado;
        }
        return $pasos ?: [1]; 
    }
}