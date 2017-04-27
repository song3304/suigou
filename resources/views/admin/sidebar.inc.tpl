<!-- Main Sidebar -->
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div id="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<{block "sidebar-brand"}><{include file="admin/sidebar.brand.inc.tpl"}><{/block}>
			<{block "sidebar-user"}><{include file="admin/sidebar.user.inc.tpl"}><{/block}>
			<{block "sidebar-theme"}><{include file="admin/sidebar.theme.inc.tpl"}><{/block}>
			<{block "sidebar-navigation"}>
			<!-- Sidebar Navigation -->
			<ul class="sidebar-nav">
				<li>
					<a href="<{''|url}>" class=""><i class="gi gi-stopwatch sidebar-nav-icon"></i>首页</a>
				</li>
				<li class="sidebar-header">
					<span class="sidebar-header-title">基本</span>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="gi gi-user sidebar-nav-icon"></i>会员管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/member'|url}>" name="member/list">会员列表</a>
						<a class="col-md-4" href="<{'admin/member/create'|url}>" name="member/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a class="col-md-8" href="<{'admin/user_address'|url}>" name="user_address/list">地址管理</a>
						<a class="col-md-4" href="<{'admin/user_address/create'|url}>" name="user_address/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li>
				<{pluginclude file="admin/sidebar.inc.tpl"}>
				<li><a href="<{'auth/logout'|url}>"><i class="gi gi-exit sidebar-nav-icon"></i>退出系统</a></li>
			</ul>
			<!-- END Sidebar Navigation -->
			<{/block}>
		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>
<!-- END Main Sidebar -->

