<?php
/**
 * This file contains the Yoast class for handling the import of Yoast SEO settings.
 *
 * @package SmartCrawl
 */

namespace SmartCrawl\Third_Party_Import;

/**
 * Class Yoast
 *
 * Handles the import of Yoast SEO settings.
 */
class Yoast extends Importer {

	/**
	 * Flag indicating if the import is in progress.
	 */
	const IMPORT_IN_PROGRESS_FLAG = 'wds-yoast-import-in-progress';

	/**
	 * Count of network sites processed during import.
	 */
	const NETWORK_IMPORT_SITES_PROCESSED_COUNT = 'wds-yoast-network-sites-processed';

	/**
	 * Custom handlers for specific Yoast options.
	 *
	 * @var array
	 */
	private $custom_handlers = array(
		'wpseo-premium-redirects-base'             => 'handle_redirects',
		'_yoast_wpseo_meta-robots-noindex'         => 'handle_robots_noindex_value',
		'wpseo_titles/noindex-POSTTYPE'            => 'handle_post_type_noindex',
		'wpseo_titles/noindex-tax-TAXONOMY'        => 'handle_taxonomy_noindex',
		'wpseo_titles/title-ptarchive-POSTTYPE'    => 'handle_pt_archive_title',
		'wpseo_titles/metadesc-ptarchive-POSTTYPE' => 'handle_pt_archive_description',
	);

	/**
	 * Check if data exists for import.
	 *
	 * @return bool True if data exists, false otherwise.
	 */
	public function data_exists() {
		// Go ahead with the import if.
		return (
			$this->version_supported() // current yoast version is explicitly marked as supported.
			|| $this->mapped_options_available() // or we have all the options we need in the right places.
		);
	}

	/**
	 * Check if the current Yoast version is supported.
	 *
	 * @return bool True if the version is supported, false otherwise.
	 */
	private function version_supported() {
		$options = get_option( 'wpseo' );
		$version = \smartcrawl_get_array_value( $options, 'version' );

		if ( ! $version ) {
			return false;
		}

		return apply_filters( 'wds-import-yoast-data-exists', strpos( $version, '16.' ) === 0 );
	}

	/**
	 * Check if the mapped options are available.
	 *
	 * @return bool True if the mapped options are available, false otherwise.
	 */
	private function mapped_options_available() {
		$mappings       = $this->expand_mappings( $this->load_option_mappings() );
		$source_options = $this->get_yoast_options();
		$difference     = array_diff_key( $mappings, $source_options );

		return empty( $difference );
	}

	/**
	 * Import Yoast options.
	 *
	 * @return void
	 */
	public function import_options() {
		$mappings       = $this->expand_mappings( $this->load_option_mappings() );
		$source_options = $this->get_yoast_options();
		$target_options = array();
		foreach ( $source_options as $source_key => $source_value ) {
			$target_key = \smartcrawl_get_array_value( $mappings, $source_key );

			if ( ! $target_key ) {
				$target_options = $this->try_custom_handlers( $source_key, $source_value, $target_options );
				continue;
			}

			$processed_target_key   = $this->pre_process_key( $target_key );
			$processed_target_value = $this->pre_process_value( $target_key, $source_value );

			if ( ! $processed_target_key ) {
				continue;
			}

			\smartcrawl_put_array_value(
				$processed_target_value,
				$target_options,
				$processed_target_key
			);
		}

		$target_options = $this->activate_modules( $target_options );
		$target_options = $this->activate_social_options_for_types( $target_options );

		$this->save_options( $target_options );
	}

	/**
	 * Load option mappings.
	 *
	 * @return array The option mappings.
	 */
	private function load_option_mappings() {
		return $this->load_mapping_file( 'yoast-mappings.php' );
	}

	/**
	 * Expand mappings.
	 *
	 * @param array $mappings The mappings to expand.
	 *
	 * @return array The expanded mappings.
	 */
	protected function expand_mappings( $mappings ) {
		$mappings = parent::expand_mappings( $mappings );

		return $this->remove_unnecessary_ptarchive_mappings( $mappings );
	}

