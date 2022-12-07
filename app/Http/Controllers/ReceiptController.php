<?php

namespace App\Http\Controllers;

use App\Enums\ReceiptStatusEnum;
use App\Enums\ReceiptTypeEnum;
use App\Services\ReceiptService;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ReceiptController extends Controller
{

    protected $receiptService;
    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('receipts.index', [
            // 'receipts' => Receipt::paginate(8)->with('createdBy')
            'receipts' => Receipt::paginate(8),
            'receiptStatusEnum' => ReceiptStatusEnum::cases()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse 
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $fields = $request->validate([
            'status' => ['required', new Enum(ReceiptStatusEnum::class)],
            'foto' => 'mimes:jpeg,jpg,png|max:15000'
        ]);

        $foto = '';

        if ($request->hasFile('foto')) {
            $request->foto->store('requests', 'public');
            $foto = $request->foto->hashName();
        }

        $newReceipt = $this->receiptService->createNewReceipt($fields['status'], $user_id, $foto);

        return response()->json(['message' => 'Success', 'receipt' => $newReceipt]);
    }

    public function image($fileName)
    {
        $path = storage_path() . '/app/public/requests/' . $fileName;
        if (!file_exists($path)) {
            return response()->download(public_path('img/default.jpg'));
        }
        return response()->download($path);
    }
}
