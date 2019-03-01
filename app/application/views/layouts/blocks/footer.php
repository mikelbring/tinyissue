			</div>
		</div> <!-- end content -->
	</div>
</div>

	<a href="javascript: this.click();" class="global-notice <?php echo Session::has('notice-error')? 'global-error' : ''; ?>"><?php echo Session::get('notice', Session::get('notice-error')); ?></a>
	<a href="javascript: void(0);" class="global-saving"><span><?php echo __('tinyissue.saving');?></span></a>

<footer>
	<small class="bugs-version-number"><a href="administration">&nbsp;</a></small>
</footer>
</body>
</html>