@extends('backend.layouts.backend')
@section('main')
    <main class="column">
        dashboard
    </main>
    <script>
        $(function(){
            $('#dashboard').addClass('active');
        });
    </script>
@endsection