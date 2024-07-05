<?php

if(!function_exists('formatUang')):
function formatUang($value, $currency = 'Rp. ') {
    return $currency . number_format($value, 0,".",".");
} 
endif;