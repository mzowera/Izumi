@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Student') }}</div>
            
                <div class="card-body">

                    <form method="POST" action="">
                        @csrf
                        
                        <!-- <pre class="card">{{ json_encode($request, JSON_PRETTY_PRINT) }}</pre> -->

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>

                            <div class="col-md-6">
                                <input id="contact_number" type="phone" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}">

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="courses" class="col-md-4 col-form-label text-md-right">{{ __('Courses') }}</label>
                            
                            <div class="col-md-6">
                                <div id="selected-courses" class="card p-1" style="display: none;">
                                </div>
                                <div id="courses-search-box" class="position-relative">
                                    <input id="search_course" type="search" class="form-control" name="search_course">
                                    <div id="course_selection" class="list-grp position-absolute w-100 d-none" style="z-index:100;">
                                        @foreach ( $courses as $course )
                                            <a href="#" onclick="addCourse(this)" class="course_selection--item list-group-item list-group-item-action" value="{{$course->id}}">{{$course->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-none">
                                    @foreach ( $courses as $course )
                                        <input type="checkbox" value="{{$course->id}}" name="courses[]" id="course-{{$course->id}}">
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="guardians" class="col-md-4 col-form-label text-md-right">{{ __('Guardians') }}</label>
                            
                            <div class="col-md-6">
                                <div id="selected-guardians" class="card p-1" style="display: none;">
                                </div>
                                <div id="guardians-search-box" class="position-relative">
                                    <input id="search_guardian" type="search" class="form-control" name="search_guardian">
                                    <div id="guardian_selection" class="list-grp position-absolute w-100 d-none" style="z-index:100;">
                                        @foreach ( $guardians as $guardian )
                                            <a href="#" onclick="addGuardian(this)" class="guardian_selection--item list-group-item list-group-item-action" value="{{$guardian->id}}">{{$guardian->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-none">
                                    @foreach ( $guardians as $guardian )
                                        <input type="checkbox" value="{{$guardian->id}}" name="guardians[]" id="guardian-{{$guardian->id}}">
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        /**
         * This script is dedicated only for courses selection handling
         */

        function delCourse(self)
        {
            var $course = $(self).parent();
            
            // update checkbox
            $(`[name="courses[]"][value="${$course.attr("value")}"]`).prop('checked', false);

            // update search box
            $(`.course_selection--item[value="${$course.attr("value")}"]`).attr("selected", false);

            // remove course from selected courses
            $course.remove();

            // hide parent if empty
            if ( $("#selected-courses").children().length == 0 )
            {
                $("#selected-courses").hide();
            }
        }

        function addCourse(self)
        {
            // hide from selection
            $(self).addClass("d-none").attr("selected", true);

            // show in selected courses
            $("#selected-courses").append(`
                <div class="panel-selected-course d-flex" value="${$(self).attr("value")}">
                    <span class="float-left">${$(self).text()}</span> 
                    <a href="#" onclick="delCourse(this)" class="btn-del-course ml-auto d-flex my-auto text-decoration-none text-danger"><i aria-hidden="true" class="fa fa-close"></i></a>
                </div>
            `).show(); 

            // update checkbox
            $(`[name="courses[]"][value="${$(self).attr("value")}"]`).prop('checked', true);
        }

        function searchCourse()
        {
            var text = $("#search_course").val().toLowerCase();
                
            var items = $("#course_selection").children();

            items.removeClass("d-none");
            items.each(function(){
                if( !$(this).text().toLowerCase().includes(text) || $(`[name="courses[]"][value="${$(this).attr("value")}"]`).prop('checked') )
                {
                    $(this).addClass("d-none");
                }
            });
        } 

        $(function(){

            // event to filter courses selection when search_course changed
            $("#search_course").bind("keyup", function() {
                searchCourse();
            });
            
            // hide course selection, when clicked outside
            $(window).click(function() {
                $("#course_selection").addClass("d-none");
            });

            // Prevent the function above when clicked inside
            $("#courses-search-box").click(function(event){
                event.stopPropagation();

                $("#course_selection").removeClass("d-none");
                searchCourse();
            });

        });
    </script>

    <script>
        /**
         * This script is dedicated only for guardians selection handling
         */

        function delGuardian(self)
        {
            var $guardian = $(self).parent();
            
            // update checkbox
            $(`[name="guardians[]"][value="${$guardian.attr("value")}"]`).prop('checked', false);

            // update search box
            $(`.guardian_selection--item[value="${$guardian.attr("value")}"]`).attr("selected", false);

            // remove guardian from selected guardians
            $guardian.remove();

            // hide parent if empty
            if ( $("#selected-guardians").children().length == 0 )
            {
                $("#selected-guardians").hide();
            }
        }

        function addGuardian(self)
        {
            // hide from selection
            $(self).addClass("d-none").attr("selected", true);

            // show in selected guardians
            $("#selected-guardians").append(`
                <div class="panel-selected-guardian d-flex" value="${$(self).attr("value")}">
                    <span class="float-left">${$(self).text()}</span> 
                    <a href="#" onclick="delGuardian(this)" class="btn-del-guardian ml-auto d-flex my-auto text-decoration-none text-danger"><i aria-hidden="true" class="fa fa-close"></i></a>
                </div>
            `).show(); 

            // update checkbox
            $(`[name="guardians[]"][value="${$(self).attr("value")}"]`).prop('checked', true);
        }

        function searchGuardian()
        {
            var text = $("#search_guardian").val().toLowerCase();
                
            var items = $("#guardian_selection").children();

            items.removeClass("d-none");
            items.each(function(){
                if( !$(this).text().toLowerCase().includes(text) || $(`[name="guardians[]"][value="${$(this).attr("value")}"]`).prop('checked') )
                {
                    $(this).addClass("d-none");
                }
            });
        } 

        $(function(){

            // event to filter guardians selection when search_guardian changed
            $("#search_guardian").bind("keyup", function() {
                searchGuardian();
            });
            
            // hide guardian selection, when clicked outside
            $(window).click(function() {
                $("#guardian_selection").addClass("d-none");
            });

            // Prevent the function above when clicked inside
            $("#guardians-search-box").click(function(event){
                event.stopPropagation();

                $("#guardian_selection").removeClass("d-none");
                searchGuardian();
            });

        });
    </script>

</div>

@endsection
