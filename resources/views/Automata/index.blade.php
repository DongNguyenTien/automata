@extends('index')
@section('title','Danh sách Automata')
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d2d6de !important;
            border-radius: 0 !important;
            height: 100% !important;
        }
    </style>
    <section class="content-header">
        <h1>
            Danh sách Automata
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active">Danh sách Automata</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">

            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">

                        @if(session()->has('messages'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> Thông báo</h4>
                                {{session('messages')}}
                            </div>
                        @else
                        @endif
                        <h3 class="box-title" style="font-weight: bold">Danh sách automata</h3>
                        <div class="pull-right">
                            <a style="display: inline-block" href="{{route('automata_create')}}"><button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm Automata</button></a>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover display compact" id="post_table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Alphabel</th>
                                    <th>State</th>
                                    <th>Final State</th>
                                    <th>Transition Rule</th>
                                    {{--<th class="actions">Chi tiết</th>--}}
                                </tr>
                                </thead>
                            </table>
                        </div><!--table-responsive-->
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script>
        $(function() {
            $('#post_table').DataTable({
                processing: true,
                serverSide: true,
                bAutoWidth: false,
                ajax: {
                    "url": '{{ route("automata_get") }}',
                    "type": 'get'
//                    "data": function (d) {
//                        d.name = $('.name').val();
//                        d.group = $('#group option:selected').val();
//                    }
                },
                columns: [
                    {data: 'id' },
                    {data: 'alphabet'},
                    {data: 'state'},
                    {data: 'final_state'},
                    {data: 'transition'},
                ],
                order: [[0, "desc"]],
                searchDelay: 500,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ bản ghi trên một trang",
                    "zeroRecords": "Không tìm bản ghi phù hợp",
                    "info": "Đang hiển thị trang _PAGE_ of _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "infoFiltered": "(lọc từ tổng số _MAX_ bản ghi)",
                    "info": "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ kết quả",
                    "paginate": {
                        "first":      "Đầu tiên",
                        "last":       "Cuối cùng",
                        "next":       "Sau",
                        "previous":   "Trước"
                    },
                    "sProcessing": '<i class="fa fa-spinner fa-pulse fa-fw"></i>Đang lấy dữ liệu ',
                    "search": 'Tìm kiếm: '
                }


            });
        });

        $(".alert-success").delay(5000).fadeOut('1000');



    </script>
@endsection
