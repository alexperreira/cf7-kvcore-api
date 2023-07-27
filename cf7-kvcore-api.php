<?php

/**
 * Plugin Name: CF7 Form Trap
 * Author: Alex Perreira
 * Description: Get CF7 Data and Send to KVCore
 * Version: 0.1.0
 * License: GPL3
 * License URL: https://www.gnu.org/licenses/gpl-3.0.en.html
 * text-domain: cf7-trap-api
 */

defined('ABSPATH') or die('Unauthorized access!');

add_action('wpcf7_before_send_mail', 'send_to_kvcore');

function send_to_kvcore($form_data)
{

    $submission = WPCF7_Submission::get_instance();

    if ($submission) {

        $posted_data = $submission->get_posted_data();

        $url = 'https://api.kvcore.com/v2/public/contact';

        $data = [
            'first_name' => $posted_data['first-name'],
            'last_name' => $posted_data['last-name'],
            'email' => $posted_data['your-email'],
            'phone' => $posted_data['tel-472'],
            'message' => $posted_data['your-message'],
        ];
    }

    $args = [
        'method' => 'POST',
        'body' => json_encode($data),
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEyODgzNjksImlhdCI6MTY5MDQ2OTQ4NywiZXhwIjoxNzIyMDkxODg3LCJuYmYiOjE2OTA0Njk0ODcsImF1ZCI6IkdFVFwvY29udGFjdHN8R0VUXC9jb250YWN0XC97Y29udGFjdElkfXxQT1NUXC9jb250YWN0fFBVVFwvY29udGFjdFwve2NvbnRhY3RJZH1cL3RhZ3N8UFVUXC9jb250YWN0XC97Y29udGFjdElkfXxQVVRcL2NvbnRhY3RcL3tjb250YWN0SWR9XC9hY3Rpb25cL25vdGV8R0VUXC9jb250YWN0XC97Y29udGFjdElkfVwvYWN0aW9uXC9ub3RlfEdFVFwvY29udGFjdFwve2NvbnRhY3RJZH1cL2FjdGlvblwvbm90ZVwve2FjdGlvbklkfXxHRVRcL2NvbnRhY3RcL3tjb250YWN0SWR9XC90YWdzfFBVVFwvY29udGFjdFwve2NvbnRhY3RJZH1cL2FjdGlvblwvY2FsbHxHRVRcL2NvbnRhY3RcL3tjb250YWN0SWR9XC9hY3Rpb25cL2NhbGxcL3thY3Rpb25JZH0iLCJhY3QiOjE4NTQsImp0aSI6IjE2ODgyYjMxZjMzOWI2YzI5NjhjYWZkNTYyMGUwNWJkIn0.s_pniFl63cKYVkzXQnKgBHQ2Zu6XjTUxlqhuuYhtm4I',
        ],
        'timeout' => 60,
        'redirection' => 5,
        'blocking' => true,
    ];

    wp_remote_post($url, $args);

    error_log(print_r($data, true));
}
