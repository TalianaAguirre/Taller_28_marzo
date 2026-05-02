<?php

class NodoArbol {
    public string $valor;
    public ?NodoArbol $izquierdo;
    public ?NodoArbol $derecho;

    public function __construct(string $valor) {
        $this->valor     = $valor;
        $this->izquierdo = null;
        $this->derecho   = null;
    }
}

class ArbolBinario {

    private ?NodoArbol $raiz = null;

    public function construirDesdePreInorden(array $preorden, array $inorden): void {
        $this->raiz = $this->buildPreIn($preorden, $inorden);
    }

    public function construirDesdePostInorden(array $postorden, array $inorden): void {
        $this->raiz = $this->buildPostIn($postorden, $inorden);
    }

    private function buildPreIn(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) return null;

        $raizValor = $pre[0];
        $nodo      = new NodoArbol($raizValor);

        $posRaiz = array_search($raizValor, $in);

        $inIzq  = array_slice($in,  0, $posRaiz);
        $inDer  = array_slice($in,  $posRaiz + 1);
        $preIzq = array_slice($pre, 1, count($inIzq));
        $preDer = array_slice($pre, 1 + count($inIzq));

        $nodo->izquierdo = $this->buildPreIn($preIzq, $inIzq);
        $nodo->derecho   = $this->buildPreIn($preDer, $inDer);

        return $nodo;
    }

    private function buildPostIn(array $post, array $in): ?NodoArbol {
        if (empty($post) || empty($in)) return null;

        $raizValor = $post[count($post) - 1];
        $nodo      = new NodoArbol($raizValor);

        $posRaiz = array_search($raizValor, $in);

        $inIzq   = array_slice($in,   0, $posRaiz);
        $inDer   = array_slice($in,   $posRaiz + 1);
        $postIzq = array_slice($post, 0, count($inIzq));
        $postDer = array_slice($post, count($inIzq), count($inDer));

        $nodo->izquierdo = $this->buildPostIn($postIzq, $inIzq);
        $nodo->derecho   = $this->buildPostIn($postDer, $inDer);

        return $nodo;
    }

    public function getRaiz(): ?NodoArbol {
        return $this->raiz;
    }

 
    public function preorden(): array {
        $resultado = [];
        $this->recPreorden($this->raiz, $resultado);
        return $resultado;
    }

 
    public function inorden(): array {
        $resultado = [];
        $this->recInorden($this->raiz, $resultado);
        return $resultado;
    }


    public function postorden(): array {
        $resultado = [];
        $this->recPostorden($this->raiz, $resultado);
        return $resultado;
    }

    private function recPreorden(?NodoArbol $nodo, array &$res): void {
        if ($nodo === null) return;
        $res[] = $nodo->valor;
        $this->recPreorden($nodo->izquierdo, $res);
        $this->recPreorden($nodo->derecho,   $res);
    }

    private function recInorden(?NodoArbol $nodo, array &$res): void {
        if ($nodo === null) return;
        $this->recInorden($nodo->izquierdo, $res);
        $res[] = $nodo->valor;
        $this->recInorden($nodo->derecho,   $res);
    }

    private function recPostorden(?NodoArbol $nodo, array &$res): void {
        if ($nodo === null) return;
        $this->recPostorden($nodo->izquierdo, $res);
        $this->recPostorden($nodo->derecho,   $res);
        $res[] = $nodo->valor;
    }

   
    public function generarHTML(): string {
        if ($this->raiz === null) return '<p>Arbol vacio</p>';

        $html   = '<ul class="arbol">';
        $html  .= $this->nodoHTML($this->raiz);
        $html  .= '</ul>';
        return $html;
    }

    private function nodoHTML(?NodoArbol $nodo): string {
        if ($nodo === null) return '';

        $html = '<li><span class="nodo">' . htmlspecialchars($nodo->valor) . '</span>';

        if ($nodo->izquierdo !== null || $nodo->derecho !== null) {
            $html .= '<ul>';
            if ($nodo->izquierdo !== null) {
                $html .= $this->nodoHTML($nodo->izquierdo);
            } else {
                $html .= '<li><span class="nodo nodo-null">&#8709;</span></li>';
            }
            if ($nodo->derecho !== null) {
                $html .= $this->nodoHTML($nodo->derecho);
            } else {
                $html .= '<li><span class="nodo nodo-null">&#8709;</span></li>';
            }
            $html .= '</ul>';
        }

        $html .= '</li>';
        return $html;
    }
}