<?php
/**
 * When kiosk mode is active (via visiting kiosk.php), ensure all links open in the same window
 */
if(!empty($_COOKIE["kiosk"])){
?>
<script id="script-kiosk-mode">
  // Define a function for wrapping the regular window.open function
  function mbaenrmWrap(object, method, wrapper){
    var fn = object[method];
    return object[method] = function(){
      return wrapper.apply(this, [fn.bind(this)].concat(
        Array.prototype.slice.call(arguments)));
    };
  };

  // If it hasn't already been wrapped, wrap window.open with special version for kiosk mode.
  if(!window._original_open){
    window._original_open = window.open;
    mbaenrmWrap(window,"open",function(originalFn){
        var originalParams = Array.prototype.slice.call(arguments,1);
        // If a 2nd name parameter is specified (target), force the target to be "_self"
        if (originalParams.length > 1){
          originalParams[1] = '_self';
        }
        // Now go ahead and call the original window.open routine with the edited params
        originalFn.apply(undefined, originalParams);
    });
  }

  function mbaenrmUpdateLinksForKiosk(){
    document.querySelectorAll('a:not([target=_self])').forEach((item) => {
      item.target = '_self';
    });
  }

  const observer = new MutationObserver(mbaenrmUpdateLinksForKiosk);

  window.addEventListener('DOMContentLoaded', function() {
    mbaenrmUpdateLinksForKiosk();
    observer.observe(document.querySelector('body'), { childList: true, subtree: true });
  });
</script>
<?php
}
?>
