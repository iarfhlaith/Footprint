
	<ul>
		[~if $paginate.page_current > 1~]
			<li class="prevpage">[~paginate_prev text="&laquo; previous" id=$pName~]</li>
		[~else~]
			<li class="disablepage">&laquo; previous</li>
		[~/if~]
		
		[~foreach from=$paginate.page item=p~]
			[~if $p.number == $paginate.page_current-3~]...[~/if~]
			[~if ($p.number > $paginate.page_current-3) && ($p.number < $paginate.page_current+3)~]
				[~if $p.is_current == 1~]
					<li class='currentpage'>[~$p.number~]</li>
				[~else~]
					<li><a href='[~$paginate.url~]?[~$paginate.urlvar~]=[~$p.item_start~]'>[~$p.number~]</a></li>
				[~/if~]
			[~/if~]
			[~if $p.number == $paginate.page_current+3~]...[~/if~]
		[~/foreach~]
	
		[~if $paginate.page_current < $paginate.page_total~]
			<li class="nextpage">[~paginate_next text="next &raquo;" id=$pName~]</li>
		[~else~]
			<li class="disablepage">next &raquo;</li>
		[~/if~]
	</ul>
	<span class='pageInfo'>Now Displaying [~$paginate.first~]-[~$paginate.last~] of [~$paginate.total~]</span>
	