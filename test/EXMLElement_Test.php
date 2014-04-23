<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by individuals
 * and is licensed under the MIT license.
 */

use EXML\EXMLElement;

require '/vendor/autoload.php';

/**
 * @backupGlobals disabled
 */
class EXMLElement_Test extends PHPUnit_Framework_TestCase {
	protected static $data;
	protected static $attributes;
	protected $obj;

	static function setUpBeforeClass() {
		self::$data = 40;
		self::$attributes = array(
			'schedule' => 'weekly', 
		);
	}

	function setUp() {
		$this->obj = new EXMLElement(self::$data, self::$attributes);
	}

	function testGetData() {
		$this->assertEquals($this->obj->getData(), self::$data);
	}

	function testSetData() {
		$rate = 55;
		$this->obj->setData($rate);
		$this->assertEquals($this->obj->getData(), $rate);
	}

	function testGetAttributes() {
		$this->assertEquals($this->obj->getAttributes(), self::$attributes);
	}

	function testSetAttributes() {
		$attributes = array(
			'schedule' => 'bi-weekly',
			'pay-rate' => 'monthly'
		);
		$this->obj->setAttributes($attributes);
		$this->assertEquals($this->obj->getAttributes(), $attributes);
	}
}


?>