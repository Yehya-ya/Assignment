@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="float-start">Categories</h2>
            <div class="text-end">
                <a class="btn btn-primary float-end" href="{{route('categories.create')}}">add new Category</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <div>{{ session('status') }}</div>
            </div>
            @endif
            <div class="list-group">
            @forelse($categories as $category)
                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start"
                        data-bs-toggle="collapse" data-bs-target="#subcategories{{$category->id}}" aria-expanded="false" aria-controls="subcategories{{$category->id}}"
                >
                    {{ $category->title }}
                    <span class="badge bg-primary rounded-pill {{($category->sub_categories_count == 0) ? 'd-none' : '' }}" >{{$category->sub_categories_count}}</span>
                </button>
                @if($category->sub_categories_count > 0)
                <div class="collapse ms-2 list-group" id="subcategories{{$category->id}}">
                    @foreach($category->subCategories as $subCategory)
                    <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        {{ $subCategory->title }}
                    </button>
                    @endforeach
                </div>
                @endif
            @empty
                <div class="text-center" colspan="2">
                    <h4 class="my-3">there is no categories added yet.</h4>
                </div>
            @endforelse
            </div>
        </div>
    </div>
@endsection
