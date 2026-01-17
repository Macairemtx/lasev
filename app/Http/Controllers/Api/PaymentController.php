<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\RetreatPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Paiement d'un retreat plan + création ou connexion utilisateur
     */
    public function payAndRegisterOrLogin(Request $request, $planId)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::where('device_id', $request->device_id)->orWhere('email', $request->email)->first();
        if ($user) {
            // Si l'utilisateur n'a pas d'email ou de mot de passe, on complète son compte
            $updated = false;
            if (empty($user->email)) {
                $user->email = $request->email;
                $updated = true;
            }
            if (empty($user->password)) {
                $user->password = Hash::make($request->password);
                $updated = true;
            }
            if ($updated) {
                $user->save();
            } elseif (!Hash::check($request->password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Mot de passe incorrect.'], 401);
            }
        } else {
            // Création du compte
            $user = User::create([
                'name' => $request->email,
                'email' => $request->email,
                'device_id' => $request->device_id,
                'password' => Hash::make($request->password),
            ]);
        }

        // Paiement (simulation)
        $payment = Payment::create([
            'retreat_plan_id' => $planId,
            'user_id' => $user->id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => 'completed',
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'paid_at' => now(),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'user' => $user,
            'payment' => $payment,
            'token' => $token
        ], 201);
    }
}
