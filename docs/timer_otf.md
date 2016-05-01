# Timer IRC

Bedienung des KirschnBot über den Twitchchat.

## Timer Erstellen

	Parameter:	!addtimer <timername> <time> Dein Timer Text
	Beispiel:   !addtimer <hallo> <5> Hallo ich bin ein Timer.

Dies erstellt denn Timer "timername" der dazu führt das der Bot "Dein Timer Text" in einem interval von "time" ausgibt.

**Wichtig:** der Parameter "time" muss einen Nummerischen Wert zwischen 1 und 60 sein 

<hr>

## Timer Starten & Stoppen

	Parameter:	!starttimer <timername>
	Beispiel:   !starttimer <hallo>

Mit diesem Command wird der Timer mit dem entsprechenden "Timernamen" gestartet falls dieser zuvor gestoppt wurde.

	Parameter:	!stoptimer <timername>
	Beispiel:   !stoptimer <hallo>

Mit diesem Command wird der Timer mit dem entsprechenden "Timernamen" gestoppt.

<hr>

## Timer Editieren

**Timer Name Editieren:**

	Parameter:	!edittimer name <timername> <newtimername>
	Beispiel:   !edittimer name <hallo> <huhu>

Mit dem Command "!edittimer name" ist es möglich den Namen des Timers zu Editieren.

**Timer Text Editieren:**

	Parameter:	!edittimer text <timername> Dein Neue Timer Text
	Beispiel:   !edittimer text <hallo> Hallo ich bin der Neue Timer

Mit dem Command "!edittimer text" ist es möglich den Ausgabe Text des Timers zu Editieren.

**Timer Interval Editieren:**

	Parameter:	!edittimer time <timername> <newtime>
	Beispiel:   !edittimer time <hallo> <10>

Mit dem Command "!edittimer time" ist es möglich den Ausgabe Interval des Timers zu ändern (in Minuten).
**Wichtig:** der Parameter "newtime" muss einen Nummerischen Wert zwischen 1 und 60 sein 

<hr>

## Timer Löschen

	Parameter:	!deltimer <timername>
	Parameter2:	!removetimer <timername>
	Beispiel:	!deltimer <hallo>
	Beispiel2:	!removetimer <hallo>

Mit dem Command "!deltimer" / "!removetimer" vor dem Timernamen wird in diesem Beispiel der Timer "hallo" gelöscht und steht dadurch nicht mehr zur Verfügung.

<hr>

## Weitere Parameter für den Timer Text:

**$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $[http(https://webseite.com)]
	Beispiel: 	!addtimer <8ball> <30> $[http(https://apis.rtainc.co/twitchbot/8ball)]
	Ausgabe:	  "Zufällige Antwort"

**$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $[rnglist(listname)]
	Beispiel: 	!addtimer <give> <10> Gibt allen $[rnglist(give)]
	Ausgabe:	  "Gibt allen (Ein zufälligen Gegenstand der sich in der Liste "Give" befindet)"

**$[rngnumber(min,max)] - Gibt eine Zufällige Nummer zwischen Min und Max wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $rngnumber(min,max)
	Beispiel: 	!addtimer <luckynumber> <10> Die Glückszahl der nächsten 10 Minuten ist: $rngnumber(0,99)
	Ausgabe:  	"Die Glückszahl der nächsten 10 Minuten ist: (Zufällige Zahl zwischen 0 und 99)"

<hr>
