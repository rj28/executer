{extends "_layout/skel.tpl"}

{block "content"}
	<div class="row">
		<div class="col-lg-12">
			<h4 class="page-header">Executing...</h4>

			<pre class="x-response"></pre>
		</div>
	</div>

	<script>
		$(function() {
			function _req() {
				$('.x-response').text('Wait...');

				$.ajax({
					dataType: 'json',
					success: function(j) {
						if (j.completed) {
							$('.x-response').text(j.response);

						} else {
							setTimeout(_req, 1000);
						}
					}
				});
			}

			_req();
		});
	</script>
{/block}
