# swiss-historic-events
This module provides historical facts (in German language) for [webtrees](https://www.webtrees.net/) - Historic Events: Switzerland
based on data from Peter Jehli-Kamm, baum.jehli.ch

## System requirements
Same as [webtrees#system-requirements](https://github.com/fisharebest/webtrees#system-requirements).

Tested with 2.0.11 version of webtrees.

## Installation
1. Make database backup
1. Download the [latest release](https://github.com/hartenthaler/swiss-historic-events/releases/latest)
1. Unzip the package into your `webtrees/modules_v4` directory of your web server
1. Rename the folder to `swiss-historic-events`

## Usage
Activate this module as an admin (in Control Panel/Modules/Individual page/Historic events).

For wikipedia links in the notes markdown formatting is used; this should be enabled for your tree. See Control panel/Manage family trees/Preferences and then scroll down to "Text" and mark the option "markdown".
If markdown is disabled the links are still working, but the formatting isn't so nice.

Select as user "Historic events" at the "Facts and events" tab.