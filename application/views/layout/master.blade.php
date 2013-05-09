<!DOCTYPE html>
<html>
<head>
  <title>rhine shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="{{ URL::to_asset('css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="span6">
        <h1>rhine shop</h1>
      </div>
      <div class="span3">
        <h4>{{ __('rhine/header.language') }}</h4>
        <p>
          <?php $firstElement = true; ?>
          @foreach(Config::get('application.languages') as $lang)
            @unless($firstElement)|@endunless
            <?php
              $firstElement = false;
              
              $isCurrentLanguage = (Config::get('application.language') == $lang)
            ?>
            @if($isCurrentLanguage)<strong>@endif
            <a href="{{ URL::to_language($lang) }}">{{ __('rhine/header.'.$lang) }}</a>
            @if($isCurrentLanguage)</strong>@endif
          @endforeach
        </p>
        </div>
        <div class="span3 text-right">
          <p><h4>{{ __('rhine/header.cart') }}</h4></p>
          <p><a href="#">2 {{ __('rhine/header.item') }} - $40.00</a></p>
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <div class="navbar navbar-inverse">
            <div class="navbar-inner">
              <div class="container">
                <div class="nav-collapse">
                  <ul class="nav">
                    <li class="active"><a href="{{ URL::to_route('shop') }}">{{ __('rhine/nav.shop') }}</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{ URL::to_route('cart') }}">{{ __('rhine/nav.cart') }}</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{ URL::to_route('account') }}">{{ __('rhine/nav.myaccount') }}</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{ URL::to_route('information') }}">{{ __('rhine/nav.information') }}</a></li>
                  </ul>
                  <a href="#" class="btn btn-inverse pull-right">{{ __('rhine/nav.logout') }}</a>
                  <span class="divider-vertical pull-right">&nbsp;</span>
                  <form class="navbar-search pull-right" action="">
                    <input type="text" class="search-query span3" placeholder="{{ __('rhine/nav.search') }}" />
                  </form>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="span3">
@yield('sidenavigation')
      </div>
      <div class="span9">
@yield('content')
      </div>
    </div>
  </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="{{ URL::to_asset('js/bootstrap.min.js') }}"></script>
</body>
</html>