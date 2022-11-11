@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Resumenes segmentados</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-sm-12 col-12">
                                    <div class="card shadow p-3 mb-5 bg-success rounded ">
                                        <div class="card-content">
                                            <div class="card-body">

                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-hospital-alt font-large-2 float-left"
                                                            style="font-size:35px"></i>
                                                    </div>
                                                    <div class="media-body text-right">

                                                        <a href="cuarteles" class="text-white">Cuarteles</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-12 col-12">
                                    <div class="card shadow p-3 mb-5 bg-warning rounded">
                                        <div class="card-content">
                                            <div class="card-body">

                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-clinic-medical font-large-2 float-left"
                                                            style="font-size:35px"></i>
                                                    </div>
                                                    <div class="media-body text-right">

                                                        <a href="mausoleos" class="text-white">Mausoleos</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-12 col-12">
                                    <div class="card shadow p-3 mb-5 bg-info rounded">
                                        <div class="card-content">
                                            <div class="card-body">

                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="fas fa-cross font-large-2 float-left"
                                                            style="font-size:35px"></i>
                                                    </div>
                                                    <div class="media-body text-right">

                                                        <a href="tumbas" class="text-white">Tumbas</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
