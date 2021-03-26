@extends('app')

@section('title')@endsection

@section('content')

<div class="jumbotron index-header jumbotron_set jumbotron-cover session-active-cover justfor">


	@if ( !Auth::check() )

	<div>

		<nav class="social">
			<ul>

				@if ( $settings->registration_active == '1' )
				<li>
					<a class="log-in font-default text-uppercase" type="button" href="{{ url('register') }}">
						{{ trans('auth.sign_up') }} <i class="glyphicon glyphicon-plus"></i>
					</a>
				</li>
				@endif
				<li>
					<a class="font-default text-uppercase @if ( $settings->registration_active == 0 ) log-in @endif" href="{{ url('login') }}" type="button">
						{{ trans('auth.login') }}<i class="glyphicon glyphicon-user" style="background-color: #01CCC;"></i>
					</a>
				</li>
			</ul>
		</nav>

	</div>

	@endif
	<div class="container wrap-jumbotron position-relative">




		<h1 class="title-site vivify driveInTop delay-500" id="titleSite">{{$settings->welcome_text}}</h1>
		<p class="subtitle-site vivify fadeInBottom delay-600"><strong>{{$settings->welcome_subtitle}}</strong></p>



		<form role="search" autocomplete="off" action="{{ url('search') }}" method="get">
			<div class="input-group input-group-lg searchBar">
				<input type="text" class="form-control" name="q" id="btnItems" placeholder="Search Png Images">

				<span class="input-group-btn">

					<li class="dropdown">
						<button class="btn success resources" data-toggle="dropdown">

							All resources<i class="ion-chevron-down margin-lft5"></i>
						</button>
						<ul class="dropdown-menu arrow-up" role="menu" aria-labelledby="dropdownMenu2">
							<li><a href="{{ url('members') }}"><i class="icon icon-Users myicon-right"></i> {{ trans('misc.members') }}</a></li>
							<li><a href="{{ url('collections') }}"><i class="fa fa-folder-open-o myicon-right"></i> {{ trans('misc.collections') }}</a></li>
							<li><a href="{{ url('tags') }}"><i class="icon icon-Tag myicon-right"></i> {{ trans('misc.tags') }}</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('featured') }}">{{ trans('misc.featured') }}</a></li>
							<li><a href="{{ url('popular') }}">{{ trans('misc.popular') }}</a></li>
							<li><a href="{{ url('latest') }}">{{ trans('misc.latest') }}</a></li>
							<li><a href="{{ url('most/commented') }}">{{trans('misc.most_commented')}}</a></li>
							<li><a href="{{ url('most/viewed') }}">{{trans('misc.most_viewed')}}</a></li>
							<li><a href="{{ url('most/downloads') }}">{{trans('misc.most_downloads')}}</a></li>

						</ul>
					</li>

				</span>

				<span class="input-group-btn">

					<!-- DROPDOWN MENU -->


					<button class="btn btn-main btn-flat" type="submit" id="btnSearch">
						<i class="glyphicon glyphicon-search"></i>
					</button>
				</span>
			</div>
		</form>




		@if($categoryPopular)
		<div style="text-align:center;color:#333;margin-top: 10px;font-size: 16px;background">
			<strong>{{trans('Examples :')}}

				@foreach( App\Models\Images::all()->take(4) as $image )
				<?php
				$tags = explode(',', $image->tags);
				$count_tags = count($tags);
				?>

				@for( $i = 0; $i < $count_tags; ++$i ) <a href="{{url('tags', str_replace(' ', '_', $tags[$i])) }}" class="btn btn-danger tags font-default btn-sm">
					{{ $tags[$i] }}
					</a>
					@endfor

					@endforeach

			</strong>
		</div>
		@endif

	</div><!-- container wrap-jumbotron -->
</div>

<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow highlight-word-color">@lang('misc.featured_photos')</h1>
			<h5 class="btn-block text-center class-montserrat text-uppercase">{{trans('misc.subtitle_featured_home')}}</h5>
		</div>
		</dib>
	</div>
</div>

<div class="container-fluid margin-bottom-40 padding-top-10 margin-margin">
	<div class="row">

		<!-- col-md-8 -->
		<div class="col-md-1">

		</div>

		<div class="col-md-10">



			<div id="imagesFlex" class="flex-images btn-block margin-bottom-40 dataResult">
				
					@include('includes.images')

                	<div class="container-paginator">
					   {{ $images->links() }}
				    </div>

			</div><!-- Image Flex -->




		</div>

		<div class="col-md-1 FollowSticky">
			<div class="panel panel-default">
				<center><div class="panel-body">
					<h5 class="text-center"> <strong>Follow Us</strong> </h5><br>


               
					@if( $settings->facebook != '' )
					<li><a href="{{$settings->facebook}}" target="_blank" class="ico-social"><img src="{{url('public/img/social')}}/facebook.png" width="20" /></a></li>
					@endif

					@if( $settings->twitter != '' )
					<li><a href="{{$settings->twitter}}" target="_blank" class="ico-social"><img width="20" src="{{url('public/img/social')}}/twitter.png" /></a></li>
					@endif

					@if( $settings->instagram != '' )
					<li><a href="{{$settings->pinterest}}" target="_blank" class="ico-social"><img width="20" src="{{url('public/img/social')}}/pinterest.png" /></a></li>
					@endif

					@if( $settings->linkedin != '' )
					<li><a href="{{$settings->instagram}}" target="_blank" class="ico-social"><img src="{{url('public/img/social')}}/instagram.png" width="20" /></a></li>
					@endif

					@if( $settings->youtube != '' )
					<li><a href="{{$settings->youtube}}" target="_blank" class="ico-social"><i class="fa fa-youtube-play"></i></a></li>
					@endif


				</div>
				</center>
			</div>
		</div><!-- col-md-12-->

	</div><!-- row -->
