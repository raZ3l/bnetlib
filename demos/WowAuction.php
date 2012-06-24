<?php
include dirname(__DIR__) . '/autoload_register.php';

$goldIntToString = function ($int) {
    $currency = array(
        'g' => round($int / 10000, 0),
        's' => round(($int % 10000) / 100, 0),
        'c' => round(($int % 10000) % 100, 0),
    );

    $return = array();
    foreach ($currency as $symbol => $value) {
        if ($value > 0) {
            $return[] = $value . $symbol;
        }
    }

    return implode(' ', $return);
};
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Auction Demo</title>
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
th,td{padding:4px 7px;text-align:center}
td{border-top:1px solid #d0d0d0}
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
                    <h1>Auction Demo</h1>
                    <?php
                    use bnetlib\Locale\Locale;
                    use bnetlib\Connection\Stub;
                    use bnetlib\WorldOfWarcraft;
                    use bnetlib\Resource\Entity\Wow\Auction\Faction;

                    $locale = new Locale(Stub::LOCALE_GB, WorldOfWarcraft::SHORT_NAME);

                    $wow = new WorldOfWarcraft(new Stub());
                    $wow->getConnection()->setOptions(array(
                        'defaults' => array(
                            'region' => Stub::REGION_EU
                        )
                    ));
                    $wow->getServiceLocator()->setLocale($locale);

                    $auction     = $wow->getAuction(array('realm' => 'Die ewige Wacht'));
                    $auctionData = $wow->getAuctionData($auction);

                    foreach (array(0 => 'getAlliance', 1 => 'getHorde') as $id => $method) {
                        printf('<h2>%s</h2>', $locale->get('faction.' . $id));

                        /* @var $faction Faction */
                        $faction = call_user_func(array($auctionData, $method));
                        $ruby    = $faction->getByItem(52986);

                        if (empty($ruby)) {
                            echo '<p>No "Heartblossom" listed.</p>';
                        } else {
                            printf(
                                '<p>Found <strong>%d</strong> entries for "Heartblossom". '
                                . 'The duration for <strong>%d</strong> auctions is "Short".</p>',
                                 count($ruby),
                                 /* $faction->getItemAndTimeIntersection(52177, 'SHORT') works too */
                                 count($faction->getItemAndTimeIntersection(52177, Faction::TIME_SHORT))
                            );


                            echo '<table><thead><tr><th>Auction Id</th><th>Quantity</th><th>Owner</th>';
                            echo '<th>Bid</th><th>Buyout</th><th>Duration</th></tr></thead><tbody>';

                            foreach ($ruby as $key => $auction) {
                                $marked = ($auction->isShort())    ? ' style="background: #FBE7E7;"' : '';
                                $marked = ($auction->isVeryLong()) ? ' style="background: #E7F9D6;"' : $marked;
                                echo '<tr' . $marked . '>';
                                printf('<td>%d</td>', $auction->getId());
                                printf('<td>%d</td>', $auction->getQuantity());
                                printf('<td>%s</td>', $auction->getOwner());
                                printf('<td>%s</td>', $goldIntToString($auction->getBid()));
                                printf('<td>%s</td>', $goldIntToString($auction->getBuyout()));
                                printf('<td>%s</td>', $auction->getTimeLeftLocale());
                                echo '</tr>';
                            }

                            echo '</tbody></table>';
                        }

                        if ($id === 0) {
                            echo '<br><br>';
                        }
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