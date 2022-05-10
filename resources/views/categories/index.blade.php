@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="float-start">Categories</h2>
            <div class="text-end">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#model">
                    Add new Category
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <div>{{ session('status') }}</div>
            </div>
            @endif
            <ul class="list-group">
            @forelse($categories as $category)
                <li class="list-group-item list-group-item-action d-flex" data-bs-toggle="collapse" data-bs-target="#subcategories{{$category->id}}"
                    aria-expanded="false" aria-controls="subcategories{{$category->id}}">
                    <div class="fw-bold fs-4">{{ $category->title }}</div>
                    <span class="badge bg-primary rounded-pill d-flex ms-2 my-auto {{($category->sub_categories_count == 0) ? 'd-none' : '' }}">{{$category->sub_categories_count}}</span>
                    <form method="post" action="{{ route('categories.destroy', ['category' => $category]) }}" class="d-flex ms-auto">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger" type="submit">delete</button>
                    </form>
                </li>
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
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="model" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{route('categories.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required autofocus>
                        </div>
                        <div class="mb-3 ">
                            <label for="parentCategory" class="form-label">Parent Category</label>
                            <select class="form-select" id="parentCategory" name="category_id">
                                <option selected value>-- no parent --</option>
                                @foreach($allCategories as $category)
                                    <option value="{{$category->id}}" >{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
