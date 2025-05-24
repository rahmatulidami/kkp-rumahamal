<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Ambil semua komentar untuk sebuah post.
     */
    public function index($postId)
    {
        // Ambil komentar utama dan semua descendants secara rekursif
        $comments = Comment::where('post_id', $postId)
            ->whereNull('parent_id')
            ->with('children')
            ->with('parent')
            ->get();

        // Hitung semua komentar pada post (termasuk reply)
        $count = Comment::where('post_id', $postId)->count();

        return response()->json([
            'comments' => $comments,
            'count' => $count
        ]);
    }

    /**
     * Tambahkan komentar baru.
     */
    public function store(Request $request)
    {
        $isAdmin = auth()->check() && auth()->user()->is_admin;

        $request->validate([
            'post_id' => 'required|integer',
            'content' => 'required|string|max:1000',
            'author' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'author' => $isAdmin ? (auth()->user()->name ?? 'Admin') : $request->author,
            'is_admin' => $isAdmin,
            'content' => $request->content,
        ]);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    // app/Http/Controllers/CommentController.php

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Optional: Hanya admin yang bisa hapus
        if (!auth()->user() || !auth()->user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Hapus beserta semua anak-anaknya (jika ingin)
        $comment->delete();

        return response()->json(['success' => true]);
    }

    // /**
    //  * Hapus komentar (beserta semua child-nya).
    //  */
    // public function destroy($id)
    // {
    //     $comment = Comment::findOrFail($id);

    //     // Hapus komentar secara rekursif
    //     $this->deleteRecursive($comment);

    //     return response()->json(['success' => true, 'message' => 'Komentar berhasil dihapus.']);
    // }

    // /**
    //  * Fungsi untuk menghapus komentar beserta semua child-nya secara rekursif.
    //  */
    // private function deleteRecursive(Comment $comment)
    // {
    //     foreach ($comment->children as $child) {
    //         $this->deleteRecursive($child);
    //     }

    //     $comment->delete();
    // }
}