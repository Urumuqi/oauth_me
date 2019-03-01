<?php
/**
 * block file.
 *
 * @author wuqi <yuri1308960477@gmail.com>
 */

namespace Drupal\oauth_me\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'OAuthMeBlock'
 *
 * @Block(
 *   id = "oauth_me_block",
 *   admin_label = @Translation("OAuthMe Block"),
 *   category = @Translation("Hello Drupal"),
 * )
 */
class OAuthMeBlock extends BlockBase implements BlockPluginInterface
{

    /**
     * submit form.
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['oauth_block_name'] = $values['oauth_block_name'];
    }

    /**
     * form.
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        $form['oauth_block_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Who'),
            '#description' => $this->t('Who do you want to say hello to?'),
            '#default_value' => isset($config['oauth_block_name']) ? $config['oauth_block_name'] : '',
        ];

        return $form;
    }

    /**
     * build something.
     * {@inheritdoc}
     */
    public function build() {
        $config = $this->getConfiguration();

        if (!empty($config['oauth_block_name'])) {
            $name = $config['oauth_block_name'];
        }
        else {
            // $name = $this->t('to no one');
            $default_config = $this->defaultConfiguration();
            $name = $default_config['oauth_block_name'];
        }

        return [
            '#markup' => $this->t('Hello @name!', ['@name' => $name])
        ];
    }

    /**
     * get default config.
     */
    public function defaultConfiguration() {
        $default_config = \Drupal::config('oauth_me.settings');
        return ['oauth_block_name' => $default_config->get('oauth.name')];
    }
}