	/**
	 * The ptarchive settings are for custom post types with archives only so let's remove mappings for:
	 * - builtin post types
	 * - post types with no archives
	 *
	 * @param array $mappings Mappings.
	 *
	 * @return array
	 */
	private function remove_unnecessary_ptarchive_mappings( $mappings ) {
		foreach (
			array_merge(
				get_post_types(
					array(
						'public'   => true,
						'_builtin' => true,
					)
				),
				get_post_types( array( 'has_archive' => false ) )
			) as $post_type
		) {
			$ptarchive_title_key = "wpseo_titles/title-ptarchive-$post_type";
			$ptarchive_desc_key  = "wpseo_titles/metadesc-ptarchive-$post_type";

			if ( isset( $mappings[ $ptarchive_title_key ] ) ) {
				unset( $mappings[ $ptarchive_title_key ] );
			}
			if ( isset( $mappings[ $ptarchive_desc_key ] ) ) {
				unset( $mappings[ $ptarchive_desc_key ] );
			}
		}

		return $mappings;
	}

	/**
	 * Get Yoast options.
	 *
	 * @return array The Yoast options.
	 */
	private function get_yoast_options() {
		$all_options = array();
		$keys        = array( 'wpseo', 'wpseo_titles', 'wpseo_social' );

		foreach ( $keys as $key ) {
			$options = get_option( $key );
			if ( is_array( $options ) && count( $options ) ) {
				foreach ( $options as $option_key => $option_value ) {
					$all_options[ $key . '/' . $option_key ] = $option_value;
				}
			}
		}

		return $this->add_redirects( $all_options );
	}

	/**
	 * Add redirects to the options.
	 *
	 * @param array $all_options All options.
	 *
	 * @return array
	 */
	private function add_redirects( $all_options ) {
		$option_id = 'wpseo-premium-redirects-base';
		$redirects = get_option( $option_id );
		if ( $redirects ) {
			$all_options = array_merge(
				$all_options,
				array( $option_id => $redirects )
			);

			return $all_options;
		}

		return $all_options;
	}

	/**
	 * Activate modules.
	 *
	 * @param array $target_options The target options.
	 *
	 * @return array
	 */
	private function activate_modules( $target_options ) {
		\smartcrawl_put_array_value( true, $target_options, array( 'wds_settings_options', 'social' ) );
		\smartcrawl_put_array_value( true, $target_options, array( 'wds_settings_options', 'onpage' ) );

		return $target_options;
	}

	/**
	 * Activate social options for types.
	 *
	 * @param array $target_options The target options.
	 *
	 * @return array
	 */
	private function activate_social_options_for_types( $target_options ) {
		$og_enabled      = \smartcrawl_get_array_value( $target_options, array( 'wds_social_options', 'og-enable' ) );
		$twitter_enabled = \smartcrawl_get_array_value(
			$target_options,
			array(
				'wds_social_options',
				'twitter-card-enable',
			)
		);

		if ( $og_enabled ) {
			foreach ( $this->get_all_supported_types() as $type ) {
				\smartcrawl_put_array_value(
					true,
					$target_options,
					array(
						'wds_onpage_options',
						sprintf( 'og-active-%s', $type ),
					)
				);
			}
		}

		if ( $twitter_enabled ) {
			foreach ( $this->get_all_supported_types() as $type ) {
				\smartcrawl_put_array_value(
					true,
					$target_options,
					array(
						'wds_onpage_options',
						sprintf( 'twitter-active-%s', $type ),
					)
				);
			}
		}

		return $target_options;
	}

	/**
	 * Get all supported types.
	 *
	 * @return array The supported types.
	 */
	private function get_all_supported_types() {
		return array_merge(
			array(
				'home',
				'search',
				'404',
				'bp_groups',
				'bp_profile',
				'author',
				'date',
			),
			$this->get_post_types(),
			\smartcrawl_get_archive_post_types(),
			$this->get_taxonomies()
		);
	}

	/**
	 * Wrap Google meta in markup.
	 *
	 * @param string $target_key The target key.
	 * @param string $source_value The source value.
	 *
	 * @return string The wrapped Google meta.
	 */
	public function wrap_google_meta_in_markup( $target_key, $source_value ) {
		if ( strpos( trim( $source_value ), '<meta' ) === 0 ) {
			return $source_value;
		}

		if ( empty( $source_value ) ) {
			return '';
		}

		return sprintf( '<meta name="google-site-verification" content="%s" />', $source_value );
	}

