@extends('laragen::layout.laragen')

@section('contents')
    <section class="section" style="padding-top: 150px;min-height: 100vh;background-color: #ffffff;box-sizing: border-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title" style="text-align: center;">Hurrah! You are all done!</h1>
                    <h4 style="font-size: 16px;text-align: center;">Just copy bellow code and paste it in your <code style="font-size: 20px;">/routes/web.php</code></h4>
                    <h1 style="font-size: 25px;border: 1px solid gray;padding: 15px;padding-left: 30px;border-radius: 5px;background-color: #dddddd;"><code>{{$route}}</code></h1>
                </div>
            </div>
        </div>
    </section>

@endsection
