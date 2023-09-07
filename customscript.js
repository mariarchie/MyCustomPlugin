function enqueue_custom_scripts() {
    wp_enqueue_script('customscripts', plugin_dir_url(__FILE__) . 'customscript.js', [''], null, true);

    $settings = [];
    $settings['nonce'] = wp_create_nonce('custom_nonce');
    $settings['templates'] = ['green', 'yellow'];
    wp_localize_script('customscripts', 'settings', $settings);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
