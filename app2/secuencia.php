<?php

class Secuencia {

    private int $numero;

    public function __construct(int $numero) {
        $this->numero = $numero;
    }

    public function getNumero(): int {
        return $this->numero;
    }

  
    public function fibonacci(): array {
        if ($this->numero <= 0) return [];
        if ($this->numero === 1) return [0];

        $serie = [0, 1];
        for ($i = 2; $i < $this->numero; $i++) {
            $serie[] = $serie[$i - 1] + $serie[$i - 2];
        }
        return $serie;
    }

   
    public function factorial(): string {
        if ($this->numero < 0) return 'No definido para números negativos';
        if ($this->numero === 0 || $this->numero === 1) return '1';

        $resultado = '1';
        for ($i = 2; $i <= $this->numero; $i++) {
            $resultado = bcmul($resultado, (string)$i);
        }
        return $resultado;
    }
}