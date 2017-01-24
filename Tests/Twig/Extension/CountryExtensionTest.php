<?php

namespace Craue\FormFlowDemoBundle\Tests\Form;

use Craue\FormFlowDemoBundle\Twig\Extension\CountryExtension;

/**
 * @group unit
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2017 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class CountryExtensionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var CountryExtension
	 */
	protected $ext;

	protected function setUp() {
		\Locale::setDefault('en');

		 $this->ext = new CountryExtension();
	}

	/**
	 * @dataProvider dataGetCountry
	 */
	public function testGetCountry($expectedValue, $country) {
		$this->assertSame($expectedValue, $this->ext->getCountry($country));
	}

	public function dataGetCountry() {
		return array(
			array(null, null),
			array(null, ''),
			array(null, 'INVALID'),
			array('Germany', 'DE'),
		);
	}

}
