
<table id="phorum-menu-table" cellspacing="0" border="0">
  <tr>
    <td id="phorum-menu">
      {INCLUDE pm_menu}
    </td>
    <td id="phorum-content">
      {IF ERROR}
        <div class="PhorumUserError">{ERROR}</div>
      {/IF}
      {IF OKMSG}
        <div class="PhorumOkMsg">{OKMSG}</div>
      {/IF}
      <?php
      // don't touch this line
      include phorum_get_template($template);
      ?>
    </td>
  </tr>
</table>
