# Twitch-Subscriber-Area
A PHP-based project to simplify a subscriber area for partnered streamers on Twitch.

# Introduction
The main idea came from a project I did for [IwinUloseLOL](http://www.twitch.tv/iwinuloselol), where his subscribers could get certain information from his website without having to send a PM if there was a new subscriber. The website basically allows subscribers to connect via Twitch and get certain subscriber information (as a perk) this way.

Moving further on, I made a [similar website](https://blacklist.rocks/) that would give access if someone was subscribed to any partnered streamer in [The Blacklist](http://www.twitch.tv/team/theblacklist). Meaning you would only have to be subscribed to one member to get access to the subscriber area.

The point of this project specifically, is to create something similar for others to use as well, but without them having to do it all from scratch.

# Requirements
- Apache web server (*Note:* This isn't necessarily a requirement, but it has only been properly tested in Apache environments).
- PHP 5.5+ (PHP 5.5 was the test versions - Earlier versions may work just as fine, but it requires *at least* PHP 5.0).
- cURL and MySQLi extensions for PHP.
- A MySQL database.
- A [Twitch developer application](http://www.twitch.tv/settings/connections) registered with the client ID and client secret (redirect URL will be explained on the installation page).

# Installation
Before installation, it's recommended to have a MySQL database ready with the information, as well as your Twitch developer application info (client ID + client secret).  
Upload the files to your web server, make sure the web server user has the correct permissions to the folder and the sub-folders to create a config file (only necessary if you get an error saying "Cannot create config...") and navigate to the directory you uploaded the files to. It should automatically redirect you to the install page.

# Credits
- [Bootstrap](http://getbootstrap.com/)
    - License: [Bootstrap License (MIT License)](https://github.com/twbs/bootstrap/blob/master/LICENSE)
- [Twitch (Kraken) API](https://github.com/justintv/Twitch-API)

# Other notes
- The design behind this project is based heavily around [Bootstrap](http://getbootstrap.com/), which may be an issue for those who already have an existing website with an existing design they wish to use. I would recommend checking out [Bootswatch](https://bootswatch.com/) in case you want to take a look at some alternative layouts, if you are not able to extract the code from this project into the current design. (Take a look at [Themes](#themes) for more info on how you can change the layout)
- Connection to the Twitch API is done through a modified version of [another project](https://github.com/Decicus/Twitch-API-PHP) I have.
- I'm aware this could be done differently and better in a lot of ways. One day I hope to come back to this project and rewrite it all into more efficient and developer-friendly code as a "2.0". Although, that may not happen anytime soon.
- Keep in mind this is meant for users that have a domain and web hosting they wish to use. If not, [SubsOnly](https://subsonly.com/) may be a better alternative.
- This has been tested under the following environments:
    - Apache 2.4.9, MySQL server 5.6.17, PHP 5.5.12 (Windows 7 64-bit & Windows 8.1 64-bit)
    - Apache 2.4.10, MySQL server 5.5.43, PHP 5.5.12 (Ubuntu 14.10)

# License
This is licensed under [MIT License](https://github.com/Decicus/Twitch-Subscriber-Area/blob/master/LICENSE), which basically says; "Do what you want, just don't sue me if anything goes wrong."

# Contact
Bugs/issues should go on the "Issues" page most of the time. Other questions or inquiries can be sent via the following methods:
- [Twitter (@Decicus)](https://twitter.com/Decicus)
- [Email (alex@thomassen.xyz)](mailto:alex@thomassen.xyz)
- [Twitch (Decicus)](http://www.twitch.tv/Decicus)

# Themes
Due to the fact that this is very heavily based around Bootstrap - You might dislike the current theme or think it doesn't fit the current layout of a website you have.  
The easiest way that I have found, is to visit [Bootswatch](https://bootswatch.com/) and find a theme that fits/you like.

- Click "Download" at the top, and then "bootstrap.min.css". CTRL + A (or 'Select all') this page and copy this.
- Next, open css/bootstrap-theme.min.css inside your Twitch Subscriber Area folder with Notepad/TextEdit or whatever text editor you may use. Remove everything in that file and paste what you copied earlier.
- Save, open/refresh the website and it should use the new theme (You may have to try Shift+F5 multiple times for the new theme to be updated, due to your web browser's cache).
