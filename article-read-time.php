<?php
/*
Plugin Name: Article Read Time
Plugin URI: https://github.com/Melodiecoding/article-read-time
Description: Une fonctionnalité à votre siteWordPress sur mesure qui calculera automatiquement le temps de lecture d'un article à son enregistrement.
Version: 0.0.1
Author: Melodiecoding
Author URI: https://github.com/Melodiecoding
Text Domain: article-read-time
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
*/

const WORDS_PER_MINUTE = 250;
const READING_TIME_META_KEY = 'reading_time';

function add_reading_time($post_id, WP_Post $post, bool $update) {
    // Do not execute when the add button is used
    if (!$update) { return; }
    // Do not execute when the post is a revision
    if (wp_is_post_revision($post_id)) { return; }
    // Do not execute on autosaves
    if (defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) { return; }
    // Only for articles
    if ($post->post_type != 'post') { return; }

    $word_count = str_word_count(strip_tags($post->post_content));

    $minutes = ceil($word_count/WORDS_PER_MINUTE);

    update_post_meta($post_id, READING_TIME_META_KEY, $minutes);
}

add_action('save_post', 'add_reading_time', accepted_args: 3);