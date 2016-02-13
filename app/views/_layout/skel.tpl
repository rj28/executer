<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Executor</title>

	<link href="/sba2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/sba2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<link href="/sba2/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
	<link href="/sba2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<link href="/sba2/dist/css/timeline.css" rel="stylesheet">
	<link href="/sba2/dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="/sba2/bower_components/morrisjs/morris.css" rel="stylesheet">
	<link href="/sba2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="/sba2/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/sba2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/sba2/bower_components/metisMenu/dist/metisMenu.min.js"></script>
	<script src="/sba2/bower_components/raphael/raphael-min.js"></script>
	{*<script src="/sba2/bower_components/morrisjs/morris.min.js"></script>
	<script src="/sba2/js/morris-data.js"></script>*}
	<script src="/sba2/dist/js/sb-admin-2.js"></script>
	<script src="/sba2/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="/sba2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<style>
		.table-no-border td { border-top: 0 !important; }
		.floating #page-wrapper { left: 0; right: 0; }
	</style>

	<script>
		$(function() {
			$('a[data-confirm]').click(function() {
				var c = confirm($(this).attr('data-confirm'));
				return c;
			});
		});
	</script>
</head>
<body>
<div id="wrapper">
	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span class="navbar-brand">Демон сейчас {if $ping_time > 10}не в сети{else}исправно работает{/if} {$ping_time}</span>
		</div>
		<!-- /.navbar-header -->

		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li><a href="/">Главная</a></li>
				</ul>
			</div>
			<!-- /.sidebar-collapse -->
		</div>
		<!-- /.navbar-static-side -->
	</nav>

	<div id="page-wrapper">
		{block "content"}{/block}
	</div>
</div>
</body>
</html>
