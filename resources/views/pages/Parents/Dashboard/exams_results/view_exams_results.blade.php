@extends('layouts.master')
@section('css')

@section('title')
    تقرير الحضور والغياب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    تقارير الحضور والغياب
@stop
<!-- breadcrumb -->

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                      
                

                
                      
               
                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                           style="text-align: center">
                        <thead>
                        <tr>
                            <th class="alert-success">#</th>
                            <th class="alert-success">{{trans('Students_trans.name')}}</th>
                            <th class="alert-success">{{trans('Students_trans.Grade')}}</th>
                            <th class="alert-success">{{trans('Students_trans.section')}}</th>
                            <th class="alert-success">اسم الاختبار</th>
                            <th class="alert-warning">النتيجه</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @foreach($sons_data as $son_data)
                             
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{$son_data->name}}</td>
                                <td>{{$son_data->grade->Name}}</td>
                                <td>{{$son_data->section->Name_Section}}</td>
                                <td>{{ $quizze_name }}</td>
                                <td>{{ $sons_degree }}</td>
                            </tr>
                      
                        @endforeach
                       
                    </table>
                </div>
                {{-- @endisset --}}
                
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@endsection
