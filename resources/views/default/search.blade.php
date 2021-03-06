@extends('app')

@section('title'){{ e($title) }}@endsection

@section('content')



<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container hidee wrap-jumbotron position-relative">
        <h1 class="title-site title-sm">{{ trans('misc.search') }}</h1>
		<p class="subtitle-site none-overflow"><strong>"{{$q}}"</strong></p>
		
		@section('searche')
        <form role="search" autocomplete="off" action="{{ url('search') }}" method="get">
        <div class="input-group input-group-lg searchBar">
                    <input type="text" autocomplete="off" name="q" class="form-control" value="{{$q}}" id="btnItems" placeholder="{{trans('misc.title_search_bar')}}">
                    <span class="input-group-btn">
                      <button class="btn btn-main btn-flat" type="submit" id="btnSearch">
                        <i class="glyphicon glyphicon-search"></i>
                      </button>
                    </span>
                  </div>
				</form>
		@endsection

      </div>
    </div>

<div class="container-fluid margin-bottom-40">
	<div class="row">
		<div class="col-md-12">

			<h2 class="text-center line position-relative none-overflow margin-bottom-30">
				{{ trans('misc.result_of') }} "{{ $q }}" <small>{{ $total }} {{ trans_choice('misc.images_plural',$total) }}</small>
				</h2>

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
				<div class="btn-block text-center margin-top-40">
	    			<i class="icon-search ico-no-result"></i>
	    		</div>

	    		<h3 class="margin-top-none text-center no-result no-result-mg">
	    		{{ trans('misc.no_results_found') }}
	    	</h3>
	    	@endif


		</div><!-- col-md-12 -->
	</div><!-- row -->
</div><!-- container -->
@endsection

@section('javascript')
<script type="text/javascript">

 $('#imagesFlex').flexImages({ rowHeight: 320 });

//<<---- PAGINATION AJAX
        $(document).on('click','.pagination a', function(e){
			e.preventDefault();
			var page = $(this).attr('href').split('page=')[1];
			$.ajax({
				headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
					url: '{{ url()->current() }}?q={{$q}}&page=' + page


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
