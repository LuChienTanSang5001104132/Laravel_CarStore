<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestDrive;
use App\Models\Car;
use Illuminate\Http\Request;

class AdminTestDriveController extends Controller
{
    public function index(Request $request)
    {
        $query = TestDrive::with('car');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $testDrives = $query->latest()->paginate(15);
        return view('admin.test-drives.index', compact('testDrives'));
    }

    public function edit($id)
    {
        $testDrive = TestDrive::with('car')->findOrFail($id);
        $cars = Car::where('status', 1)->get();
        return view('admin.test-drives.edit', compact('testDrive', 'cars'));
    }

    public function update(Request $request, $id)
    {
        $testDrive = TestDrive::findOrFail($id);

        $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255',
            'car_id'         => 'nullable|exists:cars,id',
            'preferred_date' => 'nullable|date',
            'message'        => 'nullable|string',
            'status'         => 'required|in:pending,contacted,completed,cancelled',
        ]);

        $testDrive->update($request->only([
            'full_name', 'phone', 'email', 'car_id', 'preferred_date', 'message', 'status'
        ]));

        return redirect()->route('admin.test-drives.index')
                         ->with('success', 'Cập nhật đăng ký lái thử thành công!');
    }

    public function destroy($id)
    {
        $testDrive = TestDrive::findOrFail($id);
        $testDrive->delete();

        return redirect()->route('admin.test-drives.index')
                         ->with('success', 'Đã xóa đăng ký lái thử.');
    }
}