<?php

namespace GrafCenter\CMS\Storage;

use ArrayAccess;

/**
 * Reprezentuje pojedyńczy rekord z bazy danych
 */
abstract class Entity implements ArrayAccess
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __call($offset, $params)
    {
        throw new BadMethodCallException(
            sprintf(
                "Class (%s) does not contain method named (%s)",
                get_class($this),
                $offset
            )
        );
    }

    public function &__get($offset)
    {
        if (!isset($this->data[$offset]) and !array_key_exists($offset, $this->data)) {
            throw new UnexpectedValueException(
                sprintf(
                    "Class (%s) does not contain property named (%s)",
                    get_class($this), $offset
                )
            );
        }

        return $this->data[$offset];
    }

    public function __isset($offset)
    {
        return isset($this->data[$offset]);
    }

    public function __set($offset, $value)
    {
        if (!isset($this->data[$offset])) {
            throw new UnexpectedValueException(
                sprintf(
                    "Class (%s) does not contain property named (%s)",
                    get_class($this), $offset
                )
            );
        }
        $this->data[$offset] = $value;
    }

    public function __unset($offset)
    {
        unset($this->data[$offset]);
    }

    public function &getData()
    {
        return $this->data;
    }

    public function getProperty($property, $default = null)
    {
        if (!isset($this->data[$property])) {
            return $default;
        }

        return $this->data[$property];
    }

    public function hasData(array $data)
    {
        foreach ($data as $key => $value) {
            if (!isset($this->data[$key]) or $this->data[$key] !== $value) {
                return false;
            }
        }

        return true;
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function &offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }
}
