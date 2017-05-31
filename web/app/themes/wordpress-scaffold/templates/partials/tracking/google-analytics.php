<?php

if (WP_ENV === 'development' || is_admin()) {
    echo '<!-- Google Analytics, you are admin or in development mode. -->';
    return;
}

$ga_id = 'UA-XXXXXXX-XX';

?>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', <?= $ga_id ?>, 'auto');
  ga('send', 'pageview');
</script>
