@extends('layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="float-start">Category Selector</h2>
        </div>
        <div class="card-body">
            <div class="container" id="container">

            </div>
        </div>
    </div>

    <div class="d-none" hidden>
        <select class="form-select mb-3" id="selectTemplate">
            <option selected disabled>-- not selected --</option>
        </select>
    </div>
@endsection

@push('scripts')
 <script>
     $('#homeNav').addClass('active');

     $(function (){
         loadCategories();
     });

     function loadCategories() {
         $.ajax({
             type:'GET',
             url:'{{ route('categories.index') }}',
             success:function(data){
                 if (data.data.length > 0) {
                     let select = $('#selectTemplate').clone().prop("id", 1);
                     select.change(select1);
                     $('#container').append(select);
                     data.data.forEach(function(value){
                         select.append($('<option>').val(value.id).text(value.title));
                     });
                 }
             }
         });
     }

     function select1(event) {
         console.log(event.target.id);
         let value = parseInt(event.target.value);
         let id = event.target.id;
         $('#container').children().slice(id).remove();
         if(value) {
             $.ajax({
                 type:'GET',
                 url:'{{ url('/api/categories') }}/' + value,
                 success:function(data){
                     if (data.data.length > 0) {
                         let select = $('#selectTemplate').clone().prop("id", parseInt(id)+1);
                         select.change(select1);
                         $('#container').append(select);
                         data.data.forEach(function(value){
                             select.append($('<option>').val(value.id).text(value.title));
                         });
                     }
                 }
             });
         }
     }
 </script>
@endpush
