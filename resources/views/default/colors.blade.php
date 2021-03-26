@extends('app')

@section('title'){{ $title.' - ' }}@endsection

@section('content')
<div class="jumbotron md header-colors jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">

        <h1 class="title-site title-sm">#{{$colors}}</h1>

        	<p class="subtitle-site"><strong>
        		<i class="fa fa-square myicon-right" style="@if( $images->total() != 0 ) color: #{{$colors}} @endif"></i> {{trans('misc.colors' )}} ({{$total}})
        		</strong>

        		</p>
      </div>
	</div>
	


	
<div class="container-fluid navnavba">



<div id="cont" class="row cont">



 <div class="col-md-12">

 
		
 <div id="main" class="container wrap-jumbotron hidee">


 <p class="subtitle-site vivify fadeInBottom delay-600"><strong></strong></p> 

	<a class="navbar-brand" style="margin-left:60px;padding: 1px 15px;background-color: #333333;" href="{{ url('/') }}">
	<img src="{{ url('public/img', $settings->logo) }}" class="logo" />
   </a>


   
	<form role="search"  action="{{ url('search') }}" method="get">
	
		<div class="input-group input-group-lg searchBar">
		
			<input type="text" class="form-control" name="q" id="btnItems"  placeholder="Search Png Images">

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

	

	<p class="subtitle-site vivify fadeInBottom delay-600"><strong></strong></p>


	

</div>

 </div>
 
</div>
</div>

<div class="container-fluid margin-bottom-40">

<!-- Col MD -->
<div class="col-md-12 margin-top-20 margin-bottom-20">

	@if( $images->total() != 0 )

	<div id="imagesFlex" class="flex-images btn-block margin-bottom-40 dataResult">
	     @include('includes.images')


	      @if( $images->count() != 0  )
			    <div class="container-paginator">
			    	{{ $images->links() }}
			    	</div>
			    	@endif

	  </div><!-- Image Flex -->

	  @else
	  <div class="btn-block text-center">
	    			<i class="icon icon-Picture ico-no-result"></i>
	    		</div>

	    		<h3 class="margin-top-none text-center no-result no-result-mg">
	    		{{ trans('misc.no_results_found') }}
	    	</h3>
	  @endif

 </div><!-- /COL MD -->

 </div><!-- container wrap-ui -->

@endsection

@section('javascript')

<script type="text/javascript">

 $('#imagesFlex').flexImages({ rowHeight: 320 });
 
  $(window).on('scroll' ,function() {myFunction()});

var header = $("#main");
var cont = $("#cont");

function myFunction() { 
var p = window.matchMedia('(max-device-width: 768px)').matches;
  if ($(window).scrollTop() >= 200 && !p) {
    header.removeClass("hidee");
    cont.removeClass("cont");
  } else {
    header.addClass("hidee");
    cont.addClass("cont");
  }
} 

//<<---- PAGINATION AJAX
        $(document).on('click','.pagination a', function(e){
			e.preventDefault();
			var page = $(this).attr('href').split('page=')[1];
			$.ajax({
				headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
					url: '{{ url()->current() }}?page=' + page


			}).done(function(data){
				if( data ) {

					scrollElement('#imagesFlex');

					$('.dataResult').html(data);

					$('.hovercard').hover(
		               function () {
		                  $(this).find('.hover-content').fadeIn();
		               },
		               function () {
		                  $(this).find('.hover-content').fadeOut();
		               }
		            );

					$('#imagesFlex').flexImages({ rowHeight: 320 });
					jQuery(".timeAgo").timeago();

					$('[data-toggle="tooltip"]').tooltip();
				} else {
					sweetAlert("{{trans('misc.error_oops')}}", "{{trans('misc.error')}}", "error");
				}
				//<**** - Tooltip
			});

		});//<<---- PAGINATION AJAX
</script>


@endsection
