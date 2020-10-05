@if (Auth::check())
	<?php
    // Admin URL Base
    $adminBase = config('larapen.admin.route_prefix', 'admin');

    // Get plugins admin menu
    $pluginsMenu = '';
    $plugins = plugin_installed_list();
    if (count($plugins) > 0) {
        foreach($plugins as $plugin) {
            if (method_exists($plugin->class, 'getAdminMenu')) {
                $pluginsMenu .= call_user_func($plugin->class . '::getAdminMenu');
            }
        }
    }
	?>
    <style>
        #adminSidebar ul li span {
            text-transform: capitalize;
        }
    </style>
	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar" id="adminSidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{{ Gravatar::fallback(url('images/user.jpg'))->get(Auth::user()->email) }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{{ Auth::user()->name }}</p>
					<a href="#"><i class="fa fa-circle text-success"></i> {{ __t('Online') }}</a>
				</div>
			</div>

			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				@if(Auth::user()->user_type_id == config('constant.POST_AUTHOR_ID'))
					<li class="header">{{ __t('Author') }}</li>
				@else
					<li class="header">{{ __t('administration') }}</li>
				@endif
				<!-- ================================================ -->
				<!-- ==== Recommended place for admin menu items ==== -->
				<!-- ================================================ -->

				@if(Auth::user()->user_type_id !== config('constant.POST_AUTHOR_ID'))

				<li><a href="{{ url($adminBase . '/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ __t('dashboard') }}</span></a></li>

				<li class="treeview">
					<a href="#"><i class="fa fa-table"></i><span>{{ __t('ads') }}</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li>
							<a href="{{ url($adminBase . '/post') }}">
                                <i class="fa fa-table"></i> <span>{{ __t('list') }}</span>
							</a>
						</li>
                        <li><a href="{{ url($adminBase . '/category') }}"><i class="fa fa-folder"></i> <span>{{ __t('categories') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/company') }}"><i class="fa fa-institution"></i> <span>{{ __t('companies') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/p_type') }}"><i class="fa fa-cog"></i> <span>{{ __t('ad types') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/salary_type') }}"><i class="fa fa-cog"></i> <span>{{ __t('salary type') }}</span></a></li>
					</ul>
				</li>
				
				
				<li class="treeview">
					<a href="#"><i class="fa fa-table"></i><span>{{ __t('users') }}</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li>
							<a href="{{ url($adminBase . '/user') }}">
								<i class="fa fa-users"></i> <span>{{ __t('list') }}</span>
							</a>
						</li>
						<li><a href="{{ url($adminBase . '/gender') }}"><i class="fa fa-language"></i> <span>{{ __t('titles') }}</span></a></li>
					</ul>
				</li>
				
				<li><a href="{{ url($adminBase . '/payment') }}"><i class="fa fa-usd"></i> <span>{{ __t('payments') }}</span></a></li>

				
				<li><a href="{{ url($adminBase . '/page') }}"><i class="fa fa-clone"></i> <span>{{ __t('pages') }}</span></a></li>

				@endif

				<li class="treeview">
					<a href="#"><i class="fa fa-newspaper-o"></i> <span>{{ __t('blog') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url($adminBase . '/blog-categories') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('blog_categories') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/blog-entries') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('blog_entries') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/blog-tags') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('blog_tags') }}</span></a></li>
					</ul>
				</li>

				@if(Auth::user()->user_type_id !== config('constant.POST_AUTHOR_ID'))
				
				{!! $pluginsMenu !!}
				
				<!-- ======================================= -->
				<li class="header">{{ __t('configuration') }}</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-cog"></i> <span>{{ __t('setup') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url($adminBase . '/setting') }}"><i class="fa fa-cog"></i> <span>{{ __t('general settings') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/homepage_section') }}"><i class="fa fa-home"></i> <span>{{ __t('homepage') }}</span></a></li>
						
						<li><a href="{{ url($adminBase . '/language') }}"><i class="fa fa-language"></i> <span>{{ __t('languages') }}</span></a></li>
						
						<li><a href="{{ url($adminBase . '/meta_tag') }}"><i class="fa fa-bookmark-o"></i> <span>{{ __t('meta tags') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/package') }}"><i class="fa fa-pie-chart"></i> <span>{{ __t('packages') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/branch') }}"><i class="fa fa-folder"></i> <span>{{ t('Branches') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/model-categories') }}"><i class="fa fa-circle-o"></i> <span>{{ t('Model Categories') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/payment_method') }}"><i class="fa fa-credit-card"></i> <span>{{ __t('payment methods') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/advertising') }}"><i class="fa fa-life-ring"></i> <span>{{ __t('advertising') }}</span></a></li>
						<li class="treeview">
							<a href="#"><i class="fa fa-globe"></i> <span>{{ __t('international') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="{{ url($adminBase . '/country') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('countries') }}</span></a></li>
								<li><a href="{{ url($adminBase . '/currency') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('currencies') }}</span></a></li>
								<li><a href="{{ url($adminBase . '/time_zone') }}"><i class="fa fa-circle-o"></i> <span>{{ __t('time zones') }}</span></a></li>
							</ul>
						</li>
						<li><a href="{{ url($adminBase . '/blacklist') }}"><i class="fa fa-ban"></i> <span>{{ __t('blacklist') }}</span></a></li>
						<li><a href="{{ url($adminBase . '/report_type') }}"><i class="fa fa-language"></i> <span>{{ __t('report types') }}</span></a></li>
					</ul>
				</li>
				
				<li><a href="{{ url($adminBase . '/plugin') }}"><i class="fa fa-cogs"></i> <span>{{ __t('plugins') }}</span></a></li>
				<li><a href="{{ url($adminBase . '/clear_cache') }}"><i class="fa fa-refresh"></i> <span>{{ __t('clear cache') }}</span></a></li>
				<li><a href="{{ url($adminBase . '/backup') }}"><i class="fa fa-hdd-o"></i> <span>{{ __t('backups') }}</span></a></li>
				
				@if (app()->isDownForMaintenance())
					<li>
						<a href="{{ url($adminBase . '/maintenance/up') }}" data-toggle="tooltip" title="{{ __t('Leave Maintenance Mode') }}">
							<i class="fa fa-hdd-o"></i> <span>{{ __t('Live Mode') }}</span>
						</a>
					</li>
				@else
					<li>
						<a href="#" data-toggle="modal" data-target="#maintenanceMode" title="{{ __t('Put in Maintenance Mode') }}">
							<i class="fa fa-hdd-o"></i> <span>{{ __t('Maintenance Mode') }}</span>
						</a>
					</li>
				@endif

				
				<!-- ======================================= -->
				<li class="header">{{ __t('user_panel') }}</li>
				<li><a href="{{ url($adminBase . '/account') }}"><i class="fa fa-sign-out"></i> <span>{{ __t('my account') }}</span></a></li>

				@endif
				
				<li><a href="{{ url($adminBase . '/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ __t('logout') }}</span></a></li>
			</ul>

		</section>
		<!-- /.sidebar -->
	</aside>
@endif
