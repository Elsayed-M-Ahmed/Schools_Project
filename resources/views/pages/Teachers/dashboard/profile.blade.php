@extends('layouts.master')
@section('css')
    @toastr_css
    @section('title')
        الملف الشخصي
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        الملف الشخصي
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->



    <div class="card-body">

        <section style="background-color: #eee;">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{URL::asset('assets/images/teacher.png')}}"
                                 alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 style="font-family: Cairo" class="my-3">{{$teacher_information->Name}}</h5>
                            <p class="text-muted mb-1">{{$teacher_information->email}}</p>
                            <p class="text-muted mb-4">معلم</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">اسم المستخدم باللغة العربية</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <input type="text" name="Name_ar"
                                                   value="{{ $teacher_information->getTranslation('Name', 'ar') }}"
                                                   class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">اسم المستخدم باللغة الانجليزية</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <input type="text" name="Name_en"
                                                   value="{{ $teacher_information->getTranslation('Name', 'en') }}"
                                                   class="form-control">
                                        </p>
                                    </div>
                                </div>
                                
                                <hr>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_Teacher{{ $teacher_information->id }}" ><i class="fa fa-edit"></i>     تعديل البيانات</button>
                           
                                {{-- Edit Modal --}}
                                <div class="modal fade" id="edit_Teacher{{$teacher_information->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">تعديل بيانات {{ $teacher_information->Name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{route('profile.update',$teacher_information->id)}}" method="post">
                                                    @csrf
                                                    
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">كلمة المرور</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <p class="text-muted mb-0">
                                                                <input type="password" id="password" class="form-control" name="password">
                                                            </p><br><br>
                                                            <input type="checkbox" class="form-check-input" onclick="myFunction()"
                                                                   id="exampleCheck1">
                                                            <label class="form-check-label" for="exampleCheck1">اظهار كلمة المرور</label>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('classrooms_trans.Close') }}</button>
                                                        <button type="submit"
                                                        class="btn btn-success">{{ trans('classrooms_trans.submit') }}</button>
                                                    </div>
                                                </form>

                                              
                                                <input type="hidden" name="id"  value="{{$teacher_information->id}}">
                                            </div>
                                            
                                        </div>
                                      
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
