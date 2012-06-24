<?php
include dirname(__DIR__) . '/autoload_register.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Arena Ladder and Team Demo</title>
</head>
<style type="text/css" media="screen">
body{color:#444;background:#ddd;font:normal 14px/20px 'Helvetica Neue',Helvetica,Arial,sans-serif}
a{color:#82bd1a;text-decoration:none}
a:hover{text-decoration:underline}
article a{font-weight:bold}
p,dl{margin:0 0 15px}
h1,h2,h3{color:#555;margin:0 0 30px}
h1{font-size:28px}
h2{font-size:21px}
h3{font-size:17px}
hgroup h1{margin:0 0 15px}
p:last-child,dl:last-child{margin:0}
#main{width:800px;margin:75px auto}
#lib{font-size:40px}
#lib a{color:#444}
#lib a:hover,#lib a:focus{color:#82bd1a;text-decoration:none}
footer{clear:both;color:#999;font-size:11px}
section>section{margin:0;width:800px}
article{background:#fff;margin-bottom:25px;-webkit-box-shadow:0 0 3px rgba(0,0,0,.25);-moz-box-shadow:0 0 3px rgba(0,0,0,.25);-o-box-shadow:0 0 3px rgba(0,0,0,.25);box-shadow:0 0 3px rgba(0,0,0,.25);-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px}
section>ul{margin:0;padding:0;list-style:none;font-weight:bold}
header>section{top:0;right:2px;float:right;position:relative}
section>ul>li{font-size:13px;margin-left:5px;display:inline-block}
.nav-space{margin-left:25px}
nav a,section>ul>li>a{color:#eee;line-height:1;background:#888;padding:4px 7px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.inner{padding:30px}
section>ul>li>a:hover,section>ul>li>a:focus{color:#eee;background:#82bd1a;text-decoration:none}
table{width:100%;border-spacing:0;border-collapse:collapse;margin-bottom:25px}
table:last-of-type{margin:0}
th{font-weight:bold}
th,td{padding:4px 7px;text-align:right}
td{border-top:1px solid #d0d0d0}
th:last-child,td:last-child{text-align:left}
tr:hover{background:#f5f5f5}
tr tr:hover{background:#e9e9e9}
</style>
<body>
<div id="main">
    <header>
            <section>
                <ul>
                    <li>Docs:</li>
                    <li><a href="http://coss.github.com/bnetlib/api" title="API Documentation">API</a></li>
                    <li><a href="http://coss.github.com/bnetlib" title="End User Documentation">End-User</a></li>

                    <li class="nav-space">Downlaod:</li>
                    <li><a href="https://github.com/coss/bnetlib/zipball/master" title="Download as .zip">Zip</a></li>
                    <li><a href="https://github.com/coss/bnetlib/tarball/master" title="Download as .tar.gz">Tar</a></li>

                    <li class="nav-space">Actions:</li>
                    <li><a href="https://github.com/coss/bnetlib" title="Fork bnetlib on GitHub">Fork</a></li>
                    <li><a href="https://github.com/coss/bnetlib/toggle_watch" title="Watch bnetlib on GitHub">Watch</a></li>
                    <li><a href="https://github.com/coss/bnetlib/issues" title="Report an Issue">Issues</a></li>
                </ul>
            </section>
            <h1 id="lib"><a href="http://coss.github.com/bnetlib" title="End User Documentation">bnetlib</a></h1>
    </header>
    <section>
        <section>
            <article>
                <div class="inner">
                    <h1>Arena Ladder and Team Demo</h1>
                    <?php
                    use bnetlib\Locale\Locale;
                    use bnetlib\Connection\Stub;
                    use bnetlib\WorldOfWarcraft;

                    $locale = new Locale(Stub::LOCALE_GB, WorldOfWarcraft::SHORT_NAME);

                    $wow = new WorldOfWarcraft(new Stub());
                    $wow->getConnection()->setOptions(array(
                        'defaults' => array(
                            'region' => Stub::REGION_EU
                        )
                    ));
                    $wow->getServiceLocator()->setLocale($locale);

                    $ladder = $wow->getArenaLadder(array(
                        'battlegroup' => 'Cataclysme / Cataclysm',
                        'teamsize'    => '2v2'
                    ));

                    foreach ($ladder as $entry) {
                        printf('<h2>#%d %s</h2>', $entry->getRanking(), $entry->getName());

                        echo '<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>';

                        echo '<tr>';
                        echo '<td>Size</td>';
                        printf('<td>%s</td>', $entry->getSize());
                        echo '</tr><tr>';
                        echo '<td>Realm</td>';
                        printf('<td>%s</td>', $entry->getRealm());
                        echo '</tr><tr>';
                        echo '<td>Faction</td>';
                        printf('<td>%s</td>', $entry->getFactionLocale());
                        echo '</tr><tr>';
                        echo '<td>Rating</td>';
                        printf('<td>%d</td>',$entry->getRating());
                        echo '</tr><tr>';
                        echo '<td>Ranking</td>';
                        printf(
                            '<td>Current Week: %d, Last Session: %d</td>',
                            $entry->getCurrentWeekRanking(),
                            $entry->getLastSessionRanking()
                        );
                        echo '</tr><tr>';
                        echo '<td>Created</td>';
                        printf('<td>%s</td>', $entry->getCreated()->format('l, d F Y'));
                        echo '</tr><tr>';
                        echo '<td>Stats</td>';
                        printf(
                            '<td>%d - %d (%d)</td>',
                            $entry->getWon(),
                            $entry->getLost(),
                            $entry->gePlayed()
                        );
                        echo '</tr><tr>';
                        echo '<td>Session Stats</td>';
                        printf(
                            '<td>%d - %d (%d)</td>',
                            $entry->getSessionWon(),
                            $entry->getSessionLost(),
                            $entry->getSessionPlayed()
                        );
                        echo '</tr><tr>';
                        echo '<td>Members</td>';

                        $members = array();
                        foreach ($entry as $member) {
                            $string  = '';
                            $string .= $member->getName();
                            $string .= ' - ' . $member->getRaceLocale() . ' ' . $member->getClassLocale();
                            $string .= ' (' . $member->getStatistic()->getRating() . ')';

                            $members[] = $string;
                        }

                        printf('<td>%s</td>', implode(', <br>', $members));
                        echo '</tr>';

                        echo '</tbody></table>';
                    }
                    ?>
                </div>
            </article>
    </section>
    <footer>
        © 2012 Eric Boh. All rights reserved.
    </footer>
</div>
</body>
</html>