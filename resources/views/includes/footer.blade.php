<!-- ***** Footer ***** -->


<footer class="subfooter" style="padding-block: 15px;">
	<div class="container" style="width: 90%">
	    
		<div class="row">
		<div class="col-md-6  text-left evryfooyert">
		          @ All rights reserved.
				<a href="" class="highlight-word-color-yellow"> Get PNG </a>
			</div><!-- ./End col-md-* -->
			
			

			<div class="col-md-6 text-right evryfooyert">
                    	<ul class="list-unstyled">
					<a href="{{ url('/') }}" class="link-footer">
						Home
					</a>
					@foreach( App\Models\Pages::all() as $page )



					<a class="link-footer" href="{{url('page', $page->slug) }}">{{ $page->title }}</a>

					@endforeach
					<a class="link-footer" href="{{url('contact')}}">Contact Us</a>
					
				</ul>
               
				
			</div>
		</div>
	</div>
</footer>