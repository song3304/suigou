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
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-sitemap sidebar-nav-icon"></i>门店管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/shop'|url}>" name="shop/list">门店列表</a>
						<a class="col-md-4" href="<{'admin/shop/create'|url}>" name="shop/create"><i class="glyphicon glyphicon-plus"></i>添加</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-shopping-cart sidebar-nav-icon"></i>商品管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/product'|url}>" name="product/list">商品列表</a>
						<a class="col-md-4" href="<{'admin/product/create'|url}>" name="product/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a href="<{'admin/order'|url}>" name="order/list">订单列表</a></li>
						<li><a class="col-md-8" href="<{'admin/navigation'|url}>" name="navigation/list">栏目列表</a>
						<a class="col-md-4" href="<{'admin/navigation/create'|url}>" name="navigation/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
						<li><a href="<{'admin/review'|url}>?tag=1" name="review/list">评论列表</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-balance-scale sidebar-nav-icon"></i>Banner管理</a>
					<ul>
						<li><a class="col-md-8" href="<{'admin/banner'|url}>" name="banner/list">Banner列表</a>
						<a class="col-md-4" href="<{'admin/banner/create'|url}>" name="banner/create"><i class="glyphicon glyphicon-plus"></i> 添加</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-line-chart sidebar-nav-icon"></i>财务管理</a>
					<ul>
						<li><a href="<{'admin/statistics'|url}>" name="statistics/list">财务报表</a></li>
						<li><a href="<{'admin/wechat/statement'|url}>" name="wechat/statement/list">微信入账列表</a></li>
						<li><a href="<{'admin/alipay/statement'|url}>" name="alipay/statement/list">支付宝入账列表</a></li>
						<li><a href="<{'admin/income'|url}>" name="income/list">收入细明</a></li>
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

