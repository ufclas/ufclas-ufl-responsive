<?php if (!isset($_COOKIE["UFLmobileMobile"]) || !isset($_COOKIE["UFLMobileFull"])): ?>
<div id="mobile-modal">
    <p style="margin-top:20px;">It looks like you are using a mobile device. Do you want to use the NEW mobile optimized design?</p>
    <form id="enable-responsive">
      <input type="checkbox" id="responsive-bool" checked>Use mobile theme?
      <input style="margin-left:20px;" type="button" id="submit" value="Submit" onclick="SendCookies()">
    </form>
    <div id="mobile-modal-close">X</div>
</div>
<?php endif ?>
