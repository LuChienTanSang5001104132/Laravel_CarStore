<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('brand')->withCount('orderItems');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate($request->get('per_page', 15));

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $cars]);
        }
        
        $brands = Brand::all();
        return view('admin.cars.index', compact('cars', 'brands'));
    }

    // BỔ SUNG: Hàm hiển thị Form Thêm Xe
    public function create()
    {
        $brands = Brand::all();
        return view('admin.cars.create', compact('brands'));
    }

    // BỔ SUNG: Hàm hiển thị Form Sửa Xe
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $brands = Brand::all();
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    public function show(Request $request, $id)
    {
        $car = Car::with(['brand', 'reviews.user'])->findOrFail($id);
        
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $car]);
        }
        return view('admin.cars.show', compact('car'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'brand_id'        => 'required|exists:brands,id',
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:0',
            'year'            => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type'            => 'required|string',
            'fuel_type'       => 'nullable|string',
            'transmission'    => 'nullable|string',
            'engine_capacity' => 'nullable|string',
            'seats'           => 'nullable|integer|min:1',
            'color'           => 'nullable|string',
            'description'     => 'nullable|string',
            'status'          => 'boolean',
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->except(['featured_image', 'slug']);
        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('cars', 'public');
        }

        $car = Car::create($data);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Thêm xe thành công', 'data' => $car->load('brand')], 201);
        }

        // BỔ SUNG: Redirect về danh sách kèm thông báo xanh cho Web
        return redirect()->route('admin.cars.index')->with('success', 'Thêm siêu xe mới thành công!');
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'name'            => 'sometimes|string|max:255',
            'brand_id'        => 'sometimes|exists:brands,id',
            'price'           => 'sometimes|numeric|min:0',
            'quantity'        => 'sometimes|integer|min:0',
            'year'            => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'type'            => 'sometimes|string',
            'fuel_type'       => 'nullable|string',
            'transmission'    => 'nullable|string',
            'engine_capacity' => 'nullable|string',
            'seats'           => 'nullable|integer',
            'color'           => 'nullable|string',
            'description'     => 'nullable|string',
            'status'          => 'boolean',
            'featured_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->except(['featured_image', 'slug', '_method']);

        if ($request->filled('name')) {
            $data['slug'] = Str::slug($request->name) . '-' . $car->id;
        }

        if ($request->hasFile('featured_image')) {
            if ($car->featured_image) {
                Storage::disk('public')->delete($car->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('cars', 'public');
        }

        $car->update($data);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật xe thành công', 'data' => $car->fresh()->load('brand')]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Cập nhật thông tin xe thành công!');
    }

    public function destroy(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        if ($car->featured_image) {
            Storage::disk('public')->delete($car->featured_image);
        }
        $car->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Xóa xe thành công']);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Đã xóa xe khỏi kho!');
    }
}