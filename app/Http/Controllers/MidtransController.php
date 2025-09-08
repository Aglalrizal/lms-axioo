<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $signatureKey = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response("Invalid signature", 403)
                ->header('Content-Type', 'text/plain');
        }

        $transaction = Transaction::find($request->order_id);
        if (!$transaction) {
            return response("Transaction not found", 404)
                ->header('Content-Type', 'text/plain');
        }

        $statusMap = [
            'settlement' => 'paid',
            'capture'    => 'paid',
            'pending'    => 'pending',
            'cancel'     => 'failed',
            'expire'     => 'failed',
            'deny'       => 'failed',
        ];

        if (isset($statusMap[$request->transaction_status])) {
            $transaction->status = $statusMap[$request->transaction_status];
            $transaction->save();
        }

        return response("OK", 200)
            ->header('Content-Type', 'text/plain');
    }
}
