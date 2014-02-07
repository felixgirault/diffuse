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
	 *	Services configuration.
	 *
	 *	@var array
	 */

	protected $_services = array(
		'facebook' => array(
			'url' => 'https://www.facebook.com/sharer/sharer.php',
			'urlParam' => 'u'
		),
		'google-plus' => array(
			'url' => 'https://plus.google.com/share',
			'urlParam' => 'url'
		),
		'twitter' => array(
			'url' => 'http://twitter.com/intent/tweet',
			'urlParam' => 'url'
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
	 *	@param string $serviceName Name of the service.
	 *	@param string $url URL to share.
	 *	@param array $params Additionnal parameters.
	 *	@return string Link.
	 */

	public function url( $serviceName, $url, array $params = array( )) {

		$service = $this->_service( $serviceName );

		$query = $params;
		$query[ $service['urlParam']] = $url;

		return $service['url'] . '?' . http_build_query( $query );
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
