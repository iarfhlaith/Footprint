[~*
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */
*~]
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
	