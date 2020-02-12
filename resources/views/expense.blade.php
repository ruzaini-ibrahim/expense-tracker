@extends('layout.master')

@section('title','Expense')

@section('content')

<div class="page-header text-center">
    <h1 class="page-title">Expense</h1>
</div>

<div class="page-content container-fluid">	
		<button type="button" class="btn btn-primary btn-sm waves-effect waves-light waves-round waves-effect waves-light float-right" data-target="#addNewExpense" data-toggle="modal" data-original-title="New Admin">+ New Expense</button><br><br>
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-actions">
            </div>
            <h1 class="panel-title">Listing</h1>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover dataTable table-striped width-full" id="transTable">
                    <thead>
                        <tr class="animation-fade" style="animation-fill-mode: backwards; animation-duration: 250ms; animation-delay: 0ms;">
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">#</th>
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Subject</th>
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Amount</th>
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Date Spend</th>
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Comment</th>
                            <th class="" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Created At</th>
                            <th class="hidden-xs" scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="0">Action</th>
                        </tr>
                    </thead> 
                </table>
            </div>
        </div>
    </div>
</div>



<!-- ....................................................................................................... -->
<!-- ................................................Modal.................................................. -->
<!-- ....................................................................................................... -->
<div class="modal fade modal-fade-in-scale-up" id="search" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeCollectionModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Search</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">                        
                    <label class="col-sm-3 control-label">Subject </label>
                    <div class="col-sm-9">
                        <input type="value" name="subject" placeholder="Eg: abc" class="form-control" id="subject">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Amount </label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" min="0" max="10" name="amount" placeholder="Eg: 00.00" class="form-control" id="amount">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Comment </label>
                    <div class="col-sm-9">
                        <input type="value" name="comment" placeholder="Eg: abc" class="form-control" id="comment">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Spend From</label>
                    <div class="col-sm-3">
                        <input type="value" name="spendFrom" placeholder="" class="form-control datePicker spendFrom" id="spendFrom" autocomplete="off">
                    </div>
                    <label class="col-sm-2 control-label">Spend To</label>
                    <div class="col-sm-3 offset-sm-1 ">
                        <input type="value" name="spendTo" placeholder="" class="form-control datePicker spendTo" id="spendTo" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Created From</label>
                    <div class="col-sm-3">
                        <input type="value" name="dateFrom" placeholder="" class="form-control datePicker dateFrom" id="dateFrom" autocomplete="off">
                    </div>
                    <label class="col-sm-2 control-label">Created To</label>
                    <div class="col-sm-3 offset-sm-1 ">
                        <input type="value" name="dateTo" placeholder="" class="form-control datePicker dateTo" id="dateTo" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-primary btnSearch" name="btnSearch" id="btnSearch">Filter</button>
                <button type="button"  class="btn btn-default btnReset" name="btnReset" id="btnReset">Clear</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-super-scaled" id="addNewExpense" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeCollectionModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Add New Expenses</h4>
            </div>

            <form class="form-horizontal" action="{{url('expense/add')}}" method="POST">
                {!! csrf_field() !!}
                <div class="modal-body">                                    
                    <div class="form-group row">                        
                        <label class="col-sm-3 control-label">Subject </label>
                        <div class="col-sm-9">
                            <select name="subject" id="subject" class="form-control">
                                <option value="">-Please Choose-</option>
                                @foreach(\App\Custom::all() as $group)
                                    <option value="{{$group->id}}" >{{$group->subject}}</option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Amount </label>
                        <div class="col-sm-9">
                            <input type="number" step="0.01" min="0" name="amount" placeholder="Eg: 00.00" class="form-control" id="amount" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Comment </label>
                        <div class="col-sm-9">
                            <input type="value" name="comment" placeholder="Eg: abc" class="form-control" id="comment">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Date Spend </label>
                        <div class="col-sm-9">
                            <input type="value" name="dateSpend" placeholder="Eg: 01-01-2001" class="form-control dateSpend datePicker" id="dateSpend" autocomplete="off" required="">
                        </div>
                    </div>                                         
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary btnRegister waves-effect waves-light animation-fade">
                    <span class="ladda-label">Add</span>
                </button>
                    <button type="button" class="btn btn-secondary waves-effect waves-light animation-fade" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade modal-super-scaled" id="editNewExpense" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog"
    tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeCollectionModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Edit Expenses</h4>
            </div>

            <form class="form-horizontal" action="{{url('expense/edit')}}" method="POST">
                {!! csrf_field() !!}
                <div class="modal-body">
                <input type="hidden" class="id" name="id" id="id">                    
                    <div class="form-group row">          
                        <label class="col-sm-3 control-label">Subject </label>
                        <div class="col-sm-9">
                            <select name="edit_subject" id="edit_subject" class="form-control edit_subject">
                                <option value="">-Please Choose-</option>
                                @foreach(\App\Custom::all() as $group)
                                    <option value="{{$group->id}}" >{{$group->subject}}</option>
                                @endforeach                   
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Amount </label>
                        <div class="col-sm-9">
                            <input type="value" name="edit_amount" placeholder="Eg: 00.00" class="form-control edit_amount" id="edit_amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Comment </label>
                        <div class="col-sm-9">
                            <input type="value" name="edit_comment" placeholder="Eg: abc" class="form-control edit_comment" id="edit_comment">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Date Spend </label>
                        <div class="col-sm-9">
                            <input type="value" name="edit_dateSpend" placeholder="Eg: 01-01-2001" class="form-control edit_dateSpend datePicker" id="edit_dateSpend" autocomplete="off">
                        </div>
                    </div>                                         
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary btnRegister waves-effect waves-light animation-fade">
                    <span class="ladda-label">Edit</span>
                </button>
                    <button type="button" class="btn btn-secondary waves-effect waves-light animation-fade" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function()
    {
        $('.datePicker').datepicker({
            orientation: 'auto',
            keyboardNavigation: true,
            format: 'dd-mm-yyyy',
            // startDate: 'today',
            autoclose: 'true',
            todayHighlight: 'true'
        });
    });
