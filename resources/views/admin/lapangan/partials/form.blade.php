
@csrf

@if(isset($field))
    @method('PUT')
@endif

<div class="space-y-6">

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-2">
            Nama Lapangan
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $field->name ?? '') }}"
               class="w-full rounded-2xl border border-slate-200 px-4 py-3
                      focus:outline-none focus:ring-2 focus:ring-[#0F9E82]">

        @error('name')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Harga --}}
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-2">
            Harga Per Jam
        </label>

        <input type="number"
               name="price_per_hour"
               value="{{ old('price_per_hour', $field->price_per_hour ?? '') }}"
               class="w-full rounded-2xl border border-slate-200 px-4 py-3
                      focus:outline-none focus:ring-2 focus:ring-[#0F9E82]">

        @error('price_per_hour')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-2">
            Status Lapangan
        </label>

<select name="status"
    class="w-full rounded-2xl border border-slate-200 px-4 py-3">

    {{-- TERSEDIA --}}
    <option value="available"
        {{ old('status', $field->status ?? '') == 'available' ? 'selected' : '' }}>
        Tersedia
    </option>

    {{-- MAINTENANCE --}}
    <option value="maintenance"
        {{ old('status', $field->status ?? '') == 'maintenance' ? 'selected' : '' }}>
        Maintenance
    </option>

    {{-- DITUTUP --}}
    <option value="closed"
        {{ old('status', $field->status ?? '') == 'closed' ? 'selected' : '' }}>
        Ditutup
    </option>

</select>

    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-2">
            Deskripsi
        </label>

        <textarea name="description"
                  rows="5"
                  class="w-full rounded-2xl border border-slate-200 px-4 py-3
                         focus:outline-none focus:ring-2 focus:ring-[#0F9E82]">{{ old('description', $field->description ?? '') }}</textarea>
    </div>

    {{-- Foto Lama --}}
    @if(isset($field) && $field->photo_url)
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-3">
            Foto Saat Ini
        </label>

        <img src="{{ asset('storage/'.$field->photo_url) }}"
             class="w-48 h-32 object-cover rounded-2xl border border-slate-200">
    </div>
    @endif

    {{-- Upload --}}
    <div>
        <label class="block text-sm font-semibold text-[#1A1A2E] mb-2">
            Upload Foto
        </label>

        <input type="file"
               name="photo_url"
               class="w-full rounded-2xl border border-slate-200 px-4 py-3
                      file:mr-4 file:px-4 file:py-2
                      file:border-0 file:rounded-xl
                      file:bg-[#0F9E82] file:text-white">

        @error('photo_url')
            <p class="text-red-500 text-sm mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Button --}}
    <div class="flex justify-end gap-3 pt-4">

        <a href="{{ route('admin.lapangan.index') }}"
           class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200
                  text-sm font-semibold transition">
            Batal
        </a>

        <button type="submit"
                class="px-5 py-3 rounded-2xl bg-[#0F9E82]
                       hover:bg-[#0c876f]
                       text-white text-sm font-semibold transition">

            {{ isset($field) ? 'Update Lapangan' : 'Tambah Lapangan' }}

        </button>

    </div>

</div>