	/**
	 * Wrap Bing meta in markup.
	 *
	 * @param string $target_key The target key.
	 * @param string $source_value The source value.
	 *
	 * @return string The wrapped Bing meta.
	 */
	public function wrap_bing_meta_in_markup( $target_key, $source_value ) {
		if ( strpos( trim( $source_value ), '<meta' ) === 0 ) {
			return $source_value;
		}

		if ( empty( $source_value ) ) {
			return '';
		}

		return sprintf( '<meta name="msvalidate.01" content="%s" />', $source_value );
	}

	/**
	 * Process separator value.
	 *
	 * @param string $target_key The target key.
	 * @param string $source_value The source value.
	 *
	 * @return string The processed separator value.
	 */
	public function process_separator_value( $target_key, $source_value ) {
		$mapping      = array(
			'sc-dash'   => 'dash',
			'sc-ndash'  => 'dash-l',
			'sc-mdash'  => 'dash-l',
			'sc-middot' => 'dot',
			'sc-bull'   => 'dot-l',
			'sc-star'   => 'pipe',
			'sc-smstar' => 'pipe',
			'sc-pipe'   => 'pipe',
			'sc-tilde'  => 'tilde',
			'sc-laquo'  => 'caret-left',
			'sc-raquo'  => 'caret-right',
			'sc-lt'     => 'less-than',
			'sc-gt'     => 'greater-than',
		);
		$mapped_value = \smartcrawl_get_array_value( $mapping, $source_value );

		if ( ! $mapped_value ) {
			return $source_value;
		}

		return $mapped_value;
	}

	/**
	 * Handle taxonomy noindex.
	 *
	 * @param string $source_key The source key.
	 * @param string $source_value The source value.
	 * @param array  $target_options The target options.
	 *
	 * @return array The updated target options.
	 */
	public function handle_taxonomy_noindex( $source_key, $source_value, $target_options ) {
		$current_taxonomy = null;
		foreach ( $this->get_taxonomies() as $taxonomy ) {
			if ( str_replace( 'TAXONOMY', $taxonomy, 'wpseo_titles/noindex-tax-TAXONOMY' ) === $source_key ) {
				$current_taxonomy = $taxonomy;
			}
		}

		if ( ! $current_taxonomy ) {
			return $target_options;
		}

		$noindex_key           = array( 'wds_onpage_options', sprintf( 'meta_robots-noindex-%s', $current_taxonomy ) );
		$sitemap_exclusion_key = array(
			'wds_sitemap_options',
			sprintf( 'taxonomies-%s-not_in_sitemap', $current_taxonomy ),
		);

		\smartcrawl_put_array_value( $source_value, $target_options, $noindex_key );
		\smartcrawl_put_array_value( $source_value, $target_options, $sitemap_exclusion_key );

		return $target_options;
	}

	/**
	 * Handle post type noindex.
	 *
	 * @param string $source_key The source key.
	 * @param string $source_value The source value.
	 * @param array  $target_options The target options.
	 *
	 * @return array The updated target options.
	 */
	public function handle_post_type_noindex( $source_key, $source_value, $target_options ) {
		$current_post_type = null;
		foreach ( $this->get_post_types() as $post_type ) {
			if ( str_replace( 'POSTTYPE', $post_type, 'wpseo_titles/noindex-POSTTYPE' ) === $source_key ) {
				$current_post_type = $post_type;
			}
		}

		if ( ! $current_post_type ) {
			return $target_options;
		}

		$noindex_key           = array( 'wds_onpage_options', sprintf( 'meta_robots-noindex-%s', $current_post_type ) );
		$sitemap_exclusion_key = array(
			'wds_sitemap_options',
			sprintf( 'post_types-%s-not_in_sitemap', $current_post_type ),
		);

		\smartcrawl_put_array_value( $source_value, $target_options, $noindex_key );
		\smartcrawl_put_array_value( $source_value, $target_options, $sitemap_exclusion_key );

		return $target_options;
	}

