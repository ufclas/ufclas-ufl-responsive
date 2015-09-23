<script>
currentLocation = '<?php echo "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>';
function ajaxGetMobile(){
$.ajax({
      type: 'GET',
      url: '<?php echo get_template_directory_uri() . '/library/php/SetCookieMobile.php'; ?>',
      timeout: 2000,
      success: function(data) {
      // location.reload();
      window.location.href = currentLocation.split('?')[0];
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert("error retrieving content");
      }
    })      
}
function ajaxGetFull(){
 $.ajax({
        type: 'GET',
        url:'<?php echo get_template_directory_uri() . '/library/php/SetCookieFull.php'; ?>',
        timeout: 2000,
        success: function(data) {
	window.location.href = "?mobile=no";
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert("error retrieving content");
        }
      })
}
function SendCookies(){
    if ($('#responsive-bool').is(':checked')){
        ajaxGetMobile();      
    }else{
        ajaxGetFull();
    }
}
  </script>
<script>
function hideModal(){$('#mobile-modal').hide();}
function responsiveEmbed(){$('iframe').wrap("<div class='responsive-embed'></div>")}
$('#mobile-modal-close').click(function(){hideModal();});
<?php
$fullLink = ("<li><p id='full-link' alt='change from mobile theme'>View Full Site</p></li>"); 
$mobileLink = ("<li class='mobile-icon' id='mobile-link'><Switch to mobile</li>");
if (isset($_COOKIE["UFLmobileMobile"]) ||  isset($_COOKIE["UFLmobileFull"])){
  echo "hideModal(); \n";
}
if ($detect_mobile && !isset($_COOKIE["UFLmobileFull"])){
  echo "$('#sidebar-nav').appendTo('#main-content'); \n";
  echo "responsiveEmbed(); \n";
  echo '$("#primary-nav .container").append("' . $fullLink . '");' . "\n";
} 

if (isset($_COOKIE["UFLmobileFull"]) && of_get_option("opt_responsive")){
  echo '$("#primary-nav .container").append("' . $mobileLink . '");' . "\n";
}
//hide popup if on desktop
if (!$detect_mobile) { 
    echo "hideModal() \n";
}

?>
$("#full-link").click(function(){ajaxGetFull();});
$("#mobile-link").click(function(){ajaxGetMobile();});

</script>

