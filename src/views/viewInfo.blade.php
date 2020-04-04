@extends('laragen::layout.laragen')

@section('contents')
    <section class="section" style="padding-top: 100px;min-height: 100vh;background-color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="text-align: center;">Generate View Files</h1>
                    <h4 style="font-size: 16px;text-align: center;">Provide bellow information.</h4>
                </div>
            </div>
            <form action="{{route('laragen.view')}}" method="post" class="repeater">
                @csrf
                <input type="hidden" name="fields" value="{{implode(',',$fields)}}">
                <input type="hidden" name="models" value="{{$model}}">
                <input type="hidden" name="modelNameSpace" value="{{$modelNameSpace}}">
                <div class="row">
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="namespace" class="bmd-label-floating">View file path</label>
                            <input type="text" class="form-control" id="namespace" name="namespace">
                            <span class="bmd-help">Please provide the namespace for your view files. Example: admin/permission</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="layout" class="bmd-label-floating">Extendable layout path</label>
                            <input type="text" class="form-control" id="layout" name="layout">
                            <span class="bmd-help">Example: layout.app</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <label for="section" class="bmd-label-floating">Section name where the code will sit</label>
                            <input type="text" class="form-control" id="section" name="section">
                            <span class="bmd-help">Example: contents</span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 mr-auto ml-auto">
                        <label for="namespace" class="bmd-label">Choose the files you need</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="create"> Create
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="edit"> Edit
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="index"> Index
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="show"> Show
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                @foreach($fields as $field)
                    <div class="row">
                        <div class="col-lg-2 col-sm-2"></div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="namespace" class="bmd-label-floating">Field Name</label>
                                <input type="text" class="form-control" id="namespace" name="namespace" disabled value="{{$field}}">
                                <span class="bmd-help">Example: contents</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="{{$field}}" class="bmd-label-floating">Field Type</label>
                                <select name="{{$field}}" id="" class="form-control">
                                    <option value="">Select a type</option>
                                    <option value="button">Button</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="color">Color</option>
                                    <option value="date">Date</option>
                                    <option value="datetime-local">Datetime-local</option>
                                    <option value="email">Email</option>
                                    <option value="file">File</option>
                                    <option value="hidden">Hidden</option>
                                    <option value="image">Image</option>
                                    <option value="month">Month</option>
                                    <option value="number">Number</option>
                                    <option value="password">Password</option>
                                    <option value="radio">Radio</option>
                                    <option value="range">Range</option>
                                    <option value="select">Select Box</option>
                                    <option value="tel">Tel</option>
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="time">Time</option>
                                    <option value="url">URL</option>
                                    <option value="week">Week</option>
                                </select>
                                <span class="bmd-help"></span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-lg-8 col-sm-8 ml-auto mr-auto">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Next">
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
