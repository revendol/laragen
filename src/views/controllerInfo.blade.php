@extends('laragen::layout.laragen')

@section('contents')
    <section class="section" style="padding-top: 100px;height: 100vh;background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="text-align: center;">Generate Controller</h1>
                    <h4 style="font-size: 16px;text-align: center;">Provide bellow information.</h4>
                </div>
            </div>
            <form action="{{route('laragen.controller')}}" method="post" class="repeater">
                @csrf
                <input type="hidden" name="fields" value="{{$fields}}">
                <input type="hidden" name="models" value="{{$model}}">
                <input type="hidden" name="modelNameSpace" value="{{$modelNameSpace}}">
                <input type="hidden" name="viewNameSpace" value="{{$viewNameSpace}}">
                <div class="row">
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="namespace" class="bmd-label-floating">Namespace for the Controller</label>
                            <input type="text" class="form-control" id="namespace" name="namespace">
                            <span class="bmd-help">Please provide the namespace for your controller. Example: App\Http\Controllers\Auth</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Generate">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{url('')}}/vendor/laragen//js/plugins/repeater.js" type="text/javascript"></script>
    <script src="{{url('')}}/vendor/laragen//js/plugins//indicator-repeater.js" type="text/javascript"></script>
@endsection
