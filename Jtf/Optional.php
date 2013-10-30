<?php
/**
 * "Null sucks." -Doug Lea
 *
 * "I call it my billion-dollar mistake." - Sir C. A. R. Hoare, on his invention
 *                                          of the null reference
 *
 * "Careless use of null can cause a staggering variety of bugs. Studying the
 *  Google code base, we found that something like 95% of collections weren't
 *  supposed to have any null values in them, and having those fail fast rather
 *  than silently accept null would have been helpful to developers.
 *
 *  Additionally, null is unpleasantly ambiguous. It's rarely obvious what a
 *  null return value is supposed to mean -- for example, Map.get(key) can
 *  return null either because the value in the map is null, or the value is
 *  not in the map. Null can mean failure, can mean success, can mean almost
 *  anything. Using something other than null makes your meaning clear."
 *
 * http://code.google.com/p/guava-libraries/wiki/UsingAndAvoidingNullExplained
 * http://nitschinger.at/A-Journey-on-Avoiding-Nulls-in-PHP
 *
 * @category    Jtf
 *
 * @package     Jtf_Optional
 *
 * @copyright   Copyright (C) 2011 Joseph Fallon <joseph.t.fallon@gmail.com>
 *              All rights reserved.
 *
 * @license     REDISTRIBUTION AND USE IN SOURCE AND BINARY FORMS, WITH OR
 *              WITHOUT MODIFICATION, IS NOT PERMITTED WITHOUT EXPRESS
 *              WRITTEN APPROVAL OF THE AUTHOR.
 *
 *              THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY
 *              EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 *              THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 *              PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE
 *              AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *              SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 *              NOT LIMITED TO, PROCUREMENT OF  SUBSTITUTE GOODS OR SERVICES;
 *              LOSS OF USE, DATA, OR PROFITS;  OR BUSINESS INTERRUPTION)
 *              HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 *              CONTRACT, STRICT LIABILITY, OR TORT INCLUDING NEGLIGENCE OR
 *              OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *              SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */
class Jtf_Optional
{
    /* @var mixed */
    private $_reference;


    /**
     * Class Constructor
     *
     * @param $reference
     */
    protected function __construct($reference)
    {
        $this->_reference = $reference;
    }


    /**
     * This method creates and returns a new instance of the Jtf_Optional
     * class containing the specified value. If the $reference is null,
     * then an exception is immediately thrown.
     *
     * @param $reference
     * @return Jtf_Optional
     * @throws InvalidArgumentException
     */
    public static function fromNotNullable($reference)
    {
        if($reference === null)
        {
            $msg = 'Unallowed null in reference found.';
            throw new InvalidArgumentException($msg);
        }

        return new Jtf_Optional($reference);
    }


    /**
     * This method creates and returns a new instance of the Jtf_Optional
     * class containing the specified value. If the $reference is null,
     * then the null value is stored and no exception is thrown.
     *
     * @param $reference
     * @return Jtf_Optional
     */
    public static function fromNullable($reference)
    {
        return new Jtf_Optional($reference);
    }


    /**
     * This function returns true if this instance contains a non-null
     * reference and false otherwise.
     *
     * @return boolean
     */
    public function isPresent()
    {
        if($this->_reference === null)
        {
            return false;
        }

        return true;
    }


    /**
     * This function returns the object contained within this instance. If
     * this instance contains a null reference, then a RuntimeException is
     * immediately thrown.
     *
     * @return mixed
     * @throws RuntimeException
     */
    public function get()
    {
        if($this->isPresent())
        {
            return $this->_reference;
        }

        $msg = 'The contained reference is null.';
        throw new RuntimeException($msg);
    }


    /**
     * This function returns the object contained within this instance,
     * if present, and $defaultValue otherwise. If $defaultValueis null
     * then an InvalidArgumentException is immediately thrown.
     *
     * @param $defaultValue
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getOrElse($defaultValue)
    {
        if($defaultValue === null)
        {
            $msg = 'The provided value is null.';
            throw new InvalidArgumentException($msg);
        }

        if($this->isPresent())
        {
            return $this->_reference;
        }

        return $defaultValue;
    }


    /**
     * This function returns the object contained within this instance,
     * if present, and null otherwise.
     *
     * @return mixed
     */
    public function getOrNull()
    {
        if($this->isPresent())
        {
            return $this->_reference;
        }

        return null;
    }


    /**
     * This function checks for strong equality (i.e. ===) between the
     * object contained in this instance and the provided $object. If
     * $object is null, then an InvalidArgumentException is immediately
     * thrown.
     *
     * @param $object
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function equals($object)
    {
        if($object === $this->_reference)
        {
            return true;
        }

        return false;
    }
}