<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * LẤY DANH SÁCH ĐÁNH GIÁ CỦA 1 XE (Công khai)
     */
    public function index(string $carId) // Đã thêm string
    {
        $reviews = Review::where('car_id', $carId)
                         ->with('user:id,name,avatar')
                         ->latest()
                         ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reviews
        ], 200);
    }

    /**
     * THÊM ĐÁNH GIÁ
     */
    public function store(Request $request, string $carId) // Đã thêm string
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => $request->user()->id,
            'car_id'  => $carId,
            'rating'  => $request->rating,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đánh giá thành công',
            'data' => $review
        ], 201);
    }

    /**
     * SỬA ĐÁNH GIÁ
     */
    public function update(Request $request, string $id) // Đã thêm string
    {
        $review = Review::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$review) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đánh giá'], 404);
        }

        $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'content' => 'sometimes|string|max:1000',
        ]);

        $review->update($request->only(['rating', 'content']));

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật đánh giá thành công',
            'data' => $review
        ], 200);
    }

    /**
     * XÓA ĐÁNH GIÁ
     */
    public function destroy(Request $request, string $id) // Đã thêm string
    {
        $review = Review::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$review) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đánh giá'], 404);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa đánh giá'
        ], 200);
    }
}