# Task 11

## Fragestellung
Diskussion. Diskutieren Sie Ihren Lösungsansatz aus Aufgabe 10 a).
• Was passiert, wenn sehr viele Benutzer:innen gleichzeitig die Lösung
verwenden?
• Wie verhält sich die Suche, wenn der Benutzer:innen seine Eingabe sehr
schnell mehrfach hintereinander anpasst?

## Antwort
Wenn viele Nutzer gleichzeitig die Artikelsuche verwenden wird jedes mal eine Datenbank abfrage abgerufen. 
Hier könnte Caching helfen, um die Performance zu verbessern. Dennoch wird die Suchfunktion lokal clientseitig implemntiert, 
sodass das Benutzten des Suchfeldes zu keiner Arbeitslast im Backend führt. Bei einem größeren Datensatz wäre das aber unsinnig solch eine Arbeitslast in den Client zuschreiben.
Dann würde die Suchfunktion zu anfragen gegen die Search API führen. Um hier auch die anzahl der Requests zu veringern wäre Debouncing auf dem Suchfeld wichtig.
Das bedeutet, dass die Suchanfrage erst nach einer bestimmten Zeit nach der letzten Eingabe des Nutzers abgeschickt wird.


