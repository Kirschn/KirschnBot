Bedienung des KirschnBot �ber das Webinterface.
Commands:

Command Erstellen:

Zum erstellen eines Command tr�gt man im Oberen Feld den entsprechenden Namen das Command ein, Wichtig ist das dieser mit einem "!" beginnt
<img src="http://i.imgur.com/UUSSSZN.png"/>

und als N�chstes den Text den der Bot Ausgeben soll wenn der Command benutzt wird in das Untere Feld
<img src="http://i.imgur.com/0tB8hIV.png"/>

Zum Schluss einfach auf "Submit" Dr�cken und Fertig.


Commands mit Benutzerlevel:
Auch ist es M�glich ein Command einer bestimmten Userlevel zug�nglich zu machen.
Hierf�r w�hlt man zus�tzlich noch im Dropdownmen� bei "Userlevel" das Entsprechende Userlevel
<img src="http://i.imgur.com/gc8NMRb.png"/>

So wird ausgew�hlt Welche Userleveln den Erstellten Command am ende Benutzen k�nnen
"Everyone"		- Alle k�nnen diesen Command benutzen
"Subscriber"	- Nur Subscriber, Moderatoren und der Streamer k�nnen diesen Command benutzen.
"Moderator"		- Nur Moderatoren und der Streamer k�nnen diesen Command Benutzen.
"Streamer"		- Nur der Streamer kann diesen Command benutzen.
"Custom"		- Nur Viewer mit einer Custom Userlevel k�nnen diesen Command benutzen (siehe: Erkl�rung zu "Users")

W�hlt man das Userlevel "Custom" kann man den Nummerischen Wert f�r die CustomUserlevel eintragen
<img src="http://i.imgur.com/0v7wq8G.png"/>

/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Commands Editieren:

Zum Editieren eines Commands w�hlt man Rechts "Edit" aus
<img src="http://i.imgur.com/HybHyae.png"/>

Nun �ffnet sich ein Popup Fenster in dem man Alle Parameter �ndern Kann
<img src="http://i.imgur.com/9GukCxQ.png"/>

Wichtig ist hier das man Das Userlevel nicht mit einem Dropdown Men� Editieren kann sondern nur durch den Nummerischen wert
Folgende Werte Entsprechen den Standard Userleveln:

"Everyone"		- 999 - Alle k�nnen diesen Command benutzen
"Subscriber"	- 500 - Nur Subscriber, Moderatoren und der Streamer k�nnen diesen Command benutzen.
"Moderator"		- 100 - Moderatoren und der Streamer k�nnen diesen Command Benutzen.
"Streamer"		- 000 - Nur der Streamer kann diesen Command benutzen.
"Custom"		- ### - Nur Viewer mit einer Custom Userlevel k�nnen diesen Command benutzen ("###" durch Gew�hlten Custom wert ersetzen) (siehe: Erkl�rung zu "Users")


/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Commands L�schen:

Zum L�schen eines Commands w�hlt man Rechts "Delete" aus
<img src="http://i.imgur.com/HybHyae.png"/>

und um das l�schen zu Best�tigen dr�ckt man im sich �ffnenden Popup Fenster auf "OK"
<img src="http://i.imgur.com/o6pXXGL.png"/>

/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Weitere Parameter f�r den Commands Text:

Um deine Commands bei der Ausgabe etwas an zu passen gibt es eine handvoll weiterer Parameter f�r den Commandstext.

$query - Gibt alles aus was der Benutzer hinter !Command schreibt
	Beispiel:
	<img src="http://i.imgur.com/Dot5DK0.png"/>

	Eingabe & Ausgabe:
	<img src="http://i.imgur.com/6R3rord.png"/>

$user - Gibt den Benutzernamen des Benutzers wieder der denn !Command ausf�hrt
	Beispiel:
	<img src="http://i.imgur.com/rRJR94z.png"/>
	
	Eingabe & Ausgabe:
	<img src="http://i.imgur.com/4YenSWg.png"/>
	
	
$[http(https://webseite.com)] - Gibt den Source Code der gew�hlten Webseite wieder
	Beispiel:
	<img src="http://i.imgur.com/q7ycYQo.png"/>
	
	Eingabe & Ausgabe:
	<img src="http://i.imgur.com/YNWCPlC.png"/>
	
	
$rngnumber(min,max) - Gibt eine Zuf�llige Nummer zwischen Min und Max wieder
	Beispiel:
	<img src="http://i.imgur.com/jkgEeox.png"/>
	
	Eingabe & Ausgabe:
	<img src="http://i.imgur.com/zH6ES9J.png"/>


$[rnglist(listname)] - Gibt ein Zuf�lliges Item aus der Angegebenen Liste wieder (siehe: Items)
	Beispiel:
	<img src="http://i.imgur.com/EqQxkGt.png"/>
	
	Eingabe & Ausgabe
	<img src="http://i.imgur.com/OMtjaZf.png"/>
	
###########################################################################################################################################
Scheint nicht zu Funktionieren

$[index] - Gibt ein Spezifisches Wort aus der Eingabe Nachricht wieder
	Beispiel 1:
	
	
	Eingabe & Ausgabe 1:
	
	
	
	Beispiel 2:
	
	
	Eingabe & Ausgabe 2:
	
	

	Beispiel 3:
	
	
	Eingabe & Ausgabe 3:
	
	

Dieser Abschnitt verwirrt mich derzeit D:
NOTE: the "else" variable is triggered, if the query word isn't available!
$[index]elserngnumber(min,max) - should be self explainatory
$[index]elsernglist(min,max)
$queryelseuser
$queryelsernglist(listname)

/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\