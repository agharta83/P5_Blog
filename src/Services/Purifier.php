<?php

namespace MyBlog\Services;

use \HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Classe permettant de purifier les données utilisateurs
 */
class Purifier
{
  /**
   * @var HTMLPurifier
   */
  private $htmlPurifier;

  public function __construct()
  {
    $config = $this->getConfig();

    $this->htmlPurifier = new HTMLPurifier($config);
  }

  /**
   * @param $dirtyData
   * @return string
   */
  public function sanitizeHTML($dirtyData)
  {
    return $this->htmlPurifier->purify($dirtyData);
  }

  /**
   * @return HTMLPurifier_Config
   */
  private function getConfig()
  {
    $purifierConfig = HTMLPurifier_Config::createDefault();
    $purifierConfig->set('Core.Encoding', 'UTF-8');

    $allowedElements = [
      'p[style]',
      'br',
      'b',
      'strong',
      'i',
      'em',
      's',
      'u',
      'ul',
      'ol',
      'li',
      'span[class|style]',
      'a[href|title]',
      'blockquote[cite]',
      'pre',
      'code[class|style]',
      'hr',
      'img[src|alt|class]',
      'h1',
      'h2',
      'h3',
      'h4',
      'h5',
      'h6'
    ];

    $purifierConfig->set('HTML.Allowed', implode(',', $allowedElements));

    return $purifierConfig;

  }

}

