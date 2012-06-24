<?php
include dirname(__DIR__) . '/autoload_register.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Battlegroup and Realms Demo</title>
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
th,td{padding:4px 7px;text-align:left}
td{border-top:1px solid #d0d0d0}
td.right{text-align:right}
tr:hover{background:#f5f5f5}
tr tr:hover{background:#e9e9e9}
table.center th,table.center td,th.center,td.center{text-align:center}
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
                    <h1>Battlegroup and Realms Demo</h1>
                    <?php
                    use bnetlib\Locale\Locale;
                    use bnetlib\Connection\Stub;
                    use bnetlib\WorldOfWarcraft;
                    use bnetlib\Resource\Entity\Wow\Realms;

                    $locale = new Locale(Stub::LOCALE_GB, WorldOfWarcraft::SHORT_NAME);

                    $wow = new WorldOfWarcraft(new Stub());
                    $wow->getConnection()->setOptions(array(
                        'defaults' => array(
                            'region' => Stub::REGION_EU
                        )
                    ));
                    $wow->getServiceLocator()->setLocale($locale);

                    $realms       = $wow->getRealms();
                    $battlegroups = $wow->getBattlegroups();

                    echo '<h2>Battlegroups</h2>';
                    echo '<table><thead><tr><th class="center">Realms</th><th>Name</th><th>Slug</th></tr></thead><tbody>';
                    $bgList = array();
                    foreach ($battlegroups as $battlegroup) {
                        $realmCount = count($realms->getByBattlegroup($battlegroup->getName()));

                        if ($realmCount > 0) {
                            $bgList[] = $battlegroup;
                        }

                        echo '<tr>';
                        printf('<td class="center">%d</td>', $realmCount);
                        printf('<td>%s</td>', $battlegroup->getName());
                        printf('<td>%s</td>', $battlegroup->getSlug());
                        echo '</tr>';
                    }
                    echo '</tbody></table>';

                    echo '<h2>Tol Barad Ratio</h2>';
                    $realmTypes = array(
                        'pvp'   => 'PvP',
                        'pve'   => 'PvE',
                        'rp'    => 'RP-PvE',
                        'rppvp' => 'RP-PvP',
                    );
                    $tolBaradRatio = array(
                        'Total'  => array('a' => 0, 'h' => 0),
                        'PvP'    => array('a' => 0, 'h' => 0),
                        'PvE'    => array('a' => 0, 'h' => 0),
                        'RP-PvE' => array('a' => 0, 'h' => 0),
                        'RP-PvP' => array('a' => 0, 'h' => 0),
                    );
                    foreach ($realmTypes as $key => $value) {
                        foreach ($realms->getByType($key) as $realm) {
                            $tolBarad = $realm->getTolBarad();
                            $faction  = $tolBarad->isAllianceControlled() ? 'a' : 'h';

                            $tolBaradRatio[$value][$faction]  += 1;
                            $tolBaradRatio['Total'][$faction] += 1;
                        }
                    }

                    echo '<table><tbody>';
                    foreach ($tolBaradRatio as $name => $ratio) {
                        echo '<tr>';
                        printf('<td class="right"><strong>%s</strong></td>', $name);
                            echo '<td>';
                            printf(
                                '<table class="center"><thead><tr><th>%s</th><th>%s</th></tr></thead><tbody>',
                                $locale->get('faction.0'),
                                $locale->get('faction.1')
                            );
                            echo '<tr>';
                            printf(
                                '<td>%d (%.2f%%)</td>',
                                $ratio['a'],
                                ($ratio['a'] / ($ratio['a'] + $ratio['h'])) * 100
                            );
                            printf(
                                '<td>%d (%.2f%%)</td>',
                                $ratio['h'],
                                ($ratio['h'] / ($ratio['a'] + $ratio['h'])) * 100
                            );
                            echo '</tr>';
                            echo '</tbody></table>';
                        echo '</td></tr>';
                    }

                    echo '</tbody></table>';


                    $bg = array_rand($bgList);
                    printf('<h2>Battlegroup: %s (%s)</h2>', $bgList[$bg]->getName(), $bgList[$bg]->getSlug());
                    $bgRealms = $realms->getByBattlegroup($bgList[$bg]->getName());

                    foreach ($bgRealms as $realm) {
                        printf('<h3>%s</h3>', $realm->getName());
                        echo '<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>';
                        echo '<tr>';
                        echo '<td>Online</td>';
                        printf('<td>%s</td>', ($realm->isOnline()) ? 'Yes' : 'No');
                        echo '</tr><tr>';
                        echo '<td>Queue</td>';
                        printf('<td>%s</td>', ($realm->hasQueue()) ? 'Yes' : 'No');
                        echo '</tr><tr>';
                        echo '<td>Type</td>';
                        printf('<td>%s</td>', $realm->getType());
                        echo '</tr><tr>';
                        echo '<td>Population</td>';
                        printf('<td>%s</td>', $realm->getPopulation());
                        echo '</tr><tr>';
                        echo '<td>Area</td>';
                        printf('<td>Tol Barad (%d)</td>', $realm->getTolBarad()->getArea());
                        echo '</tr><tr>';
                        echo '<td>Controlling Faction</td>';
                        printf('<td>%s</td>', $realm->getTolBarad()->getControllingFactionLocale());
                        echo '</tr><tr>';
                        echo '<td>PvP Area Status</td>';
                        printf('<td>%s</td>', $realm->getTolBarad()->getStatusLocale());
                        echo '</tr><tr>';
                        echo '<td>Next Match</td>';
                        printf('<td>%s</td>', $realm->getTolBarad()->getDate()->format('l, d F Y H:i:s'));
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