<?php

class Conjunto {

    private array $setA;
    private array $setB;

    public function __construct(array $setA, array $setB) {
        $this->setA = array_unique($setA);
        $this->setB = array_unique($setB);
    }

    public function getA(): array {
        return array_values($this->setA);
    }

    public function getB(): array {
        return array_values($this->setB);
    }

    
    public function union(): array {
        return array_values(array_unique(array_merge($this->setA, $this->setB)));
    }

   
    public function interseccion(): array {
        return array_values(array_intersect($this->setA, $this->setB));
    }

    
    public function diferenciaAB(): array {
        return array_values(array_diff($this->setA, $this->setB));
    }

    public function diferenciaBA(): array {
        return array_values(array_diff($this->setB, $this->setA));
    }
}