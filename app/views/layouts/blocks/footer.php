            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0);" class="global-notice <?php echo Session::has('notice-error')? 'global-error' : ''; ?>"><?php echo Session::get('notice', Session::get('notice-error')); ?></a>
<a href="javascript:void(0);" class="global-saving"><span><?php echo trans('tinyissue.saving');?></span></a>

