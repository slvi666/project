<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Menampilkan daftar pesan untuk pengguna yang login
public function index()
{
    $user = auth()->user();

    // Gabungkan pesan yang dikirim dan diterima, lalu ambil pesan terakhir per lawan bicara
    $messages = \App\Models\Message::where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Kelompokkan berdasarkan lawan bicara
    $conversations = [];

    foreach ($messages as $message) {
        $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;

        // Simpan hanya 1 pesan terakhir per lawan bicara
        if (!isset($conversations[$otherUserId])) {
            $conversations[$otherUserId] = $message;
        }
    }

    return view('chats.index', ['conversations' => $conversations]);
    }

    // Menampilkan halaman untuk membuat pesan baru
public function create()
{
    // Ambil semua pengguna kecuali yang sedang login
    $users = User::all();

    // Kirim data pengguna ke view
    return view('chats.create', compact('users'));
}


    // Menyimpan pesan baru
 public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string',
    ]);

    // Simpan pesan ke database
    Message::create([
        'sender_id' => auth()->user()->id, // ID pengirim diambil dari pengguna yang sedang login
        'receiver_id' => $request->receiver_id, // ID penerima dari input dropdown
        'message' => $request->message,
        'sent_at' => now(),
    ]);

    // Redirect ke halaman chat dengan penerima
    return redirect()->route('messages.show', ['receiver_id' => $request->receiver_id]);
}

    // Menampilkan percakapan antara pengguna dan penerima tertentu
    public function show($receiver_id)
    {
        // Ambil pesan antara pengguna dan penerima
        $user = auth()->user();
        $receiver = User::findOrFail($receiver_id);

        $messages = Message::where(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $user->id)->where('receiver_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($user, $receiver) {
            $query->where('sender_id', $receiver->id)->where('receiver_id', $user->id);
        })
        ->get();

        // Kirim data ke view percakapan
        return view('chats.show', compact('messages', 'receiver'));
    }

    // Menampilkan halaman untuk mengedit pesan
    public function edit($id)
    {
        // Ambil pesan berdasarkan ID
        $message = Message::findOrFail($id);

        // Cek apakah pengirim pesan adalah pengguna yang login
        if ($message->sender_id != auth()->user()->id) {
            return redirect()->route('messages.index')->with('error', 'Anda tidak memiliki izin untuk mengedit pesan ini.');
        }

        // Kirim pesan ke view untuk diedit
        return view('chats.edit', compact('message'));
    }

    // Update pesan jika diperlukan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string',
        ]);

        // Ambil pesan berdasarkan ID
        $message = Message::findOrFail($id);

        // Pastikan hanya pengirim yang dapat mengedit pesannya
        if ($message->sender_id != auth()->user()->id) {
            return redirect()->route('messages.index')->with('error', 'Anda tidak memiliki izin untuk mengedit pesan ini.');
        }

        // Perbarui pesan
        $message->message = $request->message;
        $message->save();

        // Redirect ke percakapan dengan penerima
        return redirect()->route('messages.show', ['receiver_id' => $message->receiver_id])->with('success', 'Pesan berhasil diperbarui!');
    }

    // Menghapus pesan (opsional)
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        // Pastikan hanya pengirim yang bisa menghapus pesan
        if ($message->sender_id != auth()->user()->id) {
            return redirect()->route('messages.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pesan ini.');
        }

        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
