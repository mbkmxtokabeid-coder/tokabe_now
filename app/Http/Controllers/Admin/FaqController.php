<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'question_en' => 'required',
            'answer_id' => 'required',
            'answer_en' => 'required',
            'sort_order' => 'nullable|integer',
        ]);

        Faq::create([
            'question_id' => $request->question_id,
            'question_en' => $request->question_en,
            'answer_id' => $request->answer_id,
            'answer_en' => $request->answer_en,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question_id' => 'required',
            'question_en' => 'required',
            'answer_id' => 'required',
            'answer_en' => 'required',
            'sort_order' => 'nullable|integer',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question_id' => $request->question_id,
            'question_en' => $request->question_en,
            'answer_id' => $request->answer_id,
            'answer_en' => $request->answer_en,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
