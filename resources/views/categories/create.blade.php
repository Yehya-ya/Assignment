@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="float-start">Create New Category</h2>
        </div>
        <div class="card-body mx-5">
            @error('category_id')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div>{{ $message }}</div>
            </div>
            @enderror
            <form method="post" action="{{route('categories.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required autofocus>
                </div>
                <div class="mb-3 ">
                    <label for="parentCategory" class="form-label">Parent Category</label>
                    <select class="form-select" id="parentCategory" name="category_id">
                        <option selected value>-- no parent --</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" >{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
