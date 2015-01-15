<?php
namespace Phak;
/**
 * Config wrapper
 */
class Config {

  /**
   * Settings array
   * @var Array
   */
  private static $_settings = [];

  /**
   * Set config value to for key
   * @param String $key   Config key
   * @param Mixed $value Value
   */
  public static function set($key, $value)
  {
    self::$_settings[$key] = $value;
  }

  /**
   * Get configuration value
   * @param  String $key   Name of setting to return
   */
  public static function get($key)
  {
    return isset(self::$_settings[$key]) ? self::$_settings[$key] : null;
  }

}