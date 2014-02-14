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

namespace EXML\Test;
use PHPUnit_Framework_TestCase,
	EXML\EXMLWriter;

/**
 * @backupGlobals disabled
 */
class XMLWriterTest extends PHPUnit_Framework_TestCase {
	protected static $xml = <<<xml
<xml><test><FirstName>John</FirstName><LastName>Smith</LastName><Phone>3215551234</Phone><Address><Street1>Main St</Street1><Street2>Apt 5404</Street2><City>New York</City><State>NY</State><Zip>12345</Zip></Address><DOB>1980-03-24</DOB><Level>2</Level><Active>1</Active></test></xml>
xml;

	function testWrite() {
		$this->assertXmlStringEqualsXmlString(XMLWriter::write(new XMLObjectMock()), self::$xml);
	}

	/*****	EXCEPTIONS 	*****/

	/**
	 * @expectedException XMLWriterException
	 * @expectedExceptionMessage Object must be an instance of iXMLObject.
	 */
	public function testException_InvalidObjectInstance_Object() {
		$obj = new XMLWriter(1);
	}
}


?>