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
 * A container class used to hold XMLValidator objects
 *
 * @since 1.0
 * @author Jacob Haines <jacob.k.haines@gmail.com>
 * @todo  When finalizing the exception class name, correct documentation
 */
final class EXMLRuleSet implements iEXMLValidator {

	/**
	 * Array of EXMLValidator objects
	 * @var array
	 */
	protected $validators;

	/**
	 * If set to true, any EXMLExceptions thrown by a validator will not be caught by the validate method
	 * @var boolean
	 */
	private $throwExceptions = false;

	/**
	 * Accepts either an array of EXMLValidator objects OR variable amount of XMLValidators
	 * @param mixed  must either be a single array of XMLValidators OR variable amount of XMLValidators
	 * @throws VXMLException If an element of the array or argument passed is not an XMLValidator
	 */
	function __construct()	{
		$this->setValidators(func_get_args());
	}

	/**
	 * Returns the Ruleset's EXMLValidators as an array
	 * @return array array of EXMLValidator objects
	 */
	function getValidators() {
		return $this->validators;
	}

	/**
	 * Accepts either an array of XMLValidator objects OR variable amount of XMLValidators; replaces existing validator array
	 * @param mixed  must either be a single array of XMLValidators OR variable amount of XMLValidators
	 */
	function setValidators($args) {
		$this->validators = array();

		if (is_array($args[0])) {
			$args = $args[0];
		}

		foreach ($args as $value) {
			$this->addValidator($value);
		}
	}

	/**
	 * Adds an EXMLValidator to the ruleSet
	 * @param iEXMLValidator $validator object that implements iXMLValidator interface
	 * @throws EXMLException If $validator is not of type iXMLValidator
	 */
	function addValidator($validator) {
		if (!($validator instanceof iEXMLValidator)) {
			throw EXMLException::invalidObjectInstance('iEXMLValidator');
		}

		$this->validators[] = $validator;
	}

	/**
	 * Runs through the validator array and validates data; returns true if all pass; will catch VXMLExceptions from validators and return false if $this->throwExceptions is false
	 * @param  array $data DataMap from iXMLData; normally handled internally
	 * @return bool          true if all validators pass; false otherwise (may pass on exception instead)
	 * @throws EXMLException If $this->throwExceptions is true AND a validator throws an VXMLException
	 */
	function validate($data) {
		foreach ($this->$validators as $validator) {
			try {
				if (!$validator->validate($data) {
					return false;
				}
			} catch (EXMLException $e) {
				if ($this->throwExceptions) {
					throw new EXMLException("EXMLRuleset caught EXMLException during validation.", 0, $e);
				} else {
					return false;
				}
			}
			
		}

		return true;
	}
}

?>