	/**
	 * Handle redirects.
	 *
	 * @param string $source_key The source key.
	 * @param array  $redirects The redirects.
	 * @param array  $target_options The target options.
	 *
	 * @return array The updated target options.
	 */
	public function handle_redirects( $source_key, $redirects, $target_options ) {
		if ( empty( $redirects ) ) {
			return $target_options;
		}

		$wds_redirects      = array();
		$wds_redirect_types = array();
		foreach ( $redirects as $redirect ) {
			$format = \smartcrawl_get_array_value( $redirect, 'format' );
			$origin = \smartcrawl_get_array_value( $redirect, 'origin' );
			$url    = \smartcrawl_get_array_value( $redirect, 'url' );
			$type   = \smartcrawl_get_array_value( $redirect, 'type' );

			// We are not supporting anything other than plain redirects at the moment.
			if ( 'plain' !== $format || ! $origin || ! $url || ! $type ) {
				continue;
			}

			$wds_redirects[ home_url( $origin ) ]      = home_url( $url );
			$wds_redirect_types[ home_url( $origin ) ] = $type;
		}
		\smartcrawl_put_array_value( $wds_redirects, $target_options, 'wds-redirections' );
		\smartcrawl_put_array_value( $wds_redirect_types, $target_options, 'wds-redirections-types' );

		return $target_options;
	}

	/**
	 * Handle robots noindex value.
	 *
	 * @param string $source_key The source key.
	 * @param string $source_value The source value.
	 * @param array  $post_meta The post meta.
	 *
	 * @return array The updated post meta.
	 */
	public function handle_robots_noindex_value( $source_key, $source_value, $post_meta ) {
		if ( intval( $source_value ) === 1 ) {
			\smartcrawl_put_array_value( true, $post_meta, '_wds_meta-robots-noindex' );
		} elseif ( intval( $source_value ) === 2 ) {
			\smartcrawl_put_array_value( true, $post_meta, '_wds_meta-robots-index' );
		}

		return $post_meta;
	}

	/**
	 * Process schema type value.
	 *
	 * @param string $target_key The target key.
	 * @param string $source_value The source value.
	 *
	 * @return string The processed schema type value.
	 */
	public function process_schema_type_value( $target_key, $source_value ) {
		return 'company' === $source_value ? 'Organization' : 'Person';
	}

	/**
	 * Import taxonomy meta.
	 *
	 * @return void
	 */
	public function import_taxonomy_meta() {
		$mappings             = $this->load_taxonomy_meta_mappings();
		$taxonomy_meta_option = get_option( 'wpseo_taxonomy_meta', array() );
		$wds_meta             = array();

		foreach ( $taxonomy_meta_option as $taxonomy => $taxonomy_meta ) {
			foreach ( $taxonomy_meta as $term_id => $meta_values ) {
				$wds_taxonomy_meta = array();

				foreach ( $meta_values as $meta_key => $meta_value ) {
					$target_key = \smartcrawl_get_array_value( $mappings, $meta_key );

					if ( ! $target_key || ! $meta_value ) {
						continue;
					}

					$processed_target_key   = $this->pre_process_key( $target_key );
					$processed_target_value = $this->pre_process_value( $target_key, $meta_value );

					if ( ! $processed_target_key || ! $processed_target_value ) {
						continue;
					}

					\smartcrawl_put_array_value(
						$processed_target_value,
						$wds_taxonomy_meta,
						$processed_target_key
					);
				}

				$wds_meta[ $taxonomy ][ $term_id ] = $wds_taxonomy_meta;
			}
		}
		update_option( 'wds_taxonomy_meta', $wds_meta );
	}

	/**
	 * Load taxonomy meta mappings.
	 *
	 * @return array The taxonomy meta mappings.
	 */
	public function load_taxonomy_meta_mappings() {
		return $this->load_mapping_file( 'yoast-taxonomy-meta-mappings.php' );
	}

