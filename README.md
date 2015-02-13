# KirschnBot
A simple NodeJS IRC Bot for Twitch.tv

## Setup
  
  Dependencies:
  
   - NodeJS
   
   `` sudo apt-get install nodejs ``
   
   - Node
   
   ``sudo apt-get install node npm``
   
   - node-irc
   
   ``npm install irc``
   
 Configuration:
  - Open `` bot.js ``
  - Edit the first four lines
  
    ``var IRCSERVER = 'irc.twitch.tv';``
    
    ``var USERNAME = 'kirschnbot';``
    
    ``var PASSWORD = '';``
    
    ``var CHANNEL = '#kirschnkiller'; ``
    
 Userlevels:
 
   1: Global Admin
   
   2: Streamer
   
   3: Admin
   
   4: Mod
   
   5: Regular
   
   6: Not set
   
   Configure the lists in ``users/[group].txt``.
   
   A list looks like this:
   
   ``kirschnkiller,kirschnbot,yourusername``
   
## Basic commands
 - !addcom [name] [userlevel] ||| [response]
  
  Creates a new command
  
  _use $query for everything after the command_
   > User: !addcom test2 4 ||| You said $query
   
   > User: !test2 TEST6
   
   > Bot: User -> You said TEST6
   
   
 - !renamecom [oldname] [newname]

 Renames a command into [newname]
 
 - !removecommand [name]
 
  Removes a command
 
 - !reinit
  
  Reload the users and the commands 

- !info

  Returns some informations
