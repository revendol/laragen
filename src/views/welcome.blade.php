@extends('laragen::layout.laragen')

@section('contents')
    <div class="page-header header-filter" data-parallax="true" style="background-image: url('{{url('vendor/laragen')}}/img/bg7.jpg');height: 70vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="title">We want you to be productive</h1>
                    <h4 style="font-size: 16px;">Complete CRUD operation and save a lot of time not writing repetitive code. We want you to use your time in more complex task.</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="main ">
        <div class="container">
            <div class="section text-center">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto" style="margin-bottom: 30px;">
                        <h2 class="title">Select what you want to generate</h2>
                    </div>
                </div>
                <div class="features">
                    <div class="row">
                        <div class="col-8 ml-auto mr-auto">
                            <div class="card card-nav-tabs">
                                <div class="card-header card-header-warning">
                                    <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="nav-item">
                                                    <a href="{{route('laragen.model.get')}}" class="btn btn-default">Generate Everything for a CRUD</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="tab-content text-center">
                                        <div class="tab-pane active" id="profile">
                                            <p> You will be going throw a form where we will ask all about your project information. Like namespace for your controller, model name, database name etc. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="section text-center">
                <h2 class="title">Here is our team</h2>
            </div>
        </div>
    </div>
@endsection
