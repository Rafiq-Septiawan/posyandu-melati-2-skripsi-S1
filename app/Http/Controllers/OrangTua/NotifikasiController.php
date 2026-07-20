<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $notifikasis = Notifikasi::where('user_id', $userId)
            ->latest()
            ->paginate(15);

        // Mark as read
        Notifikasi::where('user_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return view('orang-tua.notifikasi', compact('notifikasis'));
    }
}
