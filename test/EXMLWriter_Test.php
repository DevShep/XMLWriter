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

use EXML\EXMLWriter,
	EXML\Test\EXMLData_Mock;

require '/vendor/autoload.php';

/**
 * @backupGlobals disabled
 */
class EXMLWriter_Test extends PHPUnit_Framework_TestCase {
	protected static $xml;
	protected static $obj;
	protected static $xmlFiltered;

	static function setUpBeforeClass() {
		self::$xml = <<< xml
<employee><first-name>John</first-name><last-name>Smith</last-name><middle-initial>E</middle-initial><phone>304-555-1234</phone><title>Director</title><address><street-1>15th W St.</street-1><street-2>Apt 105</street-2><city>Farmvegas</city><state>VA</state><zip>23943</zip></address><birthdate>1980-03-12</birthdate><hours>40</hours><rate>30.25</rate></employee>
xml;
		self::$xmlFiltered = <<< xml
<employee><first-name>John</first-name><last-name>Smith</last-name></employee>
xml;
		self::$obj = new EXMLData_Mock();
	}

	function testValidate() {
		$this->assertTrue(EXMLWriter::validate(self::$obj));
	}

	function testWrite() {
		$this->assertXmlStringEqualsXmlString(EXMLWriter::write(self::$obj), self::$xml);
	}

	function testFilter() {
		$filter = ['first-name'=> true, 'last-name'=>true];
		$this->assertXmlStringEqualsXmlString(EXMLWriter::write(self::$obj, $filter), self::$xmlFiltered);
	}


	/****	EXCEPTIONS 	****/

	/**
	 * @expectedException EXML\EXMLException
	 * @expectedExceptionMessage Object must be an instance of iEXMLData.
	 */
	public function testException_InvalidObjectInstance() {
		EXMLWriter::write(1);	
	}

	/**
	 * @expectedException EXML\EXMLException
	 * @expectedExceptionMessage The provided EXMLData object failed validation.
	 */
	public function testException_InvalidXMLData() {
		$mockVal = $this->getMock('EXML\EXMLRuleSet');
		$mockVal->expects($this->any())
			->method('validate')
			->will($this->returnValue(false));

		$obj = $this->getMockBuilder('EXML\EXMLData')
			->disableOriginalConstructor()
			->getMock();

		$obj->expects($this->any())
			->method('getRuleSet')
			->will($this->returnValue($mockVal));

		EXMLWriter::write($obj);	
	}	
}


?>