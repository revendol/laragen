@extends('laragen::layout.laragen')

@section('contents')
    <section class="section" style="padding-top: 100px;height: 100vh;background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="text-align: center;">Let's start</h1>
                    <h4 style="font-size: 16px;text-align: center;">Let's start with model.</h4>
                </div>
            </div>
            <form action="{{route('laragen.model')}}" method="post" class="repeater">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <h3>Provide some basic information</h3>
                        <div class="form-group">
                            <label for="namespace" class="bmd-label-floating">Namespace of the model</label>
                            <input type="text" class="form-control" id="namespace" name="namespace">
                            <span class="bmd-help">Please provide the namespace for your model.</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="model" class="bmd-label-floating">Model Name</label>
                            <input type="text" class="form-control" id="model" name="model">
                            <span class="bmd-help">Please provide the name for your model.</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="table_name" class="bmd-label-floating">Table Name</label>
                            <input type="text" class="form-control" id="table_name" name="table_name">
                            <span class="bmd-help">Please provide the name of table exist in database related to this model.</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Next">
                        </div>
                    </div>

                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">--}}
{{--                        <h3>Define fields in database table</h3>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </form>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{url('')}}/vendor/laragen//js/plugins/repeater.js" type="text/javascript"></script>
    <script src="{{url('')}}/vendor/laragen//js/plugins//indicator-repeater.js" type="text/javascript"></script>

@endsection
{{--//column types--}}
{{--bigIncrements--}}
{{--unsignedBigInteger--}}
{{--boolean--}}
{{--string--}}
{{--integer--}}
{{--float--}}
{{--double--}}
{{--text--}}
{{--mediumText--}}
{{--longText--}}
{{--//foreign key--}}
{{--foreign('user_id')->references('id')->on('users')->onDelete('cascade');--}}
{{--timestamps--}}

{{--//Column Modifiers--}}
{{--default--}}
{{--nullable--}}
{{--unique--}}
