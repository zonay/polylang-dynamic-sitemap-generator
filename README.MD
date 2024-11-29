
# Polylang Dynamic Sitemap Generator

**Tags**: sitemap, SEO, XML, multilingual, post types, Polylang  
**Requires at least**: WordPress 5.0  
**Tested up to**: WordPress 6.2  
**Stable tag**: 1.0.0  
**License**: GPLv2 or later  
**License URI**: [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)  

Generate separate dynamic sitemaps for all active languages and post types for Wordpress sites with Polylang.

## Description

Polylang Dynamic Sitemap Generator is a powerful WordPress plugin that automatically generates SEO-friendly sitemaps for all active languages and post types in your multilingual website powered by Polylang. With this plugin, you can ensure that your website's sitemap stays up to date with the latest content and accurately reflects the structure of your multilingual website.

The plugin seamlessly integrates with Polylang to determine the active languages on your website. It retrieves all published posts and pages for each language and generates separate sitemap files tailored to each language. Additionally, it creates a main `sitemap.xml` file that serves as the index for the language-based sitemaps.

The generated sitemaps follow the XML Sitemap protocol, including the essential elements such as the URL, last modification date, and change frequency for each post. These sitemaps can be easily submitted to search engines, aiding in the efficient indexing of your website and improving its search engine optimization (SEO) performance.

## Features

- Generates dynamic sitemaps for all active languages and post types in Polylang.
- Supports multilingual websites using the Polylang plugin.
- Includes the URL, last modification date, and change frequency for each post.
- Automatically updates the sitemaps when a post or page is published or updated.
- Generates a main `sitemap.xml` file that indexes the language-based sitemaps.

## Installation

1. Upload the `polylang-dynamic-sitemap-generator` folder to the `/wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's it! The sitemaps will be automatically generated whenever a post or page is published or updated.

## Frequently Asked Questions

**Q: How do I submit the sitemap to search engines?**

Once the sitemap files are generated, you can submit the main `sitemap.xml` file to search engines through their respective webmaster tools. Each search engine has its own process for submitting sitemaps. For detailed instructions, refer to the documentation or support resources provided by the search engines.

**Q: Can I customize the sitemap output?**

The plugin generates the sitemap output based on the XML Sitemap protocol, ensuring compatibility with search engines. If you require customizations or additional functionality, you have the flexibility to modify the plugin code or explore dedicated XML sitemap plugins that offer more advanced customization options.

## Sample Output File Names

- English sitemap: `sitemap_en.xml`
- French sitemap: `sitemap_fr.xml`
- German sitemap: `sitemap_de.xml`
- Main sitemap: `sitemap.xml`

## License

This plugin is licensed under the GNU General Public License v2 or later.

## Support

For support or inquiries, please use the WordPress.org support forums.
