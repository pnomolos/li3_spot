<?php
namespace li3_spot\types;
use \Spot\Entity;

class Serialized implements \Spot\Type\TypeInterface
{
    /**
     * Cast given value to type required
     */
    public static function cast($value)
    {
        if(null !== $value) {
            return $value;
        }
        return $value;
    }

    /**
     * Geting value off Entity object
     */
    public static function get(Entity $entity, $value)
    {
        return self::cast($value);
    }

    /**
     * Setting value on Entity object
     */
    public static function set(Entity $entity, $value)
    {
        return self::cast($value);
    }
}
