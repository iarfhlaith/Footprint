<div align="center">
  
  <div class="PhorumStdBlock PhorumNarrowBlock">
    {IF ERROR}
      <div class="PhorumUserError">{ERROR}</div>
    {/IF}
    {IF MESSAGE}
      <div class="PhorumFloatingText">{MESSAGE}</div>
    {/IF}
    {IF URL->CLICKHERE}
      <div class="PhorumFloatingText"><a href="{URL->CLICKHERE}">{CLICKHEREMSG}</a></div>
    {/IF}
    {IF URL->REDIRECT}
      <div class="PhorumFloatingText"><a href="{URL->REDIRECT}">{BACKMSG}</a></div>
    {/IF}
  </div>
</div>
