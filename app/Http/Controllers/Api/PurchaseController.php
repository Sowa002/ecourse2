<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function purchaseCourse($courseId, Request $request)
    {
        $user = $request->user(); // Get the authenticated user
        $course = Course::find($courseId); // Get the course by ID

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Check if the user already owns the course
        $purchase = Purchase::where('user_id', $user->id)
                            ->where('course_id', $courseId)
                            ->first();

        if ($purchase && $purchase->status === 'completed') {
            return response()->json(['message' => 'Course already owned or purchased'], 400);
        }

        // Add entry to pivot table to track the purchase with status pending
        if (!$purchase) {
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'status' => 'pending',
                'transaction_id' => uniqid(), // Generate a unique transaction ID
            ]);
        }

        // Check if snap token exists and is still valid
        if ($purchase->snap_token && $purchase->snap_token_expiry && Carbon::parse($purchase->snap_token_expiry)->isFuture()) {
            return response()->json([
                'snap_token' => $purchase->snap_token,
                'snap_token_expiry' => $purchase->snap_token_expiry
            ]);
        }

        // Generate Snap token if it does not exist or has expired
        $snapTokenResponse = app(PaymentController::class)->createTransaction(
            new Request([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'purchase' => $purchase->toArray()
            ]), 
            $courseId // Pastikan untuk meneruskan $courseId sebagai argumen kedua
        );

        $snapTokenData = $snapTokenResponse->getData();

        if (isset($snapTokenData->snap_token)) {
            // Update purchase with new snap token and expiry
            $purchase->snap_token = $snapTokenData->snap_token;
            $purchase->snap_token_expiry = Carbon::now()->addMinutes(30)->setTimezone('Asia/Jakarta'); // Set expiry time in local timezone
            $purchase->save();
        }

        // Return Snap token in the response
        return $snapTokenResponse;
    }
}
