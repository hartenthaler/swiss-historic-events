<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2020 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */ 
 
declare(strict_types=1);

namespace Hartenthaler\WebtreesModules\History\swiss_historic_events;

use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleHistoricEventsTrait;
use Fisharebest\Webtrees\Module\ModuleHistoricEventsInterface;
use Illuminate\Support\Collection;

/** 
 * Historical facts (in German): around 120 events in Switzerland or with significance for the Swiss (since 1291)
 * Historische Daten: rund 120 Ereignisse in der Schweiz oder mit Bedeutung für die Schweizer (seit 1291)
 */
return new class extends AbstractModule implements ModuleCustomInterface, ModuleHistoricEventsInterface {
    use ModuleCustomTrait;
    use ModuleHistoricEventsTrait;

    public const CUSTOM_TITLE = 'Historic Events: Switzerland 🇨🇭';

    public const CUSTOM_AUTHOR = 'Module: Hermann Hartenthaler / Data: Peter Jehli-Kamm';
    
    public const CUSTOM_WEBSITE = 'https://github.com/hartenthaler/swiss-historic-events/';
    
    public const CUSTOM_VERSION = '2.0.11.2';

    public const CUSTOM_LAST = 'https://github.com/hartenthaler/swiss-historic-events/raw/master/latest-version.txt';

    /**
     * Constructor.  The constructor is called on *all* modules, even ones that are disabled.
     * This is a good place to load business logic ("services").  Type-hint the parameters and
     * they will be injected automatically.
     */
    public function __construct()
    {
        // NOTE:  If your module is dependent on any of the business logic ("services"),
        // then you would type-hint them in the constructor and let webtrees inject them
        // for you.  However, we can't use dependency injection on anonymous classes like
        // this one. For an example of this, see the example-server-configuration module.
    }

    /**
     * Bootstrap.  This function is called on *enabled* modules.
     * It is a good place to register routes and views.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return self::CUSTOM_TITLE;
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {
        return I18N::translate('Historical facts (in German) - events in Switzerland');
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return self::CUSTOM_AUTHOR;
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return self::CUSTOM_VERSION;
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
        public function customModuleLatestVersionUrl(): string
    {
        return self::CUSTOM_LAST;
    }

    /**
     * Where to get support for this module.  Perhaps a github respository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return self::CUSTOM_WEBSITE;
    }

    /**
     * Should this module be enabled when it is first installed?
     *
     * @return bool
     */
    public function isEnabledByDefault(): bool
    {
        return false;
    }

    /**
     * Where does this module store its resources
     *
     * @return string
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }
    
    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return string[]
     */
    
    public function customTranslations(string $language): array
    {
        switch ($language) {
            case 'de':
                // Arrays are preferred, and faster.
                // If your module uses .MO files, then you can convert them to arrays like this.
                return (new Translation(__DIR__ . '/resources/language/de.mo'))->asArray();
    
            default:
                return [];
        }
    }

    /**
     * Structure of events provided by this module:
     * 
     * Each line is a GEDCOM style record to describe an event (EVEN), including newline chars (\n);
     *      1 EVEN <title>
     *      2 TYPE <short category name>
     *      2 DATE <date or date period>
     *      2 NOTE <comment> including [wikipedia de](<link> )
     *
     * markdown is used for NOTE;
     * markdown should be enabled for your tree (see Control panel/Manage family trees/Preferences and then scroll down to "Text" and mark the option "markdown");
     * if markdown is disabled the links are still working (blank at the end is necessary), but the formatting isn't so nice;
     *
     * @return Collection<string>
     */
    
    public function historicEventsAll(): Collection
    {
        $eventType = I18N::translate('Historic event: Switzerland');
        
    /**
     * tbd: wikipedia should be selected based on the language of the webtrees user if the following pages exist in his wikipedia language version
     * tbd: Prüfen ob schlacht/krieg/anschlag/terror in meinem Modul german-wars-battles-worldwide bereits enthalten sind
     */
        $wikipedia  = "de";
        
        return new Collection([
"1 EVEN Gründung der Alten Eidgenossenschaft\n2 TYPE ".$eventType."\n2 DATE AUG 1291\n2 NOTE Uri, Schwyz und Unterwalden (Obwalden und Nidwalden) begründen die Eidgenossenschaft.",
"1 EVEN Schlacht am Morgarten\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 15 NOV 1315\n2 NOTE Eidgenossen besiegen Habsburger; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/Schlacht_am_Morgarten ).",
"1 EVEN Luzern tritt Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1332\n2 NOTE Stadt Luzern tritt der Eidgenossenschaft bei.",
// "1 EVEN Laupenkrieg\n2 TYPE ".$eventType."\n2 DATE 21 JUN 1339\n2 NOTE Eidgenossen besiegen Burgund und Habsburg; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/Laupenkrieg ).",
"1 EVEN Zürich tritt Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1351\n2 NOTE Stadt Zürich tritt der Eidgenossenschaft bei.",
"1 EVEN Glarus und Zug treten Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1352\n2 NOTE Land Glarus sowie Stadt und Land Zug treten der Eidgenossenschaft bei.",
"1 EVEN Bern tritt Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1353\n2 NOTE Stadt Bern tritt der Eidgenossenschaft bei.",
"1 EVEN Erdbeben in Basel\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 18 OCT 1356\n2 NOTE mindestens Stärke 9, 100–2.000 Menschen verlieren ihr Leben; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/Basler_Erdbeben_1356 ).",
"1 EVEN Gründung des Gotteshausbunds\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 29 JAN 1367\n2 NOTE In Rätien wird der Gotteshausbund gegründet.",
"1 EVEN Beitritt zum Bund der Reichstätte\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 21 FEB 1385\n2 NOTE Zürich, Bern, Solothurn und Zug treten dem Bund der Reichsstädte bei.",
"1 EVEN Schlacht bei Sempach\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 09 JUL 1386\n2 NOTE Luzern, Uri, Schwyz und Unterwalden besiegen Habsburg.",
"1 EVEN Mordnacht von Weesen\n2 TYPE ".$eventType."\n2 DATE FROM @#DJULIAN@ 21 FEB 1388 TO @#DJULIAN@ 22 FEB 1388\n2 NOTE In der Nacht werden Glarner und Schwyzer Besatzer von Habsburgern überrascht und gemeuchelt.",
"1 EVEN Schlacht bei Näfels\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 09 APR 1388\n2 NOTE Glarner, Schwyzer und ein paar Urner besiegen Habsburg",
"1 EVEN Weesen brennt\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 11 APR 1388\n2 NOTE Weesen wird von den Österreichern in Brand gesteckt.",
"1 EVEN Fahrtsbrief\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 02 APR 1389\n2 NOTE Die Glarner beschließen, den Sieg von 1388 alljährlich durch einen Kreuzgang nach Näfels zu feiern.",
"1 EVEN Gründung des Grauen Bunds\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 14 FEB 1395\n2 NOTE In Rätien wird der Obere Bund – auch Grauer Bund genannt – gegründet.",
"1 EVEN Loskauf von Säckingen\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 17 JUL 1395\n2 NOTE Glarus kauft sich von Säckingen los.",
"1 EVEN Schlacht bei Nikopolis\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 25 SEP 1396\n2 NOTE Osmanen besiegen Kreuzfahrer.",
"1 EVEN Bund Appenzells mit St. Gallen\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 17 JAN 1401\n2 NOTE Die Appenzeller schließen einen Bund mit der Stadt St. Gallen.",
"1 EVEN Schlacht bei Vögelinsegg\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 15 MAY 1403\n2 NOTE Die Appenzeller besiegen einer Heer des St. Galler Fürstabts Kuno von Stoffeln.",
"1 EVEN Schlacht am Stoss\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 17 JUN 1405\n2 NOTE Während der Appenzellerkriege besiegt Appenzell ein habsburgisch-st.-gallisches Heer",
"1 EVEN Schlacht bei Arbedo\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 30 JUN 1422\n2 NOTE Das Herzogtum Mailand besiegt die Alte Eidgenossenschaft (Ennetbirgische Feldzüge 1402–1515)",
"1 EVEN Gründung des Zehngerichtebunds\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 08 JUN 1436\n2 NOTE Zu Davos wird der Zehngerichtebund gegründet.",
"1 EVEN Alter Zürichkrieg\n2 TYPE ".$eventType."\n2 DATE FROM @#DJULIAN@ 02 NOV 1440 TO @#DJULIAN@ 12 JUN 1446\n2 NOTE Der Alte Zürichkrieg oder Toggenburger Erbschaftskrieg war ein Konflikt zwischen Zürich und der restlichen Eidgenossenschaft. Durch Zürichs Bündnis mit Habsburg erhielt der Krieg überregionale Dimensionen.",
"1 EVEN Schlacht bei St. Jakob an der Sihl\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 22 JUL 1443\n2 NOTE Die Eidgenossen besiegen die Stadt Zürich (Alter Zürichkrieg).",
"1 EVEN Schlacht bei St. Jakob an der Birs\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 26 AUG 1444\n2 NOTE Armagnaken (Kgr. Frankreich) besiegen die Eidgenossen während des Konzils von Basel (Alter Zürichkrieg).",
"1 EVEN Schlacht bei Ragaz\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 06 MAR 1446\n2 NOTE Die Eidgenossen besiegen in der letzten Schlacht des Alten Zürichkriegs die Österreicher und Zürich.",
"1 EVEN Schlacht bei Castione\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 06 JUL 1449\n2 NOTE Uri unterliegt der Ambrosianischen Republik (Mailand) während der Ennetbirgischen Feldzüge 1402–1515.",
"1 EVEN Stiftung der Universität Basel\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 12 NOV 1459\n2 NOTE Papst Julius II. stiftet die Universität Basel.",
"1 EVEN Schlacht bei Héricourt\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 13 NOV 1474\n2 NOTE Eidgenossen und Verbündete (u.a. Habsburger u. Elsäßer) besiegen Burgund.",
"1 EVEN Schlacht auf der Planta\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 13 NOV 1475\n2 NOTE Die sieben Zenden (Wallis) und Bern besiegen Savoyen bei Sion.",
"1 EVEN Schlacht bei Grandson\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 02 MAR 1476\n2 NOTE In der ersten großen Auseinandersetzung der Burgunderkrieg siegen die Eidgenossen gegen burgundischen Truppen des Herzogs Karl des Kühnen.",
"1 EVEN Schlacht bei Murten\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 22 JUN 1476\n2 NOTE Im Rahmen der Burgunderkriege besiegen die Eidgenossen in der zweiten großen Schlacht ein Heer des Herzogs Karl des Kühnen.",
"1 EVEN Schlacht bei Nancy\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 05 JAN 1477\n2 NOTE In der letzten Auseinandersetzung der Burgunderkriege siegen die für René II. von Lothringen kämpfenden Eidgenossen gegen Karl den Kühnen. Dieser verstirbt an einem Hellebardenhieb.",
"1 EVEN Schlacht bei Giornico\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 28 DEC 1478\n2 NOTE Die Eidgenossen besiegen ein Heer des Herzogtums Mailand (Ennetbirgische Feldzüge 1402–1515)",
"1 EVEN Freiburg und Solothurn treten Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1481\n2 NOTE Die Städte Freiburg (im Üechtland) und Solothurn treten der Eidgenossenschaft bei.",
"1 EVEN Hinrichtung Waldmanns\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 06 APR 1489\n2 NOTE In Zürich wird der Bürgermeister Hans Waldmann hingerichtet. Dankbar nahm er entgegen, mit dem Schwert und nicht auf andere Weise hingerichtet zu werden. Seine letzte Worte: «Bewahr dich Gott vor Leid, mein liebes Zürich.»",
"1 EVEN St. Gallerkrieg\n2 TYPE ".$eventType."\n2 DATE FROM @#DJULIAN@ 28 JUL 1489 TO 1490\n2 NOTE Fürstabt von St. Gallen mit Zürich, Luzern, Schwyz und Glarus besiegt Appenzell und die Stadt St.Gallen.",
"1 EVEN Gefecht am Bruderholz\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 22 MAR 1499\n2 NOTE Während des Schwabenkriegs besiegen die Eidgenossen den Schwäbischen Bund.",
"1 EVEN Schlacht im Schwaderloh\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 11 APR 1499\n2 NOTE Während des Schwabenkriegs besiegen die Eidgenossen den Schwäbischen Bund.",
"1 EVEN Schlacht bei Frastanz\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 20 APR 1499\n2 NOTE Während des Schwabenkriegs besiegen die Eidgenossen den Schwäbischen Bund.",
"1 EVEN Schlacht an der Calven\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 22 MAY 1499\n2 NOTE Während des Schwabenkriegs besiegen die Drei Bünde und die Eidgenossen den Schwäbischen Bund und König Maximilian I. von Österreich.",
"1 EVEN Schlacht bei Dornach\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 22 JUL 1499\n2 NOTE Während des Schwabenkriegs besiegen die Eidgenossen den Schwäbischen Bund und König Maximilian I. von Österreich.",
"1 EVEN Basel und Schaffhausen treten Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1501\n2 NOTE Städte Basel und Schaffhausen treten der Eidgenossenschaft bei.",
"1 EVEN Bellinzona an die Waldstätte\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 11 APR 1503\n2 NOTE Frankreich tritt Bellinzona an die Waldstätte ab.",
"1 EVEN Zwingli wird Pfarrer in Glarus\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 21 SEP 1506\n2 NOTE Pfarrinstallation Ulrich Zwinglis in Glarus.",
"1 EVEN Appenzell tritt Eidgenossenschaft bei\n2 TYPE ".$eventType."\n2 DATE 1513\n2 NOTE Land Appenzell tritt der Eidgenossenschaft bei.",
"1 EVEN Schlacht bei Novara\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 06 JUN 1513\n2 NOTE Die Eidgenossen besiegen während der italienischen Kriege Frankreich unter König Louis XII.",
"1 EVEN Schlacht bei Marignano\n2 TYPE ".$eventType."\n2 DATE FROM @#DJULIAN@ 13 SEP 1515 TO @#DJULIAN@ 14 SEP 1515\n2 NOTE Frankreich und Venedig besiegen die Dreizehn Alten Orte.",
"1 EVEN Zwingli wird Leutprieser in Einsiedeln\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 14 APR 1516\n2 NOTE Nachdem Zwingli Anfang 1516 in Glarus für drei Jahre beurlaubt wurde, resp. Glarus verlassen musste, beruft ihn Diebold von Geroldseck als Leutpriester und Prediger in das Kloster Maria-Einsiedeln.",
"1 EVEN Zwingli wird Leutprieser in Zürich\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 01 JAN 1519\n2 NOTE Zwingli wird Leutpriester im dem Bistum Konstanz zughörigen Großmüsterstift.",
"1 EVEN Schlacht bei Bicocca\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 27 APR 1522\n2 NOTE In der Schlacht bei Bicocca unterliegen die an der Seite der Franzosen und Venezier kämpfenden Eidgenossen einem spanisch-habsburgischen Heer. Diese Niederlage war maßgeblich auf die Überlegenheit der spanischen Arkebusiere und Artillerie über die Eidgenössischen Pikeniere zurückzuführen.",
"1 EVEN Freitstaat der Drei Bünde entsteht\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 23 SEP 1524\n2 NOTE Mit dem Bundesbrief geben sich der Gotteshausbund, der Graue Bund (Obere Bund) und der Zehngerichtebund eine gemeinsame Verfassung.",
"1 EVEN Bern wird reformiert\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 07 FEB 1528\n2 NOTE In Bern wird die Reformation eingeführt.",
"1 EVEN Erster Landfrieden\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 26 JUN 1529\n2 NOTE Im Ersten Kappeler Landfrieden wurde die Reformation durch die fünf katholischen Orte formell anerkannt. Im Gegenzug erhielten diese ihren Glauben garantiert. Zum ersten Mal wurde das gleichwertige Nebeneinander der Konfessionen gewährt.",
"1 EVEN Schlacht bei Kappel\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 11 OCT 1531\n2 NOTE In der Schlacht bei Kappel im Rahmen des Zweiten Kappelerkriegs der katholischen Orte gegen Zürich, verliert Zürich. Der Reformator gerät in Gefangenschaft und wird getötet. Sein Leichnam lassen die katholischen Truppen vierteilen und verbrennen. Die Asche wird in den Wind gestreut.",
"1 EVEN Waadt kommt zu Bern\n2 TYPE ".$eventType."\n2 DATE @#DJULIAN@ 06 JAN 1536\n2 NOTE Die Waadt wird von den Bernern eingenommen.",
"1 EVEN Westfälischer Friede\n2 TYPE ".$eventType."\n2 DATE 24 OCT 1648\n2 NOTE Der erste moderne Friedensvertrag beendet den Dreißigjährigen Krieg. Die Eidgenossenschaft wird reichsfrei.",
"1 EVEN Kriegserklärung Zürichs an Schwyz\n2 TYPE ".$eventType."\n2 DATE 06 JAN 1656\n2 NOTE Zürich erklärt im Namen der reformierten Orte Schwyz den Krieg.",
"1 EVEN Erster Villmergerkrieg\n2 TYPE ".$eventType."\n2 DATE FROM 05 JAN 1656 TO 07 MAR 1656\n2 NOTE Der Krieg der reformierten Orte Zürich und Bern gegen die katholische Innerschweiz endet mit dem Sieg der Katholiken und dem Erhalt der katholischen Hegemonie; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/Erster_Villmergerkrieg ).",
"1 EVEN Werdenberger Landeshauptmann in Glarus begraben\n2 TYPE ".$eventType."\n2 DATE 24 NOV 1721\n2 NOTE Nach einem peinlichen Verhör (Folter) ist der Werdenberger Landeshauptmann Johannes Hilty in Glarner Gefangenschaft verstorben. Er sei ehrlich begraben worden, wie die Behörden den Hinterbliebenen ausrichten lassen.",
"1 EVEN Hinrichtung der Anna Göldi\n2 TYPE ".$eventType."\n2 DATE 13 JUN 1782\n2 NOTE Die Magd war der Hexerei beschuldigt und vom Evangelischen Rat zum Tode verurteilt. Die Hinrichtung durch das Schwert findet in Glarus statt.",
"1 EVEN Sturm auf die Bastille\n2 TYPE ".$eventType."\n2 DATE 14 JUL 1789\n2 NOTE Mit dem Sturm beginnt die Französische Revolution. Die Bastille wurde von gut hundert Mann, davon 32 Schweizer Söldner verteidigt.",
"1 EVEN Tuileriensturm\n2 TYPE ".$eventType."\n2 DATE 10 AUG 1792\n2 NOTE Aufständische Bevölkerungsteile stürmen die von der Schweizergarde verteidigte königliche Residenz, den Tuilerienpalast. 550 bis 700 Schweizgardisten verlieren im Massaker das Leben; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/L%C3%B6wendenkmal_Luzern ).",
"1 EVEN Waadt erklärt Unabhängigkeit\n2 TYPE ".$eventType."\n2 DATE 24 JAN 1798\n2 NOTE Die Waadt erklärt sich von Bern unabhängig.",
"1 EVEN Werdenberg ist frei\n2 TYPE ".$eventType."\n2 DATE 11 MAR 1798\n2 NOTE Die Glarner Landsgemeinde beschließt unter dem Druck der politischen Umwälzungen, den Werdenbergern die Freiheit zu schenken.",
"1 EVEN Ausrufung der Helvetischen Republik\n2 TYPE ".$eventType."\n2 DATE 12 APR 1798\n2 NOTE Die Helvetische Republik wird als Tochterrepublik Frankreichs ins Leben gerufen.",
"1 EVEN Schreckenstage von Nidwalden\n2 TYPE ".$eventType."\n2 DATE FROM 07 SEP 1798 TO 09 SEP 1798\n2 NOTE Die Franzosen überfallen Nidwalden und bringen unsägliches Leid auch über die Zivilbevölkerung. Unter den 400 Nidwaldner Opfern des französischen Massakers befinden sich über hundert Frauen und 26 Kinder.",
"1 EVEN Erste Schlacht um Zürich\n2 TYPE ".$eventType."\n2 DATE FROM 04 JUN 1799 TO 07 JUN 1799\n2 NOTE Österreichische und russische Truppen besiegen Frankreich.",
"1 EVEN Zweite Schlacht um Zürich\n2 TYPE ".$eventType."\n2 DATE FROM 25 SEP 1799 TO 26 SEP 1799\n2 NOTE Französische Truppen besiegen Truppen Russlands und Österreichs.",
"1 EVEN Schlacht im Muotatal\n2 TYPE ".$eventType."\n2 DATE 01 OCT 1799\n2 NOTE Die russischen Truppen besiegen Frankreich.",
"1 EVEN General Suworow überquert Panixer\n2 TYPE ".$eventType."\n2 DATE FROM 06 OCT 1799 TO 06 OCT 1799\n2 NOTE Die geschwächte russische Armee Suworow überquert den Panixer am 6./7. Oktober 1799. Etwa 2000 Soldaten, ebenso viele Lasttiere und alle 25 Geschütze gehen verloren.",
"1 EVEN Auflösung des helvetischen Direktoriums\n2 TYPE ".$eventType."\n2 DATE FROM 07 JAN 1800\n2 NOTE Die Direktoren Laharpe, Oberlin und Secrétan werden abgesetzt und das Direktorium als Institution überhaupt abgeschafft.",
"1 EVEN Auflösung der Helvetischen Republik\n2 TYPE ".$eventType."\n2 DATE 10 MAR 1803\n2 NOTE Die Helvetische Republik wird aufgelöst. Es folgt die Mediationszeit als faktisch französischer Vasallenstaat.",
"1 EVEN Schlacht von Trafalgar\n2 TYPE ".$eventType."\n2 DATE 21 OCT 1805\n2 NOTE In der Seeschlacht am südspanischen Kap Trafalgar wurden die Franzosen und Spanier von den Briten vernichtend geschlagen. Der Traum Napoleons, Großbritannien zu überfallen, war damit ausgeträumt. Auf französischer Seite kämpften auch viele Schweizer.",
"1 EVEN Bergsturz von Goldau\n2 TYPE ".$eventType."\n2 DATE 02 SEP 1806\n2 NOTE Der Bergsturz von Goldau tötet 457 Menschen und 323 Stück Vieh. Er zerstört 111 Wohnhäuser, 220 Ställe und Scheunen sowie zwei Kirchen und zwei Kapellen. Die Dörfer Goldau und Röthen sind verschwunden und der Lauerzersee in der Fläche um den siebten Teil kleiner geworden.",
"1 EVEN Schlacht an der Beresina\n2 TYPE ".$eventType."\n2 DATE FROM 26 NOV 1812 TO 28 NOV 1812\n2 NOTE Diese letzte Schlacht von Napoleons Russlandfeldzug gleicht einem Desasters. Die Grande Armée verliert 30'000 der 75'000 Soldaten auf der Flucht über die Beresina. Etwa 1'000 Schweizer verlieren ihr Leben.",
"1 EVEN Wiener Kongress\n2 TYPE ".$eventType."\n2 DATE FROM 18 SEP 1814 TO 09 JUN 1815\n2 NOTE Der Kongress ordnet nach der Niederlage Napoleon Bonapartes Europa neu. Die Schweiz bleibt bestehen, ohne das Veltlin, Chiavenna, Bormio und Mulhouse.",
"1 EVEN Bundesvertrag von 1815\n2 TYPE ".$eventType."\n2 DATE 07 AUG 1815\n2 NOTE In Zürich wird der Fünfzehnerbund begründet, ein loses Bündnis souveränder Staaten (Kantone).",
"1 EVEN Schlacht bei Marigniano\n2 TYPE ".$eventType."\n2 DATE FORM 13 SEP 1515 TO 14 SEP 1515\n2 NOTE In der Schlacht um das Herzogtum Milano unterliegen die Eidgenossen dem Königreich Frankreich. De facto beendet diese Niederlage die Eidg. Expansionspolitik.",
"1 EVEN erste Militärschule der Schweiz\n2 TYPE ".$eventType."\n2 DATE 01 AUG 1819\n2 NOTE In Thun wird die erste Militärschule der Schweiz eröffnet.",
"1 EVEN Lawinenunglück in Valendas GR\n2 TYPE ".$eventType."\n2 DATE 02 MAR 1825\n2 NOTE Die Lawine am Dorfbärg in Valendas reisst fünf Männer in den Tod.",
"1 EVEN Einführung des metrischen Systems in der Schweiz\n2 TYPE ".$eventType."\n2 DATE 17 AUG 1835\n2 NOTE Die Schweiz führt das metrische System als Referenzsystem ein.",
"1 EVEN Gefecht bei Villmergen\n2 TYPE ".$eventType."\n2 DATE 11 JAN 1841\n2 NOTE Regierungstruppen marschieren ins Freiamt ein und liefern sich ein Gefecht mit den Aufständischen. Zwei Soldaten und sieben Aufständische fallen.",
"1 EVEN Gefecht bei Malters\n2 TYPE ".$eventType."\n2 DATE FROM 30 MAR 1845 TO 31 MAR 1845\n2 NOTE Militärische Auseinandersetzung zwischen Schweizer Regierungstruppen und Freischärlern während des Zweiten Freischarenzugs.",
"1 EVEN Eröffnung der ersten Eisenbahnstrecke der Schweiz\n2 TYPE ".$eventType."\n2 DATE 09 AUG 1847\n2 NOTE Die erste gesamthaft in der Schweiz liegende Eisenbahnstrecke wird zwischen Zürich und Baden eröffnet. Der Volksmund tauft sie «Spanisch-Brötli-Bahn».",
"1 EVEN Sonderbundkrieg\n2 TYPE ".$eventType."\n2 DATE FROM 03 NOV 1847 TO 29 NOV 1847\n2 NOTE Der Bürgerkrieg in der Schweiz war die letzte militärische Auseinandersetzung auf Schweizer Boden. Die Kapitulation des Kantons Wallis beendete den Krieg, der 150 Menschen das Leben kostete; siehe [fam.jehli.ch pdf](http://fam.jehli.ch/joomla/images/ab/AB001.pdf )",
"1 EVEN Bundesverfassung von 1848\n2 TYPE ".$eventType."\n2 DATE 12 SEP 1848\n2 NOTE Die erste Bundesverfassung der Schweizerischen Eidgenossenschaft tritt in Kraft.",
"1 EVEN Wahl des ersten Bundesrats\n2 TYPE ".$eventType."\n2 DATE 16 NOV 1848\n2 NOTE Die vereinigte Bundesversammlung wählt den ersten Bundesrat.",
"1 EVEN Erster Bundespräsident\n2 TYPE ".$eventType."\n2 DATE FROM 16 NOV 1848 TO 31 DEC 1849\n2 NOTE Jonas Furrer (1805-1861) ist der erste Bundespräsident der Schweiz; siehe [wikipedia ".$wikipedia."](https://".$wikipedia.".wikipedia.org/wiki/Jonas_Furrer ).",
"1 EVEN Schweizer Franken\n2 TYPE ".$eventType."\n2 DATE 01 JAN 1852\n2 NOTE Das neue schweizerische Münzsystem tritt in Kraft.",
"1 EVEN Eröffnung der ETH Zürich\n2 TYPE ".$eventType."\n2 DATE 15 OCT 1855\n2 NOTE In Zürich wird das Eidgenössische Polytechnikum eröffnet.",
"1 EVEN Sezessionskrieg\n2 TYPE ".$eventType."\n2 DATE FROM 12 APR 1861 TO 23 JUN 1865\n2 NOTE Der amerikanische Bürgerkrieg endete mit dem Sieg der Nordstaaten. Er kostete bis zu 750'000 Menschenleben. Rund 6'000 Schweizer kämpften auf der Seite der Union, eine unbekannte Zahl auf der Seite der Konföderierten.",
"1 EVEN Brand von Glarus\n2 TYPE ".$eventType."\n2 DATE FROM 10 MAY 1861 TO 11 MAY 1861\n2 NOTE Zwei Drittel des Orts Glarus werden beim Brand in der Nacht auf den 11. Mai zerstört; siehe [altglarus.ch](http://www.altglarus.ch )",
"1 EVEN Glarner Landsgemeinde erlässt Fabrikgesetz\n2 TYPE ".$eventType."\n2 DATE 22 MAY 1864\n2 NOTE Die Glarner Landsgemeinde stimmt dem «Gesetz über die Fabrikpolizei» zu, welche die Tagshöchstarbeitszeit auf 12 Stunden festsetzt, Nachtarbeit und Arbeit Schulpflichtiger verbietet sowie einen minimalen Wöchnerinnenschutz einführt.",
"1 EVEN erste Genfer Konvention\n2 TYPE ".$eventType."\n2 DATE 22 AUG 1864\n2 NOTE Im Genfer Stadthaus unterzeichnen zwölf Staaten die Konvention «betreffend die Linderung des Loses der im Felddienst verwundeten Militärpersonen»",
"1 EVEN Übertritt der Bourbaki-Armee\n2 TYPE ".$eventType."\n2 DATE FROM 01 FEB 1871 TO 03 FEB 1871\n2 NOTE Die französische, 87'000 Mann starke Bourbaki-Armee wird entwaffnet und in der Schweiz bis März 1871 interniert. Die Schweizer Truppen stehen unter dem Kommando von General Hans Herzog (1819–1894).",
"1 EVEN Grubenunglück im Landesplattenberg Engi GL\n2 TYPE ".$eventType."\n2 DATE 9 MAR 1874\n2 NOTE Als sich eine Grubendecke löst, finden drei Männer den Tod. Es ist der einzige Unfall mit Todesfolge im Landesplattenberg.",
"1 EVEN Bergsturz in Elm\n2 TYPE ".$eventType."\n2 DATE 11 SEP 1881\n2 NOTE 83 Gebäude werden zerstört und 115 Personen verlieren ihr Leben",
"1 EVEN Eisenbahnunfall von Münchenstein\n2 TYPE ".$eventType."\n2 DATE 14 JUN 1891\n2 NOTE Beim Einsturz einer Eisenbahnbrücke über die Birs sterben 73 Passagiere und 171 werden verletzt. Ein Soldat starb während der Aufräumarbeiten. In der Folge wurden erste Baunormen geschaffen. Die Brücke der Jura-Simplon-Bahn war vom Büro Alexandre Gustave Eiffel geplant und gebaut worden.",
"1 EVEN Autofahrverbot\n2 TYPE ".$eventType."\n2 DATE 17 AUG 1900\n2 NOTE Die Graubündner Regierung erlässt ein Verbot für das Fahren von Automobilen auf sämtlichen Straßen des Kantons. Das Fahrverbot wird 1925 aufgehoben.",
"1 EVEN Erster Weltkrieg\n2 TYPE ".$eventType."\n2 DATE FROM 28 JUL 1914 TO 11 NOV 1918\n2 NOTE Mit der Kriegserklärung Österreich-Ungarns an Serbien beginnt der Erste Weltkrieg. Mit dem Waffenstillstand von Compiègne endet er. Er fordert unter den Soldaten sind fast 10 Mio. Todesopfer und etwa 20 Mio. Verwundete.",
"1 EVEN Ulrich Wille ist Schweizer General\n2 TYPE ".$eventType."\n2 DATE FROM 03 AUG 1914 TO 11 DEC 1918\n2 NOTE Ulrich Wille (1848–1925) wird durch die Bundesversammlung zum General ernannt.",
"1 EVEN Rätoromanisch wird 4. Landessprache\n2 TYPE ".$eventType."\n2 DATE 11 DEC 1918\n2 NOTE Rund 92% der Schweizer Stimmbürger nehmen die Abstimmungsvorlage an.",
"1 EVEN Spanischer Bürgerkrieg\n2 TYPE ".$eventType."\n2 DATE FROM 17 JUL 1936 TO 01 APR 1939\n2 NOTE Der Krieg endet mit dem Sieg der Putschisten und führt zur Diktatur Francos. Rund 800 Schweizer kämpften auf der Seite der Republik, etwa drei Dutzend auf der Seite der Putschisten.",
"1 EVEN Guisan wird Schweizer General\n2 TYPE ".$eventType."\n2 DATE FROM 30 AUG 1939 TO 20 AUG 1945\n2 NOTE Oberstkorpskommandant Henri Guisan (1874–1960) wird durch die Bundesversammlung zum General ernannt. Er wird der Bundesversammlung 1947 einen 270-seitigen Bericht über die Zeit des Aktivdienstes übergeben.",
"1 EVEN Zweiter Weltkrieg\n2 TYPE ".$eventType."\n2 DATE FROM 01 SEP 1939 TO 08 MAY 1945\n2 NOTE Der Zweite Weltkrieg beginnt mit dem deutschen Überfall auf Polen und endet mit der bedingungslosen Kapitulation der deutschen Wehrmacht — schätzungsweise fordert er mit Einbezug der Opfer von Verbrechen und Kriegsfolgen bis zu 80 Mio. Opfer; siehe auch [Kriegsbericht bei fam.jehli.ch](http://fam.jehli.ch/joomla/images/ab/AB002.pdf ).",
"1 EVEN Letzte zivile Hinrichtung in der Schweiz\n2 TYPE ".$eventType."\n2 DATE 18 OCT 1940\n2 NOTE In der Strafanstalt Sarnen wird der dreifach Mörder Hans Vollenweider (geb. 1908) mit der Guillotine hingerichtet. Während des zweiten Weltkriegs werden 17 Landesverräter nach Militärstrafrecht erschossen.",
"1 EVEN Bombardierung Schaffhausens\n2 TYPE ".$eventType."\n2 DATE 01 APR 1944\n2 NOTE Beim schwersten Bombardement Schweizerischen Territoriums verlieren in Schaffhausen vierzig Personen ihr Leben. Über hundert Personen werden verletzt.",
"1 EVEN Murgang im Durnagelbach (Linthal GL)\n2 TYPE ".$eventType."\n2 DATE 24 AUG 1944\n2 NOTE Der schwallartige Durchbruch des entstandenen Rückstaus der Linth führte zu Verheerungen der ufernahen Gebiete bis zum Walensee hinunter.",
"1 EVEN Flugzeugabsturz bei Dürrenäsch\n2 TYPE ".$eventType."\n2 DATE 4 SEP 1963\n2 NOTE Eine Swissair-Maschine stürzt beim Flug Zürich-Genf ab. Alle 82 Insassen sterben, darunter 43 aus dem 217 Einwohner zählenden Bauerndorf Humlikon, die eine landwirtschaftliche Versuchsanstalt in der Nähe von Genf besuchen wollten. Das Unglück hinterliess im Dorf 39 Vollwaisen und fünf Halbwaisen.",
"1 EVEN Bomenanschlag auf Swissair-Maschine\n2 TYPE ".$eventType."\n2 DATE 21 FEB 1970\n2 NOTE Bei Würenlingen stürzt die Maschine des Fluges Zürich-Tel Aviv durch einen Paketbombenanschlag palästinensischer Terroristen ab. Alle 47 Insassen, darunter zehn Schweizer, kommen ums Leben.",
"1 EVEN Glarner Landsgemeinde führt Stimm- und Wahlrecht für Frauen ein\n2 TYPE ".$eventType."\n2 DATE 03 MAY 1971\n2 NOTE Im Zuge der Eidg. Volksabstimmung vom 7. Februar 1971 erhalten die Glarnerinnen das Stimm- und Wahlrecht in Kanton und Gemeinden; siehe [Video im SRF](http://www.srf.ch/play/tv/me_schonvergessen/video/glarner-sagen-ja-zum-frauenstimmrecht?id=4a134ddb-cd2e-4783-8d94-d7c9dcbde285 ).",
"1 EVEN erste Glarner Landsgemeinde mit Beteiligung der Frauen\n2 TYPE ".$eventType."\n2 DATE 07 MAY 1972\n2 NOTE Zum ersten Mal nehmen Frauen an einer kantonalen Landsgemeinde teil.",
"1 EVEN Atomunfall Tschernobyl\n2 TYPE ".$eventType."\n2 DATE 26 APR 1986\n2 NOTE Eine Kernschmelze in einem Reaktor in Tschernobyl bringt tausend Menschen den Tod und belastet weite Teile Europas radioaktiv. Die radioaktive Wolke erreicht am 30. April 1986 die Schweiz. In der Schweiz sind das Tessin, ein Teil der Ostschweiz und einige Gebiete des Juras die am schlimmsten betroffenen Regionen.",
"1 EVEN Orkan Vivian fegt über die Gebirgswälder\n2 TYPE ".$eventType."\n2 DATE 25 FEB 1990\n2 NOTE Der Orkan Vivian kam mit Windböen von bis zu 268 km/h und dauerte bis zum 27. Februar an.",
"1 EVEN Terroranschlag in Luxor\n2 TYPE ".$eventType."\n2 DATE 17 NOV 1997\n2 NOTE Beim bis dahin blutigsten Terroranschlag auf Touristen werden in der oberägyptischen Stadt Luxor 72 Menschen von radikalen Islamisten erschossen, darunter 36 Schweizer.",
"1 EVEN Orkan Lothar fegt über die Schweiz\n2 TYPE ".$eventType."\n2 DATE 26 DEC 1999\n2 NOTE Der Orkan Lothar verursacht in der Schweiz CHF 500 Mio. an Gebäudeschäden.",
"1 EVEN Terror in New York\n2 TYPE ".$eventType."\n2 DATE 11 SEP 2001\n2 NOTE Islamistische Terroristen kapern Passagierflugzeuge und steuern diese u.a. in die Zwillingstürme des World Trade Centers in New York. Auch zwei Schweizer verlieren ihr Leben.",
		]);
    }
    
};
