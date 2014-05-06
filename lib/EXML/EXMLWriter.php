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

namespace EXML;

use SimpleXMLElement;

/**
* The XMLWriter is a tool to statically write XMLData or arrays of XMLData into XML.
* @since 1.0
* @author Jacob Haines <jacob.k.haines@gmail.com>
* @todo  revisit initial write function after unit tests. Likely uses root twice
*/
class EXMLWriter
{

	/**
	 * Validates the input to be a valid XMLData or array of Objects.
	 * @param  iXMLData $obj iXMNData Object
	 * @return bool      true if all tests passed, false if not
	 * @throws EXMLException If $obj is not interfaced with iEXMLData
	 */
	static function validate($obj) {
		if (!($obj instanceof iEXMLData)) {
			throw EXMLException::invalidObjectInstance('iEXMLData');
		}
		$ruleSet = $obj->getRuleSet();
		return !is_null($ruleSet) ? $ruleSet->validate($obj->getData()) : true;
	}

	/**
	 * Returns XML string for the array of XMLDatas or XMLData. 
	 * @param  iXMLData  $obj array of XMLDatas OR single XMLData
	 * @return string         XML string
	 * @throws EXMLException If the EXMLData's validate fails.
	 * @static
	 */
	static function write($obj) {
		if (!self::validate($obj)) {
			throw EXMLException::invalidXMLData();
		}
		$root = $obj->getRoot();
		$xml = new SimpleXMLElement("<$root></$root>");
		self::objectToXML($obj->getData(), $xml);
		return $xml->asXML();
	}


	/**
	 * Takes the given XMLData or array and converts it into an XML string.
	 * @param  $obj XMLData, array of XMLDatas, or array of values
	 * @param  SimpleXMLElement $xml    Current xml element
	 * @static
	 * @access private
	 */
	private static function objectToXML($obj, &$xml) {
		// Either an array or XMLData object
		if (is_array($obj)) {
			foreach ($obj as $key => $value) {
				//	If array, add empty child element and go into that
				if (is_array($value)) {
					$subNode = $xml->addChild($key);
					self::objectToXML($value, $subNode);
				} 

				// XMLData object. Get root, dig in
				elseif ($value instanceof iEXMLData) {
					$subNode = $value->getRoot();
					self::objectToXML($value->getDataMap(), $subNode);
				} 

				// XMLElement object. Expect attributes
				elseif ($value instanceof EXMLElement) {
					$element = $value->getData();

					//	If it's an array, dig in
					if (is_array($element)) {
						$subNode = $xml->addChild($key);
						self::objectToXML($element, $subNode);
					} 

					// If it's XMLData, get root and dig in
					elseif ($element instanceof iEXMLData) {
						$subNode = $value->getRoot();
						self::objectToXML($value->getDataMap(), $subNode);
					}

					// Regular data, add child with value
					else {
						$subNode = $xml->addChild($key, $element);
					}

					// Iterate over the attribute array
					foreach ($element->getAttributes() as $attrKey => $attrValue) {
						$subNode->addAttribute($attrKey, $attrValue);
					}
				} 

				// Regular value, end of recursion
				else {
					$xml->addChild($key, $value);
				}
			}
		} 

		// Wasn't an array, must be XMLData
		else {
			$subNode = $xml->addChild($obj->getRoot());
			self::objectToXML($obj->getDataMap(), $subNode);
		}
	}
}

?>