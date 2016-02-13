{extends "_layout/skel.tpl"}

{block "content"}
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-header">Add a task</h4>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">

			<div class="panel panel-default">
				<div class="panel-body">

					<form method="post">
						{include file="_inc/form-field.tpl" title=Title name=title}
						{include file="_inc/form-field.tpl" title=Script name=script}

						<input type="submit" class="btn btn-sm btn-primary" value="Save" />
					</form>

				</div>
			</div>

		</div>
	</div>
{/block}
