<?php

// Setting up a contact form for the site that uses emails to make it all work.

function sd_encrypt_email($email) {
    $key = wp_salt('auth'); // uses your site's AUTH_KEY salt
    $iv  = substr(hash('sha256', wp_salt('secure_auth')), 0, 16);
    return base64_encode(openssl_encrypt($email, 'AES-256-CBC', $key, 0, $iv));
}

function sd_decrypt_email($encrypted) {
    $key = wp_salt('auth');
    $iv  = substr(hash('sha256', wp_salt('secure_auth')), 0, 16);
    return openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, 0, $iv);
}

function sd_contact_form_js(){
  wp_enqueue_script('contact-form', get_stylesheet_directory_uri(__FILE__) . '/assets/js/contact-form.js', array(), fileatime(get_stylesheet_directory(__FILE__) . '/assets/js/contact-form.js'));
}

add_action('wp_enqueue_scripts', 'sd_contact_form_js');