<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace Diffuse;

use Exception;



/**
 *	Diffuse.
 *
 *	@package
 */

class Diffuse {

	/**
	 *
	 */

	const url = 'url';
	const text = 'text';
	const via = 'via';
	const reply = 'reply';
	const tags = 'tags';
	const related = 'related';
	const lang = 'lang';



	/**
	 *	Services configuration.
	 *
	 *	@var array
	 */

	protected $_services = array(
		'facebook' => array(
			'url' => 'https://www.facebook.com/sharer/sharer.php',
			'map' => array(
				self::url => 'u'
			)
		),
		'google' => array(
			'url' => 'https://plus.google.com/share',
			'map' => array(
				self::url => 'url',
				self::lang => 'hl'
			)
		),
		'twitter' => array(
			'url' => 'http://twitter.com/intent/tweet',
			'map' => array(
				self::url => 'url',
				self::text => 'text',
				self::via => 'via',
				self::reply => 'in_reply_to',
				self::tags => 'hashtags',
				self::related => 'related'
			)
		)
	);



	/**
	 *	Constructor.
	 *
	 *	@param array $services Services configuration.
	 */

	public function __construct( array $services = array( )) {

		$this->_services = array_merge( $this->_services, $services );
	}



	/**
	 *	Provides shortcuts to the url( ) method:
	 *
	 *	@code
	 *	$Diffuse->url( 'facebook', 'http://example.com/page' );
	 *	// or
	 *	$Diffuse->facebook( 'http://example.com/page' );
	 *	@endcode
	 *
	 *	@param string $service Service name.
	 *	@param array $arguments Arguments.
	 *	@return string URL.
	 */

	public function __call( $service, array $arguments = array( )) {

		array_unshift( $arguments, $service );

		return call_user_func_array( array( $this, 'url' ), $arguments );
	}



	/**
	 *	Builds and returns a sharing URL for the given service.
	 *	There is two ways to call this method:
	 *
	 *	@code
	 *	$Diffuse->url( 'facebook', 'http://example.com/page' );
	 *	// or
	 *	$Diffuse->url( 'facebook', array(
	 *		Diffuse::url => 'http://example.com/page',
	 *		Diffuse::text => 'Lorem ipsum dolor sit amet'
	 *	));
	 *	@endcode
	 *
	 *	@param string $service Name of the service.
	 *	@param array|string $params Parameters, or URL to share.
	 *	@return string URL.
	 */

	public function url( $service, $params = array( )) {

		if ( is_string( $params )) {
			$params = array(
				self::url => $params
			);
		}

		$config = $this->_service( $service );
		$mapped = array( );

		if ( isset( $config['map'])) {
			foreach ( $config['map'] as $generic => $specific ) {
				if ( isset( $params[ $generic ])) {
					$mapped[ $specific ] = $params[ $generic ];
				}
			}
		}

		return $config['url'] . '?' . http_build_query( $mapped );
	}



	/**
	 *	Returns the configuration of the given service.
	 *
	 *	@param string $name Name of the service.
	 *	@return array Configuration.
	 *	@throws Exception if the service is not configured.
	 */

	protected function _service( $name ) {

		if ( !isset( $this->_services[ $name ])) {
			throw new Exception( "The '$service' service is not configured." );
		}

		return $this->_services[ $name ];
	}
}
