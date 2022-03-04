<?php

namespace WP_Forge\Options;

/**
 * Class Options
 *
 * A class for handling the fetching, saving and manipulation of options for WordPress plugins.
 * All options data is stored in a single database option, but this class allows you to individually
 * set or get options within it.
 */
class Options {

	/**
	 * The name where our option is stored in the database.
	 *
	 * @var string
	 */
	protected $optionName;

	/**
	 * Stores all options
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Tracks whether a save is necessary.
	 *
	 * @var bool
	 */
	protected $shouldSave = false;

	/**
	 * Class constructor.
	 *
	 * @param string $name Option name
	 */
	public function __construct( string $name ) {
		$this->optionName = $name;
		$this->options    = $this->fetch();
		add_action( 'shutdown', [ $this, 'maybeSave' ] );
	}

	/**
	 * Fetch options from the database.
	 *
	 * @return array
	 */
	public function fetch() {
		return (array) get_option( $this->optionName, [] );
	}

	/**
	 * Check if an option exists.
	 *
	 * @param string $name Option name
	 *
	 * @return bool
	 */
	public function has( string $name ) {
		return isset( $this->options[ $name ] );
	}

	/**
	 * Get an option by name.
	 *
	 * @param string $name    Option name
	 * @param mixed  $default Fallback value
	 *
	 * @return mixed
	 */
	public function get( string $name, $default = null ) {
		return $this->has( $name ) ? $this->options[ $name ] : $default;
	}

	/**
	 * Set an option by name.
	 *
	 * @param string $name  Option name
	 * @param mixed  $value Option value
	 */
	public function set( string $name, $value ) {
		if ( ! $this->has( $name ) || $this->get( $name ) !== $value ) {
			$this->options[ $name ] = $value;
			$this->shouldSave       = true;
		}
	}

	/**
	 * Delete an option by name.
	 *
	 * @param string $name Option name
	 */
	public function delete( string $name ) {
		if ( $this->has( $name ) ) {
			unset( $this->options[ $name ] );
			$this->shouldSave = true;
		}
	}

	/**
	 * Populate all options at once.
	 *
	 * @param array $data Option data
	 */
	public function populate( array $data ) {
		$this->options    = $data;
		$this->shouldSave = true;
	}

	/**
	 * Get all options.
	 *
	 * @return array
	 */
	public function all() {
		return $this->options;
	}

	/**
	 * Save options to the database.
	 *
	 * @return bool
	 */
	public function save() {
		$this->shouldSave = false;

		return update_option( $this->optionName, $this->options, true );
	}

	/**
	 * Only save the options to the database if something changed.
	 */
	public function maybeSave() {
		if ( $this->shouldSave ) {
			$this->save();
		}
	}

}
