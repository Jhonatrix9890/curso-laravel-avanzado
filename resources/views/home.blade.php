@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="row">
                    <div class="col-md-6">
                    {!! $chart->container() !!}
                    </div>    
                    <div class="col-md-6">
                            {!! $chart2->container() !!}
                 </div>                 
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>
{!! $chart->script() !!}
{!! $chart2->script() !!}
@endpush

