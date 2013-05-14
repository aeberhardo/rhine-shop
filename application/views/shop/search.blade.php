@layout('layout.master')


@section('topnavigation')
@include('navigation.topnav')
@endsection


@section('sidenavigation')
          <div class="span2">
@include('shop.partials.category_sidenavigation')
          </div>
@endsection


@section('content')
          <div class="span10">
@include('shop.partials.search_title')
@include('shop.partials.product_list')
          </div>
@endsection