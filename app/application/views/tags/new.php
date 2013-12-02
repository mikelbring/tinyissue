<h3>
	<?php echo __('tinyissue.create_tag'); ?>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 100%;">
			<tr>
				<th style="width: 10%"><?php echo __('tinyissue.tag'); ?></th>
				<td>
					<input type="text" name="tag" style="width: 98%;" value="<?php echo Input::old('tag', ''); ?>" />

					<?php echo $errors->first('tag', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th style="width: 10%"><?php echo __('tinyissue.bgcolor'); ?></th>
				<td>
					<input type="text" id="bgcolor" name="bgcolor" style="width: 98%;" value="<?php echo Input::old('bgcolor', 'teal'); ?>" />

					<?php echo $errors->first('bgcolor', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="<?php echo __('tinyissue.create_tag'); ?>" class="button primary" /></td>
			</tr>
		</table>

		<?php echo Form::token(); ?>
		
		<script type="text/javascript">
		
			$(function() {		
				$("#bgcolor").spectrum({
					color: "teal",
					showInput: true,
					className: "full-spectrum",
					showInitial: true,
					showSelectionPalette: true,
					maxPaletteSize: 10,
					preferredFormat: "hex",
					change: function(color) {
						$('#bgcolor').val(color.toHexString());
					}
				});
			});
			
		</script>

	</form>

</div>