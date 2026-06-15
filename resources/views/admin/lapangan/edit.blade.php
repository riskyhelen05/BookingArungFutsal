@extends('layouts.admin')

@section('title', 'Edit Lapangan')
@section('page-title', 'Edit Lapangan')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

        {{-- FORM EDIT --}}
        <form action="{{ route('admin.lapangan.update', $field->id) }}"
              method="POST"
              enctype="multipart/form-data">

            {{-- PANGGIL PARTIAL FORM --}}
            @include('admin.lapangan.partials.form')

        </form>

    </div>

</div>

@endsection