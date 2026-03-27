<?php

namespace App\Http\Controllers\Batch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Http\Requests\Batch\StoreBatchRequest;
class BatchController extends Controller
{
    //
    public function createBatch(StoreBatchRequest $request){
        Batch::updateOrCreate(
            ['batch_code' => $request->batch_code],
            [
                ''
            ]
        );
    }
}
