<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        if ($request->file('image')) {
            $path = $request->file('image')->store('images/uploads', 'public');
            $url = asset('storage/' . $path);
            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to upload image.']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $path = str_replace('/storage/', '', $request->image);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path); // Hapus file dari storage
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|max:2048', // Validasi file gambar
    //     ]);

    //     if ($request->file('image')) {
    //         $path = $request->file('image')->store('images/uploads', 'public'); // Simpan gambar di storage
    //         $url = asset('storage/' . $path); // Buat URL publik gambar
    //         return response()->json(['success' => true, 'imageUrl' => $url]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Failed to upload image.']);
    // }

    // public function delete(Request $request)
    // {
    //     $request->validate([
    //         'imageUrl' => 'required|string',
    //     ]);

    //     $path = str_replace(asset('storage') . '/', '', $request->imageUrl);

    //     if (Storage::disk('public')->exists($path)) {
    //         Storage::disk('public')->delete($path); // Hapus file dari storage
    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Image not found.']);
    // }
}
