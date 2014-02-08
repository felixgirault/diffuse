<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http =>//opensource.org/licenses/BSD-2-Clause)
 */

namespace Diffuse;

use PHPUnit_Framework_TestCase;



/**
 *	Test case for Diffuse.
 */

class DiffuseTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Diffuse = null;



	/**
	 *
	 */

	public $services = array(
		'service' => array(
			'url' => 'https://www.service.com/share',
			'map' => array(
				Diffuse::url => 'url',
				Diffuse::text => 'description'
			)
		)
	);



	/**
	 *
	 */

	public function setUp( ) {

		$this->Diffuse = new Diffuse( $this->services );
	}



	/**
	 *
	 */

	public function testCall( ) {

		$this->assertEquals(
			$this->Diffuse->url( 'service', 'url' ),
			$this->Diffuse->service( 'url' )
		);
	}



	/**
	 *
	 */

	public function testUrl( ) {

		$this->assertEquals(
			'https://www.service.com/share?url=url',
			$this->Diffuse->url( 'service', 'url' )
		);
	}



	/**
	 *
	 */

	public function testUrlWithParams( ) {

		$this->assertEquals(
			'https://www.service.com/share?url=url&description=text',
			$this->Diffuse->url( 'service', array(
				Diffuse::url => 'url',
				Diffuse::text => 'text',
				Diffuse::via => 'via'
			))
		);
	}
}
