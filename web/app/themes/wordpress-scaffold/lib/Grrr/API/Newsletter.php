<?php

namespace Grrr\API;

use Garp\Functional as f;
use Grrr\MailingListServiceProvider\Mailchimp;

/**
 * [Newsletter]
 */
class Newsletter {

    const EMAIL_INPUT = 'email';
    const HONEYPOT_INPUT = 'random_input';

    public function init() {
        add_action('rest_api_init', [$this, 'registerEndpoints']);
    }

    public function registerEndpoints(\WP_REST_Server $wp_rest_server) {
        register_rest_route('grrr/v1', 'newsletter/subscribe', [
            'methods'  => 'POST',
            'callback' => [$this, 'subscribe']
        ]);
    }

    /**
     * [subscribe]
     *
     * @param  WP_REST_Request $data
     * @return mixed
     */
    public function subscribe(\WP_REST_Request $data) {
        if ($data->get_param(self::HONEYPOT_INPUT)) {
            $message = $this->_get_failure_message('Invalid input detected.');
            return new \WP_Error('rest_invalid_param', $message, ['status' => 400]);
        }

        $email = sanitize_email($data->get_param(self::EMAIL_INPUT));
        $result = (new Mailchimp)->subscribe($email, MAILCHIMP_LIST_ID);

        if (f\prop('status', $result) === 'subscribed') {
            return new \WP_REST_Response($this->_get_success_message(), 200);
        } else {
            $message = $this->_get_failure_message(f\prop('title', $result));
            return new \WP_Error('mailchimp_signup_failed', $message, ['status' => 400]);
        }
    }

    protected function _get_success_message(): string {
        return get_field('newsletter_success_message', 'option');
    }

    protected function _get_failure_message(string $error_message): string {
        return get_field('newsletter_error_message', 'option') . " Error: {$error_message}";
    }
}
