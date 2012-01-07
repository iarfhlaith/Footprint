
<table id="phorum-index" cellspacing="0">
  {LOOP FORUMS}
    {IF FORUMS->folder_flag}
      <tr>
        {IF FORUMS->forum_id FORUMS->vroot}
          <th>{LANG->Forums}</th>
        {ELSE}
          <th><a href="{FORUMS->url}">{FORUMS->name}</a></th>
        {/IF}
        <th class="forum-last-post">{LANG->LastPost}</th>
      </tr>
    {ELSE}
      <tr class="forum">
        <td class="forum-name">
          <a href="{FORUMS->url}" class='forumTitle'>{FORUMS->name}</a><p>{FORUMS->description}</p>
        </td>
		<!--
        <td class="forum-threads" nowrap="nowrap">
          {FORUMS->thread_count}
          {IF FORUMS->new_threads}
            (<span class="PhorumNewFlag">{FORUMS->new_threads} {LANG->newflag}</span>)
          {/IF}
        </td>
        <td class="forum-posts" nowrap="nowrap">
          {FORUMS->message_count}
          {IF FORUMS->new_messages}
            (<span class="PhorumNewFlag">{FORUMS->new_messages} {LANG->newflag}</span>)
          {/IF}
        </td>
		-->
        <td class="forum-last-post" nowrap="nowrap">{FORUMS->last_post}</td>
      </tr>
	  <tr>
	  <td colspan='2' style='padding:0; border-bottom:#cc3300 1px solid;'>
	  	<div class='forumOptions'>
			{IF FORUMS->url_rss}<a href="{FORUMS->url_rss}" class='rssDocMini'>Topic RSS</a>{/IF}
			
			{FORUMS->message_count} {LANG->Posts} in {FORUMS->thread_count} {LANG->Threads}
        </div>
	  </td>
	  </tr>
    {/IF}
  {/LOOP FORUMS}
</table>
