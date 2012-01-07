
<table id="phorum-menu-table" cellspacing="0" border="0">
  <tr>
    <td id="phorum-menu" nowrap="nowrap">{INCLUDE cc_menu}</td>
    <td id="phorum-content">
      {IF content_template}
        {INCLUDE_VAR content_template}
      {ELSE}
        <div class="PhorumFloatingText">{MESSAGE}</div>
      {/IF}
    </td>
  </tr>
</table>
