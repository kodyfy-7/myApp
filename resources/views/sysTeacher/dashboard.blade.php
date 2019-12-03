@extends('sysTeacher.layouts.app')
@section('title')
    Teacher | Dashboard
@endsection

@section('content')

                <!-- top tiles -->
                <div class="row tile_count">
                    <div class="animated flipInY col-md-3 col-sm-12 col-xs-12 tile_stats_count">
                    <div class="left"></div>
                    <div class="right">
                        <span class="count_top"><i class="fa fa-calendar"></i> Session</span>
                        <div class="count">{{$session}}</div>
                    <span class="count_bottom"><i class="green">{{$term}}</i> term</span>
                    </div>
                    </div>
                    <div class="animated flipInY col-md-3 col-sm-12 col-xs-12 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-book"></i> Subjects</span>
                            <div class="count">{{count($subjects)}}</div>
                            @foreach ($subjects as $subject)
                                <div class="count_bottom">{{$subject->subject_title}}</div>    
                            @endforeach
                        </div>
                    </div>
                    <div class="animated flipInY col-md-3 col-sm-12 col-xs-12 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-book"></i> Classroom</span>
                            <div class="count_bottom">{{$class}}</div>    
                        </div>
                    </div>
                </div>
              <!-- /top tiles -->
            <p>{{$class}}</p>
@endsection

