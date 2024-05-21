@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    <div class="user-info">
                        <p>You are logged in as:</p>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-roles">
                            Roles:
                            @foreach (Auth::user()->roles as $role)
                                <span class="role">{{ $role->title }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container px-4 mx-auto">

    <div class="p-6 m-10 bg-white rounded shadow">
        {!! $chart->container() !!}
    </div>

</div>
@endsection
@section('scripts')
<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
@parent

@endsection