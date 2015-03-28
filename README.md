# Twitch-Subscriber-Area
A PHP-based project to simplify a subscriber area for partnered streamers on Twitch.

# Introduction
The main idea came from a project I did for [IwinUloseLOL](http://www.twitch.tv/iwinuloselol), where his subscribers could get certain information from his website without having to send a PM if there was a new subscriber. The website basically allows subscribers to connect via Twitch and get certain subscriber information (as a perk) this way.

Moving further on, I made a [similar website](https://blacklist.rocks/) that would give access if someone was subscribed to any partnered streamer in [The Blacklist](http://www.twitch.tv/team/theblacklist). Meaning you would only have to be subscribed to one member to get access to the subscriber area.

The point of this project specifically, is to create something similar for others to use as well, but without them having to do it all from scratch.

# Requirements
- Apache web server (*Note:* This isn't necessarily a requirement, but it has only been properly tested in Apache environments).
- PHP 5.5+ (PHP 5.5 was the test version - Earlier versions may work just as fine, but it requires *at least* PHP 5.0).
- cURL and MySQLi extensions for PHP.
- A MySQL database.
- A [Twitch developer application](http://www.twitch.tv/settings/connections) registered with the client ID and client secret (redirect URL will be explained on the installation page).

# Installation
Before installation, it's recommended to have a MySQL database ready with the information, as well as your Twitch developer application info (client ID + client secret).  
Upload the files to your web server, and navigate to it. It should automatically redirect you to the install page.

# Credits
- [Bootstrap](http://getbootstrap.com/) and [jQuery](https://jquery.com/) - Licenses: [Bootstrap License (MIT License)](https://github.com/twbs/bootstrap/blob/master/LICENSE) - [jQuery License (MIT License)](https://jquery.org/license/)
- [Twitch (Kraken) API](https://github.com/justintv/Twitch-API)

# Other notes
- The design behind this project is based heavily around [Bootstrap](http://getbootstrap.com/), which may be an issue for those who already have an existing website with an existing design they wish to use. I would recommend checking out [Bootswatch](https://bootswatch.com/) if you wish to take a look at some alternative layouts, if you are not able to extract the code from this project into the current design.
- Connection to the Twitch API is done through a modified version of [another project](https://github.com/Decicus/Twitch-API-PHP) I have.

# License
This is licensed under [MIT License](https://github.com/Decicus/Twitch-Subscriber-Area/blob/master/LICENSE), which basically says; "Do what you want, just don't sue me if anything goes wrong."

# Contact
Bugs/issues should go on the "Issues" page most of the time. Other questions or inquiries can be sent via the following methods:
- [Twitter (@Decicus)](https://twitter.com/Decicus)
- [Email (alex@thomassen.xyz)](mailto:alex@thomassen.xyz)
- [Twitch (Decicus)](http://www.twitch.tv/Decicus)
