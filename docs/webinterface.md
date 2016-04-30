Bedienung des KirschnBot über das Webinterface.

# Webinterface Übersicht

## Commands
	
## Command Overview

Übersicht über Alle Commands.	

- Command:	Entsprechender Chat Command (zB. !test).
-  Return:		Text und Paramter die der Bot Ausgibt (zB. Ich bin ein Command).
-  Userlevel:	Userlevel das zum Ausführen des Commands benötigt wird.
-  Actions:	 Möglichkeit das entsprechende Command zu Editieren & Löschen oder es per Wisper auszugeben.


## Add Command

##### Möglichkeit ein Command zu erstellen.
	
-  Command:		Feld zum eintragen des Entsprechenden Commands (zB. !DeinCommand) <b>WICHTIG</b>: Das Command muss mit einem "!" beginnen.
-  Userlevel*:		Dropdown Menü zum Auwählen des Userlevels welches zum Ausführen des Command benötigt wird.
-  Command Text:	Feld zum eintragen des Textes und der Parameter die beim Auführen des Command ausgegeben werden
		

### Mögliche Userlevel

- "Everyone"		- Alle können diesen Command benutzen
- "Subscriber"	- Nur Subscriber, Moderator und der Streamer können diesen Command benutzen.
- "Moderator"		- Nur Moderator und der Streamer können diesen Command Benutzen.
- "Streamer"		- Nur der Streamer kann diesen Command benutzen.
- "Custom"		- Nur Viewer mit einem Custom Userlevel können diesen Command benutzen (kann unter "Users" festgelegt werden)
			
			
### Weitere Parameter

Parameter um Commands individuell an zu passen.
Index ist hierbei ein numerischer Wert und gibt die Position des Wortes im Kommando aus.
	
- $query - 
  Gibt alles aus was der User hinter !Command schreibt
- $user - 
  Gibt den Usernamen des Users wieder der denn !Command ausführt
