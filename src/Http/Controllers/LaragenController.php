<?php

namespace Radoan\Laragen\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaragenController extends Controller
{
    public function index(){
        return view('laragen::welcome');
    }
    public function generateModel(){
        return view('laragen::modelInfo');
    }
    public function model(Request $request)
    {
        $folders = explode('/',$request->namespace);
        $path = base_path();
        foreach ($folders as $folder){
            if ($folder === 'App'){
                $folder = 'app';
            }
            $path .= '/'.$folder;
            if (!file_exists($path)){
                mkdir($path);
            }
        }
        $query = 'DESCRIBE '.$request->table_name;
        $results = DB::select($query);
        $fields = [];
        foreach ($results as $result){
            if ($result->Field !== 'id' && $result->Field !== 'created_at' && $result->Field !== 'updated_at' && $result->Field !== 'deleted_at'){
                $fields[] = $result->Field;
            }
        }
        $this->makeModel($request->namespace,$request->model,$request->table_name,$fields);
        $model = $request->model;
        $modelNameSpace =  $request->namespace;

        return view('laragen::viewInfo',compact('fields','model','modelNameSpace'));
    }

    protected function makeModel($namespace,$modelName,$tableName = '',$fillable = [], $guarded = []){
        $model = fopen(base_path().'\\'.$namespace.'\\'.$modelName.'.php','w');
        $fillables = '[';
        foreach ($fillable as $key => $f){
            if($key==0){
                $fillables .= '"'.$f.'"';
            } else {
                $fillables .= ','.'"'.$f.'"';
            }
        }
        $fillables .= ']';
        $txt =
            "<?php 

namespace ".$namespace.';';
        $txt .= '

use Illuminate\Database\Eloquent\Model;
';
        $txt .= '
class '.$modelName.' extends Model
{
    protected $table = "'.$tableName.'";
    
    protected $fillable = '.$fillables.';
    
}';
        fwrite($model,$txt);
    }

    public function view(Request $request){
        $folders = explode('/',$request->namespace);
        $path = base_path().'/resources/views';
        $route = strtolower($request->models);
        $vn = '';
        foreach ($folders as $key => $folder){
            $path .= '/'.$folder;
            if (!file_exists($path)){
                mkdir($path);
            }
            if ($key === 0){
                $vn = $folder;
            } else {
                $vn .= '.'.$folder;
            }
        }
        if($request->index === 'on'){
            $this->generateIndex($path,$request->layout,$request->section,$request->fields,$route);
        }
        if ($request->create === 'on'){
            $this->generateCreate($path,$request);
        }
        if ($request->edit === 'on'){
            $this->generateEdit($path,$request);
        }
        if ($request->show === 'on'){
            $this->generateShow($path,$request);
        }
        $fields = $request->fields;
        $model = $request->models;
        $modelNameSpace =  $request->modelNameSpace;
        $viewNameSpace =  $vn;
        return view('laragen::controllerInfo',compact('fields','model','modelNameSpace','viewNameSpace'));
    }

