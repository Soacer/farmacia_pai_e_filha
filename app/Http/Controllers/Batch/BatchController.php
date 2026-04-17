<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class BatchController extends Controller
{
    
    #[OA\Patch(
        path: '/batches/toggle-status/{id}',
        summary: 'Ativa ou Inativa um lote específico',
        tags: ['Lotes'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Status alterado com sucesso')
        ]
    )]
    public function toggleStatus($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $batch->isActive = !$batch->isActive;
            $batch->save();

            $status = $batch->isActive ? 'ativado' : 'inativado';
            return redirect()->back()->with('success', "Lote {$batch->batch_code} {$status}!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status.');
        }
    }

    #[OA\Get(
        path: '/batches/list',
        summary: 'Exibe a listagem visual de todos os lotes',
        tags: ['Lotes'],
        responses: [
            new OA\Response(response: 200, description: 'View carregada com sucesso'),
        ]
    )]
    public function showAllBatches()
    {
        $batches = Batch::with(['product', 'supplier'])
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('batch.batch_list', compact('batches'));
    }

    #[OA\Put(
        path: '/batches/update/{id}',
        summary: 'Atualiza os dados de um lote específico',
        tags: ['Lotes'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'batch_code', type: 'string'),
                    new OA\Property(property: 'quantity_now', type: 'integer'),
                    new OA\Property(property: 'expiration_date', type: 'string', format: 'date'),
                    new OA\Property(property: 'cost_price', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lote atualizado'),
            new OA\Response(response: 404, description: 'Lote não encontrado'),
        ]
    )]
    public function update(Request $request, $id)
    {
        try {
            $batch = Batch::findOrFail($id);

            $batch->update([
                'batch_code' => $request->batch_code,
                'quantity_now' => $request->quantity_now,
                'expiration_date' => $request->expiration_date,
                'cost_price' => str_replace(['.', ','], ['', '.'], $request->cost_price),
                'isActive' => $request->has('isActive') ? true : false,
            ]);

            return redirect()->back()->with('success', 'Lote atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar: '.$e->getMessage());
        }
    }

    #[OA\Patch(
        path: '/product/{id}/deactivate-batches',
        summary: 'Desativa todos os lotes ativos de um produto',
        tags: ['Lotes'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', description: 'ID do Produto', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lotes desativados com sucesso'),
        ]
    )]
    public function deactivateProductBatches($id)
    {
        Batch::where('idProducts', $id)
            ->where('isActive', true)
            ->update(['isActive' => false]);

        return response()->json(['success' => true]);
    }
}
