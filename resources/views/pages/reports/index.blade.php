@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-6">
        @livewire('report.income-report', ['userId' => auth()->user()->id])
    </div>

    <div class="col-lg-6">
        @livewire('report.daily-income-report', ['userId' => auth()->user()->id])
    </div>

</div>
@endsection