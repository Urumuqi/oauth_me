<?php
/**
 * oauth_me resource.
 *
 * @author wuqi <yuri1308960477@gmail.com>
 */

namespace Drupal\oauth_me\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Database\DatabaseNotFoundException;
use Drupal\user\Entity\User;

/**
 * Provides a resource to get current user base info.
 *
 * @RestResource(
 *   id = "oauth_me",
 *   label = @Translation("OAuth Me"),
 *   uri_paths = {
 *     "canonical" = "/oauth/me"
 *   }
 * )
 */
class OAuthResource extends ResourceBase {

  /**
   * Responds to GET requests.
   *
   * Returns current user base info.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The response containing user's info fields: username, uuid, id, email.
   */
  public function get() {

    // init drupal database connection.
    // $conn = \Drupal::database();

    // /**
    //  * @param \Drupal\Core\Session\AccountInterface
    //  */
    // $current_user = \Drupal::currentUser();

    // $query = $conn->query("SELECT uuid FROM {users} WHERE uid = :id", [':id' => $current_user->id()]);
    // $uuid = $query->fetchField();
    // if (empty($uuid)) {
    //   throw new DatabaseNotFoundException('user info is broken');
    // }

    // $rs = [
    //   'username' => $current_user->getUsername(),
    //   'uuid' => $uuid,
    //   'id' => $current_user->id(),
    //   'email' => $current_user->getEmail(),
    // ];
    $rs = $this->getUserInfo(\Drupal::currentUser()->id());

    return new ResourceResponse($rs);
  }

  /**
   * Get User Info By UserId.
   *
   * @param integer $userId
   *
   * @return array
   *
   * @throws DatabaseNotFoundException
   */
  protected function getUserInfo($userId) {
    if (empty($userId)) {
      throw new DatabaseNotFoundException('param user_id empty');
    }

    $user = User::load($userId);
    if (empty($user)) {
      throw new DatabaseNotFoundException('user not found');
    }

    return [
      'username' => $user->getUsername(),
      'uuid' => $user->uuid(),
      'id' => $user->id(),
      'email' => $user->getEmail(),
    ];
  }
}
