# Timer (Web)

## Timer (Übersicht)
<img src="http://i.imgur.com/eCErM1B.png"/>

In dieder Übersicht kann man Alle erstellten Timer einsehen

**Name:**
>Hier steht die Namen der Timer.

**Text**
>Hier steht der Entsprechende Text den die Timer Ausgeben

**Interval**
>Hier kann man die Zeit in Minuten einsehen in welchem Interval der Entsprechende Timer den Timertext ausgibt.

**Lines**
>Hier befindet sich die Anzahl der Chatnachrichten die innerhalb von 5 Minuten benötigt werden damit der Timer getriggert wird

**Actions**
>Hier befinden sich die Optionen zum Starten und Stoppen so wie Editieren und Löschen von Timern

<hr>

## Timer Erstellen
<img src="http://i.imgur.com/Cp4f1oJ.png"/>

**Name**
>Hier wird der Name des zu erstellenden Timers Eingetragen.

**Interval (Minutes)**
>Hier wird die Zeit in Minuten eingetragen in welchen abständen der Timer auslöst.
>Wichtig: Dieser Wert muss ein Nummerischer Wert sein!

**Lines (how many lines have to appear in 5 minutes to activate the timer)**
>Hier wird die Anzahl der Chatnachrichten eingetragen die innerhalb von 5 Minuten benötigt werden damit der Timer getriggert wird.
>dies dient dazu das der Bot nur dann Nachrichten ausgibt wenn der Chat auch genutzt wird.
>Wichtig: Dieser Wert muss ein Nummerischer Wert sein!

**Output Text**
>Hier wird der Text des Timers eingetragen, der dann im Oben angegebenen Interval ausgegeben wird

<hr>

## Timer Editieren
(Bild folgt)

Zu diesem Fenster kommt man wenn man in der Übersicht Rechts beim entsprechenden Timer auf "**Edit**" Klickt

**Name**
>Hier wird der Name des zu erstellenden Timers geändert.

**Interval**
>Hier wird die Zeit in Minuten geändert in welchen abständen der Timer auslöst.
>Wichtig: Dieser Wert muss ein Nummerischer Wert sein!

**Lines**
>Hier wird die Anzahl der Chatnachrichten geändert die innerhalb von 5 Minuten benötigt werden damit der Timer getriggert wird.
>Wichtig: Dieser Wert muss ein Nummerischer Wert sein!

**Output Text**
>Hier wird der Text der vom Timer Ausgegeben wird geändert.

<hr>

## Timer Löschen

Zum Löschen eines Timers wählt man in der Übersicht bei Action "**Delete**" aus

<hr>

## Weitere Parameter für den Timer Output Text

**$[http(https://webseite.com)] - Gibt den Source Code der gewählten Webseite wieder**

    Beispiel:   "Werden wir es schaffen? $[http(https://apis.rtainc.co/witchbot/8ball)]"
    Ausgabe:    "Werden wir es schaffen? ("Zufällige Antwort")"


**$[rnglist(listname)] - Gibt ein Zufälliges Item aus der Angegebenen Liste wieder**

    Beispiel:   "Gibts allen $[rnglist(give)]"
    Ausgabe:    "Gibt allen (Ein zufälligen Gegenstand der sich in der Liste "give" befindet)"


**$[rngnumber(min,max)] - Gibt eine Zufällige Nummer zwischen dem Min und Max wert wieder**

    Beispiel:   "Die Glückszahl der nächsten 10 Minuten ist $[rngnumber(0,99)]"
    Ausgabe:    "Die Glückszahl der nächsten 10 Minuten ist: (Zufällige Zahl zwischen 0 und 99)"

**WICHTIG:** Die Parameter "min" & "max" müssen einen Nummerischen Wert besitzen

<hr>