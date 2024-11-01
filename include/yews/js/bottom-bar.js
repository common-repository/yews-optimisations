jQuery(document).scroll(function() {
  var y = jQuery(this).scrollTop();
  if (y > 100) {
    jQuery('.yews-bottom-bar').fadeIn();
  } else {
    jQuery('.yews-bottom-bar').fadeOut();
  }
});