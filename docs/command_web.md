# Commands:

### Command Erstellen:

Zum erstellen eines Command trägt man im Oberen Feld den entsprechenden Namen das Command ein, Wichtig ist das dieser mit einem "!" beginnt:
<img src="http://i.imgur.com/UUSSSZN.png"/>

Und als Nächstes den Text den der Bot Ausgeben soll wenn der Command benutzt wird in das Untere Feld
<img src="http://i.imgur.com/0tB8hIV.png"/>

Zum Schluss einfach auf "Submit" Drücken und Fertig.


### Commands mit Benutzerlevel:
Auch ist es Möglich ein Command einer bestimmten Userlevel zugänglich zu machen.
Hierfür wählt man zusätzlich noch im Dropdownmenü bei "Userlevel" das Entsprechende Userlevel
<img src="http://i.imgur.com/gc8NMRb.png"/>

So wird ausgewählt Welche Userleveln den Erstellten Command am ende Benutzen können

	"Everyone"		 Alle können diesen Command benutzen
	"Subscriber"	 Nur Subscriber, Moderatoren und der Streamer können diesen Command benutzen.
	"Moderator"		 Nur Moderatoren und der Streamer können diesen Command Benutzen.
	"Streamer"		 Nur der Streamer kann diesen Command benutzen.
	"Custom"		 Nur Viewer mit einer Custom Userlevel können diesen Command benutzen (siehe: Erklärung zu "Users")

Wählt man das Userlevel "Custom" kann man den Nummerischen Wert für die CustomUserlevel eintragen
<img src="http://i.imgur.com/0v7wq8G.png"/>

<hr>

### Commands Editieren:

Zum Editieren eines Commands wählt man Rechts "Edit" aus
<img src="http://i.imgur.com/HybHyae.png"/>

Nun öffnet sich ein Popup Fenster in dem man Alle Parameter ändern Kann
<img src="http://i.imgur.com/9GukCxQ.png"/>

Wichtig ist hier das man Das Userlevel nicht mit einem Dropdown Menü Editieren kann sondern nur durch den Nummerischen wert
Folgende Werte Entsprechen den Standard Userleveln:

	"Everyone"		999 - Alle können diesen Command benutzen
	"Subscriber"	500 - Nur Subscriber, Moderatoren und der Streamer können diesen Command benutzen.
	"Moderator"		100 - Moderatoren und der Streamer können diesen Command Benutzen.
	"Streamer"		000 - Nur der Streamer kann diesen Command benutzen.
	"Custom"		### - Nur Viewer mit einer Custom Userlevel können diesen Command benutzen ("###" durch Gewählten Custom Wert ersetzen) (siehe: Erklärung zu "Users")


<hr>

### Commands Löschen:

Zum Löschen eines Commands wählt man Rechts "Delete" aus
<img src="http://i.imgur.com/HybHyae.png"/>

Und um das löschen zu Bestätigen drückt man im sich öffnenden Popup Fenster auf "OK"
<img src="http://i.imgur.com/o6pXXGL.png"/>

<hr>

### Weitere Parameter für den Commands Text:

Um deine Commands bei der Ausgabe etwas an zu passen gibt es eine handvoll weiterer Parameter für den Commandstext.

$query - Gibt alles aus was der Benutzer hinter !Command schreibt
>Beispiel:
	<img src="http://i.imgur.com/Dot5DK0.png"/>

> Eingabe & Ausgabe:
<img src="http://i.imgur.com/6R3rord.png"/>

$user - Gibt den Benutzernamen des Benutzers wieder der denn !Command ausführt
>Beispiel:
<img src="http://i.imgur.com/rRJR94z.png"/>
	
> Eingabe & Ausgabe:
	<img src="http://i.imgur.com/4YenSWg.png"/>
	
	
$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder
>Beispiel:
	<img src="http://i.imgur.com/q7ycYQo.png"/>
	
> Eingabe & Ausgabe:
	<img src="http://i.imgur.com/YNWCPlC.png"/>
	
	
$rngnumber(min,max) - Gibt eine Zufällige Nummer zwischen Min und Max wieder
	> Beispiel:
	<img src="http://i.imgur.com/jkgEeox.png"/>
	
>Eingabe & Ausgabe:
	<img src="http://i.imgur.com/zH6ES9J.png"/>


$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder (siehe: Items)
>Beispiel:
	<img src="http://i.imgur.com/EqQxkGt.png"/>
	
>Eingabe & Ausgabe
	<img src="http://i.imgur.com/OMtjaZf.png"/>
	
//// TODO ////


$[index] - Gibt ein Spezifisches Wort aus der Eingabe Nachricht wieder
	Beispiel 1:
	
	
	Eingabe & Ausgabe 1:
	
	
	
	Beispiel 2:
	
	
	Eingabe & Ausgabe 2:
	
	

	Beispiel 3:
	
	
	Eingabe & Ausgabe 3:
	
	

Dieser Abschnitt verwirrt mich derzeit D:
NOTE: the "else" variable is triggered, if the query word isn't available!
\$[index]elserngnumber(min,max) - should be self explainatory
\$[index]elsernglist(min,max)
\$queryelseuser
\$queryelsernglist(listname)
