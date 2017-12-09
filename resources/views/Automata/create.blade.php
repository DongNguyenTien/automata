@extends('index')
@section('content')

    <section class="content-header">
        <h1>
            Thêm mới Automata
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="{{route('automata_index')}}">Danh sách Automata</a></li>
        </ol>
    </section>


    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới Automata</h3>
            </div>

                <div class="box-body">
                    <div class ="row">
                        <div class="col-md-offset-2 col-md-8">

                                <!-- /.box-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="{{route('automata_store')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Alphabet</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputEmail3" placeholder="alphabet" name="alphabet">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label">State</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputPassword3" placeholder="State" name="state">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label">Final State</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputPassword3" placeholder="Final State" name="final_state">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label">Transition Rules</label>
                                            <div class="col-md-10">
                                                <textarea type="text" class="form-control" name="transition" rows="3" value="{{old('transition')}}"></textarea>

                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info" style="left:48%;position:relative">Submit</button>
                                    </div>

                                </form>
                                <!-- /.box-footer -->


                        </div>
                    </div>
                </div>
        </div>
    </section>


@endsection