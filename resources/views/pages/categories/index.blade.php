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
            <ul id="main_list" class="list-group">
                <li class="list-group-item text-center">
                    <h4 class="my-3">there is no categories added yet.</h4>
                </li>
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
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required autofocus>
                    </div>
                    <div class="mb-3 ">
                        <label for="parentCategory" class="form-label">Parent Category</label>
                        <select class="form-select" id="parentCategory" name="parent">
                            <option selected value>-- no parent --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="newCategorySubmitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 start-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="alertMessage">
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="d-none" hidden>
        <li id="categoryTemplate" class="list-group-item list-group-item-action d-flex"
            data-bs-toggle="collapse" aria-expanded="false" aria-controls="subcategoriesCollapseTemplate" data-bs-target="#subcategoriesCollapseTemplate" >
            <div class="fw-bold fs-4">category-title</div>
            <span class="badge bg-primary rounded-pill d-flex ms-2 my-auto">0</span>
            <button class="btn btn-sm btn-danger ms-auto" type="submit">delete</button>
        </li>
        <ul id="subcategoriesCollapseTemplate" class="collapse ms-2 list-group">
        </ul>
        <li class="list-group-item text-center" id="spinner">
            <div class="spinner-border text-primary m-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </li>
        <li class="list-group-item text-center" id="emptyCategories">
            <h4 class="my-3">there is no categories added yet.</h4>
        </li>
    </div>
@endsection

@push('scripts')
    <script>
        $('#categoriesNav').addClass('active');

        $("#newCategorySubmitBtn").click(function(e){
            e.preventDefault();
            // clear old feedback
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass("is-invalid");

            let title = $("#title");
            let parent = $("#parentCategory");
            $.ajax({
                type:'POST',
                url:'{{ route('categories.store') }}',
                data:{title:title.val(), category_id:parent.val()},
                success:function(data){
                    addAlert(data.message);
                    addCategory(data.data);
                    checkForEmptyList();

                    // update parent subcategories number
                    if (data.data.parent_id) {
                        let v = $('#category_' + data.data.parent_id).children('span').text();
                        $('#category_' + data.data.parent_id).children('span').removeClass("d-none");
                        $('#category_' + data.data.parent_id).children('span').text(parseInt(v) + 1);
                    }

                    // add the category to the option menu
                    $('#parentCategory').append($('<option>').val(data.data.id).text(data.data.title));

                    //reset model
                    bootstrap.Modal.getInstance(document.getElementById("model")).toggle();
                    title.val('');
                    parent.val('');
                },
                error: function (jqXHR)  {
                    let errors = jqXHR.responseJSON.errors;
                    if(errors.hasOwnProperty("title")) {
                        title.addClass("is-invalid");
                        let div =$("<div>").addClass("invalid-feedback");
                        errors.title.forEach(function (value, index){
                            div.append($('<p> ' + value + ' </p>'));
                            if (index !== errors.title.length - 1){
                                div.append($('<br>'));
                            }
                        });
                        title.parent().append(div);
                    }
                    if(errors.hasOwnProperty("category_id")) {
                        parent.addClass("is-invalid");
                        let div =$("<div>").addClass("invalid-feedback");
                        errors.category_id.forEach(function (value, index){
                            div.append($('<p> ' + value + ' </p>'));
                            if (index !== errors.category_id.length - 1){
                                div.append($('<br>'));
                            }
                        })
                        parent.parent().append(div);
                    }
                }
            });
        });

        $(function() {
            loadCategories();
        });

        function loadCategories() {
            let main_list = $('#main_list');
            main_list.children().remove();
            main_list.append($('#spinner').clone());
            $.ajax({
                type:'GET',
                url:'{{ route('categories.index') }}',
                success:function(data){
                    if (data.data.length > 0) {
                        data.data.forEach(function(value){
                            addCategory(value);
                        });
                    }
                    main_list.children('#spinner').remove();
                    checkForEmptyList();
                },
                error: function ()  {
                    main_list.append($('#emptyCategories').clone());
                    main_list.children('#spinner').remove();
                }
            });
            loadAllCategoryForSelectOptions()
        }

        function loadAllCategoryForSelectOptions(){
            $('#parentCategory').children().slice(1).remove();
            $.ajax({
                type:'GET',
                url:'{{ route('categories.all') }}',
                success:function(data){
                    if (data.data.length > 0) {
                        data.data.forEach(function(value){
                            $('#parentCategory').append($('<option>').val(value.id).text(value.title));
                        });
                    }
                },
                error: function (jqXHR)  {
                }
            });
        }

        function loadSubCategories(id) {
            let list = $('#subcategories_' + id);
            list.children().remove();
            list.append($('#spinner').clone());
            $.ajax({
                type:'GET',
                url:  '{{ url('/api/categories') }}/' + id,
                success:function(data){
                    data.data.forEach(function(value){
                        addCategory(value);
                    });
                    list.children('#spinner').remove();
                },
                error: function ()  {
                    list.children('#spinner').remove();
                }
            });
        }


        function addCategory(value) {
            // add the category to th list
            let newCategory = $('#categoryTemplate').clone().prop("id", "category_"+value.id);
            newCategory.attr('aria-controls', 'subcategories_'+ value.id);
            newCategory.attr('data-bs-target', '#subcategories_'+ value.id);
            newCategory.children('div').text(value.title);
            newCategory.children('span').addClass("d-none");
            newCategory.children('button').click(deleteCategory);

            if (value.sub_categories_count > 0) {
                newCategory.children('span').text(value.sub_categories_count);
                newCategory.children('span').removeClass("d-none");
                newCategory.click(expandCategory);
            }


            let group_list = (value.parent_id === null) ? $('#main_list') : $('#subcategories_' + value.parent_id);

            group_list.append(newCategory);
            group_list.append($('#subcategoriesCollapseTemplate').clone().prop('id', 'subcategories_'+ value.id));
        }

        function deleteCategory(event){
            event.preventDefault()
            event.target.disabled = true;
            event.target.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            let category_id = event.target.parentElement.id.split('_')[1]
            if (category_id) {
                $.ajax({
                    type:'DELETE',
                    url: '{{ url('api/categories')  }}/' + category_id,
                    success:function(data){
                        addAlert(data.message);
                        $('#category_'+category_id).remove();
                        $('#subcategories_'+category_id).remove();

                        if(data.data.parent_id !== null) {
                            let v = $('#category_' + data.data.parent_id).children('span').text();
                            $('#category_' + data.data.parent_id).children('span').text(parseInt(v) - 1);
                            if (parseInt(v) - 1 < 1) {
                                $('#category_' + data.data.parent_id).children('span').addClass("d-none");
                            }
                        }

                        checkForEmptyList();
                        loadAllCategoryForSelectOptions();
                    },
                    error: function ()  {
                        event.target.disabled = false;
                        event.target.innerHTML = 'delete';
                    }
                });
            }
        }

        function checkForEmptyList(){
            let main_list = $('#main_list');
            if (main_list.children().length === 0) {
                main_list.append($('#emptyCategories').clone());
            }else if(main_list.children().length > 1){
                main_list.children('#emptyCategories').remove()
            }
        }

        function expandCategory(event){
            event.preventDefault();
            let category_id = event.target.id.split('_')[1]

            if(category_id && !$('#category_'+ category_id).is('[aria-expanded="false"]')) {
                loadSubCategories(category_id);
            }
        }

        function addAlert(message) {
            let toastElement = $('#liveToast');
            $("#alertMessage").text(message);
            let toast = new bootstrap.Toast(toastElement)
            toast.show()
        }
    </script>
@endpush
