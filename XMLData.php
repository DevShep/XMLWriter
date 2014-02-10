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

namespace TBD;

/**
 * Object to store XML-related data including data, definition map (if applicable), root, and validation ruleset
 * 
 */
class XMLData implements iXMLData {

	/**
	 * Array of data to be converted into XML
	 * @var array
	 */
	protected $data;

	/**
	 * Array of booleans; matching data keys will be converted into XML; keys that are marked true are required.
	 *
	 * <code>
	 * 		$data = array(
	 * 			'required' => 1,
	 * 			'notRequired' => 2,
	 * 			'unMapped' => 3
	 * 		)
	 *
	 * 		$map = array(
	 * 			'required' => true,
	 * 			'requiredMissing' => true,
	 * 			'notRequired' => false,
	 * 			'notRequiredMissing' => false
	 * 		)
	 * </code>
	 * 
	 * Above arrays interact as follows:
	 * 'required' => converted to XML
	 * 'notRequired' => converted to XML
	 * 'unMapped' => not included in XML
	 * 'requiredMissing' => will throw exception since missing from $data
	 * 'notRequiredMissing' => not included in XML, no exception thrown		 
	 * 	
	 * @var array
	 */
	protected $map;

	/**
	 * Root element of the to-be XML document
	 * @var string
	 */
	protected $root;

	/**
	 * Array of iXMLValidator objects used to run validations against the data
	 * @var array
	 */
	protected $ruleset;

	/**
	 * $data and $root are required, $map and $ruleset are optional
	 * @param array $data    data to be converted
	 * @param string $root    root element name
	 * @param array $map     map of required/unrequied elements
	 * @param array $ruleset iXMLValidator objects
	 * @todo  add type checks
	 */
	function __construct($data, $root, $map = null, $ruleset = null) {
		$this->data = $data;
		$this->root = $root;
		$this->map = $map;
		$this->ruleset = $ruleset;
	}

	/**
	 * Returns the data array
	 * @return array data array
	 */
	function getData() {
		return $this->data;
	}

	/**
	 * Sets the data array
	 * @param array $data data array
	 */
	function setData($data) {
		$this->data = $data;
	}

	/**
	 * Returns the map array
	 * @return array map array
	 */
	function getMap() {
		return $this->map;
	}

	/**
	 * Sets the map array
	 * @param array $map map array
	 */
	function setMap($map) {
		$htis->map = $map;
	}

	/**
	 * Returns the root element
	 * @return string root element
	 */
	function getRoot() {
		return $this->root;
	}

	/**
	 * Sets the root element
	 * @param string $root root element
	 */
	function setRoot($root) {
		$this->root = $root;
	}

	/**
	 * Returns the XMLValidator array
	 * @return array XMLValidator array
	 */
	function getRuleset() {
		return $this->ruleset;
	}

	/**
	 * Sets the XMLValidator array
	 * @param array $ruleset XMLValidator array
	 */
	function setRuleset($ruleset) {
		$this->ruleset = $ruleset;
	}

	/**
	 * Returns the data array for XML conversion; may be limited by the map array
	 * @return array data
	 * @throws XMLException If A mapped key marked as required is unset/null in the data array
	 */
	function getXMLData() {
		$map = $this->map;
		$data = $this->data;

		if (!is_null($map)) {
			$arr = array();

			foreach ($map as $key => $value) {
				if ($value && is_null($data[$key])) {
					throw XMLWriterException::unsetRequiredKey($key);
				}

				$arr[$key] = $data[$key];
			}

			return $arr;
		} else {
			return $data;
		}
	}
}

?>