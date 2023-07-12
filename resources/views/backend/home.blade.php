@extends('backend.app')

@section('breadcrumb')
<h1>
    Dashboard
    <small>Control panel</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
</ol>
@endsection

@section('content')
<div class="box-header with-border">
    <h3 class="box-title">Home Dashboard</h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i>
        </button>
    </div>
</div>
<div class="box-body">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
    
                <div class="info-box-content">
              <span class="info-box-text">CPU Traffic</span>
              <span class="info-box-number">{{ $cpuUsage }}<small>%</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->            
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-microchip"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">RAM Usage</span>
              <span class="info-box-number">{{ $ramUsage }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
    </div>

    
</div>
<!-- /.box-body -->
<div class="box-footer">
    
</div>
@endsection