- $[http(https://webseite.com)] - 
  Gibt den Source Code der gewählten Webseite wieder
- $rngnumber(min,max) - 
  Gibt eine Zufällige Nummer zwischen Min und Max wieder
- $[rnglist(listname)] - 
  Gibt ein Zufälliges Item aus der Angegebenen Liste wieder (Listen und Items können unter "Items" angelegt werden)
- $[index] - 
  Gibt ein Spezifisches Wort aus der Eingabe Nachricht wieder
- $[index]elserngnumber(min,max) - 
  Wenn spezifisches Wort nicht gegeben ist wird eine zufällige ganze Zahl zwischen min und max ausgegeben
- $[index]elsernglist(listname) - 
  Wenn spezifisches Wort nicht gegeben ist wird ein zufälliges Objekt aus der Liste listname ausgegeben     
- $queryelseuser - 
- $queryelsernglist(listname) - 
	
		
<hr>

## Users

Configuration:

### Einstellen der Userlevel.
	
> "Read your moderators from the Twitch Chat:"
> Auswählen ob Userlevel die den Moderator Status haben Automatisch aus dem Twitch Chat gelesen werden.

> "Standard userlevel for your mods:"
> Festlegen des Nummerischen Wert des Userlevels "Moderator" innerhalb des Bots.

> "Standard userlevel for your subscribers:"
> Festlegen des Nummerischen Wert des Userlevels "subscriber" innerhalb des Bots.

> "Standard userlevel for your Viewers:"
> Festlegen des Nummerischen Wert des Userlevels "Viewer" innerhalb des Bots.
		
> Custom Userlevel:
> Übersicht über die Angelegeten Custom Userlevel und Möglichkeit diese zu Löschen.
				
> Add User:
> Usern bestimmte Userlevel zuordnen und Custom Userlevel erstellen (Custom Userlevel haben immer einen numerischen Wert).
		
		
<hr>

## Anti-Spam

### Filter

#### Einstellen welche Filter Aktiv sein sollen.

- Auto-Timeout URLs in your chat:
 Aktiviert den Linkfilter im Chat.

-  Auto-Timeout blacklisted phrases in your chat:
 Aktiviert den Blacklistfilter im Chat.
		
		
#### Link Filter

 Einstellen des Link Filters.
	
- Timeout length:
		Definiert die Länge die der Bot Timeoutet wenn ein Link gepostet wird
		(Längen: Purge (1sec), 1 Minute, 5 Minuten, 10 Minuten, 30 Minuten)
		
- Send Timeout Notification:
		Aktivieren der Nachricht wenn der Bot durch den Linkfilter Timeoutet
		
- Timeout text:
		Nachricht die angezeigt wird wenn der Bot durch den Linkfilter Timeoutet
		
		
- Link Whitelist:
	Links die bei Aktiviertem Linkfilter nicht Automatisch Timeouted werden.
	
	
- Add Whitelisted Link:
	Möglichkeit URLs in die Whitelist einzutragen
	
	
- Blacklist Filter:
	Einstellen des Blacklist Filters.
	
- Timeout length:
		Definiert die Länge die der Bot Timeoutet wenn ein Wort/Satz auf der Blacklist gepostet wird
		(Längen: Purge (1sec), 1 Minute, 5 Minuten, 10 Minuten, 30 Minuten)
		
- Send Timeout Notification:
		Aktivieren der Nachricht wenn der Bot ein Wort/Satz auf der Blacklist Timeoutet
		
- Timeout text:
		Nachricht die angezeigt wird wenn der Bot ein Wort/Satz auf der Blacklist Timeoutet
		
		
- Phrase Blacklist:
	Wörter/Sätze die bei Aktivierter Blacklist Automatisch Timeouted werden.
	
	
- Add Blacklisted Phrase:
	Möglichkeit Wörter/Sätze in die Blacklist einzutragen
		
		
<hr>

## Quotes

### Quote Overview

Übersicht über Alle Quotes.
	
- Name:		Name des Quotes der benötigt wird um den Quote im Chat Direkt auf zu rufen (Beispiel: !quote 0).
- Quote:		Der Entsprechende Quote den der Bot Ausgeben kann.
- Created by:	Name ders Users der den Quote angelegt hat.
- Actions:	Möglichkeit Den entsprechenden Quote zu Editieren oder Löschen
		
		
#### Add Quote

Möglichkeit ein Quote zu erstellen

- Quote Name:	Feld zum eintragen des Entsprechenden QuoteNamen um diesen direkt im Chat ab zu Rufen (Beispiel: !Quote QuoteName).
- Quote Text:	Feld zum eintragen des QuoteTextes der im Chat augegeben wird.

<hr>

### Items

#### List & Item Overview

Übersicht über Alle Listen und die Enthaltenen Items.
	
- Filter:  Dropdown Menü zum Filtern der Listen.
- List:	 Name der Listen der die Items zugeordnet sind die dann über den Command Paramter "$[rnglist(listname)]" ausgegeben werden können.
- Wenn spezifisches Wort nicht gegeben ist wird eine zufällige ganze Zahl zwischen min und max ausgegeben
- Item:	 Item der Entsprechenden Liste das der Bot Ausgeben kann.
- Actions: Möglichkeit das Entsprechende Item zu Editieren oder Löschen (Leere Listen sollten Automatisch gelöscht werden).
		
		
#### Add Item

Möglichkeit Listen und Items zu Erstellen

- List:	Feld zum Auswählen in Welche Liste das Item erstellt werden soll
				(Ist die Liste noch nicht vorhanden wird sie Erstellt)
- Item:	Feld zum Eintragen eines Items in die Oben angegebene Liste
		
<hr>

### Settings

#### Custom Chataccount

Möglichkeit einen Custom Chataccount für den KirschnBot zu Nutzen.
	
- Username:	 Feld zum Eintragen des Usernamens des zu Nutzenden Bot Accounts.
- OAuth Token: Feld zum Eintragen des OAuth-Token des zu Nutzenden Bot Accounts.
(OAuth-Token Generieren: https://twitchapps.com/tmi/ Aufrufen und mit dem zu Nutzenden Bot Account einloggen)
- Reset to "KirschnBot":	Schaltfläche um wieder den Standard Bot Account "KirschnBot" zu nutzen.
		
		
#### Confirmed Users

Übersicht über Alle User die vollen Zugiff auf das Eigene Bot Webinterface haben
	
- Username:	 Twitchname der User die Vollen zugriff auf das Webinterface haben
- Actions:	 Möglichkeit die Rechte für den Vollzugriff zu Entziehen
	
	
#### Add Confirmed User

Möglichkeit Bestimmten Usern zugriff auf das Bot Webinterface zu geben.
	
- Username:	 Feld zum eintragen des Twitchnamen des Users der vollen Zugriff auf das Webinterface haben soll.
