# Timer IRC

Bedienung des KirschnBot über den Twitchchat.

## Timer Erstellen

	Parameter:	!addtimer <timername> <time> <lines> Dein Timer Text
	Beispiel:   !addtimer <hallo> <5> <lines> Hallo ich bin ein Timer.

Dies erstellt den Timer "timername" der dazu führt das der Bot "Dein Timer Text" in einem interval von "time" und einer Anzahl von Chat "lines" in einem Zeitraum von 5 Minuten ausgibt.

**Wichtig:** die Parameter "time" und "lines" muss einen Nummerischen Wert besitzen

<hr>

## Timer Starten & Stoppen

	Parameter:	!starttimer <timername>
	Beispiel:	!starttimer <hallo>

Mit diesem Command wird der Timer mit dem entsprechenden "Timernamen" gestartet falls dieser zuvor gestoppt wurde.

	Parameter:	!stoptimer <timername>
	Beispiel:	!stoptimer <hallo>

Mit diesem Command wird der Timer mit dem entsprechenden "Timernamen" gestoppt.

<hr>

## Timer Editieren

**Timer Name Editieren:**

	Parameter:	!edittimer name <timername> <newtimername>
	Beispiel:	!edittimer name <hallo> <huhu>

Mit dem Command "!edittimer name" ist es möglich den Namen des Timers zu Editieren.

**Timer Text Editieren:**

	Parameter:	!edittimer text <timername> Dein Neue Timer Text
	Beispiel	!edittimer text <hallo> Hallo ich bin der Neue Timer

Mit dem Command "!edittimer text" ist es möglich den Ausgabe Text des Timers zu Editieren.

**Timer Zeit Editieren:**

	Parameter:	!edittimer time <timername> <newtime>
	Beispiel	!edittimer time <hallo> <10>

Mit dem Command "!edittimer time" ist es möglich den Ausgabe Interval des Timers zu ändern (in Minuten).
**Wichtig:** der Parameter "newtime" muss einen Nummerischen Wert besitzen. 

**Timer Chatlines Editieren:**

	Parameter:	!edittimer lines <timername> <newlines>
	Beispiel	!edittimer lines <hallo> <10>

Mit dem Command "!edittimer lines" ist es möglich die benötigten Chat Nachrichten (in einem Zeitraum von 5 Minuten) die benötigt werden damit ein Timer Getriggert wird zu ändern
**Wichtig:** der Parameter "newlines" muss einen Nummerischen Wert besitzen. 

<hr>

## Timer Löschen

	Parameter:	!deltimer <timername>
	Parameter2:	!remtimer <timername>
	Beispiel:	!deltimer <hallo>
	Beispiel2:	!remtimer <hallo>

Mit dem Command "!deltimer" / "!remtimer" vor dem Timernamen wird in diesem Beispiel der Timer "hallo" gelöscht und steht dadurch nicht mehr zur Verfügung.

<hr>

## Weitere Parameter für den Timer Text:

**$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder**

	Parameter:	!addtimer <timername> <time> <lines> Beispieltext mit $[http(https://webseite.com)]
	Beispiel: 	!addtimer <8ball> <30> <10> $[http(https://apis.rtainc.co/twitchbot/8ball)]
	Ausgabe:	"Zufällige Antwort"

**$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder**

	Parameter:	!addtimer <timername> <time> <lines> Beispieltext mit $[rnglist(listname)]
	Beispiel: 	!addtimer <give> <10> <30> Gibt allen $[rnglist(give)]
	Ausgabe:	"Gibt allen (Ein zufälligen Gegenstand der sich in der Liste "Give" befindet)"

**$[rngnumber(min,max)] - Gibt eine Zufällige Nummer zwischen Min und Max wieder**

	Parameter:	!addtimer <timername> <time> <lines> Beispieltext mit $rngnumber(min,max)
	Beispiel: 	!addtimer <luckynumber> <10> <20> Die Glückszahl der nächsten 10 Minuten ist: $rngnumber(0,99)
	Ausgabe:  	"Die Glückszahl der nächsten 10 Minuten ist: (Zufällige Zahl zwischen 0 und 99)"

<hr>
