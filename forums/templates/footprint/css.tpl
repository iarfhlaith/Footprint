/* Additional Footprint Styles */

#forumContent {

	width: 750px;
	margin: 0 auto;
	text-align: left;
	padding: 8px 0 0 0;
}

#forumName {

	padding:3px;
	margin:0 0 6px 0;
	font-size:11px;
}

#forumName a:link, #forumName a:active, #forumName a:visited {

	color:#000000;
}

#forumName h2 {

	font-size:12px;
	font-weight:normal;
}

.forumNav {

	list-style-type:none;
	margin:0;
	padding:0;
}

.forumNav li {

	list-style-type:none;
	background:transparent url(/forums/templates/footprint/images/li.gif) no-repeat 0 3px;
	border:0;
	margin:0;
	padding:0 0 10px 15px;
}

.rssBox {

	text-align:center;
	padding:10px 5px 10px 5px;
	border:1px solid #CCC;
	background-color:#EEE;
}

/* Document Types */

.rssDoc {

	background-repeat:no-repeat;
	background-position: 2px 3px;
	padding:3px 3px 3px 25px;
	background-image:url(/media/images/rss/feed-icon-14x14.png);
}

.rssDocMini {

	background-repeat:no-repeat;
	background-position: 2px 5px;
	padding:3px 3px 3px 17px;
	background-image:url(/media/images/rss/feed-icon-10x10.png);
}

/* Element level classes */

td, th
{
    color: {defaulttextcolor};
    font-size: {defaultfontsize};
    font-family: {defaultfont};
}

img
{
    border-width: 0px;
    vertical-align: middle;
}

input[type=text], input[type=password], input[type=file], select
{
    background-color: {backcolor};
    color: {defaulttextcolor};
    font-size: {defaultfontsize};
    font-family: {defaultfont};

    vertical-align: middle;

}

textarea
{
    background-color: {backcolor};
    color: {defaulttextcolor};
    font-size: {defaultfontsize};
    font-family: {fixedfont};
}

input[type=submit]
{
    border: 1px dotted {tablebordercolor};
    background-color: {navbackcolor};
    font-size: {defaultfontsize};
    font-family: {defaultfont};
    vertical-align: middle;
}

input
{
    vertical-align: middle;
}


/* new styles */

#phorum-index
{
	width:100%;
	border-collapse:collapse;
	border-bottom:2px solid #999;
    text-align: left;
	margin-top:3px;
}

#phorum-index th
{
	border-top:2px solid #003366;
	border-bottom:1px solid #666666;
	padding:5px 3px 5px 3px;
	background-color:#fff0e1;
	background-image: url(/forums/templates/footprint/images/tblHead.gif);
	background-repeat:repeat-x;
	font-weight:bold;
}

#phorum-index td
{
    font-family: {largefont};
    background-color: {backcolor};
    padding: 3px 0 3px 0;
}

#phorum-index th.forum-name
{
    font-family: {largefont};
    font-size: {largefontsize};
    padding: 3px 0 3px 3px;
	width:60%;
}

#phorum-index th.forum-name a
{
    color: {defaulttextcolor};
}

#phorum-index th.forum-threads
{
    width: 120px;
    text-align: center;
    vertical-align: middle;
}

#phorum-index th.forum-posts
{
    width: 120px;
    text-align: center;
    vertical-align: middle;
}

#phorum-index th.forum-last-post
{
    padding: 3px 12px 3px 3px;
    vertical-align: middle;
	width:12%;
}

#phorum-index td.forum-name
{
    font-family: {largefont};
    font-size: {defaultboldfontsize};
    font-weight: bold;
    padding: 5px 0 5px 2px;
}

.forum
{
	border:none;
}

.forumTitle
{
    margin: 10px 0 0 0;
	display:block;
	border-bottom:none;
	font-size:14px;
}

div.forumOptions
{
	border-top:none;
	background-color:#fcf2ef;
	font-weight: normal;
    font-family: {defaultfont};
	font-size:10px;
	padding:3px;
	margin:0;
}

#phorum-index td.forum-name p
{
    font-size: 11px;
    font-weight: normal;
    font-family: {defaultfont};
    margin: 2px 15px 10px 0;
}

#phorum-index td.forum-name small
{
    font-weight: normal;
    font-family: {defaultfont};
}

#phorum-index td.forum-threads
{
    width: 120px;
    text-align: center;
}

#phorum-index td.forum-posts
{
    width: 120px;
    text-align: center;
}

#phorum-index td.forum-last-post
{
    width: 120px;
    padding: 0 15px 0 0;
	font-size:11px;
}

#phorum-menu-table
{
    width: 100%;
    border-width: 0px;
}

#phorum-menu
{
    padding: 5px 3px 0 0;
    vertical-align: top;
    width: 200px;
}

#phorum-content
{
    padding: 5px 0 0 2px;
    vertical-align: top;
}

