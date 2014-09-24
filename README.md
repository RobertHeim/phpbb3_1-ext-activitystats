phpbb31-ext-activitystats
=========================

phpBB 3.1 extension that displays statistics of the latest activities on the boards index site.

This extension is the 3.1.x version of the [3.0.x Activity Stats MOD](https://www.phpbb.com/customise/db/mod/activity_stats_mod/) merged with [3.0.x Who was here? MOD](https://www.phpbb.com/customise/db/mod/nv_who_was_here/).

## Features

* adjust the timespan that is considered for calculating the "lately" activities in ACP
* show count of new topics, new posts and newly registered users in that timespan ("Activity Stats")
* list of useres who have been active lately ("Who was here?")
* en-/disable new topics in the list (adjustable in ACP)
* en-/disable new posts in the list (adjustable in ACP)
* en-/disable new users in the list (adjustable in ACP)
* en-/disable bots in the list (adjustable in ACP)
* en-/disable hidden users in the list (adjustable in ACP)
* en-/disable guests in the record (adjustable in ACP)
* en-/disable visit-time in the list or as "hover" on the name (adjustable in ACP)
* display and store the record (in ACP)
* reset-function (in ACP)
* time is displayed with user-timezone and dst(daylight-saving-time) adjustment of the ucp
* usernames are coloured
* Data is cached to improve performance (cache-time adjustable in ACP)
* permission who can see the stats:  
  Disabled (default)=everybody can always see the stats (permission is ignored).  
  Enabled=use user permission like configured in ACP. It can be assigned to users and/or groups. By default its assigned to the roles ROLE_ADMIN_FULL, ROLE_USER_FULL, ROLE_USER_STANDARD.  

## Installation

### 1. clone
Clone (or download an move) the repository into the folder phpBB3/ext/robertheim/activitystats:

```
cd phpBB3
git clone https://github.com/RobertHeim/phpbb3_1-ext-activitystats.git ext/robertheim/activitystats/
```

### 2. activate
Go to admin panel -> tab customise -> Manage extensions -> enable Activity Stats

### 3. configure
Go to admin panel -> tab Extensions -> Activity Stats -> Settings

## Support

https://www.phpbb.com/community/viewtopic.php?f=456&t=2262141
