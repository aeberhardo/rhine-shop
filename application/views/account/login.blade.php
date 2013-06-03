@layout('layout.master')


@section('topnavigation')
@include('navigation.topnav')
@endsection


@section('sidenavigation')
          <div class="span3">
          </div>
@endsection


@section('content')
          <div class="span6">
            <h2>Login</h2>
            <div class="well">
              {{ Form::open(URL::to_route('login'), 'POST', array('class' => 'form-horizontal')) }}

                <div class="control-group">
                  <label class="control-label" for="username">Username</label>
                  <div class="controls">
                    {{ Form::text('username', '', array('placeholder' => 'Username', 'required')) }}
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="password">Password</label>
                  <div class="controls">
                    {{ Form::password('password', array('placeholder' => 'Password', 'required')) }}
                  </div>
                </div>
                
@if(Session::get('status') != null)
                <div class="alert alert-error fade in">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  {{ __('rhine/status.'.Session::get('status')) }}

                </div>
@endif
                
                <div class="control-group">
                  <div class="controls">
                    {{ Form::button('Sign in', array('class' => 'btn btn-primary', 'type' => 'submit')) }}
                  </div>
                </div>
                {{ Form::token() }}

              {{ Form::close() }}

            </div>
          </div>
@endsection