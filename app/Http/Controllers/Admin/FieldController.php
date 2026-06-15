<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::latest()->get();

        $available = Field::where('status', 'available')->count();
        $maintenance = Field::where('status', 'maintenance')->count();
        $closed = Field::where('status', 'closed')->count();

        return view('admin.lapangan.index', compact(
            'fields',
            'available',
            'maintenance',
            'closed'
        ));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_hour' => 'required|numeric',
            'status' => 'required|in:available,maintenance,closed',
            'photo_url' => 'nullable|image'
        ]);

        $photo = null;

        if ($request->hasFile('photo_url')) {
            $photo = $request->file('photo_url')
                ->store('fields', 'public');
        }

        Field::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'status' => $request->status,
            'photo_url' => $photo
        ]);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }


    public function show($id)
    {
        $field = Field::findOrFail($id);

        return view('admin.lapangan.show', compact('field'));
    }



    public function edit($id)
    {
        $field = Field::findOrFail($id);

        return view('admin.lapangan.edit', compact('field'));
    }

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $photo = $field->photo_url;

        if ($request->hasFile('photo_url')) {
            $photo = $request->file('photo_url')
                ->store('fields', 'public');
        }

        $field->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'status' => $request->status,
            'photo_url' => $photo
        ]);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        $field->delete();

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus');
    }
}