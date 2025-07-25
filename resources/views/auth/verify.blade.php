@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verificar-email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.link-verificacao') }}
                        </div>
                    @endif

                    {{ __('auth.checar-email') }}
                    {{ __('auth.sem-receber-email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.receber-outro') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
