@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Guardian') }}</div>
            
                <div class="card-body">

                    <form method="POST" action="">
                        @csrf
                        
                        @if ( $saved )
                            <div class="alert alert-success" role="alert">
                                Changes saved!
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $guardian->name }}" required autocomplete="name" autofocus>

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
                                <input id="contact_number" type="phone" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') ?? $guardian->contact_number }}">

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $guardian->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="students" class="col-md-4 col-form-label text-md-right">{{ __('Students') }}</label>
                            
                            <div class="col-md-6">
                                <div id="selected-students" class="card p-1" style="display: none;">
                                </div>
                                <div id="students-search-box" class="position-relative">
                                    <input id="search_student" type="search" class="form-control" name="search_student">
                                    <div id="student_selection" class="list-grp position-absolute w-100 d-none" style="z-index:100;">
                                        @foreach ( $students as $student )
                                            <a href="#" onclick="addStudent(this)" class="student_selection--item list-group-item list-group-item-action" value="{{$student->id}}">{{$student->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-none">
                                    @foreach ( $students as $student )
                                        <input type="checkbox" value="{{$student->id}}" name="students[]" id="student-{{$student->id}}">
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" name="submit" value="save" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete student {{$student->name}}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" value="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        /**
         * This script is dedicated only for students selection handling
         */

        function delStudent(self)
        {
            var $student = $(self).parent();
            
            // update checkbox
            $(`[name="students[]"][value="${$student.attr("value")}"]`).prop('checked', false);

            // update search box
            $(`.student_selection--item[value="${$student.attr("value")}"]`).attr("selected", false);

            // remove student from selected student
            $student.remove();

            // hide parent if empty
            if ( $("#selected-students").children().length == 0 )
            {
                $("#selected-students").hide();
            }
        }

        function addStudent(self)
        {
            // hide from selection
            $(self).addClass("d-none").attr("selected", true);

            // show in selected students
            $("#selected-students").append(`
                <div class="panel-selected-student d-flex" value="${$(self).attr("value")}">
                    <span class="float-left">${$(self).text()}</span> 
                    <a href="#" onclick="delStudent(this)" class="btn-del-student ml-auto d-flex my-auto text-decoration-none text-danger"><i aria-hidden="true" class="fa fa-close"></i></a>
                </div>
            `).show(); 

            // update checkbox
            $(`[name="students[]"][value="${$(self).attr("value")}"]`).prop('checked', true);
        }

        function searchStudent()
        {
            var text = $("#search_student").val().toLowerCase();
                
            var items = $("#student_selection").children();

            items.removeClass("d-none");
            items.each(function(){
                if( !$(this).text().toLowerCase().includes(text) || $(`[name="students[]"][value="${$(this).attr("value")}"]`).prop('checked') )
                {
                    $(this).addClass("d-none");
                }
            });
        } 

        function initStudents()
        {
            var selectedStudents = {{ old('students') ?? json_encode( $guardian_students, JSON_PRETTY_PRINT) ?? [] }};
            
            for ( selectedStudent of selectedStudents )
            {
                $(`.student_selection--item[value="${selectedStudent}"]`).click();
            }
            $("#student_selection").addClass("d-none");
        }

        $(function(){

            // event to filter students selection when search_student changed
            $("#search_student").bind("keyup", function() {
                searchStudent();
            });
            
            // hide student selection, when clicked outside
            $(window).click(function() {
                $("#student_selection").addClass("d-none");
            });

            // Prevent the function above when clicked inside
            $("#students-search-box").click(function(event){
                event.stopPropagation();

                $("#student_selection").removeClass("d-none");
                searchStudent();
            });

            // Initilize selected students
            initStudents();

        });
    </script>

</div>

@endsection