    public function controllerView(Request $request){
        $this->validate($request,[
            'namespace' => 'required'
        ]);
        $folders = explode('\\',$request->namespace);
        $path = base_path();
        $cn = '';
        foreach ($folders as $key=>$folder){
            if ($folder === 'App'){
                $folder = 'app';
            }
            $path .= '/'.$folder;
            if (!file_exists($path)){
                mkdir($path);
            }
            if($key==0){
                $cn = $folder;
            } else {
                $cn .= '\\'.$folder;
            }

        }
        $fields = explode(',',$request->fields);
        $controller = fopen($path.'/'.$request->models.'Controller.php','w');
$txt ='<?php

namespace '.$request->namespace.';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use '.str_replace('/','\\',$request->modelNameSpace).'\\'.$request->models.';

class '.$request->models.'Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function index()
    {
        $rows = '.$request->models.'::orderBy("id","desc")->get();
        return view("'.$request->viewNameSpace.'.index",compact("rows"));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        return view("'.$request->viewNameSpace.'.create");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[';
foreach ($fields as $field){
    $txt .= '
           "'.$field.'"    => "required",';
}
$txt .= '
        ]);
        $data = [';
foreach ($fields as $field){
    $txt .= '
            "'.$field.'"    => $request->'.$field.',';
}
$txt .= '
        ];
        $'.strtolower($request->models).' = '.$request->models.'::create($data);
        return back()->with("success","Entry in '.$request->models.' was created successfully");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = '.$request->models.'::where("id",$id)->firstOrFail();
        return view("'.$request->viewNameSpace.'.show",compact("row"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = '.$request->models.'::where("id",$id)->firstOrFail();
        return view("'.$request->viewNameSpace.'.edit",compact("row"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[';
foreach ($fields as $field){
    $txt .= '
            "'.$field.'"    => "required",';
}
$txt .= '
        ]);
        $data = [';
foreach ($fields as $field){
    $txt .= '
            "'.$field.'"    => $request->'.$field.',';
}
$txt .='
        ];
        $'.strtolower($request->models).' = '.$request->models.'::where("id",$id)->update($data);
        return back()->with("success","Entry in '.$request->models.' with ID ".$id." was updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = '.$request->models.'::where("id",$id)->firstOrFail();
        $row->delete();
        return back()->with("success","Entry in '.$request->models.' with ID ".$id." was deleted successfully");
    }
}
';

        fwrite($controller,$txt);
        $cn = str_replace('app\Http\Controllers\\','',$cn);
        $route = "Route::resource('".strtolower($request->models)."','".$cn.'\\'.$request->models."Controller');";
        return view('laragen::done',compact('route'));
    }

    protected function generateIndex($path,$layout,$section,$fields,$route){
        $index = fopen($path.'/index.blade.php','w');
        $txt =
'@extends("'.$layout.'")

@section("'.$section.'")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Here is your Index View</h1>
                <a href="{{route(\''.$route.'.create\')}}" class="btn btn-success" style="margin-top: 15px;margin-bottom: 15px;">Create '.ucfirst($route).'</a>
            </div>
            <div class="col-md-12">
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th scope="col">#</th>';
foreach (explode(',',$fields) as $field){
$txt .= '
                            <th scope="col">'.ucfirst(str_replace('_',' ',$field)).'</th>';
}
$txt .= '
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $sl = 1; @endphp
                    @foreach($rows as $row)
                        <tr>
                            <th scope="row">{{$sl++}}</th>';
foreach (explode(',',$fields) as $field){
    $txt .= '
                            <td>{{$row->'.$field.'}}</td>';
}
$txt .= '
                            <td>
                            <a href="{{route(\''.$route.'.show\',$row->id)}}" class="btn btn-info">Show</a>
                            <a href="{{route(\''.$route.'.edit\',$row->id)}}" class="btn btn-warning">Edit</a>
                            <a class="btn btn-danger" title="delete" href="" onclick="
                                                if (confirm(\'Are You Sure To Delete This?\')){
                                                event.preventDefault();
                                                document.getElementById(\'delete-form{{ $row->id }}\').submit();
                                                }else {
                                                event.preventDefault();
                                                }
                                                ">Delete</a>
                            <form id="delete-form{{ $row->id }}" method="post" action="{{ route(\''.$route.'.destroy\',$row->id) }}" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field(\'DELETE\') }}
                            </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
';
        fwrite($index,$txt);
    }

    protected function generateCreate($path,$request){
        $route = strtolower($request->models);
        $create = fopen($path.'/create.blade.php','w');
$txt =
    '@extends("'.$request->layout.'")

@section("'.$request->section.'")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Here is your Create View</h1>
                <a href="{{route(\''.$route.'.index\')}}" class="btn btn-success" style="margin-top: 15px;margin-bottom: 15px;">All '.$request->models.'</a>
            </div>
        </div>
        <form action="{{route(\''.$route.'.store\')}}" method="post">
        @csrf
        ';
foreach (explode(',',$request->fields) as $field){
    if ($request->$field === 'textarea'){
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <textarea name="'.$field.'" id="'.$field.'" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div>
            </div>
        ';
    } elseif ($request->$field === 'checkbox' || $request->$field === 'radio'){
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="'.$request->$field.'" class="form-check-input" id="'.$field.'" name="'.$field.'">
                        <label class="form-check-label" for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                     </div>
                </div>
            </div>
        ';
    } elseif ($request->$field === 'select'){
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <select class="form-control" id="'.$field.'" name="'.$field.'">
                            <option value="" selected disabled>Please select '.ucfirst(str_replace('_',' ',$field)).'</option>
                        </select>
                    </div>
                </div>
            </div>
        ';
    } elseif ($request->$field === 'range'){
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'" min="0" max="100">
                    </div>
                </div>
            </div>
        ';
    } elseif ($request->$field === 'button'){
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'" value="'.ucfirst(str_replace('_',' ',$field)).'">
                    </div>
                </div>
            </div>
        ';
    } else {
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'">
                    </div>
                </div>
            </div>
        ';
    }
}
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                </div>
            </div>
        ';
$txt .='
        </form>
    </div>
@endsection';
        fwrite($create,$txt);
    }

    protected function generateEdit($path,$request){
        $route = strtolower($request->models);
        $create = fopen($path.'/edit.blade.php','w');
        $txt =
            '@extends("'.$request->layout.'")

@section("'.$request->section.'")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Here is your Edit View</h1>
                <a href="{{route(\''.$route.'.index\')}}" class="btn btn-success" style="margin-top: 15px;margin-bottom: 15px;">All '.$request->models.'</a>
                <a class="btn btn-danger" title="delete" href="" onclick="if (confirm(\'Are You Sure To Delete This?\')){event.preventDefault();document.getElementById(\'delete-form{{ $row->id }}\').submit();} else {event.preventDefault();}">Delete</a>
                <form id="delete-form{{ $row->id }}" method="post" action="{{ route(\''.$route.'.destroy\',$row->id) }}" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field(\'DELETE\') }}
                </form>
            </div>
        </div>
        <form action="{{route(\''.$route.'.update\',$row->id)}}" method="post">
        @csrf
        {{method_field("PATCH")}}
        ';
        foreach (explode(',',$request->fields) as $field){
            if ($request->$field === 'textarea'){
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <textarea name="'.$field.'" id="'.$field.'" class="form-control" cols="30" rows="5">{{$row->'.$field.'}}</textarea>
                    </div>
                </div>
            </div>
        ';
            } elseif ($request->$field === 'checkbox' || $request->$field === 'radio'){
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="'.$request->$field.'" class="form-check-input" id="'.$field.'" name="'.$field.'" @if($row->'.$field.'===1) checked @endif>
                        <label class="form-check-label" for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                     </div>
                </div>
            </div>
        ';
            } elseif ($request->$field === 'select'){
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <select class="form-control" id="'.$field.'" name="'.$field.'">
                            <option value="" selected disabled>Please select '.ucfirst(str_replace('_',' ',$field)).'</option>
                            <option value="{{$row->'.$field.'}}" selected>{{$row->'.$field.'}}</option>
                        </select>
                    </div>
                </div>
            </div>
        ';
            } elseif ($request->$field === 'range'){
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'" min="0" max="100" value="{{$row->'.$field.'}}">
                    </div>
                </div>
            </div>
        ';
            } elseif ($request->$field === 'button'){
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'" value="'.ucfirst(str_replace('_',' ',$field)).'">
                    </div>
                </div>
            </div>
        ';
            } else {
                $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="'.$field.'">'.ucfirst(str_replace('_',' ',$field)).'</label>
                        <input type="'.$request->$field.'" class="form-control" id="'.$field.'" name="'.$field.'" value="{{$row->'.$field.'}}">
                    </div>
                </div>
            </div>
        ';
            }
        }
        $txt .= '
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </div>
            </div>
        ';
        $txt .='
        </form>
    </div>
@endsection';
        fwrite($create,$txt);
    }

    protected function generateShow($path,$request){
        $route = strtolower($request->models);
        $create = fopen($path.'/show.blade.php','w');
        $txt =
            '@extends("'.$request->layout.'")

@section("'.$request->section.'")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Here is your Show View</h1>
                <a href="{{route(\''.$route.'.index\')}}" class="btn btn-success" style="margin-top: 15px;margin-bottom: 15px;">All '.$request->models.'</a>
                <a href="{{route(\''.$route.'.edit\', $row->id)}}" class="btn btn-warning" style="margin-top: 15px;margin-bottom: 15px;">Edit this '.$request->models.'</a>
                <a class="btn btn-danger" title="delete" href="" onclick="if (confirm(\'Are You Sure To Delete This?\')){event.preventDefault();document.getElementById(\'delete-form{{ $row->id }}\').submit();} else {event.preventDefault();}">Delete</a>
                <form id="delete-form{{ $row->id }}" method="post" action="{{ route(\''.$route.'.destroy\',$row->id) }}" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field(\'DELETE\') }}
                </form>
            </div>
        </div>
        <table class="table table-striped">
            <thead>';
foreach (explode(',',$request->fields) as $field){
    $txt .= '
                <tr>
                    <th>'.ucfirst(str_replace('_',' ',$field)).'</th>
                    <th>{{$row->'.$field.'}}</th>
                </tr>  
    ';
}
        $txt .='
            </thead>
        </table>
    </div>
@endsection';
        fwrite($create,$txt);
    }
}
