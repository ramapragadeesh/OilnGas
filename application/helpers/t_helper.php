<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed'); 
require_once('googleTranslate.class.php');
 if ( ! function_exists('t'))
 {
 function t($text, $src,$lang, $cache = false, $format = 'html')
 {
 $_ci =& get_instance();
 $apiKey = $_ci->config->config['googleTranslateAPIKey'];
 
$ip = $_ci->config->config['googleTranslateIPAddress'];
$defaultLang = $_ci->config->config['defaultLang'];
$gt = new GoogleTranslateWrapper();

$gt->_cache_directory = realpath(APPPATH . "cache") .'/';
$gt->setCredentials($apiKey, $ip, $format);
$gt->setReferrer($_SERVER['SERVER_NAME']);

if(!$cache)
$gt->cacheEnabled(false);

$trans = $gt->translate($text, $lang, $src);

if(!$gt->isSuccess())
return $text;
else
return $trans;

}
}
?>