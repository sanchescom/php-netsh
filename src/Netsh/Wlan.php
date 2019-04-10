<?php

namespace Sanchescom\Utility\Netsh;

use Sanchescom\Utility\Command;

/**
 * Class Wlan.
 */
class Wlan
{
    /**
     * @var string Netsh command
     */
    private const WLAN = 'wlan';

    /**
     * Adds a wireless network, by Service Set Identifier (SSID)
     * and network type, to the wireless allowed or blocked list.
     *
     * @param string $permission Specifies the permission type of the filter.
     * @param string $ssid SSID of the wireless network.
     * @param string $networkType Specifies the wireless network type.
     *
     * @return string
     */
    public static function addFilter(string $permission, string $ssid, string $networkType)
    {
        return Command::make(self::WLAN, __FUNCTION__, [
            'permission' => $permission,
            'ssid' => $ssid,
            'network_type' => $networkType,
        ]);
    }

    /**
     * Adds a WLAN profile to the specified interface on the computer.
     *
     * @param string $fileName Specifies both the path to, and name of the XML file containing the profile data.
     * @param string|null $interface Specifies the name of the wireless interface on which to add the profile
     * (where InterfaceName is the name of the wireless interface, as listed in Network Connections, or as rendered
     * by the netsh wlan show interfaces command)
     * @param string|null $user Specifies whether the profile is applied only to the current user or to all users.
     *
     * @return Command
     */
    public static function addProfile(string $fileName, string $interface = null, string $user = null)
    {
        return Command::make(self::WLAN, __FUNCTION__, [
            'filename' => $fileName,
            'interface' => $interface,
            'user' => $user,
        ]);
    }

    /**
     * Connects to a wireless network by using the specified parameter.
     *
     * @param string $name Specifies the name of the wireless profile to use for the connection attempt, (where
     * ProfileName is the name of the wireless profile, as listed in Manage Wireless Networks, or as rendered
     * by the netsh wlan show profiles command).
     * @param string $interface Specifies the wireless interface to use for the connection attempt, (where
     * InterfaceName is the name of the wireless interface, as listed in Network Connections, or as rendered
     * by the netsh wlan show interfaces command).
     * @param string|null $ssid Specifies the SSID of the wireless network.
     *
     * @return Command
     */
    public static function connect(string $name, string $interface, string $ssid = null)
    {
        return Command::make(self::WLAN, __FUNCTION__, [
            'name' => $name,
            'ssid' => $ssid,
            'interface' => $interface,
        ]);
    }

    /**
     * Disconnects the specified interface from a wireless network.
     *
     * @param string $interface Specifies the wireless interface to use for the connection attempt, (where
     * InterfaceName is the name of the wireless interface, as listed in Network Connections, or as rendered
     * by the netsh wlan show interfaces command).
     *
     * @return Command
     */
    public static function disconnect(string $interface)
    {
        return Command::make(self::WLAN, __FUNCTION__, [
            'interface' => $interface,
        ]);
    }

    /**
     * Displays a list of wireless networks that are visible on the computer.
     *
     * @param string|null $interface Specifies for which interface the network information is returned,
     * (where InterfaceName is the name of the wireless interface, as listed in Network Connections, or
     * as rendered by the netsh wlan show interfaces command).
     * @param string|null $mode Specifies whether to display information for Basic Service Set
     * Identifier (BSSID), or Service Set Identifier (SSID).
     *
     * @return Command
     */
    public static function showNetworks(string $interface = null, string $mode = null)
    {
        return Command::make(self::WLAN, __FUNCTION__, [
            'interface' => $interface,
            'mode' => $mode,
        ]);
    }

    /**
     * Displays a list of the current wireless interfaces on a computer.
     *
     * @return Command
     */
    public static function showInterfaces()
    {
        return Command::make(self::WLAN, __FUNCTION__);
    }
}
