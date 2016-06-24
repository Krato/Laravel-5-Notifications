@extends('layouts.default')

@section('styles')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

@endsection

@section('content')
<!-- Modal -->
    <div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Message info</h4>
            </div>
            <div class="modal-body">
                {!! $notification->message !!}
          </div>
        </div>
      </div>
    </div>

	<div class="container">
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Notification id <strong>{{ $notification->count }}</strong>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalMessage">View message</button>
                    </div>

                    <div class="panel-body">
                        <table class="table  table-hover table-responsive" id="notif">
							<thead>
								<tr>
									<th>ID</th>
									<th>Notification</th>
									<th>Type</th>
									<th>Sent to</th>
                                    <th>Read</th>
                                    <th>Date</th>
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
		
		table = $('#notif');
        var settings = {
            "destroy": true,
            "responsive": true,
            "scrollCollapse": true,
            "processing": true,
            "serverSide": true,
            "iDisplayLength": 50,
            "ajax" : "{{ url('notifications/getNotifications/'.$notification->count) }}",
            "columns": [
                {data: "id", name: "id" },
                {data: "subject", name: "subject" },
                {data: "type", name: "type" },
                {data: "model", name: "model" },
                {data: "is_read", name: "read" },
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
                    text: "If you click delete, this notification will be deleted permanently. Please confirm you want to delete.",
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