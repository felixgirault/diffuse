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
		'googlePlus' => array(
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
	 *	Builds and returns a sharing URL for the given service.
	 *
	 *	@param string $service Name of the service.
	 *	@param array $params Parameters.
	 *	@return string Link.
	 */

	public function url( $service, array $params = array( )) {

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
