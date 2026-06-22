<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cutis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class CutiController extends Controller
{
    public function index()
    {
        try {
            $Cuti = Cutis::where('user_id', Auth::id())
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'user_id' => $item->user_id,
                        'start_date' => $item->start_date,
                        'end_date' => $item->end_date,
                        'reason' => $item->reason,
                        'status' => $item->status,
                        'note' => $item->Note, // Database column is capital 'Note'
                        'created_at' => $item->created_at ? $item->created_at->toDateTimeString() : null,
                        'updated_at' => $item->updated_at ? $item->updated_at->toDateTimeString() : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $Cuti,
                'message' => 'Successfully retrieved cuti data',
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cuti data',
            ], 500);
        }
    }

    public function store (Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                /**
                 * Start Date
                 *
                 * @example 2026-01-01
                 */
                'start_date' => 'required|date',
                /**
                 * End Date
                 *
                 * @example 2026-01-02
                 */
                'end_date' => 'required|date|after_or_equal:start_date',
                /**
                 * Reason
                 *
                 * @example Keperluan keluarga
                 */
                'reason' => 'required|string',
            ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $Cuti = Cutis::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        $Cuti->load('user');
        return response()->json([
            'success' => true,
            'data' => $Cuti,
            'message' => 'Cuti request created successfully',
        ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cuti request',
            ], 500);

        }

    }
}
