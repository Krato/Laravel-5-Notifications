@extends('layouts.default')

@section('styles')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

@endsection

@section('content')
	<div class="container">
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                    Notifications
                        <div class="pull-right ">
                            <a class="btn btn-primary" href="{{ url('notifications/create') }}">New Notification</a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-responsive" id="notis">
							<thead>
								<tr>
									<th>ID</th>
									<th>Notification</th>
									<th>Type</th>
									<th>Sent to</th>
									<th>Options</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>

		

	</div>
@endsection


@section('scripts')
	<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<script type="text/javascript">

		//Datatables
		table = $('#notis');
        var settings = {
            "destroy": true,
            "responsive": true,
            "scrollCollapse": true,
            "processing": true,
            "serverSide": true,
            "iDisplayLength": 50,
            "ajax" : "{{ url('notifications/getNotifications/') }}",
            "columns": [
                {data: "id", name: "id" },
                {data: "subject", name: "subject" },
                {data: "type", name: "type" },
                {data: "sent_at", name: "sent_at" },
                {data: 'actions', name: 'actions', 'searchable' : false, 'orderable' : false}
            ]
        };

        table.dataTable(settings);
        $('#search-table').keyup(function() {
            table.fnFilter($(this).val());
        });

        //Delete actions
        $(document).on('click', "[data-button=delete]", function(e) {
            e.preventDefault();
            var delete_button = $(this);
            var delete_url = $(this).attr('href');
            swal({  title: "Are you sure?",
                    text: "If you click delete all notifications about this group will be deleted. Please confirm you want to delete.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "No",
                    closeOnConfirm: true
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            url: delete_url,
                            beforeSend: function (request){
                                request.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                            },
                            type: 'DELETE',
                            success: function(result) {
                                delete_button.parentsUntil('tr').parent().remove();
                            }
                        });
                    }
                });
        });
	</script>
@endsection