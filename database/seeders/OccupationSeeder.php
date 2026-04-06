<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $occupations = [
            ['name' => 'Farmacêutico RT', 'requires_crf' => true],
            ['name' => 'Farmacêutico Substituto', 'requires_crf' => true],
            ['name' => 'Gerente', 'requires_crf' => false],
            ['name' => 'Balconista', 'requires_crf' => false],
            ['name' => 'Operador de Caixa', 'requires_crf' => false],
            ['name' => 'Serviços Gerais', 'requires_crf' => false],
        ];

        foreach ($occupations as $occ) {
            \App\Models\Occupation::create($occ);
        }
    }
}
