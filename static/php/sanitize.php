<?php

  function sanitize($string) {
    return addslashes($string);
  }
  
  function unsanitize($string) {
    return stripslashes($string);
  }

  function sanitizeHTML($string) {
    return htmlspecialchars($string);
  }


?>
