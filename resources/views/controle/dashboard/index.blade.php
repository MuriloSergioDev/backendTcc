@section('title', 'Dashboard')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    </ol>

    <h1 class="page-header">Dashboard</h1>

    <h3>Bloco 1</h3>

    <div id="donut-chart" class="height-sm"></div>

    <h3>Bloco 2</h3>
    <div id="donut-chart2" class="height-sm"></div>
@endsection

@push('scripts')
    <script src="/assets/plugins/flot/jquery.flot.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.time.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.pie.js"></script>
    <script>
        $(document).ready(function() {
            if ($('#donut-chart').length !== 0) {

                let bloco1_salas = [];
                let bloco2_salas = [];

                axios.get('/api/dashboard/salas')
                    .then(res => {
                        let bloco1 = res.data.bloco1_salas
                        let bloco2 = res.data.bloco2_salas

                        bloco1.forEach(sala => {
                            bloco1_salas.push({
                                label: sala.titulo,
                                data: sala.eventos.length,
                                color: COLOR_PURPLE_DARKER
                            })
                        });

                        bloco2.forEach(sala => {
                            bloco2_salas.push({
                                label: sala.titulo,
                                data: sala.eventos.length,
                                color: COLOR_PURPLE_DARKER
                            })
                        });

                        $.plot('#donut-chart', bloco1_salas, {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true,
                                    label: {
                                        show: true
                                    }
                                }
                            },
                            legend: {
                                show: true
                            }
                        });

                        $.plot('#donut-chart2', bloco2_salas, {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true,
                                    label: {
                                        show: true
                                    }
                                }
                            },
                            legend: {
                                show: true
                            }
                        });
                    })
                    .catch(err => {
                        console.error(err);
                    })


                // var donutData = [{
                //         label: "Chrome",
                //         data: 35,
                //         color: COLOR_PURPLE_DARKER
                //     },
                //     {
                //         label: "Firefox",
                //         data: 30,
                //         color: COLOR_PURPLE
                //     },
                //     {
                //         label: "Safari",
                //         data: 15,
                //         color: COLOR_PURPLE_LIGHTER
                //     },
                //     {
                //         label: "Opera",
                //         data: 10,
                //         color: COLOR_BLUE
                //     },
                //     {
                //         label: "IE",
                //         data: 5,
                //         color: COLOR_BLUE_DARKER
                //     }
                // ];                
            }
        });
    </script>
@endpush
