# Timer IRC

Bedienung des KirschnBot �ber den Twitchchat.

## Timer Erstellen

	Parameter:	!addtimer <timername> <time> Dein Timer Text
	Beispiel:	!addtimer <hallo> <5> Hallo ich bin ein Timer.

Dies erstellt denn Timer "timername" der dazu f�hrt das der Bot "Dein Timer Text" in einem interval von "time" ausgibt.

**Wichtig:** der Parameter "time" muss einen Nummerischen Wert zwischen 1 und 60 sein 

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

Mit dem Command "!edittimer name" ist es m�glich den Namen des Timers zu Editieren.

**Timer Text Editieren:**

	Parameter:	!edittimer text <timername> Dein Neue Timer Text
	Beispiel:	!edittimer text <hallo> Hallo ich bin der Neue Timer

Mit dem Command "!edittimer text" ist es m�glich den Ausgabe Text des Timers zu Editieren.

**Timer Interval Editieren:**

	Parameter:	!edittimer time <timername> <newtime>
	Beispiel:	!edittimer time <hallo> <10>

Mit dem Command "!edittimer time" ist es m�glich den Ausgabe Interval des Timers zu �ndern (in Minuten).
**Wichtig:** der Parameter "newtime" muss einen Nummerischen Wert zwischen 1 und 60 sein 

<hr>

## Timer L�schen

	Parameter:	!deltimer <timername>
	Parameter2:	!removetimer <timername>
	Beispiel:	!deltimer <hallo>
	Beispiel2:	!removetimer <hallo>

Mit dem Command "!deltimer" / "!removetimer" vor dem Timernamen wird in diesem Beispiel der Timer "hallo" gel�scht und steht dadurch nicht mehr zur Verf�gung.

<hr>

## Weitere Parameter f�r den Timer Text:

**$[http(https://webseite.com)] - Gibt den Source Code der gew�hlten Webseite wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $[http(https://webseite.com)]
	Beispiel: 	!addtimer <8ball> <30> $[http(https://apis.rtainc.co/twitchbot/8ball)]
	Ausgabe:	"Zuf�llige Antwort"

**$[rnglist(listname)] - Gibt ein Zuf�lliges Item aus der Angegebenen Liste wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $[rnglist(listname)]
	Beispiel: 	!addtimer <give> <10> Gibt allen $[rnglist(give)]
	Ausgabe:	"Gibt allen (Ein zuf�lligen Gegenstand der sich in der Liste "Give" befindet)"

**$[rngnumber(min,max)] - Gibt eine Zuf�llige Nummer zwischen Min und Max wieder**

	Parameter:	!addtimer <timername> <time> Beispieltext mit $rngnumber(min,max)
	Beispiel: 	!addtimer <luckynumber> <10> Die Gl�ckszahl der n�chsten 10 Minuten ist: $rngnumber(0,99)
	Ausgabe:	"Die Gl�ckszahl der n�chsten 10 Minuten ist: (Zuf�llige Zahl zwischen 0 und 99)"

<hr>
