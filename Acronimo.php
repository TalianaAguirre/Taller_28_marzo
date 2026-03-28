<?php
 
class Acronimo {
    private string $frase;
 
    public function __construct(string $frase) {
        $this->frase = $frase;
    }
 
    public function getFrase(): string {
        return $this->frase;
    }
 
  
    public function convertir(): string {
        $frase = str_replace('-', ' ', $this->frase);
 
        $frase = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/u', '', $frase);
 
        $palabras = preg_split('/\s+/', trim($frase));
 
        $acronimo = '';
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $acronimo .= mb_strtoupper(mb_substr($palabra, 0, 1, 'UTF-8'), 'UTF-8');
            }
        }
 
        return $acronimo;
    }
}
 