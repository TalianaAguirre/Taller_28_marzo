<?php

class Binario {

    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function convertir(): string {
        return decbin($this->numero);
    }
}