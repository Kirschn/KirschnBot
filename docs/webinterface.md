Bedienung des KirschnBot �ber das Webinterface.

Commands:
	
	Command Overview:
	�bersicht �ber Alle Commands.
	
		Command:	Entsprechender Chat Command (zB. !test).
		Return:		Text und Paramter die der Bot Ausgibt (zB. Ich bin ein Command).
		Userlevel:	Userlevel das zum Ausf�hren des Commands ben�tigt wird.
		Actions:	M�glichkeit Das entsprechende Command zu Editieren & L�schen oder es per Wisper auszugeben.


	Add Command:
	M�glichkeit ein Command zu erstellen.
	
		Command:		Feld zum eintragen des Entsprechenden Commands (zB. !DeinCommand) WICHTIG: Das Command muss mit einem "!" beginnen.
		Userlevel*:		Dropdown Men� zum Auw�hlen des Userlevels welches zum Ausf�hren des Command ben�tigt wird.
		Command Text:	Feld zum eintragen des Textes und der Parameter die beim Auf�hren des Command ausgegeben werden
		
			(*) M�gliche Userlevel:
			"Everyone"		- Alle k�nnen diesen Command benutzen
			"Subscriber"	- Nur Subscriber, Moderator und der Streamer k�nnen diesen Command benutzen.
			"Moderator"		- Nur Moderator und der Streamer k�nnen diesen Command Benutzen.
			"Streamer"		- Nur der Streamer kann diesen Command benutzen.
			"Costume"		- Nur Viewer mit einem Custom Userlevel k�nnen diesen Command benutzen (kann unter "Users" festgelegt werden)
			
			
	Weitere Parameter:
	Parameter um Commands Individuell an zu passen.
	
		$query - Gibt alles aus was der User hinter !Command schreibt
		$user - Gibt den Usernamen des Users wieder der denn !Command ausf�hrt
		$[http(https://webseite.com)] - Gibt den Source Code der gew�hlten Webseite wieder
		$rngnumber(min,max) - Gibt eine Zuf�llige Nummer zwischen Min und Max wieder
		$[rnglist(listname)] - Gibt ein Zuf�lliges Item aus der Angegebenen Liste wieder (Listen und Items k�nnen unter "Items" angelegt werden)
		$[index] - Gibt ein Spezifisches Wort aus der Eingabe Nachricht wieder
		##########UNBEKANNT##########
		$[index]elserngnumber(min,max) - should be self explainatory
		$[index]elsernglist(min,max)
		$queryelseuser
		$queryelsernglist(listname)
		##########UNBEKANNT##########
		
		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Users:

	Configuration:
	Einstellen der Userlevel.
	
		Read your moderators from the Twitch Chat:
		Ausw�hlen ob Userlevel die den Moderator Status haben Automatisch aus dem Twitch Chat gelesen werden.

		Standard userlevel for your mods:
		Festlegen des Nummerischen Wert des Userlevels "Moderator" innerhalb des Bots.

		Standard userlevel for your subscribers:
		Festlegen des Nummerischen Wert des Userlevels "subscriber" innerhalb des Bots.

		Standard userlevel for your Viewers:
		Festlegen des Nummerischen Wert des Userlevels "Viewer" innerhalb des Bots.
		
		
	Custom Userlevel:
	�bersicht �ber die Angelegeten Custom Userlevel und M�glichkeit diese zu L�schen.
		
		
	Add User:
	Usern Bestimmte Userlevel zuordnen und Custom Userlevel Erstellen (Custom Userlevel haben immer einen Nummerischen Wert).
		
		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Anti-Spam:

	Filter:
	Einstellen welche Filter Aktiv sein sollen.

		Auto-Timeout URLs in your chat:
		Aktiviert den Linkfilter im Chat.

		Auto-Timeout blacklisted phrases in your chat:
		Aktiviert den Blacklistfilter im Chat.
		
		
	Link Filter:
	Einstellen des Link Filters.
	
		Timeout length:
		Definiert die L�nge die der Bot Timeoutet wenn ein Link gepostet wird
		(L�ngen: Purge (1sec), 1 Minute, 5 Minuten, 10 Minuten, 30 Minuten)
		
		Send Timeout Notification:
		Aktivieren der Nachricht wenn der Bot durch den Linkfilter Timeoutet
		
		Timeout text:
		Nachricht die angezeigt wird wenn der Bot durch den Linkfilter Timeoutet
		
		
	Link Whitelist:
	Links die bei Aktiviertem Linkfilter nicht Automatisch Timeouted werden.
	
	
	Add Whitelisted Link:
	M�glichkeit URLs in die Whitelist einzutragen
	
	
	Blacklist Filter:
	Einstellen des Blacklist Filters.
	
		Timeout length:
		Definiert die L�nge die der Bot Timeoutet wenn ein Wort/Satz auf der Blacklist gepostet wird
		(L�ngen: Purge (1sec), 1 Minute, 5 Minuten, 10 Minuten, 30 Minuten)
		
		Send Timeout Notification:
		Aktivieren der Nachricht wenn der Bot ein Wort/Satz auf der Blacklist Timeoutet
		
		Timeout text:
		Nachricht die angezeigt wird wenn der Bot ein Wort/Satz auf der Blacklist Timeoutet
		
		
	Phrase Blacklist:
	W�rter/S�tze die bei Aktivierter Blacklist Automatisch Timeouted werden.
	
	
	Add Blacklisted Phrase:
	M�glichkeit W�rter/S�tze in die Blacklist einzutragen
		
		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Quotes:

	Quote Overview:
	�bersicht �ber Alle Quotes.
	
		Name:		Name des Quotes der ben�tigt wird um den Quote im Chat Direkt auf zu rufen (Beispiel: !quote 0).
		Quote:		Der Entsprechende Quote den der Bot Ausgeben kann.
		Created by:	Name ders Users der den Quote angelegt hat.
		Actions:	M�glichkeit Den entsprechenden Quote zu Editieren oder L�schen
		
		
	Add Quote:
	M�glichkeit ein Quote zu erstellen

		Quote Name:	Feld zum eintragen des Entsprechenden QuoteNamen um diesen direkt im Chat ab zu Rufen (Beispiel: !Quote QuoteName).
		Quote Text:	Feld zum eintragen des QuoteTextes der im Chat augegeben wird.

		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Items:

	List & Item Overview:
	�bersicht �ber Alle Listen und die Enthaltenen Items.
	
		Filter:  Dropdown Men� zum Filtern der Listen.
		List:	 Name der Listen der die Items zugeordnet sind die dann �ber den Command Paramter "$[rnglist(listname)]" ausgegeben werden k�nnen.
		Item:	 Item der Entsprechenden Liste das der Bot Ausgeben kann.
		Actions: M�glichkeit das Entsprechende Item zu Editieren oder L�schen (Leere Listen sollten Automatisch gel�scht werden).
		
		
	Add Item:
	M�glichkeit Listen und Items zu Erstellen

		List:	Feld zum Ausw�hlen in Welche Liste das Item erstellt werden soll
				(Ist die Liste noch nicht vorhanden wird sie Erstellt)
		Item:	Feld zum Eintragen eines Items in die Oben angegebene Liste
		
		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\

Settings:

	Custom Chataccount:
	M�glichkeit einen Custom Chataccount f�r den KirschnBot zu Nutzen.
	
		Username:	 Feld zum Eintragen des Usernamens des zu Nutzenden Bot Accounts.
		OAuth Token: Feld zum Eintragen des OAuth-Token des zu Nutzenden Bot Accounts.
			(OAuth-Token Generieren: https://twitchapps.com/tmi/ Aufrufen und mit dem zu Nutzenden Bot Account einloggen)
			
		Reset to "KirschnBot":	Schaltfl�che um wieder den Standard Bot Account "KirschnBot" zu nutzen.
		
		
	Confirmed Users:
	�bersicht �ber Alle User die vollen Zugiff auf das Eigene Bot Webinterface haben
	
		Username:	 Twitchname der User die Vollen zugriff auf das Webinterface haben
		Actions:	 M�glichkeit die Rechte f�r den Vollzugriff zu Entziehen
	
	
	Add Confirmed User:
	M�glichkeit Bestimmten Usern zugriff auf das Bot Webinterface zu geben.
	
		Username:	 Feld zum eintragen des Twitchnamen des Users der vollen zugriff auf das Webinterface haben soll.

		
/~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\
	

