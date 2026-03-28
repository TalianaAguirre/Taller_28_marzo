<?php

class Conjunto {
    private array $elementos;

    public function __construct(array $elementos) {
        $this->elementos = array_values(array_unique($elementos));
        sort($this->elementos);
    }

    public function getElementos(): array { return $this->elementos; }

    public function union(Conjunto $otro): Conjunto {
        return new Conjunto(array_merge($this->elementos, $otro->getElementos()));
    }

    public function interseccion(Conjunto $otro): Conjunto {
        return new Conjunto(array_intersect($this->elementos, $otro->getElementos()));
    }

    public function diferencia(Conjunto $otro): Conjunto {
        return new Conjunto(array_diff($this->elementos, $otro->getElementos()));
    }

    public function __toString(): string {
        return '{' . implode(', ', $this->elementos) . '}';
    }
}