@extends('layouts.user')

@section('title', 'Pembayaran – ' . $booking->reservation_code)

@section('content')
<div class="p-6 lg:p-8 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 animate-fade-up">
        <div class="flex items-center gap-2 text-xs text-brand-600 font-semibold mb-1">
            <a href="{{ route('user.booking.index') }}" class="hover:underline">Booking</a>
            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-400">Pembayaran</span>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Pembayaran</h1>
        <p class="text-sm text-gray-500 mt-0.5">Upload bukti transfer untuk mengkonfirmasi booking kamu.</p>
    </div>

    {{-- Step indicator --}}
    <div class="flex items-center gap-2 mb-8 animate-fade-up" style="animation-delay:.04s">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-brand-200 text-brand-600 flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-xs font-medium text-brand-500 hidden sm:block">Pilih Jadwal</span>
        </div>
        <div class="step-line done"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs font-bold shadow">2</div>
            <span class="text-xs font-bold text-brand-700 hidden sm:block">Pembayaran</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-xs font-bold">3</div>
            <span class="text-xs text-gray-400 hidden sm:block">Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- LEFT: Ringkasan + Bank --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Ringkasan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 animate-slide-in" style="animation-delay:.08s">
                <h2 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Ringkasan Booking
                </h2>
                <div class="space-y-2 text-sm">
                    @php
                        $rows = [
                            'Nama Pemesan' => Auth::user()->name,
                            'Tanggal'      => \Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMMM YYYY'),
                            'Lapangan'     => $booking->field->name ?? '–',
                            'Jam'          => \Carbon\Carbon::parse($booking->start_time)->format('H:i') . ' – ' . \Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                            'Durasi'       => $booking->duration_hours . ' Jam',
                            'Harga'        => 'Rp ' . number_format($booking->price_per_hour, 0, ',', '.') . '/jam',
                        ];
                    @endphp
                    @foreach($rows as $label => $value)
                    <div class="flex justify-between gap-2">
                        <span class="text-gray-400">{{ $label }}</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $value }}</span>
                    </div>
                    @endforeach
                    <div class="border-t border-dashed border-gray-100 pt-2.5 flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-extrabold text-brand-600">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Transfer Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 animate-slide-in" style="animation-delay:.12s">
                <h2 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Transfer ke Rekening
                </h2>
                <div class="bg-brand-50 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 shadow">
                        <span class="text-white font-extrabold text-xs">BRI</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-mono font-bold text-gray-900 text-base tracking-widest">0123-4567-8901</p>
                        <p class="text-xs text-gray-500 mt-0.5">Bank BRI · a.n <span class="font-semibold text-gray-700">Arung Futsal</span></p>
                    </div>
                    <button onclick="copyRek(this)" class="p-2 rounded-lg hover:bg-brand-100 transition-colors flex-shrink-0" title="Salin">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                </div>
                <p class="mt-3 text-xs text-gray-400">
                    Transfer tepat <span class="font-bold text-gray-700">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span> sesuai total.
                </p>
            </div>

        </div>

        {{-- RIGHT: Upload --}}
        <div class="lg:col-span-3 animate-fade-up" style="animation-delay:.14s">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col">
                <h2 class="font-bold text-gray-800 mb-5 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Upload Bukti Pembayaran
                </h2>

                <form action="{{ route('user.payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 gap-5">
                    @csrf

                    {{-- Drop Zone --}}
                    <label for="proof_image" id="drop-zone"
                           class="upload-zone group flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-2xl p-8 cursor-pointer hover:border-brand-400 hover:bg-brand-50 transition-all min-h-52">

                        <div id="upload-placeholder" class="flex flex-col items-center gap-3 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-brand-100 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700 text-sm">Klik untuk upload bukti pembayaran</p>
                                <p class="text-xs text-gray-400 mt-0.5">Format JPG, PNG · Maks. 5 MB</p>
                            </div>
                        </div>

                        <div id="upload-preview" class="hidden flex-col items-center gap-3">
                            <div class="relative">
                                <img id="preview-img" src="" alt="Preview" class="max-h-44 rounded-xl object-cover shadow-md" />
                                <div class="absolute top-2 right-2 bg-brand-500 text-white rounded-full p-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            </div>
                            <p id="preview-name" class="text-xs font-medium text-gray-700"></p>
                            <button type="button" onclick="clearUpload()" class="text-xs text-red-500 hover:underline">Hapus & ganti</button>
                        </div>

                        <input type="file" id="proof_image" name="proof_image" accept="image/jpg,image/jpeg,image/png" class="hidden" />
                    </label>

                    @error('proof_image')
                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror

                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <p class="text-xs text-amber-700">Pastikan foto bukti transfer <strong>jelas dan terbaca</strong>. Admin akan memverifikasi dalam 1×24 jam.</p>
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-brand-200/50 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
const fileInput   = document.getElementById('proof_image');
const dropZone    = document.getElementById('drop-zone');
const placeholder = document.getElementById('upload-placeholder');
const previewDiv  = document.getElementById('upload-preview');
const previewImg  = document.getElementById('preview-img');
const previewName = document.getElementById('preview-name');

fileInput.addEventListener('change', e => { if (e.target.files[0]) showPreview(e.target.files[0]); });

dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-brand-400', 'bg-brand-50'); });
dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-brand-400', 'bg-brand-50'); });
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-brand-400', 'bg-brand-50');
    const f = e.dataTransfer.files[0];
    if (f && f.type.startsWith('image/')) {
        const dt = new DataTransfer(); dt.items.add(f);
        fileInput.files = dt.files;
        showPreview(f);
    }
});

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = ev => {
        previewImg.src = ev.target.result;
        previewName.textContent = file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
        placeholder.classList.add('hidden');
        previewDiv.classList.remove('hidden');
        previewDiv.classList.add('flex');
    };
    reader.readAsDataURL(file);
}

function clearUpload() {
    fileInput.value = '';
    previewImg.src = '';
    placeholder.classList.remove('hidden');
    previewDiv.classList.add('hidden');
    previewDiv.classList.remove('flex');
}

function copyRek(btn) {
    navigator.clipboard.writeText('012345678901').then(() => {
        btn.innerHTML = `<svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>`;
        setTimeout(() => { btn.innerHTML = `<svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`; }, 2000);
    });
}
</script>
@endpush