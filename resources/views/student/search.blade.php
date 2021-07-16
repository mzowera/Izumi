@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Search Student') }} 
                    <a href="/student/create" class="badge badge-primary p-2 float-right">Create</a>
                </div>
            
                <div class="card-body">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input id="student_search" type="text" class="form-control mb-3" name="student_search" placeholder="Search" autofocus>
                    </div>
                    <div id="student_list" class="list-group">
                        @foreach ( $students as $student )
                            <a href="/student/edit/{{$student->id}}" class="list-group-item list-group-item-action">{{$student->name}}</a>
                        @endforeach
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
        * This script is dedicated only for student search handling
        */
        
        function searchStudent()
        {
            var text = $("#student_search").val().toLowerCase();
            var items = $("#student_list").children();

            items.hide();
            items.each(function(){
                if( $(this).text().toLowerCase().includes(text) )
                {
                    $(this).show();
                }
            });
        }

        $(function(){
            $("#student_search").bind("keyup", function() {
                searchStudent();
            }).change(function(){
                searchStudent();
            });
        });
    </script>

</div>

@endsection
