<?php
include dirname(__DIR__) . '/autoload_register.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Character and Guild Demo</title>
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
table.center th,table.center td,th.center,td.center{text-align:center}
img{left:0;top:-2px;float:left;position:relative;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;margin-right:10px}
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
                    <h1>Character and Guild Demo</h1>
                    <?php
                    use bnetlib\Locale\Locale;
                    use bnetlib\Connection\Stub;
                    use bnetlib\WorldOfWarcraft;
                    use bnetlib\Resource\Entity\Wow\Guild\News;

                    $locale = new Locale(Stub::LOCALE_GB, WorldOfWarcraft::SHORT_NAME);

                    $wow = new WorldOfWarcraft(new Stub());
                    $wow->getConnection()->setOptions(array(
                        'defaults' => array(
                            'region' => Stub::REGION_EU
                        )
                    ));
                    $wow->getServiceLocator()->setLocale($locale);

                    $guild = $wow->getGuild(array(
                        'realm' => 'Blackrock',
                        'name'  => 'Roots of Dragonmaw'
                    ));

                    $char = $wow->getCharacter(array(
                        'realm' => 'Blackrock',
                        'name'  => 'Coss',
                        'fields' => array(
                            'guild',
                            'talents',
                            'reputation',
                            'titles',
                            'professions',
                        ),
                    ));

                    $tbn = $wow->getThumbnail($char);

                    printf(
                        '<h2><img src="data:image/jpeg;base64,%s" height="26" wight="26"> %s</h2>',
                        base64_encode($tbn->getData()),
                        $char->getFullName()
                    );
                    echo '<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>';
                    echo '<tr>';
                    echo '<td>Name</td>';
                    printf('<td>%s</td>',$char->getName());
                    echo '</tr><tr>';
                    echo '<td>Realm</td>';
                    printf('<td>%s</td>', $char->getRealm());
                    echo '</tr><tr>';
                    echo '<td>Level</td>';
                    printf('<td>%d</td>', $char->getLevel());
                    echo '</tr><tr>';
                    echo '<td>Race</td>';
                    printf('<td>%s</td>', $char->getRaceLocale());
                    echo '</tr><tr>';
                    echo '<td>Class</td>';
                    printf('<td>%s</td>', $char->getClassLocale());
                    echo '</tr><tr>';
                    echo '<td>Gender</td>';
                    printf('<td>%s</td>', $char->getGenderLocale());
                    echo '</tr><tr>';
                    echo '<td>Faction</td>';
                    printf('<td>%s</td>', $char->getFactionLocale());
                    echo '</tr><tr>';
                    echo '<td>Talent Specialization</td>';
                    printf(
                        '<td>%s (%s)</td>',
                        $char->getTalents()->getSelectedSpec()->getName(),
                        $char->getTalents()->getSelectedSpec()->getSimpleBuild()
                    );
                    echo '</tr><tr>';
                    echo '<td>Professions</td><td>';
                    $profs = array();
                    foreach ($char->getProfessions() as $prof) {
                        $profs[] = sprintf('%s (%d/%d)', $prof->getName(), $prof->getRank(), $prof->getMaxRank());
                    }
                    echo implode('<br>', $profs);
                    echo '</td></tr><tr>';
                    echo '<td>Reputation</td><td>';
                    $reps = array();
                    foreach ($char->getReputation() as $faction) {
                        if (!isset($reps[$faction->getStandingLocale()])) {
                            $reps[$faction->getStandingLocale()] = 0;
                        }
                        $reps[$faction->getStandingLocale()] += 1;
                    }
                    $output = array();
                    foreach ($reps as $key => $value) {
                        $output[] = $key . ': ' . $value;
                    }
                    echo implode('<br>', $output);
                    echo '</td></tr><tr>';
                    echo '<td>Achievement Points</td>';
                    printf('<td>%s</td>', $char->getAchievementPoints());
                    echo '</tr><tr>';
                    echo '<td>Last Modified</td>';
                    printf('<td>%s</td>', $char->getDate()->format('l, d F Y H:i:s'));
                    echo '</tr>';
                    echo '</tbody></table>';

                    printf('<h2>%s</h2>', $guild->getName());
                    echo '<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>';
                    echo '<tr>';
                    echo '<td>Realm</td>';
                    printf('<td>%s</td>', $guild->getRealm());
                    echo '</tr><tr>';
                    echo '<td>Level</td>';
                    printf('<td>%d</td>', $guild->getLevel());
                    echo '</tr><tr>';
                    echo '<td>Faction</td>';
                    printf('<td>%s</td>', $guild->getFactionLocale());
                    echo '</tr><tr>';
                    echo '<td>Achievement Points</td>';
                    printf('<td>%s</td>', $guild->getAchievementPoints());
                    echo '</tr><tr>';
                    echo '<td>Members</td>';
                    printf('<td>%s</td>', count($guild->getMembers()));
                    echo '</tr><tr>';
                    echo '<td>Last Modified</td>';
                    printf('<td>%s</td>', $guild->getDate()->format('l, d F Y H:i:s'));
                    echo '</tr>';
                    echo '</tbody></table>';

                    echo '<h3>Members</h3>';
                    echo '<table><thead><tr><th class="center">Rank</th><th>Character</th></tr></thead><tbody>';
                    foreach ($guild->getMembers() as $member) {
                        echo '<tr>';
                        printf('<td class="center">%d</td>', $member->getRank());
                        printf(
                            '<td>%s, Level %d %s %s with %d Achievement Points</td>',
                            $member->getCharacter()->getName(),
                            $member->getCharacter()->getLevel(),
                            $member->getCharacter()->getRaceLocale(),
                            $member->getCharacter()->getClassLocale(),
                            $member->getCharacter()->getAchievementPoints()
                        );
                        echo '</tr>';
                    }
                    echo '</tbody></table>';

                    echo '<h3>News</h3>';
                    $news = $guild->getNews()->getByType(News::TYPE_ITEM_PURCHASE);
                    if ($news === null) {
                        echo '<p>No News with the type of ' . News::TYPE_ITEM_PURCHASE . '</p>';
                    } else {
                        echo '<table class="center"><thead><tr><th>Character</th>';
                        echo '<th>Id</th><th>Date</th></tr></thead><tbody>';
                        foreach ($news as $entry) {
                            echo '<tr>';
                            printf('<td>%s</td>', $entry->getCharacter());
                            printf('<td>%d</td>', $entry->getItemId());
                            printf('<td>%s</td>', $entry->getDate()->format('l, d F Y H:i:s'));
                            echo '</tr>';
                        }
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