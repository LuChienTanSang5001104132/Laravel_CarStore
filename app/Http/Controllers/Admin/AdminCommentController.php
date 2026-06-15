<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review; // Nếu bạn dùng model Comment thì sửa thành Comment
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    /**
     * Hiển thị danh sách bình luận (có lọc)
     */
    public function index(Request $request)
    {
        $query = Review::with([
            'user:id,name,email,avatar',
            'car:id,name,brand_id',
            'car.brand:id,name',
        ]);

        // Lọc theo từ khóa nội dung
        if ($request->filled('search')) {
            $query->where('content', 'like', "%{$request->search}%");
        }

        // Lọc theo xe
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        // Lọc theo số sao
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Lọc theo trạng thái duyệt
        if ($request->filled('status')) {
            if ($request->status == 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status == 'pending') {
                $query->where('is_approved', false);
            }
        }

        $comments = $query->latest()->paginate($request->get('per_page', 20));
        
        // Hỗ trợ cả tên biến $reviews cho view cũ
        $reviews = $comments;

        // Trả về JSON nếu là API request
        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $comments
            ]);
        }

        // Trả về view cho admin web
        return view('admin.comments.index', compact('comments', 'reviews'));
    }

    /**
     * Duyệt bình luận (cập nhật is_approved = true)
     */
    public function approve(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Duyệt bình luận thành công'
            ]);
        }

        return redirect()->back()->with('success', 'Bình luận đã được duyệt.');
    }

    /**
     * Form chỉnh sửa bình luận
     */
    public function edit($id)
    {
        $comment = Review::with('user', 'car')->findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Cập nhật bình luận
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content'       => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'is_approved'   => 'sometimes|boolean',
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->only('content', 'rating', 'is_approved'));

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật bình luận thành công'
            ]);
        }

        return redirect()->route('admin.comments.index')->with('success', 'Cập nhật bình luận thành công.');
    }

    /**
     * Xóa bình luận
     */
    public function destroy(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa bình luận thành công'
            ]);
        }

        return redirect()->route('admin.comments.index')->with('success', 'Đã xóa bình luận thành công!');
    }
}