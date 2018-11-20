@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Win one of our prizes !!!</div>

                <div class="card-body">
                    <ul>
                        <li id="cash">
                            Cash - up to 1000$.
                        </li>
                        <li>
                            One of the items is a: phone, tablet, etc.
                        </li>
                        <li>                           
                            Get up to 50,000 points to your bonus account.
                        </li>
                    </ul>
                    
                    @guest
                        <a class="btn btn-success btn-right" href="{{ route('login') }}">Get prize</a>
                    @else
                        <button id="get_prize" class="btn btn-success btn-right">Get prize</button>
                    @endguest                    
                </div>
                                                
            </div>
            
            <div class="card card-prize">
                <div class="card-header">Your prize!!!</div>                
                <div class="card-body">
                    
                </div>
                                                
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/user.js') }}"></script>
    
@endpush
