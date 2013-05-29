<script type="text/javascript">
	ls.registry.set('plugin.skac.comments_limit',{Config::Get('plugin.skac.comments_limit')});
	ls.registry.set('plugin.skac.use_ajax_cut',{$bAjaxCut});
	ls.registry.set('plugin.skac.use_ajax_comments',{$bAjaxComments});
	ls.registry.set('plugin.skac.lang_readmore','{$aLang.topic_read_more}');
	ls.registry.set('plugin.skac.comments_link','{Config::Get('plugin.skac.comments_link')}');
	ls.registry.set('plugin.skac.cut_link','{Config::Get('plugin.skac.cut_link')}');
	ls.registry.set('plugin.skac.count_comments','{Config::Get('plugin.skac.count_comments')}');
</script>
{if $oConfig->GetValue('view.tinymce')}
<script src="{cfg name='path.root.engine_lib'}/external/tinymce-jq/tiny_mce.js"></script>
{/if}