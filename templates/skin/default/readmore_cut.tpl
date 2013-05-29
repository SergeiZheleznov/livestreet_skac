<br />
<a href="{$oTopic->getUrl()}#cut" title="{$aLang.topic_read_more}" class="link-dotted" onclick="ls.skac.getFullText({$oTopic->getId()},$(this)); return false;">
	{if $oTopic->getCutText()}
		{$oTopic->getCutText()}
	{else}
		{$aLang.topic_read_more}
	{/if}
</a>