<?php
/**
 * oauth_me controller file.
 *
 * @author wuqi <yuri1308960477@gmail.com>
 */

namespace Drupal\oauth_me\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * OAuthController Class.
 */
class OAuthController extends ControllerBase {

    /**
     * get content.
     */
    public function oauth_hello() {
        return ['#markup' => ' ' . t('Hello Drupal') . ' '];
    }
}