</script>

<script>
    $(function() {
        $('#transTable').DataTable({
            order: [[ 3, "desc" ]],
            responsive: false,
            processing: true,
            serverSide: true,
            searching: false,
            columnDefs: [ { orderable: false, targets: [0,6] }],
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            buttons: [
                {
                    extend:    'pageLength',
                    className: 'btn btn-default btn-pure align-center',
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
                    text:      '<i class="fa fa-filter"></i> Filter',
                    titleAttr: 'Filter',
                    className: 'btn btn-default btn-pure btnFilter',
                    action: function ( e, dt, node, config ) {
                        $('.btnFilter')
                            .attr('data-toggle', 'modal')
                            .attr('data-target', '#search');
                    }

                },
            ],
            ajax:   { "url":"{{url('/expense/data')}}"},
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'subject', name: 'subject' },
                { data: 'amount', name: 'amount' },
                { data: 'dateSpend', name: 'dateSpend' },
                { data: 'comment', name: 'comment' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action' },
            ],

        });
       
    });
</script>
<script>
    $(function() {

        $('#btnSearch').on('click',function(){

            $('#transTable').DataTable().clear().destroy();

            $('#transTable').DataTable({
                order: [[ 3, "desc" ]],
                responsive: false,
                processing: true,
                serverSide: true,
                searching: false,
                columnDefs: [ { orderable: false, targets: [0,6] }],
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
                        text:      '<i class="fa fa-filter"></i> Filter',
                        titleAttr: 'Filter',
                        className: 'btn btn-default btn-pure btnFilter',
                        action: function ( e, dt, node, config ) {
                            $('.btnFilter')
                                .attr('data-toggle', 'modal')
                                .attr('data-target', '#search');
                        }
                    },
                ],
                ajax:   {
                            "url":"{{url('/expense/data')}}",
                            "data":   function(data) {                                
                                        data.subject = $('#subject').val();
                                        data.dateCreated = $('#dateCreated').val();
                                        data.amount = $('#amount').val();
                                        data.comment = $('#comment').val();
                                        data.spendFrom = $('#spendFrom').val();
                                        data.spendTo = $('#spendTo').val();
                                        data.dateFrom = $('#dateFrom').val();
                                        data.dateTo = $('#dateTo').val();
                                    },
                        },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'subject', name: 'subject' },
                    { data: 'amount', name: 'amount' },
                    { data: 'dateSpend', name: 'dateSpend' },
                    { data: 'comment', name: 'comment' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' },
                ],

            });
            $('#search').modal('hide'); 
        });
       
    });
</script>
<script>
    $(function() {

        $('#btnReset').on('click',function(){
            $('#subject').val('');
            $('#amount').val('');
            $('#comment').val('');
            $('#spendFrom').val('');
            $('#spendTo').val('');
            $('#dateFrom').val('');
            $('#dateTo').val('');
            // $('#search').modal('hide'); 
           
        });
    });
</script>
<script>
    $(function() {
    // sweetalert
        $('#transTable').on('click','.btnDelete',function(e){
            // Start rendering ladda 
            var urlDelete = $(this).attr('href');
            e.preventDefault();
            var l = Ladda.create(this);
            l.start();
            l.setProgress( 1 );

            swal({
                title: "Delete List",
                text: "Are you sure you want to delete this list? This list will no longer be available.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
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
        $('#transTable').on('click','.btnEdit', function(){
 
            var index = $(this).val();
            $('.id').val(index);
            $('.edit_subject').val($('.subject_'+index).val());
            $('.edit_amount').val($('.amount_'+index).val());
            $('.edit_comment').val($('.comment_'+index).val());
            $('.edit_dateSpend').val($('.dateSpend_'+index).val());            
        });
    });

</script>
@endpush