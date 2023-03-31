@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="mb-3">
                @if(session('updateSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>  {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                    <i class="fa-solid fa-lg fa-arrow-left-long" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                {{-- <h3 class="text-center title-2">Pizza Details</h3> --}}
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" class="img-thumbnail shadow-sm">
                                </div>
                                <div class="col-7">
                                    <div class="my-3  btn bg-danger text-white d-block w-50 fs-5">{{ $pizza->name }}</div>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-money-bill-1-wave me-2 fs-5"></i> {{ $pizza->price }} kyats</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clock me-2 fs-5"></i> {{ $pizza->waiting_time }} mins</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-eye me-2 fs-5"></i> {{ $pizza->view_count }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fas fa-chart-bar fs-5 me-2"></i></i> {{ $pizza->category_name}}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-user-clock me-2 fs-5"></i>  {{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"><i class="fa-solid fa-comments me-2 fs-5"></i>Description</div>
                                    <div class="">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
