<?php
namespace App\Helpers;

class Base64Helper {
  public static function encode($input)
  {
    $encodedText = $input;
    for ($i=0; $i < 4; $i++) { 
      $encodedText= base64_encode($encodedText);
    }
    return $encodedText;
  }

  public static function decode($input)
  {
    $decodedText = $input;
    for ($i = 0; $i < 4; $i++) {
      $decodedText = base64_decode($decodedText);
    }
    return $decodedText;
  }
}