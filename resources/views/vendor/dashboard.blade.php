@extends('vendor.layouts.app')
@section('title', 'Dashboard | Vendor')
{{-- header code --}}
@section('header-css')
    <link rel="stylesheet" href="{{ asset('plugins/charts/chart.css') }}">
@endsection

@section('main')
    <div class="content-wrapper pb-5">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Main Claim</h3>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases }}</h3>
                                    <p>Cases</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_query') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_query }}</h3>
                                    <p>Cases : Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_investigation') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_investigation }}</h3>
                                    <p>Cases : Investigation</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_reject') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_reject }}</h3>
                                    <p>Cases : Reject</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_underprocess') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_underprocess }}</h3>
                                    <p>Cases : Under Process</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_approved') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_approved }}</h3>
                                    <p>Cases : Approved</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'main_claim_cases_paid') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $main_claim_cases_paid }}</h3>
                                    <p>Cases : Piad</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Post One Data</h3>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases }}</h3>
                                    <p>Cases</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_query') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_query }}</h3>
                                    <p>Cases : Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_investigation') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_investigation }}</h3>
                                    <p>Cases : Investigation</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_reject') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_reject }}</h3>
                                    <p>Cases : Reject</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_underprocess') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_underprocess }}</h3>
                                    <p>Cases : Under Process</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_approved') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_approved }}</h3>
                                    <p>Cases : Approved</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_claim_cases_paid') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_claim_cases_paid }}</h3>
                                    <p>Cases : Piad</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Post Two Data</h3>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases }}</h3>
                                    <p>Cases</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_query') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_query }}</h3>
                                    <p>Cases : Query</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_investigation') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_investigation }}</h3>
                                    <p>Cases : Investigation</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_reject') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_reject }}</h3>
                                    <p>Cases : Reject</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_underprocess') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_underprocess }}</h3>
                                    <p>Cases : Under Process</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_approved') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_approved }}</h3>
                                    <p>Cases : Approved</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6">
                        <a target="_blank" href="{{ route('vendor.case.index', 'post_two_claim_cases_paid') }}"
                            class="text-light">
                            <div class="small-box text-sm bg-secondary">
                                <div class="inner">
                                    <h3>{{ $post_two_claim_cases_paid }}</h3>
                                    <p>Cases : Piad</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <div class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- footer code --}}
@section('footer-script')

@endsection
@endsection
