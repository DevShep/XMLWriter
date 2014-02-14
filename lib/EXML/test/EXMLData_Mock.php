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

use EXML\EXMLRuleSet;


/**
* 
*/
class EXMLData_Mock implements iEXMLData
{
	private $data =  array(
		'first-name' => 'John',
		'last-name' => 'Smith',
		'middle-initial' => 'E',
		'phone' => '304-555-1234',
		'title' => 'Director',
		'address' => array(
			'street-1' => '15th W St.',
			'street-2' => 'Apt 105',
			'city' => 'Farmvegas',
			'state' => 'Virginia',
			'zip' =. '23943'
			),
		'birthdate' => '1980-03-12',
		'hours' => new EXMLElementMock(),
		'rate' => 30.25
	);

	private $root = 'employee';

	private $ruleSet = array(
		1 => new EXMLValidator_Mock(),
		2 => new EXMLValidator_Mock(),
		3 => new EXMLValidator_Mock(),
	);

	function getData() {
		return $this->data;
	}
	function getRoot() {
		return $this->root;
	}
	function getRuleset() {
		return $this->ruleSet;
	}
}
?>
