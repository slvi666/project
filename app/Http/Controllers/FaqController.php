<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Menampilkan semua FAQ
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('faq.index', compact('faqs'));
    }

    // Menampilkan form tambah FAQ
    public function create()
    {
        return view('faq.create');
    }

    // Menyimpan FAQ baru
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        Faq::create($request->all());

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil disimpan!');
    }

    // Menampilkan form edit FAQ
    public function edit(Faq $faq)
    {
        return view('faq.edit', compact('faq'));
    }

    // Update data FAQ
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'nullable|string|max:255',
            'answer' => 'nullable|string',
        ]);

        $faq->update($request->all());

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    // Hapus FAQ
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
