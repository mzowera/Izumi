@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="container">
                        <div class="row mb-4">
                            @foreach ( $stats as $stat )
                                <div class="col-4 p-1 box-shadow">
                                    <a href="{{ $stat['link'] }}" class="text-decoration-none {{ !$stat['enabled'] ? 'disabled' : '' }}">
                                        <div class="card p-3 text-center">
                                            <h1 class="card-title display-1 m-auto">
                                                <i class="fa fa-{{$stat['icon']}}" aria-hidden="true"></i>
                                            </h1>
                                            <h3>{{ $stat['title'] }}</h3>
                                            <span class="badge-stats badge badge-dark m-3 p-2">{{$stat['value']}}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
