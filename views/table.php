<div class="box snap">


	<div class="tbl-ctrls">
		<fieldset class="tbl-search right">
			<a class="btn tn action" href="<?=ee('CP/URL', 'addons/settings/url_metas/add')?>">
				<?=lang('add_url_metas')?>
			</a>&nbsp;
			<a class="btn tn action" href="<?=ee('CP/URL')->make('addons/settings/url_metas/default_metas')?>">
				<?=lang('set_default_url_metas')?>
			</a>

		</fieldset>
		<h1>
			<?=lang('url_metas_list')?>
		</h1>

		<?php
		if (@$_GET['s'] == 1) {
			?>
			<div class="tbl">
				<p class="alert inline success"><b>Success:</b> Meta data saved</p>
			</div>
			<?php
		}

		if (@$_GET['es'] == 1) {
			?>
			<div class="tbl">
				<p class="alert inline"><b>Error:</b> Could not save</p>
			</div>
			<?php
		}

		if (@$_GET['d'] == 1) {
			?>
			<div class="tbl">
				<p class="alert inline success"><b>Success:</b> Meta data deleted</p>
			</div>
			<?php
		}

		if (@$_GET['ed'] == 1) {
			?>
			<div class="tbl">
				<p class="alert inline"><b>Error:</b> Could not be deleted</p>
			</div>
			<?php
		}
		?>

		<?php
		$this->embed('ee:_shared/table', $table);
		?>
	</div>
</div>
