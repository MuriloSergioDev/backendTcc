@extends('layouts.default')


@section('title', 'Admin')

@push('css')
    <link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
    <link href="/assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
@endpush

@section('content')

    {{ $msg ?? '' }}
    @include('controle.includes.alert.mensagem')
    <h1 class="page-header mb-3">Seja bem-vindo a sua área adminstrativa!</h1>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            function loadContentPage(page) {
                var url = "{{ url('/') }}/";
                $('#content-wrapper').children().fadeOut(150, function() {
                    if (page != 'index') {
                        url += page;
                    }
                    $('#content-wrapper').load(url, function(data) {
                        $(this).html(data);
                    });
                });
            }
        });
    </script>
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/4.2.2/jquery.flot.pie.min.js"
        integrity="sha512-xjmShmauHgG5L4dEf291qw/YPAbnTnDevXa+yXAp7slPWnLGDJNlJBuEn8ckjVImEZdI71V7+2ymsh+2Ym3rZA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/assets/plugins/d3/d3.min.js"></script>
    <script src="/assets/plugins/nvd3/build/nv.d3.js"></script>
    <script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
    <script src="/assets/plugins/jvectormap-next/jquery-jvectormap-world-mill.js"></script>
    <script src="/assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/demo/dashboard-v3.js"></script>    
@endpush
