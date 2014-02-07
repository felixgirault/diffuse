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
			'urlParam' => 'url'
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

	public function testUrl( ) {

		$this->assertEquals(
			'https://www.service.com/share?url=URL',
			$this->Diffuse->link( 'service', 'URL' )
		);
	}
}