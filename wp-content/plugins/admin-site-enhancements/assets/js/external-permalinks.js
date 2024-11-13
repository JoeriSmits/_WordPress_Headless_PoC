document.addEventListener('DOMContentLoaded', function() {

   // console.log( phpVars );

   // When External Permalinks is enabled, remove #new_tab from external permalinks and set target to _blank
   if (phpVars.externalPermalinksEnabled) {

      var links = document.getElementsByTagName('a');

      for (var i = 0; i < links.length; i++) {
         var url = links[i].getAttribute('href');
         var target = links[i].getAttribute('target');

         if (url != null) {
            if (url.indexOf('#new_tab') >= 0) {
               url = url.replace('#new_tab', '');
               target = '_blank';
               links[i].setAttribute('href', url);
               links[i].setAttribute('target', target);
               links[i].setAttribute('rel', 'noopener noreferrer nofollow');
            }
         }
      }
   }

});