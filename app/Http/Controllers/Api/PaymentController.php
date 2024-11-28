<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request, $id)
{
    $request->validate([
        'user' => 'required|array',
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'purchase' => 'required|array',
        'purchase.transaction_id' => 'required|string',
    ]);

    $user = $request->input('user');
    $transactionId = $request->input('purchase.transaction_id');
    $course = Course::find($id);

    if (!$course) {
        Log::error('Course not found', ['course_id' => $id]);
        return response()->json(['message' => 'Course not found'], 404);
    }

    // Ensure gross_amount and price are integers
    $grossAmount = intval($course->price);
    $price = intval($course->price);

    $params = [
        'transaction_details' => [
            'order_id' => $transactionId,
            'gross_amount' => $grossAmount,
        ],
        'customer_details' => [
            'first_name' => $user['name'],
            'email' => $user['email'],
        ],
        'item_details' => [
            [
                'id' => $course->id,
                'price' => $price,
                'quantity' => 1,
                'name' => $course->class_name,
            ],
        ],
    ];

    Log::info('Midtrans transaction parameters', $params);

    try {
        $snapToken = Snap::getSnapToken($params);
        $snapTokenExpiry = Carbon::now()->addMinutes(30)->setTimezone('Asia/Jakarta'); // Set expiry time in local timezone
        Log::info('Snap token received', ['snap_token' => $snapToken]);

        return response()->json([
            'snap_token' => $snapToken,
            'snap_token_expiry' => $snapTokenExpiry
        ]);
    } catch (\Exception $e) {
        Log::error('Unable to create transaction', ['error' => $e->getMessage(), 'params' => $params]);
        return response()->json(['message' => 'Unable to create transaction'], 500);
    }
}


    public function handleWebhook(Request $request)
    {
        Log::info('Webhook received', $request->all());
    
        $transactionId = $request->input('transaction_id');
        $transactionStatus = $request->input('transaction_status');
        $orderId = $request->input('order_id');
    
        $purchase = Purchase::where('transaction_id', $transactionId)->first();
    
        if (!$purchase) {
            Log::error('Purchase not found for transaction ID', ['transaction_id' => $transactionId]);
            return response()->json(['message' => 'Purchase not found'], 404);
        }
    
        Log::info('Transaction status', ['transaction_status' => $transactionStatus]);
    
        if ($transactionStatus === 'settlement') {
            $purchase->status = 'completed';
            $purchase->save();
            Log::info('Purchase status updated to completed', ['purchase_id' => $purchase->id]);
        } else {
            Log::info('Transaction not completed', ['transaction_status' => $transactionStatus]);
        }
    
        return response()->json(['message' => 'Webhook handled successfully'], 200);
    }
}
