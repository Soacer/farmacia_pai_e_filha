<?php

namespace App\Enums;

enum CategoryClass: string
{
    case NERVOUS_SYSTEM = 'Sistema Nervoso e Dor';
    case ANTI_INFECTIVES = 'Anti-infecciosos';
    case CARDIOVASCULAR = 'Cardiovascular e Renal';
    case DIGESTIVE = 'Aparelho Digestivo e Metabólico';
    case RESPIRATORY = 'Sistema Respiratório'; 
    case HYGIENE = 'Higiene Pessoal';
    case MOM_BABY = 'Mamãe e Bebê';
    case BEAUTY_WELLNESS = 'Beleza e Bem-estar';

    /**
     * Retorna o valor da string (o rótulo) do Enum
     */
    public function label(): string
    {
        return $this->value;
    }
}