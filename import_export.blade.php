@include("admin-SchoolDir/pagenav")

<div class="container">

    <div class="panel panel-primary">

        <div class="panel-heading">Import Excel | Create table if does not exist</div>

        <div class="panel-body">
            <div class="row">
                {{--@if(!empty($successMsg))--}}
                {{--<div class="alert alert-success"> {{ $successMsg }}</div>--}}
                {{--@endif--}}
                {{--@if(!empty($errorMsg))--}}
                {{--<div class="alert alert-danger"> {{ $errorMsg }}</div>--}}
                {{--@endif--}}
                {{----}}
            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <a href="{{ route('export.file',['type'=>'xls']) }}">Download Excel xls</a> |

                    <a href="{{ route('export.file',['type'=>'xlsx']) }}">Download Excel xlsx</a> |

                    <a href="{{ route('export.file',['type'=>'csv']) }}">Download CSV</a>

                </div>

            </div>

            {!! Form::open(array('route' => 'import.file','method'=>'POST','files'=>'true')) !!}

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        {!! Form::label('sample_file','Select File to Import:',['class'=>'col-md-3']) !!}

                        <div class="col-md-9">

                            {!! Form::file('sample_file', array('class' => 'form-control')) !!}

                            {!! $errors->first('sample_file', '<p class="alert alert-danger">:message</p>') !!}

                        </div>

                    </div>
                    <br>
                    <div class="form-group">

                        {!! Form::label('Table','Select the database table:',['class'=>'col-md-3']) !!}

                        <div class="col-md-9">

                            {!! Form::input('table', 'table', null, array('class' => 'form-control')) !!}

                            {!! $errors->first('table', '<p class="alert alert-danger">:message</p>') !!}

                        </div>

                    </div>
                </div>
                <br>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                    {!! Form::submit('Upload',['class'=>'btn btn-primary']) !!}

                </div>

            </div>

            {!! Form::close() !!}

        </div>

    </div>

</div>

