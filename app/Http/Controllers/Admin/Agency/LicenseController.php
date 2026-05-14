<?php

namespace App\Http\Controllers\Admin\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\AgentService;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LicenseController extends Controller
{
    /**
     * List license requests with filters and pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = AgentService::query()
            ->select('agent_services.*', 'users.email as user_email')
            ->join('users', 'agent_services.user_id', '=', 'users.id')
            ->where('agent_services.service_type', 'license_request');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('agent_services.first_name', 'like', "%$search%")
                  ->orWhere('agent_services.last_name', 'like', "%$search%")
                  ->orWhere('agent_services.email', 'like', "%$search%")
                  ->orWhere('agent_services.phone_number', 'like', "%$search%")
                  ->orWhere('agent_services.reference', 'like', "%$search%")
                  ->orWhere('agent_services.field_name', 'like', "%$search%")
                  ->orWhere('users.email', 'like', "%$search%");
            });
        }

        if ($statusFilter) {
            $query->where('agent_services.status', $statusFilter);
        }

        $submissions = $query->orderByRaw("CASE agent_services.status
                WHEN 'pending' THEN 1
                WHEN 'processing' THEN 2
                WHEN 'resolved' THEN 3
                WHEN 'successful' THEN 4
                WHEN 'rejected' THEN 5
                WHEN 'failed' THEN 6
                ELSE 99 END")
            ->orderByDesc('agent_services.created_at')
            ->paginate(10);

        $statusCounts = [
            'pending'    => AgentService::where('service_type', 'license_request')->where('status', 'pending')->count(),
            'processing' => AgentService::where('service_type', 'license_request')->where('status', 'processing')->count(),
            'completed'  => AgentService::where('service_type', 'license_request')->whereIn('status', ['resolved', 'successful', 'completed'])->count(),
        ];

        return view('admin.license.index', compact('submissions', 'search', 'statusFilter', 'statusCounts'));
    }

    /**
     * Show details of a single license request
     */
    public function show($id)
    {
        $submission = AgentService::findOrFail($id);
        $user = User::find($submission->user_id);

        return view('admin.license.view', compact('submission', 'user'));
    }

    /**
     * Update the status of a license request
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,resolved,successful,completed,rejected,failed',
            'comment' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $submission = AgentService::findOrFail($id);
            $oldStatus = $submission->status;

            $submission->status = $request->status;
            $submission->comment = $request->comment;
            $submission->approved_by = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $submission->save();

            // Handle refund logic if rejected
            if (in_array($request->status, ['rejected', 'failed']) && !in_array($oldStatus, ['rejected', 'failed'])) {
                $this->processRefund($submission);
            }

            DB::commit();
            return redirect()->route('admin.license.index')
                ->with('successMessage', 'Status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin License Update Error: ' . $e->getMessage());
            return redirect()->route('admin.license.index')
                ->with('errorMessage', 'Failed to update status: ' . $e->getMessage());
        }
    }

    /**
     * Handle refund when a request is rejected
     */
    private function processRefund($submission)
    {
        $user = User::find($submission->user_id);
        if (!$user) return;

        $refundAmount = $submission->amount; 

        $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
        if (!$wallet) return;

        $wallet->increment('balance', $refundAmount);

        Transaction::create([
            'transaction_ref' => 'REF-' . strtoupper(Str::random(10)),
            'user_id' => $user->id,
            'performed_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'amount' => $refundAmount,
            'description' => "Refund for rejected License request #{$submission->id}",
            'type' => 'refund',
            'status' => 'completed',
        ]);
    }
}
