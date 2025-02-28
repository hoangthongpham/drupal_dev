<?php

namespace Drupal\miniorange_2fa\Helper;

class MoUtility
{
  public static function isCurlInstalled() {
    return in_array('curl', get_loaded_extensions());
  }
}
