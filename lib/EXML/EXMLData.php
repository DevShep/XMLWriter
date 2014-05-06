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

/**
 * Object to store XML-related data including data, root, and validation ruleSet
 *
 * XMLData hosts the data to be converted into XML as well as rules to easily 
 * decide what is included in the final XML document and to validate the data.
 * @todo  write example code
 */
class EXMLData implements iEXMLData {

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
	 * Validator for the data 
	 * @var EXMLValidator
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
	 * Returns the EXMLValidator
	 * @return EXMLValidator
	 */
	function getRuleSet() {
		return $this->ruleSet;
	}

	/**
	 * Sets the EXMLValidator
	 * @param EXMLValidator $ruleSet EXMLValidator
	 */
	function setRuleSet($ruleSet) {
		$this->ruleSet = $ruleSet;
	}
}

?>