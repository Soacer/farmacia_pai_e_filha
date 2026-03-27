<?php

namespace App\Enums;

use App\Enums\CategoryClass; 

enum CategorySubclass: string
{
    // 1. Sistema Nervoso e Dor
    case ANALGESICS = 'Analgésicos e Antitérmicos';
    case ANTI_INFLAMMATORIES = 'Anti-inflamatórios (AINEs)';
    case ANXIOLYTICS = 'Ansiolíticos e Sedativos (Tarja Preta)';
    case ANTIDEPRESSANTS = 'Antidepressivos';

    // 2. Anti-infecciosos
    case ANTIBIOTICS = 'Antibióticos';
    case ANTIVIRALS_ANTIFUNGALS = 'Antivirais e Antifúngicos';
    case ANTIPARASITICS = 'Antiparasitários (Vermífugos)';

    // 3. Cardiovascular e Renal
    case ANTIHYPERTENSIVES = 'Anti-hipertensivos';
    case DIURETICS = 'Diuréticos';
    case STATINS = 'Estatinas (Colesterol)';

    // 4. Aparelho Digestivo e Metabólico
    case ANTACIDS = 'Antiácidos e Protetores Gástricos (Ex: Omeprazol)';
    case HYPOGLYCEMICS = 'Hipoglicemiantes e Insulinas (Diabetes)';
    case LAXATIVES = 'Laxantes e Antidiarreicos';

    // 5. Sistema Respiratório
    case ANTIHISTAMINES = 'Antialérgicos (Anti-histamínicos)';
    case BRONCHODILATORS = 'Broncodilatadores e Corticoides Inalatórios';

    // 6. Higiene Pessoal
    case ORAL_CARE = 'Cuidados Bucais';
    case HAIR_CARE = 'Cuidados com o Cabelo';
    case BATH_BODY = 'Banho e Corpo';
    case DEODORANTS = 'Desodorantes';

    // 7. Mamãe e Bebê (Grupo Infantil)
    case DIAPERS = 'Fraldas e Lenços Umedecidos';
    case BABY_FORMULA = 'Leites e Fórmulas Infantis';
    case BABY_ACCESSORIES = 'Acessórios (Mamadeiras e Chupetas)';

    // 8. Beleza e Bem-estar
    case SUN_PROTECTION = 'Proteção Solar';
    case SKINCARE = 'Skincare e Dermocosméticos';
    case FIRST_AID = 'Primeiros Socorros (Curativos e Gaze)';
    case VITAMINS = 'Vitaminas e Suplementos';

    /**
     * Retorna o nome amigável da Subclasse para exibição
     */
    public function label(): string
    {
        return match($this) {
            self::ANALGESICS => 'Analgésicos e Antitérmicos',
            self::ANTI_INFLAMMATORIES => 'Anti-inflamatórios (AINEs)',
            self::ANXIOLYTICS => 'Ansiolíticos e Sedativos (Tarja Preta)',
            self::ANTIDEPRESSANTS => 'Antidepressivos',
            self::ANTIBIOTICS => 'Antibióticos',
            self::ANTIVIRALS_ANTIFUNGALS => 'Antivirais e Antifúngicos',
            self::ANTIPARASITICS => 'Antiparasitários (Vermífugos)',
            self::ANTIHYPERTENSIVES => 'Anti-hipertensivos',
            self::DIURETICS => 'Diuréticos',
            self::STATINS => 'Estatinas (Colesterol)',
            self::ANTACIDS => 'Antiácidos e Protetores Gástricos',
            self::HYPOGLYCEMICS => 'Hipoglicemiantes e Insulinas (Diabetes)',
            self::LAXATIVES => 'Laxantes e Antidiarreicos',
            self::ANTIHISTAMINES => 'Antialérgicos (Anti-histamínicos)',
            self::BRONCHODILATORS => 'Broncodilatadores e Corticoides Inalatórios',
            self::ORAL_CARE => 'Cuidados Bucais',
            self::HAIR_CARE => 'Cuidados com o Cabelo',
            self::BATH_BODY => 'Banho e Corpo',
            self::DEODORANTS => 'Desodorantes',
            self::DIAPERS => 'Fraldas e Lenços Umedecidos',
            self::BABY_FORMULA => 'Leites e Fórmulas Infantis',
            self::BABY_ACCESSORIES => 'Acessórios (Mamadeiras e Chupetas)',
            self::SUN_PROTECTION => 'Proteção Solar',
            self::SKINCARE => 'Skincare e Dermocosméticos',
            self::FIRST_AID => 'Primeiros Socorros (Curativos e Gaze)',
            self::VITAMINS => 'Vitaminas e Suplementos',
        };
    }

    /**
     * Vincula cada Subclasse à sua respectiva CategoryClass
     */
    public function categoryClass(): CategoryClass
    {
        return match ($this) {
            self::ANALGESICS, 
            self::ANTI_INFLAMMATORIES, 
            self::ANXIOLYTICS, 
            self::ANTIDEPRESSANTS => CategoryClass::NERVOUS_SYSTEM,

            self::ANTIBIOTICS, 
            self::ANTIVIRALS_ANTIFUNGALS, 
            self::ANTIPARASITICS => CategoryClass::ANTI_INFECTIVES,

            self::ANTIHYPERTENSIVES, 
            self::DIURETICS, 
            self::STATINS => CategoryClass::CARDIOVASCULAR,

            self::ANTACIDS, 
            self::HYPOGLYCEMICS, 
            self::LAXATIVES => CategoryClass::DIGESTIVE,

            self::ANTIHISTAMINES, 
            self::BRONCHODILATORS => CategoryClass::RESPIRATORY,

            self::ORAL_CARE, 
            self::HAIR_CARE, 
            self::BATH_BODY, 
            self::DEODORANTS => CategoryClass::HYGIENE,

            self::DIAPERS, 
            self::BABY_FORMULA, 
            self::BABY_ACCESSORIES => CategoryClass::MOM_BABY,
            
            self::SUN_PROTECTION, 
            self::SKINCARE, 
            self::FIRST_AID, 
            self::VITAMINS => CategoryClass::BEAUTY_WELLNESS,
        };
    }
}