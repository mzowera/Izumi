@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Search Course') }} 
                </div>
            
                <div class="card-body">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input id="course_search" type="text" class="form-control mb-3" name="course_search" placeholder="Search" autofocus>
                    </div>
                    <div id="course_list" class="list-group">
                        @foreach ( $courses as $course )
                            <a href="#" class="list-group-item list-group-item-action">{{$course->name}}</a>
                        @endforeach
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
        * This script is dedicated only for course search handling
        */
        
        function searchcourse()
        {
            var text = $("#course_search").val().toLowerCase();
            var items = $("#course_list").children();

            items.hide();
            items.each(function(){
                if( $(this).text().toLowerCase().includes(text) )
                {
                    $(this).show();
                }
            });
        }

        $(function(){
            $("#course_search").bind("keyup", function() {
                searchcourse();
            }).change(function(){
                searchcourse();
            });
        });
    </script>

</div>

@endsection
