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

class SuspensionNinController extends Controller
{
    /**
     * List suspension requests with filters and pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = AgentService::query()
            ->select('agent_services.*', 'users.email as user_email')
            ->join('users', 'agent_services.user_id', '=', 'users.id')
            ->where('agent_services.service_type', 'NIN_SUSPENSION');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('agent_services.nin', 'like', "%$search%")
                  ->orWhere('agent_services.reference', 'like', "%$search%")
                  ->orWhere('agent_services.performed_by', 'like', "%$search%")
                  ->orWhere('users.email', 'like', "%$search%");
            });
        }

        if ($statusFilter) {
            $query->where('agent_services.status', $statusFilter);
        }

        $enrollments = $query->orderByRaw("CASE agent_services.status
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
            'pending'    => AgentService::where('service_type', 'NIN_SUSPENSION')->where('status', 'pending')->count(),
            'processing' => AgentService::where('service_type', 'NIN_SUSPENSION')->where('status', 'processing')->count(),
            'completed'  => AgentService::where('service_type', 'NIN_SUSPENSION')->whereIn('status', ['resolved', 'successful', 'completed'])->count(),
        ];

        return view('admin.suspension.index', compact('enrollments', 'search', 'statusFilter', 'statusCounts'));
    }

    /**
     * Show details of a single suspension request
     */
    public function show($id)
    {
        $enrollmentInfo = AgentService::findOrFail($id);
        $user = User::find($enrollmentInfo->user_id);

        return view('admin.suspension.view', compact('enrollmentInfo', 'user'));
    }

    /**
     * Update the status of a suspension request
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,resolved,successful,completed,rejected,failed',
            'comment' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $enrollment = AgentService::findOrFail($id);
            $oldStatus = $enrollment->status;

            $enrollment->status = $request->status;
            $enrollment->comment = $request->comment;
            $enrollment->save();

            // Handle refund logic if rejected
            if (in_array($request->status, ['rejected', 'failed']) && !in_array($oldStatus, ['rejected', 'failed'])) {
                $this->processRefund($enrollment);
            }

            DB::commit();
            return redirect()->route('admin.suspension.index')
                ->with('successMessage', 'Status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Suspension Update Error: ' . $e->getMessage());
            return redirect()->route('admin.suspension.index')
                ->with('errorMessage', 'Failed to update status: ' . $e->getMessage());
        }
    }

    /**
     * Handle refund when a request is rejected
     */
    private function processRefund($enrollment)
    {
        $user = User::find($enrollment->user_id);
        if (!$user) return;

        $refundAmount = $enrollment->amount; // Full refund for manual agency services usually

        $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();
        if (!$wallet) return;

        $wallet->increment('balance', $refundAmount);

        Transaction::create([
            'transaction_ref' => 'REF-' . strtoupper(Str::random(10)),
            'user_id' => $user->id,
            'performed_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'amount' => $refundAmount,
            'description' => "Refund for rejected Suspension NIN request #{$enrollment->id}",
            'type' => 'refund',
            'status' => 'completed',
        ]);
    }
}
