# Commands IRC

Bedienung des KirschnBot über den Twitchchat.

## Command Erstellen

	Parameter:	!addcom !deincommand Dein Command Text
	Beispiel:	!addcom !hallo Hallo ich bin ein Command.

Dies erstellt denn Command "**!deincommand**" der dazu führt das der Bot "**Dein Command Text**" ausgibt.
**Wichtig:** Wenn kein Userlevel angegeben wurde, wird automatisch das Userlevel für Normale User benutzt.
Dadurch kann jeder dieses Command ausführen


## Command mit Userlevel

Auch ist es Möglich ein Command einer bestimmten Usergruppe zugänglich zu machen.
Hierfür benutzt man hinter "**!addcom**" den Userlevel Parameter "**-ul=**" so hat man die Möglichkeit zu entscheiden ob ein Command nur für **Moderatoren, Subscriber oder den Streamer** zur Verfügung steht.

	Parameter:	!addcom -ul=mod !deincommand Dein Command Text
	Beispiel:	!addcom -ul=mod !hallo Hallo ich bin ein Command nur für Mods

In diesem Beispiel ist der Command "**!hallo**" nur für **Mods und den Streamer** ausführbar.
Die Parameter für die einzelnen Usergruppen sind:

- "**-ul=sub**"	- Nur Subscriber, Moderatoren und der Streamer können diesen command benutzen.
- "**-ul=mod**" - Nur Moderatoren und der Streamer können diesen command benutzen.
- "**-ul=owner**" - Nur der Streamer kann diesen command benutzen.


## Userlevel (Erweitert)

Des weiteren ist es Möglich neben der Beschreibung des Userlevels auch möglich den Nummerischen Wert zu Benutzen

	Parameter:	!addcom -ul=100 !deincommand Dein Command Text
	Beispiel:	!addcom -ul=100 !hallo Hallo ich bin ein Command nur für Mods

Auch in diesem Beispiel ist der Command "**!hallo**" nur für **Mods und den Streamer** ausführbar.
Die Standard Parameter für die einzelnen Usergruppen sind:

- "**-ul=500**"	- Nur Subscriber, Moderatoren und der Streamer können diesen command benutzen.
- "**-ul=100**" - Nur Moderatoren und der Streamer können diesen command benutzen.
- "**-ul=0**" - Nur der Streamer kann diesen command benutzen.

<hr>

## Command Editieren

**Command Text Editieren:**

	Parameter:	!editcom text !deincommand Dein Neue Command Text
	Beispiel:	!editcom text !hallo Hallo ich bin der Neue Command

Mit dem Command "**!editcom text**" ist es möglich den Ausgabe Text des Commands zu Editieren.

**Userlevel Editieren/Hinzufügen:**

	Parameter:	!editcom userlevel !deincommand moderator
	Beispiel:	!editcom userlevel !hallo moderator

Durch den Command "**!editcom userlevel**" und dem Syntax "**moderator**" hinter dem Commands Namen "**!hallo**" wird dieser Command nur für **Moderatoren und höher** benutzbar.
Natürlich ist auch hier wie bei der Erstellung neben der direkten Angabe des Userlevels auch der Nummerische Wert möglich.

	Parameter:	!editcom userlevel !deincommand 100
	Beispiel:	!editcom userlevel !hallo 100

Auch hier wird der Command "**!hallo**" nun durch den Nummerischen Wert "**100**" nur für **Moderatoren und höher** benutzbar.
Parameter für die Userlevel sind:

- "**viewer**" (Nummerischer Standard: 999)
- "**subscriber**" (Nummerischer Standard: 500)
- "**moderator**" (Nummerischer Standard: 100)
- "**streamer**" (Nummerischer Standard: 0)

<hr>

## Commands Löschen

	Parameter:	!delcom !deincommand
	Parameter2:	!removecom !deinfehl
	Beispiel:	!delcom !hallo
	Beispiel2:	!removecom !hallo

Mit dem Command "**!delcom**" / "**!removecom**" vor dem Command Namen wird in diesem Beispiel der Command "**!hallo**" gelöscht und steht dadurch nicht mehr zur Verfügung.

<hr>

## Weitere Parameter für den Command Text:

**$query - Gibt alles was der User hinter !command schreibt**

	Parameter:	!addcom !deincommand Beispieltext mit $query
	Beispiel: 	!addcom !hallo Hallo $query
	Eingabe:	!hallo an alle die das hier Lesen
	Ausgabe:	"Hallo an alle die das hier Lesen"

**$user - Gibt den Usernamen des Users wieder der denn !command ausführt**

	Parameter:	!addcom !deincommand Commandstext mit $user
	Beispiel: 	!addcom !hallo Hallo $user
	Eingabe:	!hallo
	Ausgabe:	"Hallo (Username)"

**$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder**

	Parameter:	!addcom !deincommand Beispieltext mit $[http(https://webseite.com)]
	Beispiel: 	!addcom !8ball $[http(https://apis.rtainc.co/twitchbot/8ball)]
	Eingabe:	!8ball Werde ich diesen Command benutzen?
	Ausgabe:	"Zufällige Antwort"

**$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder**

	Parameter:	!addcom !deincommand Beispieltext mit $[rnglist(listname)]
	Beispiel: 	!addcom !give Gibt dir $[rnglist(give)]
	Eingabe:	!give
	Ausgabe:	"Gibt dir (Ein zufälligen Gegenstand der sich in der Liste "Give" befindet)"

**$rngnumber(min,max) - Gibt eine Zufällige Nummer zwischen Min und Max wieder**

	Parameter:	!addcom !deincommand Beispieltext mit $rngnumber(min,max)
	Beispiel: 	!addcom !dice Du Würfelst eine $rngnumber(1,6)
	Eingabe:	!dice
	Ausgabe:	"Du Würfelst eine (Zufällige Zahl zwischen 1 und 6)"

**$[index] - Gibt ein Spezifisches Wort aus der Eingabe Nachricht wieder**

	Parameter:	!addcom !deincommand Beispieltext mit $[index]
	Beispiel1: 	!addcom !hallo Hallo $[1]
	Eingabe1:	!Hallo Ihr Alle zusammen
	Ausgabe1:	"Hallo Ihr"

	Beispiel2: 	!addcom !hallo Hallo $[2]
	Eingabe2:	!Hallo Ihr Alle zusammen
	Ausgabe2:	"Hallo Alle"

	Beispiel3: 	!addcom !hallo Hallo $[3]
	Eingabe3:	!Hallo Ihr Alle zusammen
	Ausgabe3:	"Hallo zusammen"

Wobei hier die Zahl die anstelle von "**index**" benutzt wird, den Stellenwert der Wörter des auszugebenden Wortes wiederspiegelt. 

###//// TODO ////###
NOTE: the "else" variable is triggered, if the query word isn't available!

- $[index]elserngnumber(min,max) - should be self explainatory
- $[index]elsernglist(min,max)
- $queryelseuser
- $queryelsernglist(listname)

<hr>
