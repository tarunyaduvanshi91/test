<?php

namespace Drupal\custom_module\Plugin\rest\resource;
use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Annotation for get method
 *
 * @RestResource(
 *   id = "custom_module_api",
 *   label = @Translation("Page Access"),
 *   uri_paths = {
 *     "canonical" = "/page_json/{key}/{node}"
 *   }
 * )
 */
class ApiResource extends ResourceBase {
  /**
   * Responds to GET requests.
   *
   * Returns a list of bundles for specified entity.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get($urlapikey,$node_id) {
    $response = new ResourceResponse();
    if(isset($urlapikey) && is_numeric($node_id)){
      $node = Node::load($node_id);
      if ($node->bundle() && $node->bundle() == 'page'){
        $siteApiKey = \Drupal::config('siteapikey.configuration')->get('siteapikey');
        if (isset($siteApiKey) && $urlapikey == $siteApiKey ){
          return new ResourceResponse('access the page',200);
        }
      }
    }
    return $response->setStatusCode(403,'access denied');
  }
}