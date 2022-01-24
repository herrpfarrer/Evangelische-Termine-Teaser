<?php
/**
 * @package    Evangelische Termine Teaser
 *
 * @author     Daniel Städtler - github_herrpfarrer@posteo.de
 * @copyright  Copyright 2022 Daniel Städtler. – All rights reserved.
 * @license    GNU General Public License version 3
 * @link       https://github.com/herrpfarrer/Evangelische-Termine-Teaser
 */

// Benötigt, um CSS-Dateien und JavaScript aus ET-Output in den Header der Joomla-Seite zu schreiben
use Joomla\CMS\Factory;

class modETTeaserHelper
{
  
    public static function getTeaser($params)
    {
		// =========================
		// E I N S T E L L U N G E N
		// =========================
	
	
	
		// A. MODUL-EINSTELLUNGEN
		// ======================

		// Zeichenkodierung
		// Passen Sie die Zeichenkodierung des Moduls der Zeichenkodierung Ihrer Webseite an. Unterstützt werden 'latin-1 (ISO 8859-1)' und 'utf8'.
		$encoding = $params->get('encoding');
		if($encoding == '' || $encoding == 'utf8'){
			$encoding = 'utf8';
			$encodingXML = 'utf8';
		} elseif ($encoding == 'latin-1'){
			$encodingXML = 'ISO 8859-1';
		}

		
		
		// B. KALENDEREINSTELLUNGEN
		// ========================

		// Veranstalter-ID
		// Geben Sie hier Ihre Veranstalter-ID von www.evangelische-termine.de ein. Mehrere IDs können durch Komma getrennt angegeben werden.
		// Für die Dekanatsausgabe geben Sie als Veranstalter-ID 'all' ein.
		$veranstalterID = $params->get('veranstalterid');
		if($veranstalterID == ''){
			$veranstalterID = '3';
		}

		// Dekanats-Nummer
		// Für die Dekanatsausgabe geben Sie hier Ihre 3-stellige Dekanatsnummer ein. Denken Sie daran, als Veranstalter-ID 'all' einzugeben.
		// Mehrere Dekanatsnummern können durch Kommata getrennt angegeben werden.
		$region = $params->get('dekanatsnummer');

		// Anzahl
		// Wie viele Veranstaltungen sollen pro Seite angezeigt werden?
		$itemsPerPage = $params->get('itemsperpage');
		if($itemsPerPage == ''){
			$itemsPerPage = '4';
		}

		// Nur Highlights?
		// Sollen nur Highlights oder alle Veranstaltungen angezeigt werden?
		$highlight = $params->get('highlights');
		if($highlight == ''){
			$highlight = 'all';
		}

		// Kategorien
		// Legen Sie fest, welche Kategorien berücksichtigt werden sollen:
		//	all => alle 
		//	1 => Gottesdienste
		//	2 => Gruppen / Kreise
		//	3 => Fortbildungen / Seminare / Vorträge
		//	4 => Konzerte / Theater / Musik
		//	5 => Freizeiten / Reisen
		//	6 => Ausstellungen / Kunst
		//	7 => Feste / Feiern
		//	8 => Sport/Spiel
		//	9 => Sonstiges
		//	Ein vorangestelltes '-' negiert die Auswahl, z.B. -1 => alles außer Gottesdienste. 
		//	Mehrere Kategorien können durch Komma getrennt angegeben werden (=ODER Verknüpfung).
        //  Mehrere Kategorien können durch Punkt getrennt angegeben werden (= UND Verknüpfung).
		$eventtype = $params->get('eventtype');
		if ($eventtype == ''){
			$eventtype =='all';
		}

		// Zielgruppe
		// Legen Sie fest, welche Zielgruppen berücksichtigt werden sollen:
        //  0 => Alle
        //  5 => Kinder
        //  40 => Konfirmanden
        //  10 => Jugendliche
        //  15 => Junge Erwachsene
        //  16 => Frauen
        //  17 => Männer
        //  20 => Familien
        //  25 => Erwachsene
        //  30 => Senioren
        //  35 => besondere Zielgruppe
        //  Mehrere Zielgruppen können durch Komma getrennt angegeben werden.
		$people = $params->get('people');
		if($people == ''){
			$people = 'all';
		}

		// Veranstaltungsort
		// ID des Veranstaltungsortes. Mehrere Veranstaltungsorte können durch Komma getrennt angegeben werden. 'all' für alle Veranstaltungsorte eingeben.
		$place = $params->get('place');
		if($place == ''){
			$place = 'all';
		}

		// Ansprechpartner
		// ID des Ansprechpartners. Mehrere Ansprechpartner können durch Komma getrennt angegeben werden. 'all' für alle Ansprechpartner eingeben.
		$person = $params->get('person');
		if($person == ''){
			$person = 'all';
		}

		// Barrierefreiheit
		//Legen Sie fest, welche Formen von Barrierefreiheit berücksichtigt werden sollen:
        //  Angaben bei den Veranstaltungsorten:
        //     p1 => Rollstuhlgeeignet
        //     p2 => Induktionsanlage für Hörgeräte
        //     p3 => Behinderten WC
        //     p4 => Behindertenparkplatz
        //  Angaben bei der Veranstaltung:
        //     v1 = Veranstaltung in Gebärdensprache bzw. Gebärdendolmetscher ist anwesend
        //     v2 = Predigt / Liturgie der Veranstaltung liegt in schriftlicher Form vor
        //     v3 = Veranstaltung findet in Leichter Sprache statt
        //     v4 = Gebärdensprachdolmetscher kann bei Bedarf bestellt werden
        //     v5 = Abholung o. Fahrdienst kann bei Bedarf organisiert werden
        //     v6 = Induktive Höranlage
        //     v7 = FM-Anlage (drahtlose Funkanlage)
        //     v8 = Punktschrift / Großdruck auf Anfrage
        //     v9 = Begleitservice auf Anfrage
        //  Mehrere Angaben können durch Komma getrennt angegeben werden. 'all' für alle Veranstaltungen mit und ohne Barrierefreiheit eingeben.
		$bf = $params->get('bf');
		if($bf== ''){
			$bf = 'all';
		}

		// Veranstaltungstyp
		// ID des Veranstaltungstyps. Mehrere Veranstaltungstypen können mit Komma getrennt angegeben werden. 'all' für alle Veranstaltungstypen eingeben.
		$ipm = $params->get('ipm');
		if($ipm == ''){
			$ipm = 'all';
		}

		// Kanal
		// ID des Kanals. Mehrere Kanäle können mit Komma getrennt angegeben werden. 'all' für alle Kanäle eingeben.
		$cha = $params->get('cha');
		if($cha == ''){
			$cha = 'all';
		}

		// Suchbegriff
		// Durchsucht die Felder Titel, Untertitel, Kurzbeschreibung, Langbeschreibung, Textbox 1-3, Textline 1-3, Ortsname, Stadt, Personenname und Kanalbezeichnung. 'none' eingeben, falls nach nichts gesucht werden soll.
		$q = $params->get('q');
		if($q == ''){
			$q = 'none';
		}

		// Nur heute
		// Sollen nur Veranstaltungen angezeigt werden, die am aktuellen Tag stattfiinden?
		$today = $params->get('today');
		if($today == 'true'){
		  $today = '&today=true';
		}
		else{
		  $today = '';
		}

		// Bestimmtes Datum
		// Zeigt nur Veranstaltungen an, die am angegebenen Datum sattfinden. Das Datum muss im Format TT.MM.YYYY angegeben werden!
		$date = $params->get('date');
		if($date != ''){
		  $date = '&date='.$date;
		}

		// Bestimmter Monat
		// Zeigt nur Veranstaltungen an, die in einem bestimmten Monat sattfinden. Das Datum muss im Format M.YY (z.B. '4.22' für April 2022 oder '10.22' für Oktober 2022) angegeben werden!
		$month = $params->get('month');
		if($month != ''){
		  $month = '&d=0&month='.$month;
		}

		// Bestimmtes Jahr
		// Zeigt nur Veranstaltungen an, die in einem bestimmten Jahr sattfinden. Das Jahr muss im Format YYYY angegeben werden! 'none' eingeben, falls alle Jahre berücksichtigt werden sollen.
		$year = $params->get('year');
		if ($year == ''){
			$year = '&year=none';
		} else{
			$year = '&year='.$year;
		}

		// Veranstaltungen ab
		// Zeigt alle Veranstaltungen nach dem angegebenen Datum an. Das Datum muss im Format YYYY-MM-DD angegeben werden (z.B. '2022-04-01' für alle Veranstaltungen nach dem 1. April 2022).
		$start = $params->get('start');

		// Veranstaltungen bis
		// Zeigt alle Veranstaltungen bis zum angegebenen Datum an. Das Datum muss im Format YYYY-MM-DD angegeben werden (z.B. '2025-12-25' für alle Veranstaltungen bis zum 25. Dezember 2025).
		$end = $params->get('end');
		$end = '&end='.$end;
		
		if($start != '' and $end == ''){
			$start = '&start='.$start;
			$end = '&end='.'2100-12-31';
		} elseif ($start == '' and $end != ''){
			$start = '&start='.'2022-01-01';
			$end = '&end='.$end;
		} elseif ($start != '' and $end != ''){
			$start = '&start='.$start;
			$end = '&end='.$end;
		}		

		// Veranstaltungen über mehrere Tage werden bis zu Enddatum angezeigt yes|no
		$until  = $params->get('showuntil');
		if ($until == ''){
			$until = 'yes';
		}
      


		// C. LAYOUTEINSTELLUNGEN
		// ======================
		
		// Link zum Veranstaltungskalender anzeigen?
		$showlink = $params->get('showlink');
		if($showlink == ''){
			$showlink = 'false';
		}

		// Link zum Veranstaltungskalender
		$link = $params->get('link');

		// Custom-CSS
		// Passen Sie das aussehen des Moduls mit Hilfe von individuellem CSS-Code an.
		$customstyle = $params->get('customstyle');

		// Teaserformat
		// Wählen Sie, wie breit der Teaser sein soll. (1 = breite, 2= schmal)
		$tpl = $params->get('teaserformat');
		if ($tpl == ''){
			$tpl = '2';
		}

		
		// ==========================================================================
		// K O M M U N I K A TI O N   M I T   E V A N G E L I S C H E   T E R M I N E
		// ==========================================================================
		// Der nachfolgende Code basiert auf Code von EVangelische Termine, der dort im Admin-Bereich veröffentlicht wurde (https://evangelische-termine.de/Admin/ausgabe).
		// Auf Anfrage hat der Verantwortliche Miklós Geyer mitgeteilt, dass der Code keiner Lizenz unterliegt, also gemeinfrei ist, und beliebig verändert und genutzt werden darf.
		
       
		$queryString = 'vid=' . $veranstalterID . '&'.'region=' . $region. '&itemsPerPage=' . $itemsPerPage . '&highlight=' . $highlight
				   . '&eventtype=' . $eventtype . '&people=' . $people . '&place=' . $place . '&person=' . $person . '&bf=' . $bf . '&ipm=' . $ipm
				   . '&q=' . $q . '&tpl=' . $tpl . '&cha=' . $cha . $today . $date . $month. $start . $end . '&until=' . $until . '&encoding='. $encoding . '&css=none';

		$url = "https://www.evangelische-termine.de/teaser?" . $queryString;

		if(function_exists('curl_init')){
		  $sobl = curl_init($url);
		  curl_setopt($sobl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($sobl, CURLOPT_USERAGENT, 'TeaserScript');
		  curl_setopt($sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
		  curl_setopt($sobl, CURLOPT_CONNECTTIMEOUT, 5);
		  $pageContent = curl_exec ($sobl);
		  $sobl_info = curl_getinfo ( $sobl);

		  if($sobl_info['http_code'] == '200'){
			  
			$pageContent = str_replace("span", "div", $pageContent);
			
			if($itemsPerPage % 2 == 0){
			  // "Even";
			  $veranstaltungskalender = "<div class='et_odd et_more'><a href='".$link."'>alle Veranstaltungen</a></div>";
			}
			else{
			  // "Odd";
			  $veranstaltungskalender = "<div class='et_even et_more'><a href='".$link."'>alle Veranstaltungen</a></div>";
			}
			
			if($showlink == "true"){
			  $pageContent .= $veranstaltungskalender;  
			}
			  
			$pageContent = str_replace("et_", "etteaser_", $pageContent);
					
			$teaser = $pageContent;

			// Ergänze Custom-CSS im Header der Joomla-Seite
			$jdocument = Factory::getDocument();			
			if ($customstyle != ''){
				$jdocument->addStyleDeclaration($customstyle);
			}
		  
		  } else {
			  $teaser = "Der Terminkalender ist derzeit nicht erreichbar.";
		  }
		  
		} else {
		  $teaser = "Das benötigte PHP-Modul curl ist nicht installiert.";
		}

        return $teaser;
    }
}