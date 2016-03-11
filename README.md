# KirschnBot
KirschnBot is a Node.js based Twitch Chat moderation bot. To be clear: This Repository is not here to build your own, just to have it open source!
Well if you like to set up an own instance - have fun! Probably not a single line code is documented :P

The bot uses the node-irc framework to connect to the Twitch IRC and uses three IRC Clients. One for the main IRC connection, one for the AWS Cluster
and the third one for the Whisper feature (you have to connect to the group chat IRC to whisper).

The Database runs on MySQL and has the capability to connect to multiple servers or clusters.

For more information, just look here: http://kirschnbot.tk
