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

use EXML\EXMLData,
	EXML\Test\EXMLData_Mock;

require '/vendor/autoload.php';

/**
 * @backupGlobals disabled
 */
class EXMLData_Test extends PHPUnit_Framework_TestCase {
	protected static $data;
	protected static $root;
	protected static $ruleSet;
	protected $obj;

	static function setUpBeforeClass() {
		// Grab Mock Object's values
		$mock = new EXMLData_Mock();
		self::$data = $mock->getData();
		self::$root = $mock->getRoot();
		self::$ruleSet = $mock->getRuleSet();
	}

	function setUp() {
		$this->obj = new EXMLData(self::$root, self::$data, self::$ruleSet);
	}

	function testGetRoot() {
		$this->assertEquals($this->obj->getRoot(), self::$root);
	}

	function testSetRoot() {
		$root = 'book';
		$this->obj->setRoot($root);
		$this->assertEquals($this->obj->getRoot(), $root);
	}

	function testGetData() {
		$this->assertEquals($this->obj->getData(), self::$data);
	}

	function testSetData() {
		$data = array(
			'title' => 'Game of Thrones',
			'author' => 'George R. R. Martin',
			'series' => 'Song of Ice and Fire',
		);
		$this->obj->setData($data);
		$this->assertEquals($this->obj->getData(), $data);
	}
}


?>