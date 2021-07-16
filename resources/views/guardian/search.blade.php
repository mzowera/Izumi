@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Search Guardian') }} 
                    <a href="/guardian/create" class="badge badge-primary p-2 float-right">Create</a>
                </div>
            
                <div class="card-body">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input id="guardian_search" type="text" class="form-control mb-3" name="guardian_search" placeholder="Search" autofocus>
                    </div>
                    <div id="guardian_list" class="list-group">
                        @foreach ( $guardians as $guardian )
                            <a href="/guardian/edit/{{$guardian->id}}" class="list-group-item list-group-item-action">{{$guardian->name}}</a>
                        @endforeach
                    </div>                
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
        * This script is dedicated only for guardian search handling
        */
        
        function searchGuardian()
        {
            var text = $("#guardian_search").val().toLowerCase();
            var items = $("#guardian_list").children();

            items.hide();
            items.each(function(){
                if( $(this).text().toLowerCase().includes(text) )
                {
                    $(this).show();
                }
            });
        }

        $(function(){
            $("#guardian_search").bind("keyup", function() {
                searchGuardian();
            }).change(function(){
                searchGuardian();
            });
        });
    </script>

</div>

@endsection
