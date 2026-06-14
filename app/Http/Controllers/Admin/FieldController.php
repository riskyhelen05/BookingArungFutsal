<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::latest()->get();

        return view('admin.lapangan.index', compact('fields'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('fields', 'public');
        }

        Field::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'status' => $request->status,
            'photo_url' => $photo,
        ]);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }

    public function edit(Field $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Field $lapangan)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price_per_hour' => 'required|numeric|min:0',
            'status' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {

            if ($lapangan->photo_url) {
                Storage::disk('public')->delete($lapangan->photo_url);
            }

            $lapangan->photo_url =
                $request->file('photo')->store('fields', 'public');
        }

        $lapangan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'status' => $request->status,
            'photo_url' => $lapangan->photo_url,
        ]);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil diperbarui');
    }

    public function destroy(Field $lapangan)
    {
        if ($lapangan->photo_url) {
            Storage::disk('public')->delete($lapangan->photo_url);
        }

        $lapangan->delete();

        return back()->with('success', 'Lapangan berhasil dihapus');
    }
}