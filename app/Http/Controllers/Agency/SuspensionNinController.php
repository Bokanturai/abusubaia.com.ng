<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AgentService;
use App\Models\Service;
use App\Models\ServiceField;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SuspensionNinController extends Controller
{
    public function index(Request $request)
    {
        $validationService = Service::where('name', 'Validation')->first();
        $suspensionField = $validationService ? $validationService->fields()->where('field_code', '041')->first() : null;

        if (!$suspensionField) {
            // Fallback or handle missing field
            $price = 3000;
            $fieldId = null;
        } else {
            $user = Auth::user();
            $role = $user->role ?? 'user';
            $price = $suspensionField->prices()->where('user_type', $role)->value('price') ?? $suspensionField->base_price;
            $fieldId = $suspensionField->id;
        }

        $wallet = Wallet::where('user_id', Auth::id())->first();
        
        $query = AgentService::where('user_id', Auth::id())
            ->where('service_type', 'NIN_SUSPENSION');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nin', 'like', "%{$searchTerm}%");
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('nin.suspension', [
            'price' => $price,
            'fieldId' => $fieldId,
            'wallet' => $wallet,
            'submissions' => $submissions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:service_fields,id',
            'nin' => 'required|digits:11',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'phone_number' => 'required|digits:11',
            'consent' => 'required|accepted',
        ]);

        $serviceField = ServiceField::with('service')->findOrFail($request->field_id);
        
        $user = Auth::user();
        $role = $user->role ?? 'user';
        
        $servicePrice = $serviceField->prices()->where('user_type', $role)->value('price') ?? $serviceField->base_price;

        $wallet = Wallet::where('user_id', $user->id)->first();

        if (!$wallet || $wallet->balance < $servicePrice) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        DB::beginTransaction();

        try {
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
            
            if (!$wallet || $wallet->balance < $servicePrice) {
                throw new \Exception('Insufficient wallet balance.');
            }

            $wallet->decrement('balance', $servicePrice);

            $transactionRef = 'SUS-' . strtoupper(Str::random(10));
            $performedBy = $user->first_name . ' ' . $user->last_name;

            $transaction = Transaction::create([
                'transaction_ref' => $transactionRef,
                'user_id' => $user->id,
                'amount' => $servicePrice,
                'description' => "Suspension NIN for {$request->nin}",
                'type' => 'debit',
                'status' => 'completed',
                'performed_by' => $performedBy,
                'metadata' => [
                    'service' => 'NIN_SUSPENSION',
                    'nin' => $request->nin,
                    'name' => $request->first_name . ' ' . $request->last_name,
                ],
            ]);

            AgentService::create([
                'reference' => 'REF-' . strtoupper(Str::random(10)),
                'user_id' => $user->id,
                'service_id' => $serviceField->service_id,
                'service_field_id' => $serviceField->id,
                'field_code' => $serviceField->field_code,
                'transaction_id' => $transaction->id,
                'service_type' => 'NIN_SUSPENSION',
                'nin' => $request->nin,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'phone_number' => $request->phone_number,
                'amount' => $servicePrice,
                'status' => 'pending',
                'submission_date' => now(),
                'service_field_name' => $serviceField->field_name,
                'performed_by' => $performedBy,
            ]);

            DB::commit();
            return back()->with('success', 'Suspension NIN request submitted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Suspension NIN Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to process request: ' . $e->getMessage());
        }
    }
}
