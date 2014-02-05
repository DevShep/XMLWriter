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

namespace XMLWriter;

use SimpleXMLElement;

/**
* The XMLWriter is a tool to statically write XMLObjects or arrays of XMLObjects into XML.
* @since 1.0
* @author Jacob Haines <jacob.k.haines@gmail.com>
*/
class XMLWriter
{

	/**
	 * Validates the input to be a valid XMLObject or array of Objects.
	 * @param  mixed $xmlObj      
	 * @throws XMLWriterException If $xmlObject or array elements are not of iXMLObject
	 * @static
	 * @access private
	 */
	private static function validate($xmlObj) {
		if(is_array($xmlObj)) {
			foreach ($xmlObj as $key => $value) {
				self::validate($value);
			}
		} elseif(!($xmlObj instanceof iXMLObject)) {
			throw XMLWriterException::invalidObjectInstance('iXMLObject');
		} else {
			// Is there a way to have custom exception handling here? Should that even matter?
			$xmlObj->validate();
		}
	}

	/**
	 * Returns XML string for the array of XMLObjects or XMLObject. 
	 * @param  mixed  $xmlObj array of XMLObjects OR single XMLObject
	 * @param  string $base   Base element name
	 * @return string         XML string
	 * @static
	 */
	static function write($xmlObj, $base = 'xml') {
		self::validate($xmlObj);

		$xml = new SimpleXMLElement("<$base></$base>");
		self::objectToXML($xmlObj, $xml);
		return $xml->asXML();
	}


	/**
	 * Takes the given XMLObject or array and converts it into an XML string.
	 * @param  $xmlObj XMLObject, array of XMLObjects, or array of values
	 * @param  SimpleXMLElement $xml    Current xml element
	 * @static
	 * @access private
	 */
	private static function objectToXML($xmlObj, &$xml) {
		if(is_array($xmlObj)) {
			foreach ($xmlObj as $key => $value) {
				if(is_array($value)) {
					$subNode = $xml->addChild($key);
					self::objectToXML($value, $subNode);
				} elseif ($value instanceof iXMLObject) {
					$subNode = $value->getBase();
					self::objectToXML($value->getDataMap(), $subNode);
				} else {
					$xml->addChild($key, $value);
				}
			}
		} else {
			$subNode = $xml->addChild($xmlObj->getBase());
			self::objectToXML($xmlObj->getDataMap(), $subNode);
		}
	}
}

?>