@extends('layouts.default')

@section('styles')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        Add new notification
                    </div>

                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('notifications') }}">
                            {!! csrf_field() !!}
                          <div class="form-group">
                            <label for="model">Send to:</label>
                            <select name="model" id="model" class="form-control">
                                @foreach($modelList as $value => $name)
                                    <option value="{{ $value }}">{{ $name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="ntype">Type:</label>
                            <select name="ntype" id="ntype" class="form-control">
                                @foreach(config('notifications.notification_types') as $key => $class)
                                    <option value="{{ str_slug($key) }}">{{ $key }}</option>
                                @endforeach
                            </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" id="subject" name="subject" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea id="message" name="message" class="form-control"></textarea>
                          </div>
                          <a href="{{ url('notifications') }}" class="btn btn-default">Cancel</a>
                          <button type="submit" class="btn btn-primary">Send notification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        

    </div>
@endsection


@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#message').summernote({
            height: 300
          });
        });

    </script>
@endsection