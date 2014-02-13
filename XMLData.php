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
 * Object to store XML-related data including data, root, and validation ruleSet
 *
 * XMLData hosts the data to be converted into XML as well as rules to easily 
 * decide what is included in the final XML document and to validate the data.
 *
 * The data array's keys are used to generate the XML elements and attributes. 
 * Using the following setup <code>$data[$key] = $value</code>, we have the 
 * following rules:
 *
 * 1) In general, the data is converted into the following: <$key>$value</$key>
 * 2) To add an attribute, use "@ele-attr" as the key where
 * 'ele' is equal to the attribute's element and 'attr' is equal to the 
 * attribute's name
 * 3) To have XML elements of the same name, have a nested array where its keys
 * are integers
 * 4) To create child elements, use a nested array with string keys to represent
 * child element names.
 *
 * As an demonstration, say we're recording information about a library
 * @todo  write example code
 */
class XMLData implements iXMLData {

	/**
	 * Array of data to be converted into XML
	 *
	 *
	 * Above will be converted to
	 * @var array
	 */
	protected $data;

	/**
	 * Root element of the to-be XML document
	 * @var string
	 */
	protected $root;

	/**
	 * Array of iXMLValidator objects used to   run validations against the data
	 * @var array
	 */
	protected $ruleSet;

	/**
	 * $data and $root are required, $ruleSet is optional
	 * @param array $data    data to be converted
	 * @param string $root    root element name
	 * @param array $ruleSet iXMLValidator objects
	 * @todo  add type checks
	 */
	function __construct($root, $data, $ruleSet = null) {
		$this->data = $data;
		$this->root = $root;
		$this->ruleSet = $ruleSet;
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
	function getRuleSet() {
		return $this->ruleSet;
	}

	/**
	 * Sets the XMLValidator array
	 * @param array $ruleSet XMLValidator array
	 */
	function setRuleSet($ruleSet) {
		$this->ruleSet = $ruleSet;
	}
}

?>