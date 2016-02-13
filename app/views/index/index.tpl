{extends "_layout/skel.tpl"}

{block "content"}
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-header">Task list</h4>

			<table class="table table-condensed table-striped table-no-border">
				{foreach Task::find() as $task}
					<tr>
						<td class="col-lg-4">{$task->title|e}</td>
						<td class="col-lg-3">{$task->executed_at|e}</td>
						<td class="text-right">
							<a href="/task/execute/{$task->task_id|e}" class="btn btn-xs btn-default"><i class="fa fa-gear"></i></a>
							{*<a href="/task/edit/{$task->task_id|e}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							<a href="/task/delete/{$task->task_id|e}" class="btn btn-xs btn-default" data-confirm="Are you sure?"><i class="fa fa-times"></i></a>*}
						</td>
					</tr>
				{foreachelse}
					<tr>
						<td colspan="99">No tasks.</td>
					</tr>
				{/foreach}
			</table>

			<a href="/task/add" class="btn btn-info btn-sm"><i class="fa fa-fw fa-plus"></i> Add job</a>
		</div>
	</div>
{/block}
