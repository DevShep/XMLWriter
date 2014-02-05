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

class XMLObject implements iXMLObject {
	protected $dataMap;
	protected $reqMap;
	protected $typeMap;
	protected $lengthMap;

	function __construct($base, $dataMap, $reqMap = null, $typeMap = null, $lengthMap = null);
	{
		$this->base = $base;
		$this->dataMap = $dataMap;
		$this->reqMap = $reqMap;
		$this->typeMap = $typeMap;
		$this->lengthMap = $lengthMap;

		//	If the reqMap is defined, validate the integrity of other maps
		if (!is_null($reqMap)) {
			if(!is_null($typeMap)) {
				self::validateMapIntegrity($reqMap, $typeMap, "type");
			}
			if(!is_null($lengthMap)) {
				self::validateMapIntegrity($reqMap, $lengthMap, "length");
			}
		}
	}

	function validate() {
		//	If there isn't any reqMap, no data validation
		if (is_null($this->getReqMap())) {
			return true;
		}

		# code
	}

	function getBase() {
		return $this->base;
	}

	function setBase($base) {
		$this->base = $base;
	}

	function getDataMap() {
		return $this->dataMap;
	}

	/**
	 * Sets the DataMap parameter
	 * @param array $map dataMap
	 * @todo account for arrays within the array
	 */
	function setDataMap($map) {
		foreach ($map as $key => $value) {
			$this->set($key, $value);
		}
	}

	function getTypeMap() {
		return $this->typeMap;
	}

	function setTypeMap($map) {
		$this->typeMap = $map;
	}

	function getLengthMap() {
		return $this->getLengthMap;
	}

	function setLengthMap($map) {
		$this->lengthMap = $map;
	}

	/**
	 * Sets element in datamap
	 * @param any $key   name of key
	 * @param any $value value
	 * @throws XMLWriterException If reqMap is defined and $key is not found in it
	 * @todo account for $value being an array
	 */
	function set($key, $value) {
		$reqMap = $this->getReqMap();
		if (!is_null($reqMap)) {
			if (!isset($reqMap[$key])) {
				throw XMLWriterException::unMappedKey($key);
			}
		}

		$this->dataMap[$key] = $value;
	}

	/**
	 * Compares a map against reqMap to element keys match 1:1.
	 * @param  array $reqMap  requirement map
	 * @param  array $map     map to be compared
	 * @param  string $mapName name of comapred map
	 * @throws XMLWriterException If count of each map's elements is not equal
	 * @throws XMLWriterException If $map is missing an element defined in requirement Map
	 * @static
	 * @access private
	 */
	static private function validateMapIntegrity($reqMap, $map, $mapName) {
		if (count($reqMap) !== count($map) && !is_null($reqMap)) {
			throw XMLWriterException::inequivalentLengths($mapName);
		}

		foreach ($reqMap as $key => $value) {
			if (is_array($value)) {
				self::validateMapIntegrity($value, $map[$key]);
			} elseif (!isset($map[$key])) {
				throw XMLWriterException::unsetKey($key, $mapName);
			}
		}
	}


}

?>