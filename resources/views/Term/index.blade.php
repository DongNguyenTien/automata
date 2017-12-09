@extends('index')
@section('content')

    <section class="content-header">
        <h1>
            Kiểm tra term có được chấp nhận bởi cây automata nào không
        </h1>

    </section>


    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kiểm tra</h3>
            </div>

            <div class="box-body">
                <div class ="row">
                    <div class="col-md-offset-2 col-md-8">

                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="get" action="{{route('term_handle')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Term</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="...." name="term">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Chọn máy automata</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="automata">
                                            @for($i=0;$i<count($list);$i++)
                                                <option value="{{$list[$i]->id}}">Máy automata thứ {{$i+1}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info" style="left:48%;position:relative">Kiểm tra</button>
                            </div>

                        </form>
                        <!-- /.box-footer -->


                    </div>

                </div>
            </div>


            <div class="box-body">
                <div class="row">

                </div>
            </div>
        </div>
    </section>


@endsection