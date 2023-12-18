<?php

namespace App\Application\Services;
use InvalidArgumentException;

class CnsRulesService
{
    public function __construct(
    ) {}

    public function cnsRulesValidate(string $cns)
    {
        if (strlen(trim($cns)) !== 15) {
            throw new InvalidArgumentException('O CNS deve ter exatamente 15 dígitos.');
        }
    
        $firstDigit = (int) $cns[0];
    
        return match ($firstDigit) {
            1, 2 => $this->cnsGroupOne($cns),
            7, 8, 9 => $this->cnsGroupTwo($cns),
            default => throw new InvalidArgumentException('O primeiro dígito do CNS deve ser 1, 2, 7, 8 ou 9.'),
        };
    }

    public function cnsGroupOne(string $cns) {
        $pis = substr($cns, 0, 11);
        $soma = 0;
    
        for ($i = 0; $i < 11; $i++) {
            $soma += (int) $pis[$i] * (15 - $i);
        }
    
        $resto = $soma % 11;
        $dv = ($resto == 11) ? 0 : (11 - $resto);
    
        if ($dv == 10) {
            $soma = 0;
            for ($i = 0; $i < 11; $i++) {
                $soma += (int) $pis[$i] * (15 - $i);
            }
            $resto = $soma % 11;
            $dv = ($resto == 11) ? 0 : (11 - $resto);
            $resultado = $pis . "001" . (int) $dv;
        } else {
            $resultado = $pis . "000" . (int) $dv;
        }
    
        if ($cns !== $resultado) {
            throw new InvalidArgumentException("O CNS do grupo um ('$cns') é inválido");
        }
    
        return true;
    }

    function cnsGroupTwo($cns) {
        $soma = 0;
    
        for ($i = 0; $i < 15; $i++) {
            $soma += (int) $cns[$i] * (15 - $i);
        }
    
        $resto = $soma % 11;
    
        if ($resto !== 0) {
            throw new InvalidArgumentException("O CNS do grupo dois ('$cns') é inválido");
        }
    
        return true;
    }
}