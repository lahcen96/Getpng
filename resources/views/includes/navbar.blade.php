<?php
$userAuth = Auth::user();
if (Auth::check()) {
	// Notifications
	$notifications_count = App\Models\Notifications::where('destination', Auth::user()->id)->where('status', '0')->count();
}
?>
<?php
/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */                                                                                                 
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} ?>
<div class="btn-block text-center class-montserrat showBanner padding-top-10 padding-bottom-10" style="display:none;">
{{trans('misc.cookies_text')}} 
<button class="btn btn-sm btn-success" id="close-banner">{{trans('misc.go_it')}}</button>
</div>


<div class="navbar navbar-inverse navBar hidee navnavbar">
	<div class="container-fluid">
		<div class="navbar-header" style="padding-left: 70px;">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

				<?php if (isset($totalNotify)) : ?>
					<span class="notify notifyResponsive"><?php echo $totalNotify; ?></span>
				<?php endif; ?>

				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<a class="navbar-brand"  href="{{ url('/') }}">
				<img src="{{ url('public/img', $settings->logo) }}" class="logo" />
			</a>
		</div><!-- navbar-header -->




		<div class="navbar-collapse collapse">




			<ul class="nav navbar-nav navbar-center">
				@if (!Request::is('/') && !Request::is('search/*'))

				<!--<li id="li-search ">
					<a class="color-default font-default text-uppercase" id="btnExpand" data-toggle="collapse" href="#formShow" aria-expanded="false" aria-controls="form_Show">
						<i class="icon-search color-def"></i> <span class="title-dropdown">{{trans('misc.search')}}</span>
					</a>
				</li>-->
				@endif

				@if ($settings->sell_option == 'on')
				<!--<li>
        			<a href="{{url('photos/premium')}}" class="font-default text-uppercase text-warning">
        			<i class="icon icon-Crown myicon-right"></i>	{{trans('misc.premium')}}
        				</a>
        		</li>-->
				@endif

				<!--@if ( Auth::check() )
				<li>
					<a href="{{url('feed')}}" class="font-default text-uppercase">
						{{trans('misc.feed')}}
					</a>
				</li>
				@endif-->


				<!--<li class="dropdown">
					<a href="javascript:void(0);" class="font-default text-uppercase" data-toggle="dropdown">{{trans('misc.explore')}}
						<i class="ion-chevron-down margin-lft5"></i>
					</a>


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

				</li>-->

				<li class="dropdown">
					<a href="{{ url('/') }}" class="font-default text-uppercase">
						Home
					</a>
				</li>

				@foreach( App\Models\Categories::where('mode','on')->orderBy('name')->take(9)->get() as $category )

				<li class="dropdown">
					<a href="{{ url('category') }}/{{ $category->slug }}" class="font-default text-uppercase">
						@if (Lang::has('categories.'.$category->slug, config('app.locale')))
						@lang('misc.'.$category->slug)
						@else
						{{$category->name}}
						@endif
					</a>
				</li>

				@endforeach

				<!--@if ( App\Models\Categories::count() > 9 )
			        		<li><a href="{{ url('categories') }}">
			        			<strong>{{ trans('misc.view_all') }} <i class="fa fa-long-arrow-right"></i></strong>
			        		</a></li>
							@endif-->


			</ul>


			<ul class="nav navbar-nav navbar-right margin-bottom-zero">

				@if ( Auth::check() )

				<li>
					<span class="notify @if ( $notifications_count != 0 ) displayBlock @endif" id="noti_connect">@if ( $notifications_count != 0 ) {{ $notifications_count }} @endif</span>
					<a href="{{ url('notifications') }}" title="{{ trans('users.notifications') }}" class="font-default text-uppercase">
						<i class="fa fa-bell-o"></i>
						<span class="title-dropdown">{{ trans('users.notifications') }}</span>
					</a>
				</li><!-- NOTY -->

				<li class="dropdown">
					<a href="javascript:void(0);" data-toggle="dropdown" class="userAvatar myprofile dropdown-toggle font-default text-uppercase">
						<img src="{{ Storage::url(config('path.avatar').$userAuth->avatar) }}" alt="User" class="img-circle avatarUser" width="21" height="21">
						<span class="title-dropdown">{{ trans('users.my_profile') }}</span>
						<i class="ion-chevron-down margin-lft5"></i>
					</a>

					<!-- DROPDOWN MENU -->
					<ul class="dropdown-menu dd-close arrow-up nav-session" role="menu" aria-labelledby="dropdownMenu4">


						@if ($userAuth->role == 'admin' )
						<li>
							<a href="{{ url('panel/admin') }}" class="text-overflow">
								<i class="icon icon-Speedometter myicon-right"></i> {{ trans('admin.admin') }}</a>
						</li>
						<li role="separator" class="divider"></li>
						@endif
						<!-- DROPDOWN MENU -->
						@if ($settings->sell_option == 'on')
						<li>
							<span class="balance text-overflow">
								<i class="fa fa-dollar myicon-right"></i> {{ trans('misc.balance') }} <strong>{{\App\Helper::amountFormatDecimal(Auth::user()->balance)}}</strong>
							</span>
						</li>

						<li>
							<span class="balance text-overflow">
								<i class="icon icon-Dollars myicon-right"></i> {{ trans('misc.funds') }} <strong>{{\App\Helper::amountFormatDecimal(Auth::user()->funds)}}</strong>
							</span>
						</li>

						@if ($settings->daily_limit_downloads != 0 && auth()->user()->role != 'admin')
						<li>
							<span class="balance text-overflow">
								<i class="fa fa-download myicon-right"></i> {{ trans('misc.downloads') }}
								<span class="label label-default">{{ auth()->user()->downloads()->whereRaw("DATE(date) = '". date('Y-m-d', strtotime('today')) ."'")->whereType('free')->count() }}/{{ $settings->daily_limit_downloads }}</span>
							</span>
						</li>
						@endif

						<li role="separator" class="divider"></li>

						<li>
							<a href="{{ url('user/dashboard') }}" class="text-overflow">
								<i class="icon icon-Speedometter myicon-right"></i> {{ trans('admin.dashboard') }}</a>
						</li>

						<li>
							<a href="{{ url('user/dashboard/add/funds') }}" class="text-overflow">
								<i class="icon icon-Dollars myicon-right"></i> {{ trans('misc.add_funds') }}</a>
						</li>

						<li>
							<a href="{{ url('user/dashboard/withdrawals') }}" class="text-overflow">
								<i class="icon icon-Bag myicon-right"></i> {{ trans('misc.withdraw_balance') }}</a>
						</li>

						<li role="separator" class="divider"></li>
						@endif

						<li>
							<a href="{{ url($userAuth->username) }}" class="myprofile text-overflow">
								<i class="icon icon-User myicon-right"></i> {{ trans('users.my_profile') }}
							</a>
						</li>

						<li>
							<a href="{{ url($userAuth->username,'collections') }}">
								<i class="fa fa-folder-open-o myicon-right"></i> {{ trans('misc.collections') }}
							</a>
						</li>

						<li>
							<a href="{{ url('likes') }}" class="text-overflow">
								<i class="icon icon-Heart myicon-right"></i> {{ trans('users.likes') }}
							</a>
						</li>

						<li>
							<a href="{{ url('account') }}" class="text-overflow">
								<i class="icon icon-Settings myicon-right"></i> {{ trans('users.account_settings') }}
							</a>
						</li>
						<li>
							<a href="{{ url('logout') }}" class="logout text-overflow">
								<i class="icon icon-Exit myicon-right"></i> {{ trans('users.logout') }}
							</a>
						</li>

					</ul><!-- DROPDOWN MENU -->

				</li>





						@else

							<!--
						@if ( $settings->registration_active == '1' )
						<li>
							<a class="log-in font-default text-uppercase" href="{{ url('register') }}">
								<i class="glyphicon glyphicon-user"></i> {{ trans('auth.sign_up') }}
							</a>
						</li>
						@endif
						<li>
							<a class="font-default text-uppercase @if ( $settings->registration_active == 0 ) log-in @endif" href="{{ url('login') }}">
								{{ trans('auth.login') }}
							</a>
						</li>-->
							@endif





				<li class="hov">
					<a class="font-default btnup" href="{{ url('upload') }}" type="button" title="{{ trans('users.upload') }}">
						<i class="fa fa-cloud-upload"></i> <span>{{ trans('users.upload') }}</span>
					</a>
				</li>

				<li class="hov">
					<a class="font-default btnup" data-toggle="modal" data-backdrop="false" data-target="#FiltreModal" type="button" href="#" title="Filtre">
						<i class="fa fa-sliders"></i> <span>Filter</span>
					</a>
				</li>
			</ul>
			

		</div>

		<!--/.navbar-collapse -->
	</div>
