<?php


require 'db.php';
require '/home/admin/web/api.mint-plantation.com/public_html/webapi.php';
$fd = fopen("/home/admin/web/api.mint-plantation.com/public_html/monitoring/logs/log.txt","a"); 
fwrite($fd,date("d.m.Y H:i")."\r\n"); 
fclose($fd);

function parse($server,$org,$project)
{
    $webapi = new WebApi();
    $data = $webapi->getMembers($project,$server,$org);
    if(is_array($data))
    {
        echo "\n".$org . " | ok\n";
        $leadernick = "Не стоял";
        $online = 0;
        foreach($data as $key => $value)
        {
            if($value['isLeader'])
            {
                $leadernick = $value['name'];
            }

            if($value['isOnline'])
            {
                $online++;
            }
        }
        $changeMobile = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
            13 => 13,
            14 => 14,
            15 => 15,
            16 => 16,
            17 => 17,
            18 => 18,
            19 => 19,
            20 => 20,
            21 => 21,
            22 => 22,
            23 => 101,
            24 => 102,
            25 => 103,
          );

        $a = R::findone('records','server = ? AND project = ? AND org = ?', [$changeMobile[$server],$project,$org]);
        if($a)
        {
            if($a->record < $online)
            {
                echo 'New record | Was: '. $a->record . ' | Became: '. $online;
                $a->record = $online;
                $a->leader = $leadernick;
                $a->date = date("d.m.Y H:i");
                R::store($a);
            }
        } else {



              $b = R::dispense('records');
              $b->project = $project;
              $b->server = $changeMobile[$server];
              $b->org = $org; 
              $b->record = $online;
              $b->leader = $leadernick;
              $b->date = date("d.m.Y H:i");
              R::store($b);
  
        }


        
        return $data;
    } else {
        $fd = fopen("/home/admin/web/api.mint-plantation.com/public_html/monitoring/logs/log.txt","a"); 
        fwrite($fd,date("d.m.Y H:i")." BLOCKED\r\n"); 
        fclose($fd);
        echo $org . ' | blocked';
        sleep(120);
        parse($server,$org,$project);
    }
}

for ($i=1; $i <= 4; $i++) { 
    $serverarray = array();
    for($m = 1; $m <= 21; $m++) {
        $data = parse($i,$m,1);
        array_push($serverarray,$data);
        sleep((float)rand() / (float)getrandmax());
    }
    $f = fopen("/home/admin/web/api.mint-plantation.com/public_html/monitoring/rodinam_".$i.".json", 'w');
    fwrite($f,json_encode($serverarray,JSON_UNESCAPED_UNICODE));
    fclose($f);
}

for ($i=1; $i <= 23; $i++) { 
    $serverarray = array();
    for($m = 1; $m <= 29; $m++) {
        $data = parse($i,$m,0);
        array_push($serverarray,$data);
        sleep((float)rand() / (float)getrandmax());
    }
    $f = fopen("/home/admin/web/api.mint-plantation.com/public_html/monitoring/arizonam_".$i.".json", 'w');
    fwrite($f,json_encode($serverarray,JSON_UNESCAPED_UNICODE));
    fclose($f);
}
