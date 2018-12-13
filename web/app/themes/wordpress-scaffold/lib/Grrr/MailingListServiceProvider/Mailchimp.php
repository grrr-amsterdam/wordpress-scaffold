<?php

namespace Grrr\MailingListServiceProvider;

use \DrewM\MailChimp\MailChimp as MailChimpAPI;

/**
 * [MailChimp service provider]
 */
class MailChimp implements MailingListServiceProvider {

    /**
     * [subscribe adds user to a mailing list]
     *
     * @param  string $email user email address
     * @param  string $type  type of the mailing list: e.g. newsletter
     */
    public function subscribe(string $email, string $list) {

        if (!defined('MAILCHIMP_API_KEY') || !MAILCHIMP_API_KEY) {
            return;
        }

        return (new MailChimpAPI(MAILCHIMP_API_KEY))->post("lists/{$list}/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
        ]);

    }
}
