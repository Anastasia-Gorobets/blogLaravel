@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('users.update', ['user'=>$user->id])}}" enctype="multipart/form-data" class="form-horizontal">
@csrf
@method('PUT')

    <div class="row">

        <div class="col-4">
            <img src="{{$user->image->url() ?  : ''}}" class="img-thumbnail avatar">

            <div class="card mt-4">
                <div class="card-body">
                    <h6>Upload new photo</h6>
                    <input  class="form-control-file" type="file" name="avatar">
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" value="{{$user->name}}" name="name">
            </div>

             <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save changes">
            </div>



        </div>



    </div>


</form>
@endsection