div.phorum-menu
{
    font-size: {defaultfontsize};
    font-family: {defaultfont};
    background-color: {backcolor};
    border: 1px solid {tablebordercolor};
    padding: 3px;
}

div.phorum-menu ul
{
    font-weight: bold;
    list-style: none;
    padding: 0;
    margin: 0 0 10px 0;
}

div.phorum-menu li
{
    font-weight: bold;
    font-family: {navfont};
    font-size: {navfontsize};
    padding: 0 0 0 15px;
    margin-top:3px;
    background-image: url('templates/default/images/square_bullet.png');
    background-repeat: no-repeat;
    background-position: 1px 2px;
}

div.phorum-menu a
{
    font-weight: normal;
    color: {navtextcolor};
}

div.phorum-menu a:hover
{
    color: {hoverlinkcolor};
}

div.phorum-menu a.phorum-current-page
{
    font-weight: bold;
}

#phorum-post-form ul
{
    padding: 0 0 0 20px;
    margin: 3px 0px 8px 0px;
    font-size: {smallfontsize};
}

#phorum-post-form li
{
    margin-bottom: 3px;
}

#phorum-attachment-list td
{
    font-size: {smallfontsize};
}

    /* Standard classes for use in any page */
    /* PhorumDesignDiv - a div for keeping the forum-size size */
    .PDDiv
    {
        width: {forumwidth};
        text-align: left;
    }
    /* new class for layouting the submit-buttons in IE too */
    .PhorumSubmit {
        border: 1px dotted {tablebordercolor};
        color: {defaulttextcolor};
        background-color: {navbackcolor};
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        vertical-align: middle;
    }

    .PhorumTitleText
    {
        float: right;
    }

    .PhorumStdBlock
    {
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        background-color: {backcolor};
        border: 1px solid {tablebordercolor};
/*        width: {tablewidth}; */
        padding: 3px;
        text-align: left;
    }

    .PhorumStdBlockHeader
    {
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        background-color: {navbackcolor};
/*        width: {tablewidth}; */
        border-left: 1px solid {tablebordercolor};
        border-right: 1px solid {tablebordercolor};
        border-top: 1px solid {tablebordercolor};
        padding: 3px;
        text-align: left;
    }

    .PhorumHeaderText
    {
        font-weight: bold;
    }

    .PhorumNavBlock
    {
        font-size: 11px;
        font-family: {navfont};
        margin-top: 1px;
        margin-bottom: 1px;
        padding: 2px 3px 2px 3px;
		background-color:fcf2ef;
    }

    .PhorumNavHeading
    {
        font-weight: bold;
    }

    A.PhorumNavLink
    {
        color: {navtextcolor};
        text-decoration: none;
        font-weight: {navtextweight};
        font-family: {navfont};
        font-size: {navfontsize};
        border-style: solid;
        border-color: {navbackcolor};
        border-width: 1px;
        padding: 0px 4px 0px 4px;
    }

    .PhorumSelectedFolder
    {
        color: {navtextcolor};
        text-decoration: none;
        font-weight: {navtextweight};
        font-family: {navfont};
        font-size: {navfontsize};
        border-style: solid;
        border-color: {navbackcolor};
        border-width: 1px;
        padding: 0px 4px 0px 4px;
    }

    A.PhorumNavLink:hover
    {
        background-color: {navhoverbackcolor};
        font-weight: {navtextweight};
        font-family: {navfont};
        font-size: {navfontsize};
        border-style: solid;
        border-color: {tablebordercolor};
        border-width: 1px;
        color: {navhoverlinkcolor};
    }

    .PhorumFloatingText
    {
        padding: 10px;
    }

    .PhorumHeadingLeft
    {
        padding-left: 3px;
        font-weight: bold;
    }

    .PhorumUserError
    {
        padding: 10px;
        text-align: center;
        color: {errorfontcolor};
        font-size: {largefontsize};
        font-family: {largefont};
        font-weight: bold;
    }

    .PhorumOkMsg
    {
        padding: 10px;
        text-align: center;
        color: {okmsgfontcolor};
        font-size: {largefontsize};
        font-family: {largefont};
        font-weight: bold;
    }

   .PhorumNewFlag
    {
        font-family: {defaultfont};
        font-size: {tinyfontsize};
        font-weight: bold;
        color: {newflagcolor};
    }

    .PhorumNotificationArea
    {
        float: right;
        border-style: dotted;
        border-color: {tablebordercolor};
        border-width: 1px;
    }

    /* PSUEDO Table classes                                       */
    /* In addition to these, each file that uses them will have a */
    /* column with a style property to set its right margin       */

    .PhorumColumnFloatXSmall
    {
        float: right;
        width: 75px;
    }

    .PhorumColumnFloatSmall
    {
        float: right;
        width: 100px;
    }

    .PhorumColumnFloatMedium
    {
        float: right;
        width: 150px;
    }

    .PhorumColumnFloatLarge
    {
        float: right;
        width: 200px;
    }

    .PhorumColumnFloatXLarge
    {
        float: right;
        width: 400px;
    }

    .PhorumRowBlock
    {
        background-color: {backcolor};
        border-bottom: 1px solid {listlinecolor};
        padding: 5px 0px 0px 0px;
    }

    .PhorumRowBlockAlt
    {
        background-color: {altbackcolor};
        border-bottom: 1px solid {listlinecolor};
        padding: 5px 0px 0px 0px;
    }

    /************/


    /* All that is left of the tables */

    .PhorumStdTable
    {	
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #999;
		text-align: left;
		margin-top:3px;
    }

    .PhorumTableHeader
    {
		border-top:2px solid #003366;
		border-bottom:1px solid #666666;
		padding:5px 3px 5px 3px;
		background-color:#fff0e1;
		background-image: url(/forums/templates/footprint/images/tblHead.gif);
		background-repeat:repeat-x;
		font-weight:bold;
    }

    .PhorumTableRow
    {
        background-color: {backcolor};
        border-bottom-style: solid;
        border-bottom-color: {listlinecolor};
        border-bottom-width: 1px;
        color: {defaulttextcolor};
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        height: 35px;
        padding: 3px;
    }

    .PhorumTableRowAlt
    {
        background-color: {altbackcolor};
        border-bottom-style: solid;
        border-bottom-color: {listlinecolor};
        border-bottom-width: 1px;
        color: {altlisttextcolor};
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        height: 35px;
        padding: 3px;
    }

    table.PhorumFormTable td
    {
        height: 26px;
    }

    /**********************/


    /* Read Page specifics */

    .PhorumReadMessageBlock
    {
        margin-bottom: 5px;
    }

   .PhorumReadBodySubject
    {
        color: {defaulttextcolor};
        font-size: {largefontsize};
        font-family: {largefont};
        font-weight: bold;
        padding-left: 3px;
    }

    .PhorumReadBodyHead
    {
        padding-left: 5px;
    }

    .PhorumReadBodyText
    {
        font-size: {defaultfontsize};
        font-family: {defaultfont};
        padding: 5px;
    }

    .PhorumReadNavBlock
    {
        font-size: {navfontsize};
        font-family: {navfont};
        border-left: 1px solid {tablebordercolor};
        border-right: 1px solid {tablebordercolor};
        border-bottom: 1px solid {tablebordercolor};
/*        width: {tablewidth}; */
        background-color: {navbackcolor};
        padding: 2px 3px 2px 3px;
    }

    /********************/

    /* List page specifics */

    .PhorumListSubText
    {
        color: {listpagelinkcolor};
        font-size: {tinyfontsize};
        font-family: {tinyfont};
    }

    .PhorumListPageLink
    {
        color: {listpagelinkcolor};
        font-size: {tinyfontsize};
        font-family: {tinyfont};
    }

    .PhorumListSubjPrefix
    {
        font-weight: bold;
    }

    /********************/

    /* Posting editor specifics */

    .PhorumListModLink, .PhorumListModLink a
    {
        color: {listmodlinkcolor};
        font-size: {tinyfontsize};
        font-family: {tinyfont};
    }

    .PhorumAttachmentRow {
        border-bottom: 1px solid {altbackcolor};
        padding: 3px 0px 3px 0px;
    }

    /********************/

    /* PM specifics */

    .phorum-recipientblock
    {
        border: 1px solid {tablebordercolor};
        position:relative;
        float:left;
        padding: 1px 1px 1px 5px;
        margin: 0px 5px 5px 0px;
        font-size: {smallfontsize};
        background-color: {backcolor};
        border: 1px solid {tablebordercolor};
        white-space: nowrap;
    }

    .phorum-pmuserselection
    {
        padding-bottom: 5px;
    }

    .phorum-gaugetable {
        border-collapse: collapse;
    }

    .phorum-gauge {
        border: 1px solid {tablebordercolor};
        background-color: {navbackcolor};
    }

    .phorum-gaugeprefix {
        border: none;
        background-color: {backcolor};
        padding-right: 10px;
    }

    /********************/

    /* Override classes - Must stay at the end */

    .PhorumNarrowBlock
    {
        width: {narrowtablewidth};
    }

    .PhorumSmallFont
    {
        font-size: {smallfontsize};
    }

    .PhorumLargeFont
    {
        color: {defaulttextcolor};
        font-size: {largefontsize};
        font-family: {largefont};
        font-weight: bold;
    }


    .PhorumFooterPlug
    {
        margin-top: 10px;
        font-size: {tinyfontsize};
        font-family: {tinyfont};
    }



    /*   BBCode styles  */

    blockquote.bbcode
    {
        font-size: {smallfontsize};
        margin: 0 0 0 10px;
    }

    blockquote.bbcode div
    {
        margin: 0;
        padding: 5px;
        border: 1px solid {tablebordercolor};
    }

    blockquote.bbcode strong
    {
        font-style: italic;
        margin: 0 0 3px 0;
    }
