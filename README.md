# Twitch-Subscriber-Area
A PHP-based project to simplify a subscriber area for partnered streamers on Twitch.

# Introduction
The main idea came from a project I did for [IwinUloseLOL](http://www.twitch.tv/iwinuloselol), where his subscribers could get certain information from his website without having to PM him or something like that. They just clicked a button, authorized the application in the Twitch API and then they would get access if they were subscribed.

Moving further on, I made a [similar website](https://blacklist.rocks/) that would give access if someone was subscribed to any partnered streamer in [The Blacklist](http://www.twitch.tv/team/theblacklist). Meaning you would only have to be subscribed to one member to get access to the subscriber area.

The point of this project is to create something similar for others to use as well, but without having to know how to program it all.

# Requirements
- Apache web server (*Note:* This isn't necessarily a requirement, but it has only been properly tested in Apache environments).
- PHP 5.5+ (PHP 5.5 was the test version - Earlier versions may work just as fine, but it requires *at least* PHP 5+).
- cURL and MySQLi extensions for PHP.
- A MySQL database.
- A [Twitch developer application](http://www.twitch.tv/settings/connections) registered with the client ID and client secret (redirect URL will be explained on the installation page).

# Installation
Before installation, it's recommended to have a MySQL database ready with the information, as well as your Twitch developer application info (client ID + client secret).  
Upload the files to your web server, and navigate to it. It should automatically redirect you to the install page.

# Credits
- [Bootstrap](http://getbootstrap.com/) and [jQuery](https://jquery.com/) - Licenses: [Bootstrap License (MIT License)](https://github.com/twbs/bootstrap/blob/master/LICENSE) - [jQuery License (MIT License)](https://jquery.org/license/)
- [Twitch (Kraken) API](https://github.com/justintv/Twitch-API)