	/**
	 * Import post meta.
	 *
	 * @return bool
	 */
	public function import_post_meta() {
		$mappings    = $this->load_post_meta_mappings();
		$batch_size  = apply_filters( 'wds_post_meta_import_batch_size', 300 );
		$all_posts   = $this->get_posts_with_yoast_metas();
		$batch_posts = array_slice( $all_posts, 0, $batch_size );

		foreach ( $batch_posts as $post_id ) {
			$wds_meta = array();

			foreach ( $mappings as $source_key => $target_key ) {
				$source_value = get_post_meta( $post_id, $source_key, true );

				if ( ! $target_key ) {
					$wds_meta = $this->try_custom_handlers( $source_key, $source_value, $wds_meta );
					continue;
				}

				$processed_target_key   = $this->pre_process_key( $target_key );
				$processed_target_value = $this->pre_process_value( $target_key, $source_value, $post_id );

				if ( ! $processed_target_key ) {
					continue;
				}

				\smartcrawl_put_array_value( $processed_target_value, $wds_meta, $processed_target_key );
			}

			$this->add_post_meta( $post_id, $wds_meta );
		}

		$this->update_status(
			array(
				'remaining_posts' => count( $this->get_posts_with_yoast_metas() ),
				'completed_posts' => count( $this->get_posts_with_target_metas() ),
			)
		);

		return count( $all_posts ) === count( $batch_posts );
	}

	/**
	 * Load post meta mappings.
	 *
	 * @return array The post meta mappings.
	 */
	private function load_post_meta_mappings() {
		return $this->load_mapping_file( 'yoast-post-meta-mappings.php' );
	}

	/**
	 * Get posts with source metas.
	 *
	 * @return int[]
	 */
	private function get_posts_with_yoast_metas() {
		return $this->get_posts_with_source_metas( '_yoast_' );
	}

	/**
	 * Add post meta.
	 *
	 * @param int   $post_id The post ID.
	 * @param array $meta The meta data.
	 *
	 * @return void
	 */
	private function add_post_meta( $post_id, $meta ) {
		foreach ( $meta as $meta_key => $meta_value ) {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}
	}

	/**
	 * Handle post type archive title.
	 *
	 * @param string $source_key The source key.
	 * @param string $source_value The source value.
	 * @param array  $target_options The target options.
	 *
	 * @return array The updated target options.
	 */
	public function handle_pt_archive_title( $source_key, $source_value, $target_options ) {
		return $this->add_pt_archive_setting( $source_value, $target_options, 'title-%s' );
	}

	/**
	 * Add post type archive setting.
	 *
	 * @param mixed  $source_value The source value.
	 * @param array  $target_options The target options.
	 * @param string $setting_key The setting key.
	 *
	 * @return array
	 */
	private function add_pt_archive_setting( $source_value, $target_options, $setting_key ) {
		foreach ( \smartcrawl_get_archive_post_types() as $archive_post_type ) {
			\smartcrawl_put_array_value(
				$source_value,
				$target_options,
				array(
					'wds_onpage_options',
					sprintf( $setting_key, $archive_post_type ),
				)
			);
		}

		return $target_options;
	}

	/**
	 * Handle post type archive description.
	 *
	 * @param string $source_key The source key.
	 * @param string $source_value The source value.
	 * @param array  $target_options The target options.
	 *
	 * @return array The updated target options.
	 */
	public function handle_pt_archive_description( $source_key, $source_value, $target_options ) {
		return $this->add_pt_archive_setting( $source_value, $target_options, 'metadesc-%s' );
	}

	/**
	 * Get pre-processors.
	 *
	 * @return array The pre-processors.
	 */
	protected function get_pre_processors() {
		return array(
			'wds_onpage_options/preset-separator'          => 'process_separator_value',
			'wds_social_options/schema_type'               => 'process_schema_type_value',
			'wds_sitemap_options/verification-google-meta' => 'wrap_google_meta_in_markup',
			'wds_sitemap_options/verification-bing-meta'   => 'wrap_bing_meta_in_markup',
		);
	}

	/**
	 * Get the next network site option ID.
	 *
	 * @return string The next network site option ID.
	 */
	protected function get_next_network_site_option_id() {
		return self::NETWORK_IMPORT_SITES_PROCESSED_COUNT;
	}

	/**
	 * Get the import in progress option ID.
	 *
	 * @return string The import in progress option ID.
	 */
	protected function get_import_in_progress_option_id() {
		return self::IMPORT_IN_PROGRESS_FLAG;
	}

	/**
	 * Get custom handlers.
	 *
	 * @return array The custom handlers.
	 */
	protected function get_custom_handlers() {
		return $this->custom_handlers;
	}

	/**
	 * Get source plugins.
	 *
	 * @return array The source plugins.
	 */
	protected function get_source_plugins() {
		return array(
			'wordpress-seo/wp-seo.php',
			'wordpress-seo-premium/wp-seo-premium.php',
		);
	}
}