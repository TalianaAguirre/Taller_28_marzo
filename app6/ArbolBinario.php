<?php

class NodoArbol {
    public string $valor;
    public ?NodoArbol $izquierdo = null;
    public ?NodoArbol $derecho   = null;

    public function __construct(string $valor) {
        $this->valor = $valor;
    }
}

class ArbolBinario {
    private ?NodoArbol $raiz = null;

   
    public function construirDesdePreInorden(array $pre, array $in): void {
        $this->raiz = $this->buildPI($pre, $in);
    }

    private function buildPI(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) return null;
        $raizVal = $pre[0];
        $nodo    = new NodoArbol($raizVal);
        $idx     = array_search($raizVal, $in);
        if ($idx === false) return $nodo;

        $inIzq  = array_slice($in,  0, $idx);
        $inDer  = array_slice($in,  $idx + 1);
        $preIzq = array_slice($pre, 1, count($inIzq));
        $preDer = array_slice($pre, 1 + count($inIzq));

        $nodo->izquierdo = $this->buildPI($preIzq, $inIzq);
        $nodo->derecho   = $this->buildPI($preDer, $inDer);
        return $nodo;
    }

    
    public function construirDesdePostInorden(array $post, array $in): void {
        $this->raiz = $this->buildPostI($post, $in);
    }

    private function buildPostI(array $post, array $in): ?NodoArbol {
        if (empty($post) || empty($in)) return null;
        $raizVal = end($post);
        $nodo    = new NodoArbol($raizVal);
        $idx     = array_search($raizVal, $in);
        if ($idx === false) return $nodo;

        $inIzq   = array_slice($in,   0, $idx);
        $inDer   = array_slice($in,   $idx + 1);
        $postIzq = array_slice($post, 0, count($inIzq));
        $postDer = array_slice($post, count($inIzq), count($inDer));

        $nodo->izquierdo = $this->buildPostI($postIzq, $inIzq);
        $nodo->derecho   = $this->buildPostI($postDer, $inDer);
        return $nodo;
    }

    public function getRaiz(): ?NodoArbol { return $this->raiz; }

    public function toArray(?NodoArbol $nodo = null, bool $inicio = true): ?array {
        if ($inicio) $nodo = $this->raiz;
        if ($nodo === null) return null;
        return [
            'valor'     => $nodo->valor,
            'izquierdo' => $this->toArray($nodo->izquierdo, false),
            'derecho'   => $this->toArray($nodo->derecho,   false),
        ];
    }

    public function preorden(?NodoArbol $n = null, bool $init = true): array {
        if ($init) $n = $this->raiz;
        if ($n === null) return [];
        return array_merge([$n->valor], $this->preorden($n->izquierdo, false), $this->preorden($n->derecho, false));
    }

    public function inorden(?NodoArbol $n = null, bool $init = true): array {
        if ($init) $n = $this->raiz;
        if ($n === null) return [];
        return array_merge($this->inorden($n->izquierdo, false), [$n->valor], $this->inorden($n->derecho, false));
    }

    public function postorden(?NodoArbol $n = null, bool $init = true): array {
        if ($init) $n = $this->raiz;
        if ($n === null) return [];
        return array_merge($this->postorden($n->izquierdo, false), $this->postorden($n->derecho, false), [$n->valor]);
    }
}