@layout('layout.master')


@section('topnavigation')
@include('navigation.topnav')
@endsection


@section('sidenavigation')
          <div class="span3">
@include('account.partials.account_sidenavigation')
@include('admin.partials.admin_sidenavigation')
          </div>
@endsection


@section('content')
          <div class="span9">
            <h2>{{ __('rhine/admin.manage_products') }}</h2>
@include('admin.partials.admin_products')
          </div>
@endsection