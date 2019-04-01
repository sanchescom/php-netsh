<?php

namespace Sanchescom\Utility\Netsh;

/**
 * Class Wlan.
 * @method static addProfile(string $fileName, string $interface = null, string $user = null) Adds a WLAN profile to the specified interface on the computer.
 */
class Wlan
{
    protected static $utility = 'netsh';

    /**
     * Adds a wireless network, by Service Set Identifier (SSID)
     * and network type, to the wireless allowed or blocked list.
     *
     * @param string $permission
     * @param string $ssid
     * @param string $networkType
     *
     * @return string
     */
    public static function addFilter(string $permission, string $ssid, string $networkType)
    {
        return self::getCommand(__METHOD__, [
            'permission' => $permission,
            'ssid' => $ssid,
            'network_type' => $networkType,
        ]);
    }

    protected static function getCommand(string $method, array $properties = [])
    {
        $stack = array_merge([
            static::$utility,
            strtolower(__CLASS__),
            self::splitMethodName($method),
        ], self::implodeProperties($properties));

        return implode(' ', $stack);
    }

    protected static function splitMethodName(string $method)
    {
        return implode(' ', preg_split('/(?=[A-Z])/', $method));
    }

    protected static function implodeProperties(array $properties = [])
    {
        return array_map(
            function ($value, $property) {
                return sprintf("%s='%s'", $property, $value);
            },
            $properties,
            array_keys($properties)
        );
    }
}

Wlan::addProfile('');
