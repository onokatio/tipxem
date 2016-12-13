<?php
function calcFeeTransfer($amount){
    if(20000 * 1000000 > $amount){
        return 1 * 1000000;
    }elseif(250000 * 1000000 <= $amount){
        return 25 * 1000000;
    }else{
        return floor($amount / (10000 * 1000000));
    }
}
function calcFeeMessage($message){
    return (floor(strlen($message) / 32) + 1) * 1000000; 
}
function int2binary($int){
  return pack("V*", $int);
}
function long2binary($longlong){
  $highMap = 0xffffffff00000000; 
  $lowMap = 0x00000000ffffffff; 
  $higher = ($longlong & $highMap) >>32; 
  $lower = $longlong & $lowMap; 
  $packed = pack('VV', $lower, $higher);
  return $packed;
}
function timestamp2NEMTime($timestamp){
  return $timestamp - 1427587585;
}
