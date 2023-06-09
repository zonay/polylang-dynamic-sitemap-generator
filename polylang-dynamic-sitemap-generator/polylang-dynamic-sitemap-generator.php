<?php
/**
 * Plugin Name: Polylang Dynamic Sitemap Generator
 * Description: Generates dynamic sitemaps for all active languages and post types.
 * Version: 1.0.0
 * Author: Zafer Onay
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

// Register the plugin activation hook.
register_activation_hook(__FILE__, 'dynamic_sitemap_generator_activate');

/**
 * Plugin activation hook.
 * Flushes rewrite rules to ensure sitemap URLs work.
 */
function dynamic_sitemap_generator_activate()
{
  flush_rewrite_rules();
}

// Register the plugin deactivation hook.
register_deactivation_hook(__FILE__, 'dynamic_sitemap_generator_deactivate');

/**
 * Plugin deactivation hook.
 * Flushes rewrite rules to remove sitemap URLs.
 */
function dynamic_sitemap_generator_deactivate()
{
  flush_rewrite_rules();
}

// Register the sitemap generation hooks.
add_action('publish_post', 'dynamic_sitemap_generator_create_sitemap');
add_action('publish_page', 'dynamic_sitemap_generator_create_sitemap');
add_action('save_post', 'dynamic_sitemap_generator_create_sitemap');

/**
 * Creates the sitemap files for all active languages and post types.
 */
function dynamic_sitemap_generator_create_sitemap()
{
  $active_languages = pll_languages_list(array('fields' => 'slug')); // Get the slugs of active languages

  // Create an array to store the language-based sitemap file names
  $language_sitemaps = array();

  // Get all registered post types
  $post_types = get_post_types(array('public' => true), 'names');

  foreach ($active_languages as $language) {
    $postsForSitemap = get_posts(
      array(
        'numberposts' => -1,
        'orderby' => 'modified',
        'post_type' => $post_types, // Include all registered post types
        'order' => 'DESC',
        'lang' => $language, // Set the language for the query
      )
    );

    $sitemap = new DOMDocument('1.0', 'UTF-8');
    $sitemap->formatOutput = true;

    $urlset = $sitemap->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
    $urlset->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $urlset->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

    foreach ($postsForSitemap as $post) {
      setup_postdata($post);

      $postdate = explode(" ", $post->post_modified);

      $url = $sitemap->createElement('url');

      $loc = $sitemap->createElement('loc', get_permalink($post->ID));
      $url->appendChild($loc);

      $lastmod = $sitemap->createElement('lastmod', $postdate[0]);
      $url->appendChild($lastmod);

      $changefreq = $sitemap->createElement('changefreq', 'daily');
      $url->appendChild($changefreq);

      $urlset->appendChild($url);
    }

    $sitemap->appendChild($urlset);

    $language_slug = $language; // Use the language slug as the file name
    $filename = 'sitemap_' . $language_slug . '.xml';
    $filepath = trailingslashit(get_home_path()) . $filename;

    $sitemap->save($filepath);

    // Add the language-based sitemap file name to the array
    $language_sitemaps[] = $filename;
  }

  // Create the main sitemap.xml file
  $main_sitemap = new DOMDocument('1.0', 'UTF-8');
  $main_sitemap->formatOutput = true;

  $sitemapindex = $main_sitemap->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'sitemapindex');
  $sitemapindex->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
  $sitemapindex->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemapindex.xsd');

  foreach ($language_sitemaps as $language_sitemap) {
    $sitemap = $main_sitemap->createElement('sitemap');

    $loc = $main_sitemap->createElement('loc', site_url($language_sitemap));
    $sitemap->appendChild($loc);

    $sitemapindex->appendChild($sitemap);
  }

  $main_sitemap->appendChild($sitemapindex);

  $main_sitemap_filename = 'sitemap.xml';
  $main_sitemap_filepath = trailingslashit(get_home_path()) . $main_sitemap_filename;

  $main_sitemap->save($main_sitemap_filepath);
}