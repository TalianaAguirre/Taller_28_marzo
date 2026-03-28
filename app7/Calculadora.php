<?php

class Calculadora {
    private float $a;
    private float $b;
    private string $operacion;

    public function __construct(float $a, float $b, string $operacion) {
        $this->a         = $a;
        $this->b         = $b;
        $this->operacion = $operacion;
    }

    public function calcular(): float|string {
        return match($this->operacion) {
            '+'  => $this->a + $this->b,
            '-'  => $this->a - $this->b,
            '*'  => $this->a * $this->b,
            '/'  => $this->b != 0 ? $this->a / $this->b : 'Error: división entre cero',
            '%'  => $this->b != 0 ? fmod($this->a, $this->b) : 'Error: módulo entre cero',
            default => 'Operación no válida',
        };
    }

    public function getExpresion(): string {
        $sym = $this->operacion;
        return "{$this->a} {$sym} {$this->b}";
    }

    public function formatNumero(float $n): string {
        return rtrim(rtrim(number_format($n, 10, '.', ''), '0'), '.');
    }
}