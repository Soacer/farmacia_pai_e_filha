<?php

namespace Database\Seeders;

use App\Enums\CategorySubclass;
use App\Models\Batch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Desativa constraints para limpar as tabelas com segurança
        Schema::disableForeignKeyConstraints();
        Batch::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Garante a existência de um Fornecedor para vincular aos lotes
        $supplier = Supplier::first() ?? Supplier::create([
            'id' => (string) Str::uuid(),
            'company_name' => 'Distribuidora Pharma Central Ltda',
            'trade_name' => 'Pharma Central',
            'cnpj' => '12345678000199',
            'email' => 'contato@pharmacentral.com',
            'phone' => '71988887777',
            'contact_name' => 'Gerente de Vendas',
            'isActive' => true,
        ]);

        $allData = $this->getFullDataSet();

        foreach ($allData as $subclassKey => $items) {
            $subclassEnum = CategorySubclass::from($subclassKey);

            // 3. Cria ou encontra a categoria baseada no Enum
            $category = Category::firstOrCreate(
                ['subclass' => $subclassEnum->label()],
                [
                    'class' => $subclassEnum->categoryClass()->label(),
                    'isActive' => true,
                ]
            );

            foreach ($items as $index => $item) {
                // 4. Cria o Produto
                $product = Product::create([
                    'id' => (string) Str::uuid(),
                    'idCategory' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['desc'] ?? 'Descrição detalhada para '.$item['name'],
                    'barcode' => '789'.str_pad(abs(crc32($subclassKey.$index)), 10, '0', STR_PAD_LEFT),
                    'active_principle' => $item['principle'],
                    'price' => $item['price'],
                    'min_stock_alert' => rand(5, 20),
                    'isActive' => true,
                    'requires_prescription' => $item['rx'],
                    'image_path' => 'products/1862579758566595.webp',
                ]);

                // 5. Cria o Lote (Batch) associado ao produto recém-criado
                $quantity = rand(20, 100);

                Batch::create([
                    'id' => (string) Str::uuid(),
                    'idProducts' => $product->id,
                    'idSuppliers' => $supplier->id,
                    'batch_code' => 'LOT-'.strtoupper(Str::random(6)),
                    'manufacturing_date' => now()->subMonths(rand(1, 12)),
                    'expiration_date' => now()->addYears(rand(1, 2)),
                    'quantity' => $quantity,
                    'quantity_now' => $quantity,
                    'cost_price' => $item['price'] * 0.55, // Custo médio de 55% do preço de venda
                    'isActive' => true,
                ]);
            }
        }
    }

    private function getFullDataSet(): array
    {
        return [
            // 1. SISTEMA NERVOSO E DOR
            CategorySubclass::ANALGESICS->value => [
                ['name' => 'Dipirona 500mg Cimed', 'principle' => 'Dipirona', 'price' => 12.50, 'rx' => false],
                ['name' => 'Paracetamol 750mg Medley', 'principle' => 'Paracetamol', 'price' => 15.90, 'rx' => false],
                ['name' => 'Tylenol 750mg c/ 20', 'principle' => 'Paracetamol', 'price' => 28.50, 'rx' => false],
                ['name' => 'Lisador c/ 16 caps', 'principle' => 'Dipirona + Aditivos', 'price' => 18.20, 'rx' => false],
                ['name' => 'Dorflex c/ 36 comp', 'principle' => 'Dipirona + Orfenadrina', 'price' => 24.90, 'rx' => false],
                ['name' => 'Neosaldina 30 Drágeas', 'principle' => 'Dipirona + Isometepteno', 'price' => 32.40, 'rx' => false],
                ['name' => 'Buscopan Composto 20ml', 'principle' => 'Escopolamina + Dipirona', 'price' => 22.10, 'rx' => false],
                ['name' => 'Advil 400mg 20 caps', 'principle' => 'Ibuprofeno', 'price' => 38.90, 'rx' => false],
            ],
            CategorySubclass::ANTI_INFLAMMATORIES->value => [
                ['name' => 'Cataflam 50mg c/ 20', 'principle' => 'Diclofenaco Potássico', 'price' => 45.00, 'rx' => false],
                ['name' => 'Nimesulida 100mg Eurofarma', 'principle' => 'Nimesulida', 'price' => 14.50, 'rx' => false],
                ['name' => 'Alivium 600mg c/ 10', 'principle' => 'Ibuprofeno', 'price' => 29.90, 'rx' => false],
                ['name' => 'Aclasta 5mg/100ml', 'principle' => 'Ácido Zoledrônico', 'price' => 1200.00, 'rx' => true],
                ['name' => 'Toragesic 10mg SL', 'principle' => 'Cetorolaco Trometamol', 'price' => 35.60, 'rx' => true],
                ['name' => 'Arcoxia 90mg c/ 7', 'principle' => 'Etoricoxibe', 'price' => 68.20, 'rx' => true],
                ['name' => 'Feldene 20mg c/ 10', 'principle' => 'Piroxicam', 'price' => 42.10, 'rx' => true],
                ['name' => 'Flanax 550mg c/ 10', 'principle' => 'Naproxeno', 'price' => 33.40, 'rx' => false],
            ],
            CategorySubclass::ANXIOLYTICS->value => [
                ['name' => 'Rivotril 2mg c/ 30', 'principle' => 'Clonazepam', 'price' => 22.50, 'rx' => true],
                ['name' => 'Frontal 0.5mg c/ 30', 'principle' => 'Alprazolam', 'price' => 58.00, 'rx' => true],
                ['name' => 'Lexotan 3mg c/ 30', 'principle' => 'Bromazepam', 'price' => 45.20, 'rx' => true],
                ['name' => 'Valium 10mg c/ 20', 'principle' => 'Diazepam', 'price' => 33.10, 'rx' => true],
                ['name' => 'Olcadil 2mg c/ 30', 'principle' => 'Cloxazolam', 'price' => 52.40, 'rx' => true],
                ['name' => 'Urbanil 10mg c/ 20', 'principle' => 'Clobazam', 'price' => 38.90, 'rx' => true],
                ['name' => 'Dormonid 15mg c/ 20', 'principle' => 'Midazolam', 'price' => 74.00, 'rx' => true],
                ['name' => 'Apraz 1.0mg c/ 30', 'principle' => 'Alprazolam', 'price' => 62.15, 'rx' => true],
            ],
            CategorySubclass::ANTIDEPRESSANTS->value => [
                ['name' => 'Sertralina 50mg EMS', 'principle' => 'Sertralina', 'price' => 42.00, 'rx' => true],
                ['name' => 'Fluoxetina 20mg Medley', 'principle' => 'Fluoxetina', 'price' => 18.50, 'rx' => true],
                ['name' => 'Lexapro 10mg c/ 30', 'principle' => 'Escitalopram', 'price' => 195.00, 'rx' => true],
                ['name' => 'Pondera 20mg c/ 30', 'principle' => 'Paroxetina', 'price' => 92.40, 'rx' => true],
                ['name' => 'Efexor XR 75mg c/ 30', 'principle' => 'Venlafaxina', 'price' => 148.00, 'rx' => true],
                ['name' => 'Amytril 25mg c/ 30', 'principle' => 'Amitriptilina', 'price' => 24.10, 'rx' => true],
                ['name' => 'Pristiq 50mg c/ 28', 'principle' => 'Desvenlafaxina', 'price' => 165.90, 'rx' => true],
                ['name' => 'Zoloft 50mg c/ 28', 'principle' => 'Sertralina', 'price' => 125.00, 'rx' => true],
            ],

            // 2. ANTI-INFECTIOSOS
            CategorySubclass::ANTIBIOTICS->value => [
                ['name' => 'Amoxicilina 500mg Eurofarma', 'principle' => 'Amoxicilina', 'price' => 34.20, 'rx' => true],
                ['name' => 'Azitromicina 500mg Neo', 'principle' => 'Azitromicina', 'price' => 45.00, 'rx' => true],
                ['name' => 'Clavulin BD 875mg', 'principle' => 'Amoxicilina + Clavulanato', 'price' => 118.00, 'rx' => true],
                ['name' => 'Ciprofloxacino 500mg c/ 14', 'principle' => 'Ciprofloxacino', 'price' => 39.50, 'rx' => true],
                ['name' => 'Keflex 500mg c/ 10', 'principle' => 'Cefalexina', 'price' => 52.40, 'rx' => true],
                ['name' => 'Macrodantina 100mg', 'principle' => 'Nitrofurantoína', 'price' => 38.00, 'rx' => true],
                ['name' => 'Levofloxacino 500mg c/ 7', 'principle' => 'Levofloxacino', 'price' => 64.10, 'rx' => true],
                ['name' => 'Rocephin 1g IM', 'principle' => 'Ceftriaxona', 'price' => 85.00, 'rx' => true],
            ],
            CategorySubclass::ANTIVIRALS_ANTIFUNGALS->value => [
                ['name' => 'Aciclovir 200mg c/ 25', 'principle' => 'Aciclovir', 'price' => 28.90, 'rx' => true],
                ['name' => 'Fluconazol 150mg c/ 1', 'principle' => 'Fluconazol', 'price' => 15.40, 'rx' => false],
                ['name' => 'Itrazon 100mg c/ 15', 'principle' => 'Itraconazol', 'price' => 84.00, 'rx' => true],
                ['name' => 'Tamiflu 75mg c/ 10', 'principle' => 'Fosfato de Oseltamivir', 'price' => 210.00, 'rx' => true],
                ['name' => 'Canditrat 100.000UI', 'principle' => 'Nistatina', 'price' => 22.10, 'rx' => false],
                ['name' => 'Voran 500mg c/ 3', 'principle' => 'Fanciclovir', 'price' => 145.00, 'rx' => true],
                ['name' => 'Terbinafina 250mg c/ 28', 'principle' => 'Terbinafina', 'price' => 92.00, 'rx' => true],
                ['name' => 'Zovirax Creme 10g', 'principle' => 'Aciclovir', 'price' => 54.90, 'rx' => false],
            ],
            CategorySubclass::ANTIPARASITICS->value => [
                ['name' => 'Annita 500mg c/ 6', 'principle' => 'Nitazoxanida', 'price' => 65.00, 'rx' => true],
                ['name' => 'Ivermectina 6mg c/ 4', 'principle' => 'Ivermectina', 'price' => 18.50, 'rx' => false],
                ['name' => 'Albendazol 400mg Mastigável', 'principle' => 'Albendazol', 'price' => 9.20, 'rx' => false],
                ['name' => 'Pantelmin 100mg c/ 6', 'principle' => 'Mebendazol', 'price' => 14.30, 'rx' => false],
                ['name' => 'Secnidazol 1g c/ 2', 'principle' => 'Secnidazol', 'price' => 22.10, 'rx' => false],
                ['name' => 'Zentel 400mg c/ 1', 'principle' => 'Albendazol', 'price' => 12.50, 'rx' => false],
                ['name' => 'Combantrin Suspensão', 'principle' => 'Pamoato de Pirantel', 'price' => 19.80, 'rx' => false],
                ['name' => 'Ascaridil Adulto', 'principle' => 'Levamisol', 'price' => 8.50, 'rx' => false],
            ],

            // 3. CARDIOVASCULAR E RENAL
            CategorySubclass::ANTIHYPERTENSIVES->value => [
                ['name' => 'Losartana 50mg Medley', 'principle' => 'Losartana Potássica', 'price' => 15.20, 'rx' => false],
                ['name' => 'Atenolol 50mg EMS', 'principle' => 'Atenolol', 'price' => 12.40, 'rx' => false],
                ['name' => 'Selozok 50mg c/ 30', 'principle' => 'Metoprolol', 'price' => 72.00, 'rx' => false],
                ['name' => 'Aradois 50mg c/ 30', 'principle' => 'Losartana', 'price' => 45.10, 'rx' => false],
                ['name' => 'Concor 5mg c/ 30', 'principle' => 'Bisoprolol', 'price' => 54.90, 'rx' => false],
                ['name' => 'Diovan 160mg c/ 28', 'principle' => 'Valsartana', 'price' => 128.00, 'rx' => false],
                ['name' => 'Enapril 10mg c/ 30', 'principle' => 'Maleato de Enalapril', 'price' => 18.40, 'rx' => false],
                ['name' => 'Anlodipino 5mg Neo', 'principle' => 'Anlodipino', 'price' => 11.20, 'rx' => false],
            ],
            CategorySubclass::DIURETICS->value => [
                ['name' => 'Lasix 40mg c/ 20', 'principle' => 'Furosemida', 'price' => 14.50, 'rx' => false],
                ['name' => 'Hidroclorotiazida 25mg', 'principle' => 'Hidroclorotiazida', 'price' => 8.90, 'rx' => false],
                ['name' => 'Aldactone 25mg c/ 30', 'principle' => 'Espironolactona', 'price' => 42.10, 'rx' => false],
                ['name' => 'Higroton 50mg c/ 20', 'principle' => 'Clortalidona', 'price' => 35.60, 'rx' => false],
                ['name' => 'Daonil 5mg c/ 30', 'principle' => 'Glibenclamida', 'price' => 22.40, 'rx' => false],
                ['name' => 'Indapamida 1.5mg SR', 'principle' => 'Indapamida', 'price' => 38.20, 'rx' => false],
                ['name' => 'Natrilix SR 1.5mg', 'principle' => 'Indapamida', 'price' => 54.00, 'rx' => false],
                ['name' => 'Moduretic c/ 30', 'principle' => 'Amilorida + Hidroclo.', 'price' => 29.30, 'rx' => false],
            ],
            CategorySubclass::STATINS->value => [
                ['name' => 'Sinvastatina 20mg Medley', 'principle' => 'Sinvastatina', 'price' => 18.90, 'rx' => false],
                ['name' => 'Atorvastatina 20mg Neo', 'principle' => 'Atorvastatina', 'price' => 45.20, 'rx' => false],
                ['name' => 'Rosuvastatina 10mg EMS', 'principle' => 'Rosuvastatina', 'price' => 58.40, 'rx' => false],
                ['name' => 'Lipitor 20mg c/ 30', 'principle' => 'Atorvastatina', 'price' => 185.00, 'rx' => false],
                ['name' => 'Crestor 10mg c/ 30', 'principle' => 'Rosuvastatina', 'price' => 198.00, 'rx' => false],
                ['name' => 'Vytorin 10/20mg', 'principle' => 'Ezetimiba + Sinvastatina', 'price' => 142.00, 'rx' => false],
                ['name' => 'Ezetrol 10mg c/ 30', 'principle' => 'Ezetimiba', 'price' => 115.00, 'rx' => false],
                ['name' => 'Livalo 2mg c/ 30', 'principle' => 'Pitavastatina', 'price' => 134.00, 'rx' => false],
            ],

            // 4. APARELHO DIGESTIVO E METABÓLICO
            CategorySubclass::ANTACIDS->value => [
                ['name' => 'Omeprazol 20mg Cimed', 'principle' => 'Omeprazol', 'price' => 14.50, 'rx' => false],
                ['name' => 'Pantoprazol 40mg Medley', 'principle' => 'Pantoprazol', 'price' => 38.20, 'rx' => false],
                ['name' => 'Nexium 40mg c/ 28', 'principle' => 'Esomeprazol', 'price' => 185.00, 'rx' => false],
                ['name' => 'Eno Pó Efervescente', 'principle' => 'Bicarbonato de Sódio', 'price' => 3.50, 'rx' => false],
                ['name' => 'Estomazil Sachê', 'principle' => 'Bicarbonato + Ácidos', 'price' => 2.90, 'rx' => false],
                ['name' => 'Mylanta Plus 240ml', 'principle' => 'Hidróxido de Alumínio', 'price' => 32.40, 'rx' => false],
                ['name' => 'Dexilant 60mg c/ 28', 'principle' => 'Dexlansoprazol', 'price' => 165.00, 'rx' => false],
                ['name' => 'Vonau Flash 8mg c/ 10', 'principle' => 'Ondansetrona', 'price' => 45.90, 'rx' => true],
            ],
            CategorySubclass::HYPOGLYCEMICS->value => [
                ['name' => 'Glifage XR 500mg c/ 30', 'principle' => 'Metformina', 'price' => 22.50, 'rx' => false],
                ['name' => 'Januvia 100mg c/ 28', 'principle' => 'Sitagliptina', 'price' => 174.00, 'rx' => false],
                ['name' => 'Galvus Met 50/850mg', 'principle' => 'Vildagliptina + Metfor.', 'price' => 155.00, 'rx' => false],
                ['name' => 'Trayenta 5mg c/ 30', 'principle' => 'Linagliptina', 'price' => 182.00, 'rx' => false],
                ['name' => 'Jardiance 25mg c/ 30', 'principle' => 'Empagliflozina', 'price' => 210.00, 'rx' => false],
                ['name' => 'Forxiga 10mg c/ 30', 'principle' => 'Dapagliflozina', 'price' => 195.00, 'rx' => false],
                ['name' => 'Diamicron MR 60mg', 'principle' => 'Gliclazida', 'price' => 58.40, 'rx' => false],
                ['name' => 'Victoza 6mg/ml Injetável', 'principle' => 'Liraglutida', 'price' => 450.00, 'rx' => true],
            ],
            CategorySubclass::LAXATIVES->value => [
                ['name' => 'Dulcolax 5mg c/ 20', 'principle' => 'Bisacodil', 'price' => 18.50, 'rx' => false],
                ['name' => 'Luftal Gotas 15ml', 'principle' => 'Simeticona', 'price' => 24.20, 'rx' => false],
                ['name' => 'Lactulona Xarope 120ml', 'principle' => 'Lactulose', 'price' => 38.90, 'rx' => false],
                ['name' => 'Floratil 200mg c/ 6', 'principle' => 'Saccharomyces boulardii', 'price' => 42.10, 'rx' => false],
                ['name' => 'Imosec 2mg c/ 12', 'principle' => 'Loperamida', 'price' => 19.50, 'rx' => false],
                ['name' => 'Muvinlax c/ 20 sachês', 'principle' => 'Macrogol', 'price' => 65.00, 'rx' => false],
                ['name' => 'Tamarine Geleia 250g', 'principle' => 'Senna + Cassia', 'price' => 74.50, 'rx' => false],
                ['name' => 'Naturetti c/ 16 caps', 'principle' => 'Senna + Cassia', 'price' => 32.15, 'rx' => false],
            ],

            // 5. SISTEMA RESPIRATÓRIO
            CategorySubclass::ANTIHISTAMINES->value => [
                ['name' => 'Loratadina 10mg Medley', 'principle' => 'Loratadina', 'price' => 12.50, 'rx' => false],
                ['name' => 'Allegra 120mg c/ 10', 'principle' => 'Fexofenadina', 'price' => 48.90, 'rx' => false],
                ['name' => 'Zyrtec 10mg c/ 12', 'principle' => 'Cetirizina', 'price' => 54.20, 'rx' => false],
                ['name' => 'Desalex 5mg c/ 10', 'principle' => 'Desloratadina', 'price' => 62.00, 'rx' => false],
                ['name' => 'Claritin D c/ 10', 'principle' => 'Loratadina + Pseudoefe.', 'price' => 45.30, 'rx' => false],
                ['name' => 'Hixizine Xarope 120ml', 'principle' => 'Hidroxizina', 'price' => 38.40, 'rx' => false],
                ['name' => 'Polaramine Drágeas', 'principle' => 'Dexclorfeniramina', 'price' => 22.10, 'rx' => false],
                ['name' => 'Ebastel 10mg c/ 10', 'principle' => 'Ebastina', 'price' => 55.60, 'rx' => false],
            ],
            CategorySubclass::BRONCHODILATORS->value => [
                ['name' => 'Aerolin Spray 200 doses', 'principle' => 'Salbutamol', 'price' => 32.40, 'rx' => false],
                ['name' => 'Busonid 50mcg Spray', 'principle' => 'Budesonida', 'price' => 58.00, 'rx' => false],
                ['name' => 'Seretide 25/125 Spray', 'principle' => 'Salmeterol + Flutica.', 'price' => 145.00, 'rx' => true],
                ['name' => 'Spiriva Respimat', 'principle' => 'Tiotrópio', 'price' => 285.00, 'rx' => true],
                ['name' => 'Symbicort 12/400mcg', 'principle' => 'Budesonida + Formote.', 'price' => 195.00, 'rx' => true],
                ['name' => 'Berotec Gotas 20ml', 'principle' => 'Fenoterol', 'price' => 28.50, 'rx' => false],
                ['name' => 'Atrovent Gotas 20ml', 'principle' => 'Ipratrópio', 'price' => 22.10, 'rx' => false],
                ['name' => 'Relvar Ellipta 100/25', 'principle' => 'Vilanterol + Flutica.', 'price' => 165.00, 'rx' => true],
            ],

            // 6. HIGIENE PESSOAL
            CategorySubclass::ORAL_CARE->value => [
                ['name' => 'Colgate Total 12 90g', 'principle' => 'N/A', 'price' => 12.90, 'rx' => false],
                ['name' => 'Sensodyne Rápido Alívio', 'principle' => 'N/A', 'price' => 24.50, 'rx' => false],
                ['name' => 'Listerine Cool Mint 500ml', 'principle' => 'N/A', 'price' => 29.90, 'rx' => false],
                ['name' => 'Escova Curaprox 5460', 'principle' => 'N/A', 'price' => 65.00, 'rx' => false],
                ['name' => 'Fio Dental Oral-B 50m', 'principle' => 'N/A', 'price' => 14.20, 'rx' => false],
                ['name' => 'Crest 3D White Strips', 'principle' => 'N/A', 'price' => 185.00, 'rx' => false],
                ['name' => 'Corega Creme 40g', 'principle' => 'N/A', 'price' => 42.10, 'rx' => false],
                ['name' => 'Enxaguante Periogard', 'principle' => 'N/A', 'price' => 32.50, 'rx' => false],
            ],
            CategorySubclass::HAIR_CARE->value => [
                ['name' => 'Shampoo Dercos Anticaspa', 'principle' => 'N/A', 'price' => 98.00, 'rx' => false],
                ['name' => 'Condicionador Pantene 3 min', 'principle' => 'N/A', 'price' => 22.50, 'rx' => false],
                ['name' => 'Tônico Capilar Minoxidil 5%', 'principle' => 'Minoxidil', 'price' => 85.00, 'rx' => false],
                ['name' => 'Máscara L\'Oréal Absolut Repair', 'principle' => 'N/A', 'price' => 145.00, 'rx' => false],
                ['name' => 'Shampoo Head & Shoulders', 'principle' => 'N/A', 'price' => 28.90, 'rx' => false],
                ['name' => 'Óleo de Coco Extra Virgem', 'principle' => 'N/A', 'price' => 35.00, 'rx' => false],
                ['name' => 'Creme de Pentear Seda', 'principle' => 'N/A', 'price' => 18.20, 'rx' => false],
                ['name' => 'Shampoo Johnson\'s Baby', 'principle' => 'N/A', 'price' => 15.90, 'rx' => false],
            ],
            CategorySubclass::BATH_BODY->value => [
                ['name' => 'Sabonete Dove Original 90g', 'principle' => 'N/A', 'price' => 4.50, 'rx' => false],
                ['name' => 'Loção Hidratante CeraVe 473ml', 'principle' => 'N/A', 'price' => 112.00, 'rx' => false],
                ['name' => 'Sabonete Líquido Protex', 'principle' => 'N/A', 'price' => 18.90, 'rx' => false],
                ['name' => 'Óleo Bio-Oil 60ml', 'principle' => 'N/A', 'price' => 65.00, 'rx' => false],
                ['name' => 'Gel de Banho La Roche-Posay', 'principle' => 'N/A', 'price' => 88.00, 'rx' => false],
                ['name' => 'Talco Granado Bebê', 'principle' => 'N/A', 'price' => 14.50, 'rx' => false],
                ['name' => 'Creme de Mãos Neutrogena', 'principle' => 'N/A', 'price' => 32.40, 'rx' => false],
                ['name' => 'Esfoliante Tree Hut', 'principle' => 'N/A', 'price' => 125.00, 'rx' => false],
            ],
            CategorySubclass::DEODORANTS->value => [
                ['name' => 'Rexona Men Clinical', 'principle' => 'N/A', 'price' => 28.90, 'rx' => false],
                ['name' => 'Dove Original Aerosol', 'principle' => 'N/A', 'price' => 19.50, 'rx' => false],
                ['name' => 'Old Spice Wolfthorn', 'principle' => 'N/A', 'price' => 18.20, 'rx' => false],
                ['name' => 'Nivea Black & White', 'principle' => 'N/A', 'price' => 17.40, 'rx' => false],
                ['name' => 'Vichy Stress Resist Roll-on', 'principle' => 'N/A', 'price' => 74.00, 'rx' => false],
                ['name' => 'Secret Gel Deodorant', 'principle' => 'N/A', 'price' => 35.00, 'rx' => false],
                ['name' => 'Herbíssimo Creme Original', 'principle' => 'N/A', 'price' => 7.50, 'rx' => false],
                ['name' => 'Gillette Gel Arctic Ice', 'principle' => 'N/A', 'price' => 22.90, 'rx' => false],
            ],

            // 7. MAMÃE E BEBÊ
            CategorySubclass::DIAPERS->value => [
                ['name' => 'Pampers Confort Sec G 60un', 'principle' => 'N/A', 'price' => 89.90, 'rx' => false],
                ['name' => 'Huggies Supreme Care M 80un', 'principle' => 'N/A', 'price' => 98.00, 'rx' => false],
                ['name' => 'MamyPoko Calça G 38un', 'principle' => 'N/A', 'price' => 55.40, 'rx' => false],
                ['name' => 'Fralda Pom Pom G 42un', 'principle' => 'N/A', 'price' => 42.10, 'rx' => false],
                ['name' => 'Pampers Premium Care P', 'principle' => 'N/A', 'price' => 74.50, 'rx' => false],
                ['name' => 'Fralda Babysec Galinha Pin.', 'principle' => 'N/A', 'price' => 38.90, 'rx' => false],
                ['name' => 'Lenços Umedecidos Huggies', 'principle' => 'N/A', 'price' => 19.50, 'rx' => false],
                ['name' => 'Lenços Johnson\'s Baby 48un', 'principle' => 'N/A', 'price' => 18.20, 'rx' => false],
            ],
            CategorySubclass::BABY_FORMULA->value => [
                ['name' => 'Leite NAN Supreme 1 800g', 'principle' => 'N/A', 'price' => 78.00, 'rx' => false],
                ['name' => 'Aptamil Profutura 2 800g', 'principle' => 'N/A', 'price' => 92.50, 'rx' => false],
                ['name' => 'Nestogeno 1 400g', 'principle' => 'N/A', 'price' => 35.40, 'rx' => false],
                ['name' => 'Enfamil Premium 1 400g', 'principle' => 'N/A', 'price' => 48.90, 'rx' => false],
                ['name' => 'Milnutri Cereal Infantil', 'principle' => 'N/A', 'price' => 15.20, 'rx' => false],
                ['name' => 'Mucilon Arroz e Aveia', 'principle' => 'N/A', 'price' => 12.40, 'rx' => false],
                ['name' => 'Leite Ninho Fases 1+', 'principle' => 'N/A', 'price' => 42.00, 'rx' => false],
                ['name' => 'Sustagen Kids Chocolate', 'principle' => 'N/A', 'price' => 54.00, 'rx' => false],
            ],
            CategorySubclass::BABY_ACCESSORIES->value => [
                ['name' => 'Chupeta Avent Ultra Air', 'principle' => 'N/A', 'price' => 58.00, 'rx' => false],
                ['name' => 'Mamadeira NUK First Choice', 'principle' => 'N/A', 'price' => 74.90, 'rx' => false],
                ['name' => 'Copo de Transição Lillo', 'principle' => 'N/A', 'price' => 32.40, 'rx' => false],
                ['name' => 'Escova de Mamadeira Sanremo', 'principle' => 'N/A', 'price' => 18.50, 'rx' => false],
                ['name' => 'Aspirador Nasal NoseFrida', 'principle' => 'N/A', 'price' => 125.00, 'rx' => false],
                ['name' => 'Mordedor de Silicone Fisher', 'principle' => 'N/A', 'price' => 28.90, 'rx' => false],
                ['name' => 'Termômetro de Banho Peixinho', 'principle' => 'N/A', 'price' => 15.00, 'rx' => false],
                ['name' => 'Prendedor de Chupeta Mam', 'principle' => 'N/A', 'price' => 24.10, 'rx' => false],
            ],

            // 8. BELEZA E BEM-ESTAR
            CategorySubclass::SUN_PROTECTION->value => [
                ['name' => 'Anthelios XL FPS 60', 'principle' => 'N/A', 'price' => 95.00, 'rx' => false],
                ['name' => 'Vichy Idéal Soleil FPS 50', 'principle' => 'N/A', 'price' => 88.00, 'rx' => false],
                ['name' => 'Neutrogena Sun Fresh 70', 'principle' => 'N/A', 'price' => 64.20, 'rx' => false],
                ['name' => 'Sundown Praia e Piscina 30', 'principle' => 'N/A', 'price' => 45.00, 'rx' => false],
                ['name' => 'Protetor Solar Episol Color', 'principle' => 'N/A', 'price' => 78.90, 'rx' => false],
                ['name' => 'Nivea Sun Kids FPS 60', 'principle' => 'N/A', 'price' => 54.00, 'rx' => false],
                ['name' => 'Minesol Oil Control 70', 'principle' => 'N/A', 'price' => 82.10, 'rx' => false],
                ['name' => 'Avene Cleanance Sun 50', 'principle' => 'N/A', 'price' => 99.00, 'rx' => false],
            ],
            CategorySubclass::SKINCARE->value => [
                ['name' => 'Água Micelar Garnier', 'principle' => 'N/A', 'price' => 32.50, 'rx' => false],
                ['name' => 'Cicatricure Gel Cicatrizes', 'principle' => 'N/A', 'price' => 48.90, 'rx' => false],
                ['name' => 'Gel de Limpeza Effaclar', 'principle' => 'N/A', 'price' => 65.00, 'rx' => false],
                ['name' => 'Sérum Vitamina C Payot', 'principle' => 'N/A', 'price' => 84.20, 'rx' => false],
                ['name' => 'Creme Anti-idade Revitalift', 'principle' => 'N/A', 'price' => 74.00, 'rx' => false],
                ['name' => 'Mineral 89 Vichy 50ml', 'principle' => 'N/A', 'price' => 165.00, 'rx' => false],
                ['name' => 'Bantol Derma Creme', 'principle' => 'N/A', 'price' => 32.10, 'rx' => false],
                ['name' => 'Tônico Adstringente Nivea', 'principle' => 'N/A', 'price' => 28.50, 'rx' => false],
            ],
            CategorySubclass::FIRST_AID->value => [
                ['name' => 'Band-aid Transparente c/ 40', 'principle' => 'N/A', 'price' => 14.50, 'rx' => false],
                ['name' => 'Gaze Estéril 7.5x7.5', 'principle' => 'N/A', 'price' => 2.50, 'rx' => false],
                ['name' => 'Álcool 70% 500ml', 'principle' => 'N/A', 'price' => 8.90, 'rx' => false],
                ['name' => 'Esparadrapo Impermeável', 'principle' => 'N/A', 'price' => 12.40, 'rx' => false],
                ['name' => 'Água Oxigenada 10v 100ml', 'principle' => 'N/A', 'price' => 4.20, 'rx' => false],
                ['name' => 'Algodão em Bola 50g', 'principle' => 'N/A', 'price' => 7.80, 'rx' => false],
                ['name' => 'Povidine Antisséptico 30ml', 'principle' => 'Iodopovidona', 'price' => 18.50, 'rx' => false],
                ['name' => 'Curativo Nexcare à prova d\'água', 'principle' => 'N/A', 'price' => 22.10, 'rx' => false],
            ],
            CategorySubclass::VITAMINS->value => [
                ['name' => 'Lavitan AZ c/ 60 drágeas', 'principle' => 'Vitaminas', 'price' => 35.00, 'rx' => false],
                ['name' => 'Centrum de A a Zinco c/ 30', 'principle' => 'Multivitamínico', 'price' => 68.00, 'rx' => false],
                ['name' => 'Ad-til Gotas 10ml', 'principle' => 'Vitamina A+D', 'price' => 14.20, 'rx' => false],
                ['name' => 'Targifor C efervescente c/ 16', 'principle' => 'Vitamina C + Arginina', 'price' => 42.90, 'rx' => false],
                ['name' => 'Redoxon Zinco c/ 10', 'principle' => 'Vitamina C + Zinco', 'price' => 24.50, 'rx' => false],
                ['name' => 'Vitamina D Sundown 1000 UI', 'principle' => 'Colecalciferol', 'price' => 52.00, 'rx' => false],
                ['name' => 'Pharmaton Vitality c/ 30', 'principle' => 'Vitaminas + Ginseng', 'price' => 84.00, 'rx' => false],
                ['name' => 'Beneroc c/ 100 drágeas', 'principle' => 'Complexo B', 'price' => 48.20, 'rx' => false],
            ],
        ];
    }
}
