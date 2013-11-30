<?php

if (!function_exists('get_captcha')) {

    function get_captcha_img() {
        $CI = & get_instance();

        $vals = array(
            'img_path' => 'captcha/',
            'img_url' => base_url('captcha') . '/',
            'font_path' => 'fonts/arial.ttf',
            'word' => get_random_word(5, '2345689ABCDEFGHKLMNPQRSTWXYZ'),
            'img_width' => '150',
            'img_height' => '50',
            'expiration' => '7200'
        );


        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $CI->input->ip_address(),
            'word' => $cap['word']
        );

        $query = $CI->db->insert_string('captcha', $data);
        $CI->db->query($query);

        return $cap['image'];
    }

}

if (!function_exists('validate_captcha')) {

    function validate_captcha($captchaText, $expirationDuration) {
        $CI = & get_instance();

        $expiration = time() - 7200;
        $CI->db->where('captcha_time <', $expiration);
        $CI->db->delete('captcha');

        $CI->db->where(array('word' => $captchaText, 'ip_address' => $CI->input->ip_address(), 'captcha_time >' => $expiration));
        $count = $CI->db->count_all_results('captcha');

        return $count > 0;
    }

}

if (!function_exists('get_random_word')) {

    function get_random_word($length, $pool) {
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }

        return $str;
    }

}
?>