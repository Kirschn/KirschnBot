Usage of the KirschnBot-Webinterface

# Webinterface Overview

## Commands

### Command overview

##### List of all commands

- **Command:** the chat command itself (i.e. !test)
- **Return:** the text and parameters returned by the bot (i.e. I am a command)
- **Userlevel:** the userlevel needed to execute the command
- **Actions:** options to edit, delete the selected command, also you can set the response of the command to return as a whisper
 
##### Add Command

option to add a command to the bot

- **Command:** field to set the name of the command (i.e. !YourCommand)  
    **Important:** The name of the command **must** beginn with an exclamation point ("!")!
- **Userlevel:** dropdown menu to set the userlevel needed to execute the command
- **Command text:** field to add the response the command will return when triggered

##### possible userlevels

- **Everyone** - all users are able to trigger the command
- **Subscriber** - the command can be triggered by subscribers, moderators and the streamer
- **Moderator** - the command can be triggered by moderators and the streamer
- **Streamer** - the command can only be triggered by the streamer
- **Custom** - only users with the set userlevel or higher can trigger the command (the userlevels can be set in the "Users" menu)

##### Command Parameters

Paramters can be used to customize the response of the command.

- **$query** - returns erverything written after the command itself (i.e. "!Command test" - here the $query will return "test")
- **$user** - returns the username of the user who triggered the command
- **$[http(https://website.com)]** - returns the body of the given website
- **$rngnumber(min,max)** - returns a random number between the min and max value
- **$[rnglist(listname)]** - returns a random item from the list given in the parameter (Lists and items can be set in the "Items" menu)
- **$[index]** - returns the word in the given position after the command (**Caution:** the index value must be numeric!)
- **$[index]elserngnumber(min,max)** - when the parameter at the specified position is not given, the command will return a random number
- **$[index]elsernglist(listname)** - when the parameter at the specified position is not given, the command will return a random item from the given list
- **$queryelseuser** - the command will return the user who triggered the command, if there is no parameter given
- **$queryelsernglist(listname)** - the command will return a random item from a list, if there is no parameter given

---

## Users

##### setting the userlevels

- **Read your moderators from the Twitch Chat:** Option to decide if userlevel will try to determine the moderator status automatically from the  twitch chat
- **Standard userlevel for your mods:** sets the numeric value of the "Moderator" userlevel for the bot
- **Standard userlevel for subscribers:** sets the numeric value of the "Subscriber" userlevel for the bot
- **Standard userlevel for your viewers:** sets the numerical value of the "Viewer" userlevel for the bot
- **Custom userlevel:** list of all set custom userlevels and the option to delete them
- **Add User:** set specific userlevels for certain users and create custom userlevels (custom userlevels are always numeric values)

---

## Anti-Spam

##### Filter
set which filters are active

-  **Auto-Timeout URLs in your chat:** activates the linkfilter for your chat
-  **Auto-Timeout blacklisted phrases:** activates the filter for blacklisted phrases in your chat
  
##### Link Filter
Setup for the link filter

- **Timeout length:** Defines the duration of the timeout the bot will issue if a link is posted (possible Durations: Purge (1 second), 1 minute, 5 minutes, 10 minutes, 30 minutes)
- **Send Timeout Notification:** a notification is sent when a timeout is triggered by the filter
- **Timeout Text:** Text of the notification that will be sent when the timeout is triggered
- **Link Whitelist:** A List of Links, that are allowed to be posted in chat
- **Add Whitelisted link:** Otion to add URLs to the whitelist

##### Blacklist Filter
Setup of the blacklist filter

- **Timeout length:** Defines the duration of the timeout the bot will issue if a link is posted (possible Durations: Purge (1 second), 1 minute, 5 minutes, 10 minutes, 30 minutes)
- **Send Timeout Notification:** a notification is sent when a timeout is triggered by the filter
- **Timeout Text:** Text of the notification that will be sent when the timeout is triggered
- **Phrase Blacklist:** words/phrases which will be timeouted if they are posted in the chat
- **Add blacklisted Phrase:** Option to add words/phrases to the blacklist

---

## Quotes

###### Quote Overview

List of all saved quotes

- **Name:** Name used for the quote *(You can query the specific quote by name with **!quote <name>**)*
- **Quote:** the quote itself
- **Created by:** The user who added that quote to the list
- **Actions:** Options to edit or delete the quote

##### Add Quote

Option to add a quote to the list

- **Quote Name:** Field to enter the name of the quote
- **Quote Text:** Field to enter the text of the quote
 
---

## Items

##### List & Item overview

overview of all lists and the items they contain

- **Filter:** dropdown menu to select a specific list
- **List:** name of the list which items can be queried by the command parameter *( $[rnglist(<listname>)] )*
- **Item:** Item which is contained in the list
- **Actions:** Options to edit or delete the listitem
 
##### Add Item

Option to add an item to a given list (also to create the list itself)

- **List:** Field to chose a list (the list will be automatically created if it doesn't exist)
- **Item:** Field to enter an item which will be added to the list
 
---

## Settings

##### Custom Chataccount

Option to use the KirschnBot with a custom chataccount

- **Username:** Field to enter the username of the account
- **OAuth-Token:** Field to enter the OAuth-Token needed to authenticate KirschnBot on Twitch (The OAuth-Token can be generated here: [Twitch Chat OAuth Password Generator](https://twitchapps.com/tmi/) )
- **Reset to "KirschnBot":** button to reset the bot to the KirschnBot-account
 
##### Confirmed Users

list of all users who can have full access to the KirschnBot webinterface

- **Username:** Twitch-username of the confirmed user
- **Actions:** Option to remove the accessrights of the confirmed user
- 
##### Add Confirmed User

otion to add a user to grant full access to the webinterface

- **Username:** Twitch-username to add
