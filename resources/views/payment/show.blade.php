@extends('layouts.user')
@section('title', 'Pembayaran')

@section('content')
<div class="p-6 lg:p-8 max-w-5xl">

    <div class="mb-6 animate-fade-up">
        <p class="flex items-center gap-1.5 text-xs font-semibold text-brand-600 mb-1.5">
            <a href="{{ route('user.booking.index') }}" class="hover:underline">Booking</a>
            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-400">Pembayaran</span>
        </p>
        <h1 class="text-2xl font-extrabold text-gray-900">Pembayaran</h1>
        <p class="text-sm text-gray-500 mt-0.5">Upload bukti transfer untuk mengkonfirmasi booking.</p>
    </div>

    {{-- Steps --}}
    <div class="flex items-center gap-2 mb-8 animate-fade-up" style="animation-delay:.04s">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background:#ccfbef;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="#0d9488" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-xs font-semibold text-brand-600 hidden sm:block">Pilih Jadwal</span>
        </div>
        <div class="step-line done"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-black shadow-btn"
                 style="background:linear-gradient(135deg,#14b8a6,#0d9488);">2</div>
            <span class="text-xs font-black text-brand-700 hidden sm:block">Pembayaran</span>
        </div>
        <div class="step-line"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xs font-bold">3</div>
            <span class="text-xs text-gray-400 hidden sm:block">Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Ringkasan --}}
            <div class="bg-white rounded-2xl overflow-hidden animate-slide-right" style="box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);animation-delay:.06s">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-brand-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h2 class="font-bold text-gray-800 text-sm">Ringkasan Booking</h2>
                </div>
                <div class="px-5 py-4 space-y-2.5">
                    @php
                        $rows=['Nama Pemesan'=>Auth::user()->name,
                               'Tanggal'=>\Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMMM YYYY'),
                               'Lapangan'=>$booking->field->name??'–',
                               'Jam'=>\Carbon\Carbon::parse($booking->start_time)->format('H:i').' – '.\Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                               'Durasi'=>$booking->duration_hours.' Jam',
                               'Harga'=>'Rp '.number_format($booking->price_per_hour,0,',','.').'/ jam'];
                    @endphp
                    @foreach($rows as $l => $v)
                    <div class="flex justify-between gap-2 text-sm">
                        <span class="text-gray-400">{{ $l }}</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $v }}</span>
                    </div>
                    @endforeach
                    <div class="pt-3 border-t border-dashed border-gray-200 flex justify-between items-center">
                        <span class="font-bold text-gray-900 text-sm">Total</span>
                        <span class="font-black text-brand-600 text-lg">Rp {{ number_format($booking->total_amount,0,',','.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Rekening --}}
            <div class="bg-white rounded-2xl p-5 animate-slide-right" style="box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);animation-delay:.1s">
                <h2 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-brand-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    Transfer ke Rekening
                </h2>
                <div class="rounded-xl p-4 flex items-center gap-3" style="background:linear-gradient(135deg,#f0fdf9,#ccfbef);">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:linear-gradient(135deg,#1d4ed8,#1e40af);box-shadow:0 4px 12px rgba(30,64,175,.35);">
                        <span class="text-white font-black text-xs tracking-wide">BRI</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-mono font-black text-gray-900 text-base tracking-widest">0123-4567-8901</p>
                        <p class="text-xs text-gray-500 mt-0.5">Bank BRI · a.n <span class="font-bold text-gray-700">Arung Futsal</span></p>
                    </div>
                    <button id="copy-btn" onclick="copyRek(this)" class="p-2 rounded-lg hover:bg-white transition-all" title="Salin">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                </div>
                <p class="mt-3 text-xs text-gray-400">
                    Transfer tepat <strong class="text-gray-600">Rp {{ number_format($booking->total_amount,0,',','.') }}</strong>
                </p>
            </div>
        </div>

        {{-- RIGHT: Upload --}}
        <div class="lg:col-span-3 animate-fade-up" style="animation-delay:.12s">
            <div class="bg-white rounded-2xl p-6 h-full flex flex-col" style="box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);">
                <h2 class="font-bold text-gray-800 text-sm mb-5 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-brand-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    Upload Bukti Pembayaran
                </h2>

                <form action="{{ route('user.payment.upload',$booking->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 gap-4">
                    @csrf

                    <label for="proof_image" id="drop-zone"
                           class="upload-zone flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-2xl p-8 cursor-pointer flex-1 min-h-56 hover:border-brand-400 hover:bg-brand-50/50 transition-all group">

                        <div id="upload-placeholder" class="flex flex-col items-center gap-3 text-center">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-transform group-hover:scale-105"
                                 style="background:linear-gradient(135deg,#f0fdf9,#ccfbef);">
                                <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-700 text-sm">Klik untuk upload</p>
                                <p class="text-xs text-gray-400 mt-0.5">JPG, PNG · Maks. 5 MB</p>
                            </div>
                        </div>

                        <div id="upload-preview" class="hidden flex-col items-center gap-3">
                            <div class="relative">
                                <img id="preview-img" src="" alt="Preview" class="max-h-44 rounded-xl object-cover shadow-md"/>
                                <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full flex items-center justify-center text-white"
                                     style="background:linear-gradient(135deg,#14b8a6,#0d9488);">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            </div>
                            <p id="preview-name" class="text-xs font-semibold text-gray-600"></p>
                            <button type="button" onclick="clearUpload()" class="text-xs font-semibold text-red-500 hover:text-red-600">Hapus & ganti</button>
                        </div>

                        <input type="file" id="proof_image" name="proof_image" accept="image/jpg,image/jpeg,image/png" class="hidden"/>
                    </label>

                    @error('proof_image')
                    <p class="text-xs text-red-500 font-semibold">{{ $message }}</p>
                    @enderror

                    <div class="flex items-start gap-3 px-4 py-3 rounded-xl" style="background:#fef9ec;border:1px solid #fde68a;">
                        <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <p class="text-xs text-amber-700 font-medium">Foto harus <strong>jelas & terbaca</strong>. Admin verifikasi dalam 1×24 jam.</p>
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl text-sm font-black text-white transition-all active:scale-95"
                            style="background:linear-gradient(135deg,#14b8a6,#0d9488);box-shadow:0 4px 20px rgba(20,184,166,.45);">
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
const fileInput=$('proof_image'),dz=$('drop-zone'),ph=$('upload-placeholder'),pv=$('upload-preview'),pi=$('preview-img'),pn=$('preview-name');
function $(id){return document.getElementById(id);}
fileInput.addEventListener('change',e=>{if(e.target.files[0])show(e.target.files[0]);});
dz.addEventListener('dragover',e=>{e.preventDefault();dz.classList.add('border-brand-400','bg-brand-50');});
dz.addEventListener('dragleave',()=>{dz.classList.remove('border-brand-400','bg-brand-50');});
dz.addEventListener('drop',e=>{
    e.preventDefault();dz.classList.remove('border-brand-400','bg-brand-50');
    const f=e.dataTransfer.files[0];
    if(f&&f.type.startsWith('image/')){const dt=new DataTransfer();dt.items.add(f);fileInput.files=dt.files;show(f);}
});
function show(f){
    const r=new FileReader();
    r.onload=ev=>{pi.src=ev.target.result;pn.textContent=f.name+' ('+(f.size/1024/1024).toFixed(2)+' MB)';
        ph.classList.add('hidden');pv.classList.remove('hidden');pv.classList.add('flex');};
    r.readAsDataURL(f);
}
function clearUpload(){fileInput.value='';pi.src='';ph.classList.remove('hidden');pv.classList.add('hidden');pv.classList.remove('flex');}
function copyRek(btn){
    navigator.clipboard.writeText('012345678901').then(()=>{
        btn.innerHTML=`<svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>`;
        setTimeout(()=>{btn.innerHTML=`<svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`;},2000);
    });
}
</script>
@endpush