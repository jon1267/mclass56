@extends('layouts.app')

{{--это шаблон гл стр. на ней не должно быть breadcrumbs. Секция с парам ''
как-бы опустошает bc. А на ост.стр. крошки будут см app.blade --}}
@section('breadcrumbs', '')

@section('content')
    <div class="card">
        <div class="card-header">Hello</div>

        <div class="card-body">
            Your site
        </div>
    </div>
@endsection