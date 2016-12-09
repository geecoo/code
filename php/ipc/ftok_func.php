<?php

function ftoks($pathname, $proj_id) {
   $st = @stat($pathname);
   if (!$st) {
       return -1;
   }
  
   $key = sprintf("%u", (($st['ino'] & 0xffff) | (($st['dev'] & 0xff) << 16) | (($proj_id & 0xff) << 24)));
   return $key;
}

echo ftoks(__FILE__, 'm');
echo "\n";
echo ftok(__FILE__, 'm');
