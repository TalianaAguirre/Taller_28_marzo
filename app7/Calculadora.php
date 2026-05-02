<?php

class Calculadora {
    private float $num1;
    private float $num2;

    public function __construct(float $num1, float $num2) {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }

    public function sumar(): float {
        return $this->num1 + $this->num2;
    }

    public function restar(): float {
        return $this->num1 - $this->num2;
    }

    public function multiplicar(): float {
        return $this->num1 * $this->num2;
    }

    public function dividir(): ?float {
        if ($this->num2 == 0) return null;
        return $this->num1 / $this->num2;
    }

    public function porcentaje(): float {
        return ($this->num1 * $this->num2) / 100;
    }
}