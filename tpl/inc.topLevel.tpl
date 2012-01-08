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
<div id='navStrip'>
	
		<div id='navContent'>
		
		<ul class="topLevel">
			<li[~if $belowHome~] 	  class='active'[~/if~]><a href="/">Home</a></li>
			<li[~if $belowFeatures~]  class='active'[~/if~]><a href="/features">Features</a></li>
			<li[~if $belowTour~] 	  class='active'[~/if~]><a href="/tour">Tour</a></li>
			<li[~if $belowCases~]     class='active'[~/if~]><a href="/cases">Case Studies</a></li>
			<li[~if $belowBlog~] 	  class='active'[~/if~]><a href="/blog">Blog</a></li>
			<li[~if $belowHelp~]      class='active'[~/if~]><a href="/help">Help/FAQs</a></li>
			<li[~if $belowPricing~]   class='active'[~/if~]><a href="/pricing">Pricing &amp; Sign Up</a></li>
			<li[~if $belowForums~]    class='active'[~/if~]><a href="/forums">Forums</a></li>
			<li[~if $belowAbout~]     class='active'[~/if~]><a href="/about">About</a></li>
		</ul>
		
		</div>
	
</div>