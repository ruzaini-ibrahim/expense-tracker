@extends('layout.master')

@section('title','Permission')

@section('content')

<div class="page-header text-center">
	<h1 class="page-title">Permissions</h1>
    <div class="page-header-actions">
    </div>
</div>
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">

                <div class="panel-heading">
                    <div class="panel-actions">
                    </div>
                    <h1 class="panel-title">Permission Lists</h1>
                </div>
                <div class="panel-body"> 
               
                    <table class="table table-striped datatable table-hover" id="permissionsTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Permissions</th>
                                <th scope="col">Guard Name</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade modal-fade-in-scale-up" id="addNewPermission" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeCollectionModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Add New Permission</h4>
            </div>

            <form class="form-horizontal" action="{{url('user_management/permission/new')}}" method="POST">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <input type="hidden" name="guard_name" id="guard_name" value="user">
            
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Permission </label>
                        <div class="col-sm-9">
                            <input type="" name="permission" placeholder="e.g. Edit Post" class="form-control" id="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary btnRegister waves-effect waves-light">
                    <span class="ladda-label">Add</span>
                </button>
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade modal-fade-in-scale-up" id="editPermission" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeCollectionModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Edit Permission</h4>
            </div>
            <form method="post" action="{{url('/user_management/permission/edit')}}">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <input type="hidden" class ="permission_id" name="permission_id" id="permission_id" value="">
                    <input type="hidden" class ="guard_name" name="guard_name" id="guard_name" value="user">
                    <input type="hidden" class="id" name="id" id="id">  
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Permission </label>
                        <div class="col-sm-9">
                            <input type="" name="edit_name" placeholder="e.g. Edit Post" class="form-control edit_name" id="edit_name" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnSave" id="btnSave" class="btn btn-primary btnRegister waves-effect waves-light">
                    <span class="ladda-label">Save</span>
                </button>
                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>

    $(function() {
        $('#permissionsTable').DataTable({
            order: [[ 3, "desc" ]],
            // responsive: true,
            processing: true,
            serverSide: true,
            searching:false,
            columnDefs: [ { orderable: false, targets: [0,4] }],
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            buttons: [
                {
                    extend:    'pageLength',
                    className: 'btn btn-default btn-pure',
                },
                {
                    extend:    'excelHtml5',
                    className: 'btn btn-default btn-pure',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    footer: true
                },
                {
                    extend:    'csvHtml5',
                    className: 'btn btn-default btn-pure',
                    text:      '<i class="fa fa-file-text-o"></i> CSV',
                    titleAttr: 'CSV',
                    footer: true
                },
                {
                    extend:    'print',
                    className: 'btn btn-default btn-pure',
                    text:      '<i class="fa fa-print"></i> Print',
                    titleAttr: 'Print',
                    footer: true
                },
                {
                    text:      '<i class="fa fa-plus"></i> New Permission',
                    titleAttr: 'New Permission',
                    className: 'btn btn-default btn-pure btnNew',
                    action: function ( e, dt, node, config ) {
                        $('.btnNew')
                        .attr('data-toggle', 'modal')
                        .attr('data-target', '#addNewPermission');
                    }
                },
            ],
            ajax:   {
                        "url":"{{url('/user_management/permission/data')}}",
                        "data":   function(data) {
                            data.guard = 'admin';
                        }
                    },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'guard_name', name: 'guard_name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' },
            ],
        });

    });
</script>

 <script>
    $(function() {
    // sweetalert
        $('#permissionsTable').on('click','.btnDelete',function(e){
            // Start rendering ladda 
            var urlDelete =$(this).attr('href');

            e.preventDefault();
            var l = Ladda.create(this);
            l.start();
            l.setProgress( 1 );

            swal({
                title: "Delete Permission?",
                text: "Are you sure you want to delete this permission? This link will no longer be available.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if(isConfirm){
                    window.location.href = urlDelete;
                    l.stop(); 
                    return true;
                }else{
                    l.stop(); 
                    return false;
                }
            });
           
        });
    });
</script>
<script>
    $(function() {
        $('#permissionsTable').on('click','.btnEdit', function(){
            var index = $(this).val();
            $('.id').val(index);
            $('.edit_name').val($('.name_'+index).val());
        });
    });
</script>
@endpush