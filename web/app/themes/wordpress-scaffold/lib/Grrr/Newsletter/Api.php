<?php namespace Grrr\Newsletter;

use Garp\Functional as f;
use Grrr\Rest\Routes;
use \DrewM\MailChimp\MailChimp;

/**
 * Mailchimp newsletter endpoint.
 */
class Api {

    const EMAIL_INPUT = 'email';
    const HONEYPOT_INPUT = 'random_input';

    public function register() {
        add_action('rest_api_init', [$this, 'register_endpoints']);
    }

    public function register_endpoints(\WP_REST_Server $wp_rest_server) {
        register_rest_route(Routes::NAMESPACE, Routes::get('newsletter'), [
            'methods'  => 'POST',
            'callback' => [$this, 'subscribe'],
            'args' => [
                'email' => [
                    'required' => true,
                    'validate_callback' => function($param, $request, $key) {
                        return is_string($param);
                    },
                ],
            ],
        ]);
    }

    /**
     * Subscribe
     *
     * @param  WP_REST_Request $data
     * @return mixed
     */
    public function subscribe(\WP_REST_Request $data) {
        if (!MAILCHIMP_API_KEY || !MAILCHIMP_LIST_ID) {
            $message = $this->_get_failure_message('Mailchimp is not configured.');
            return new \WP_Error('rest_config_error', $message, ['status' => 400]);
        }

        if ($data->get_param(self::HONEYPOT_INPUT)) {
            $message = $this->_get_failure_message('Invalid input detected.');
            return new \WP_Error('rest_invalid_param', $message, ['status' => 400]);
        }

        $email = sanitize_email($data->get_param(self::EMAIL_INPUT));
        $result = (new MailChimp(MAILCHIMP_API_KEY))->post('lists/' . MAILCHIMP_LIST_ID . '/members', [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);

        if (f\prop('status', $result) === 'subscribed') {
            return new \WP_REST_Response($this->_get_success_message(), 200);
        } else {
            $message = $this->_get_failure_message(f\prop('title', $result) ?: '');
            return new \WP_Error('mailchimp_signup_failed', $message, ['status' => 400]);
        }
    }

    protected function _get_success_message(): string {
        return 'Succesfully subscribed';
    }

    protected function _get_failure_message(string $error_message): string {
        return 'Subscription failed.' . " Error: {$error_message}";
    }
}