</div><!-- container -->

<!-- jumbotron -->


<!-- row -->

<!--<div class="row margin-bottom-40">

		<div class="container">

			@if ($settings->show_counter == 'on')
			<div class="col-md-4 border-stats">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow"><span class=".numbers-with-commas counter"><?php echo html_entity_decode(App\Helper::formatNumbersStats(App\Models\User::where('status', 'active')->count())) ?></span></h1>
				<h5 class="btn-block text-center class-montserrat subtitle-color text-uppercase">{{trans('misc.members')}}</h5>
			</div>

			<div class="col-md-4 border-stats">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow"><span class=".numbers-with-commas counter"><?php echo html_entity_decode(App\Helper::formatNumbersStats(App\Models\Downloads::count())) ?></span></h1>
				<h5 class="btn-block text-center class-montserrat subtitle-color text-uppercase">{{trans('misc.downloads')}}</h5>
			</div>

			<div class="col-md-4 border-stats">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow"><span class=".numbers-with-commas counter"><?php echo html_entity_decode(App\Helper::formatNumbersStats(App\Models\Images::where('status', 'active')->count())) ?></span></h1>
				<h5 class="btn-block text-center class-montserrat subtitle-color text-uppercase">{{trans('misc.stock_photos')}}</h5>
			</div>
			@endif

			@if( isset( $settings->google_adsense ) && $settings->google_ads_index == 'on' && $settings->google_adsense_index != '' )
			<div class="col-md-12 margin-top-40">
				<?php echo html_entity_decode($settings->google_adsense_index); ?>
			</div>
			@endif

		</div>
	</div>-->

</div>

<!--
<div class="jumbotron jumbotron-bottom margin-bottom-zero jumbotron-cover">
	<div class="container wrap-jumbotron position-relative">
		<h1 class="title-site">{{trans('misc.title_2_index')}}</h1>
		<p class="subtitle-site"><strong>{{$settings->welcome_subtitle}}</strong></p>


		@if( Auth::check() || $settings->registration_active == 0 )

		<form role="search" autocomplete="off" action="{{ url('search') }}" method="get">
			<div class="input-group input-group-lg searchBar">
				<input type="text" class="form-control" name="q" id="btnItems_2" placeholder="{{trans('misc.title_search_bar')}}">
				<span class="input-group-btn">
					<button class="btn btn-main btn-flat" type="submit" id="btnSearch_2">
						<i class="glyphicon glyphicon-search"></i>
					</button>
				</span>
			</div>
		</form>

		@else
		<div class="btn-block text-center">
			<a href="{{ url('register') }}" class="btn btn-lg btn-main custom-rounded">
				{{ trans('misc.signup_free') }}
			</a>
		</div>

		@endif
	</div>
</div> jumbotron -->

<!--@if ($settings->show_categories_index == 'on')
<div class="wrapper">
	<div class="container">
		<div class="row margin-bottom-40">
			<div class="col-md-12 btn-block margin-bottom-40">
				<h1 class="btn-block text-center class-montserrat margin-bottom-zero none-overflow color-white">{{trans('misc.categories')}}</h1>
				<h5 class="btn-block text-center class-montserrat text-uppercase color-gray">{{trans('misc.brows_by_category')}}</h5>
			</div>

			@foreach($categories->chunk(3) as $column)

			<div class="col-md-3 col-center">
				<ul class="list-unstyled imagesCategory">
					@foreach ($column as $category)

					<li>
						<a class="link-category" href="{{ url('category') }}/{{ $category->slug }}">{{ $category->name }} ({{$category->images()->count()}}) </a>
					</li>

					@endforeach

				</ul>
			</div>
			@endforeach

			@if( $categories->total() > 11 )
			<div class="col-md-12 text-center margin-top-40">
				<a href="{{ url('categories') }}" class="btn btn-lg btn-main custom-rounded">
					{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i>
				</a>
			</div>
			@endif

		</div>
	</div>
</div>
@endif-->



@endsection

@section('javascript')



<script src="{{ asset('public/plugins/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('public/plugins/jquery.counterup/waypoints.min.js') }}"></script>



<script type="text/javascript">
	$('#imagesFlex').flexImages({
		rowHeight: 320,
		maxRows: 8,
		truncate: true
	});

	$('#imagesFlexFeatured').flexImages({
		rowHeight: 320,
		maxRows: 8,
		truncate: true
	});


	jQuery(document).ready(function($) {
		$('.counter').counterUp({
			delay: 10, // the delay time in ms
			time: 1000 // the speed time in ms
		});
	});

	@if(session('success_verify'))
	swal({
		title: "{{ trans('misc.welcome') }}",
		text: "{{ trans('users.account_validated') }}",
		type: "success",
		confirmButtonText: "{{ trans('users.ok') }}"
	});
	@endif

	@if(session('error_verify'))
	swal({
		title: "{{ trans('misc.error_oops') }}",
		text: "{{ trans('users.code_not_valid') }}",
		type: "error",
		confirmButtonText: "{{ trans('users.ok') }}"
	});
	@endif

	// GET country
	/*$.get("https://ipinfo.io", function (response) {
   		     console.log(response.country);

   		 }, "jsonp");*/
</script>

@endsection