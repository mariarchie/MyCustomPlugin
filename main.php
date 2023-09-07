<?php
/*
Plugin Name: My Custom Plugin
Description: Custom plugin for handling AJAX requests.
Version: 1.0
Author: Marianna Adekova
*/

class CustomAJAXHandler {
    public function test_jobcart() {
        // Проверяем nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'custom_nonce')) {
            echo json_encode(['status' => false]);
            wp_die();
        }

        // Очищаем входящие данные
        $templates = isset($_POST['templates']) ? sanitize_text_field($_POST['templates']) : '';
        $date = current_time('mysql');

        if (empty($templates)) {
            echo json_encode(['status' => 'empty']);
            wp_die();
        }

        // Текущий ID пользователя
        $user_id = get_current_user_id();

        // Обновляем meta поле 'templates'
        update_user_meta($user_id, 'templates', $templates);

        // Проверяем существование meta поля 'template-date'
        if (!get_user_meta($user_id, 'template-date', true)) {
            update_user_meta($user_id, 'template-date', $date);
            echo json_encode(['status' => 'inserted']);
        } else {
            update_user_meta($user_id, 'template-date-update', $date);
            echo json_encode(['status' => 'update']);
        }
        wp_die();
    }
}

add_action('wp_ajax_test_jobcart', [new CustomAJAXHandler(), 'test_jobcart']);
add_action('wp_ajax_nopriv_test_jobcart', [new CustomAJAXHandler(), 'test_jobcart']);


