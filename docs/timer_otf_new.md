# Timer IRC

Bedienung des KirschenBot über den Twitchchat

## Timer Erstellen

    Parameter:  !addtimer <timername> <time> <lines> Dein Timer Text.
    Beispiel:   !addtimer hallo 5 10 Hallo ich bin ein Timer

Dies erstellt den Timer "timername" der dazu führt das der Bot "Dein Timer Text" ineinem interval von "time" und einer Anzahl von Chat "lines" in einem zeitraum von 5 Minuten ausgibt.

**Wichtig:** Die Paramter "time" und "lines" müssen einen Nummerischen Wert besitzen

<hr>

## Timer Starten & Stoppen

**Timer Starten**

    Parameter:  !starttimer <timername>
    Beispiel:   !starttimer hallo

Mit diesem Command wir der Timer mit dem entsprechenden "Timername" gestartet falls dieser zuvor gestoppt wurde.


**Timer Stoppen**

    Parameter:  !stoptimer <timername>
    Beispiel:   !stoptimer hallo

Mit diesem Command wird der Timer mit dem entsprechenden "Timernamen" gestoppt.

<hr>

## Timer Editieren

**Timer Namen Editieren**

    Parameter:  !edittimer name <timername> <newtimername>
    Beispiel:   !edittimer name hallo huhu

Mit dem Command "!edittimer name" ist es möglich den Namen des Timers zu Editieren.


**Timer Text Editieren**

    Parameter:  !edittimer text <timername> Dein Neuer Timer Text.
    Beispiel:   !edittimer text hallo Hallo ich bin der Neue Timer.

Mit dem Command "!edittimer text" ist es möglich den Ausgabe Text des Timers zu Editieren.


**Timer Zeit Editieren**

    Parameter:  !edittimer time <timername> <newtime>
    Beispiel:   !edittimer time hallo 10

Mit dem Command "!edittimer time" ist es möglich den Ausgabe Interval des Timers zu ändern (in Minuten)*.

**Wichtig:** der Parameter "newtime" muss einen Nummerischen Wert besitzen.


**Timer Chatlines Editieren**

    Parameter:  !edittimer lines <timername> <newlines>
    Beispiel:   !edittimer lines hallo 15

Mit dem Command "!edittimer lines" ist es möglich die benötigten Chat Nachrichten (in einem Zeitraum von 5 Minuten) die benötigt werden damit der Timer Getriggert wird zu ändern

**Wichtig** der Parameter "newlines" muss einen Nummerischen Wert besitzen.

<hr>

## Timer Löschen

    Parameter1: !deltimer <timername>
    Parameter2: !remtimer <timername>
    Beispiel1:  !deltimer hallo
    Beispiel2:  !remtimer hallo

Mit dem Command "!deltimer" oder "!remtimer" vor dem Timernamen wird in diesem Beispiel der Timer "hallo" gelöscht und steht dadurch nicht mehr zur verfügung.

<hr>

## Weitere Parameter für den Timer Text

**$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder**

    Parameter:  !addtimer <timername> <time> <lines> Beispieltext mit $[http(https://webseite.com)]
    Beispiel:   !addtimer 8ball 30  15  $[http(https://apis.rtainc.co/witchbot/8ball)]
    Ausgabe:    "Zufällige Antwort"


**$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder**

    Parameter:  !addtimer <timername> <time> <lines> Beispieltext mit $[rnglist(listname)]
    Beispiel:   !addtimer give 10 20 Gibts allen $[rnglist(give)]
    Ausgabe:    "Gibt allen (Ein zufälligen Gegenstand der sich in der Liste "give" befindet)"


**$[rngnumber(min,max)] - Gibt eine Zufällige Nummer zwischen dem Min und Max wert wieder**

    Parameter:  !addtimer <timername> <time> <lines> Beispieltext mit $[rngnumber(min,max)]
    Beispiel:   !addtimer luckynumber 10 30 Die Glückszahl der nächsten 10 Minuten ist $[rngnumber(0,99)]
    Ausgabe:    "Die Glückszahl der nächsten 10 Minuten ist: (Zufällige Zahl zwischen 0 und 99)"

**WICHTIG:** Die Parameter "min" & "max" müssen einen Nummerischen Wert besitzen

<hr>