</div>


<div id="FiltreModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="" aria-hidden="true">
				<div class="modal-dialog modal-sm spacer">
					<button type="button" class="btnmo" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="fa fa-times"></i></span>
					</button>
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Filter</h4>
						</div>
						<div class="modal-body modalb">
							<form id="filter_form" class="panel-group" role="tablist" aria-multiselectable="true" method="">
								<div class="panel">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse"  href="#p1" aria-controls="#p1">
												Sort By
											</a>
										</h4>
									</div>
									<div id="p1" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="radio margin-bottom-15">
												<label class="padding-zero">
													<input id="popular_sort" name="sort" type="radio" value="popular">
													<span class="input-sm"><strong> Popular </strong></span>
												</label>
											</div>

											<div class="radio margin-bottom-15">
												<label class="padding-zero">
													<input id="latest_sort" name="sort" type="radio" value="latest">
													<span class="input-sm"><strong> Latest </strong></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="panel">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse"  href="#p2" aria-controls="#p2">
												Category
											</a>
										</h4>
									</div>
									<div id="p2" class="panel-collapse collapse">
										<div class="panel-body">
											@foreach( App\Models\Categories::where('mode','on')->orderBy('name')->take(9)->get() as $category )
											<div class="checkbox margin-bottom-15">
												<label class="padding-zero">
													<input name="category" id="{{$category->id}}" type="checkbox" value="{{ url('category') }}/{{ $category->slug }}">
													<span class="input-sm"><strong> {{$category->name}} </strong></span>
												</label>
											</div>
											@endforeach
										</div>
									</div>
								</div>
								<!--<div class="panel">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse"  href="#p3" aria-controls="#p3">
												Resolution
											</a>
										</h4>
									</div>
									<div id="p3" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="checkbox margin-bottom-15">
												<label class="padding-zero">
													<input name="res" id="-2000" type="checkbox" value="-2000">
													<span class="input-sm"><strong>-2000 pixel</strong></span>
												</label>
											</div>
											<div class="checkbox margin-bottom-15">
												<label class="padding-zero">
													<input name="res" id="2000" type="checkbox" value="2000">
													<span class="input-sm"><strong> +2000 pixel</strong></span>
												</label>
											</div>
											<div class="checkbox margin-bottom-15">
												<label class="padding-zero">
													<input name="res" id="3000" type="checkbox" value="3000">
													<span class="input-sm"> <strong>+3000 pixel</strong></span>
												</label>
											</div>
										</div>
									</div>
								</div>-->
								<div class="panel">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" href="#p4" aria-controls="#p4">
												{{trans('misc.colors')}}
											</a>
										</h4>
									</div>
									<div id="p4" class="panel-collapse collapse anyClass">
										<div class="panel-body">
											@php
											$colos = array();
											@endphp
											@foreach( App\Models\Images::all() as $img)
											@if($img->colors != '')
											<?php
											$colors  = explode(',', $img->colors);
											$count_colors = count($colors);
											array_push($colos, hex2RGB($colors[0], true));
											?>
											@endif
											@endforeach
												<?php
												$colos = $colos ;
												 foreach( $colos as $j)
												{
													$ar = explode(',' , $j);
													$co = sprintf("#%02x%02x%02x", $ar[0], $ar[1], $ar[2]);
													$co = substr($co, 1)
													?>
														<a title="rgb({{$j}})" href="{{url('colors') }}/{{$co}}" 
														class="colorPalette showTooltip" 
														style="background-color: {{ 'rgb('.$j.')' }};"></a>
														<?php
												} 
												?>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>