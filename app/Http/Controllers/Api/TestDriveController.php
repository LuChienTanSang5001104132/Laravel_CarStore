<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestDrive;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|max:255',
            'car_id'    => 'nullable|exists:cars,id',
            'preferred_date' => 'nullable|date',
            'message'   => 'nullable|string',
        ]);

        $testDrive = TestDrive::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký lái thử thành công! Chúng tôi sẽ liên hệ bạn sớm nhất.',
            'data'    => $testDrive,
        ], 201);
    }
}