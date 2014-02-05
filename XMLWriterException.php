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

use Exception;

/**
* Base exception class for XMLWriter library
*/
class XMLWriterException extends Exception
{
	public static function unMappedKey($key) {
		return new self("Key $key is not defined in the requirement map.");
	}

	public static function unsetKey($key, $map) {
		return new self("Key $key is not defined in the $map map.");
	}

	public static function inequivalentLengths($map) {
		return new self("The $map map's element count does not match the requirment map's element count.");
	}

	public static function undefinedRequiredElement($key) {
		return new self("Required element $key is not defined.");
	}

	public static function incorrectDataType($key, $expected, $given) {
		return new self("For element $key, expected $expected, $given given.");
	}

	public static function maxLengthViolation($key, $expected, $given) {
		return new self("Element $key is too long. Expected a length of $expected; received a length of $given.");
	}

	public static function unsetReqMap($map) {
		return new self("Unset requirement map. Cannot use $map validations.");
	}

	public static function invalidObjectInstance($type) {
		return new self("Object must be an instance of $type.");
	}
}

?>

?>