<?php
/**
 * Plugin Name: Harrix MarkdownFile
 * Plugin URI: https://github.com/Harrix/Harrix-MarkdownFile
 * Description: Harrix MarkdownFile is a plugin to display Markdown files with syntax highlighting in Wordpress.
 * Version: 1.2
 * Author: Sergienko Anton
 * Author URI: http://harrix.org
 * License: MIT
 */

require_once('Parsedown.php');

add_action( 'wp_enqueue_scripts', 'harrix_add_scripts_styles' );
add_action('wp_head','harrix_load_highlight_js');
add_shortcode('markdown-file','harrix_markdown_make');

function harrix_add_scripts_styles()
{
    wp_register_script( 'highlight.js', plugin_dir_url( __FILE__ ) . 'highlight.min.js' );
    wp_enqueue_style( 'github.css', plugin_dir_url( __FILE__ ) . 'styles/github.css' );
    wp_enqueue_script( 'highlight.js' );
}

function harrix_load_highlight_js() 
{
    echo "\n<script>hljs.initHighlightingOnLoad();</script>\n";
}

function harrix_markdown_make( $atts, $content ) 
{
    $yourfile = esc_url( $content );
    $contents = file_get_contents( $yourfile );

    if ($contents === false) {
              $contents = "Do not downloaded $yourfile";
          }
          else {
              $contents = html_entity_decode($contents);
              $contents = trim($contents);
    
              $Parsedown = new Parsedown();
              
              $contents = $Parsedown->text($contents);
          }

    return $contents;
}