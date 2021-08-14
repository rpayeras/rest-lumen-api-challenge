<?php

$debug = false;

if($debug){
    error_reporting(E_ERROR | E_PARSE);
    ini_set("display_errors", 1); error_reporting(E_ALL);
}

require 'classes/RestClient.php';
require('joysail-columns.php');

function toInfoLog($msg, $clear = false){
    if($clear == true){
        file_put_contents('info.log', $msg);
    } else {
        file_put_contents('info.log', $msg, FILE_APPEND);
    }
}

function toErrorLog($msg, $clear = false){
    if($clear){
        file_put_contents('error.log', $msg);
    } else {
        file_put_contents('error.log', $msg, FILE_APPEND);
    }
}

$servername = "localhost";
$username = "ibizajoy_crmREF";
$password = "sXKBQBkS728CHeR";
$database = "ibizajoy_live";

$records = [];

//$username = "root";
//$password = "";
//$database = "ibizajoysail";

$restClient = new RestClient('http://api.group-ipm.com');
//$restClient = new RestClient('http://groupipm-api.test');

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    toErrorLog("Connection failed: " . $conn->connect_error, true);
}

$res = $restClient->login('joysail_user', 'vQD2k4owDk8bVAPA');

if($debug){
    toInfoLog("<pre>".var_export($res, true)."</pre>", true);
}

$categoriesMembers = $restClient->get('/joysail/members/categories');
foreach($categoriesMembers as $idx => $cat){
    $categoriesMembers[$cat['name']] = $cat['id'];
    unset($categoriesMembers[$idx]);
}

$attendantsTypes = $restClient->get('/joysail/attendants/types');
foreach($attendantsTypes as $idx => $cat){
    $attendantsTypes[$cat['name']] = $cat['id'];
    unset($attendantsTypes[$idx]);
}

$columnsWhere = array_values(array_unique(array_merge(array_keys($columns),array_keys($columnsAttendants)), SORT_REGULAR));;
$columnsWhere[0] = "'".$columnsWhere[0];
$columnsWhere[count($columnsWhere)-1] = $columnsWhere[count($columnsWhere)-1]."'";
$query = "SELECT DISTINCT U.*, P.guid AS url FROM wp_usermeta U
LEFT JOIN wp_posts P ON SUBSTR(meta_value, POSITION('\"File\";i:0;i:' IN meta_value)+13, 4) = P.id
WHERE user_id > 1 AND meta_key IN (".implode("','", $columnsWhere).")";

$res = $conn->query($query);
$data = [];
$validParticipants = ['participants', 'subscriber'];
$validFileFields = ['rib' => 'uploadribdocs', 'boat' => 'uploadboatdocs', 'diver' => 'divercertificate'];

while($row = $res->fetch_assoc()){
    $data[$row['user_id']] = is_array($data[$row['user_id']]) ? $data[$row['user_id']] : [];

    if(strpos($row['meta_value'], 'File') > -1){
        $data[$row['user_id']][$row['meta_key']] = $row['url'];
    } else {
        $data[$row['user_id']][$row['meta_key']] = $row['meta_value'];
    }
}

if($debug){
    echo "Before insert all <br>";
    echo "<pre>".var_export($data, true)."</pre>";
    toInfoLog("<pre>".var_export($data, true)."</pre>");
}

foreach ($data as $idxData => $valData){
    $team = [];
    $teamManager = [];
    $captain = [];
    $owner = [];
    $member = [];
    $rib = [];
    $diver = [];
    $attendant = [];
    $documents = [];
    $continueSending = false;
    $currentAttendant = null;

    foreach($validParticipants as $val){
        if(strpos(strtolower($valData['wp_capabilities']), $val) > -1){
            $currentAttendant = $val;
            $continueSending = true;
        }
    }

    if(!$continueSending){
        continue;
    }

    toInfoLog("New record\n");
    if($debug){
        echo var_export($valData, true);
        toInfoLog("<pre>".var_export($valData, true)."</pre>");
    }

    if($currentAttendant == 'participants'){
        $team[$columns['boatname']] = $valData['boatname'];
        $team[$columns['boatbrand']] = $valData['boatbrand'];
        $team[$columns['boatmodel']] = $valData['boatmodel'];
        $team[$columns['boatloa']] = str_replace(",",".",$valData['boatloa']);
        $team[$columns['boatbeam']] = str_replace(",",".",$valData['boatbeam']);
        $team[$columns['boatdraft']] = str_replace(",",".",$valData['boatdraft']);
        $team[$columns['boatsailnumber']] = $valData['boatsailnumber'];
        $team[$columns['boatarrivalstp']] = date('Y-m-d', strtotime($valData['boatarrivalstp']));
        $team[$columns['boatdeparturemi']] = date('Y-m-d', strtotime($valData['boatdeparturemi']));
        $team[$columns['boatclass']] = $valData['boatclass'];
        $team[$columns['owncontainersize']] = empty($valData['owncontainersize']) ? 0 : $valData['owncontainersize'];
        $team[$columns['externaldiverreq']] = $valData['externaldiverreq'] != 'No' ? 1 : 0;
        $team['external_id'] = $idxData;

        $teamManager[$columns['firstnametm']] = utf8_encode($valData['firstnametm']);
        $teamManager[$columns['lastnametm']] = utf8_encode($valData['lastnametm']);
        $teamManager[$columns['mobilephonetm']] = $valData['mobilephonetm'];
        $teamManager[$columns['nickname']] = $valData['nickname'];
        $teamManager['category_id'] = $categoriesMembers['Team Manager'];
        $teamManager['external_id'] = $idxData;

        $owner[$columns['firstnameoc']] = utf8_encode($valData['firstnameoc']);
        $owner[$columns['lastnameoc']] = utf8_encode($valData['lastnameoc']);
        $owner[$columns['mobilephoneoc']] = $valData['mobilephoneoc'];
        $owner[$columns['emailoc']] = $valData['emailoc'];
        $owner['category_id'] = $categoriesMembers['Owner'];
        $owner['external_id'] = $idxData;

        $captain[$columns['firstnamebc']] = utf8_encode($valData['firstnamebc']);
        $captain[$columns['lastnamebc']] = utf8_encode($valData['lastnamebc']);
        $captain[$columns['mobilephonebc']] = $valData['mobilephonebc'];
        $captain[$columns['emailbc']] = $valData['emailbc'];
        $captain['category_id'] = $categoriesMembers['Captain'];
        $captain['external_id'] = $idxData;

        $diver[$columns['firstnamedv']] = utf8_encode($valData['firstnamedv']);
        $diver[$columns['lastnamedv']] = utf8_encode($valData['lastnamedv']);
        $diver['category_id'] = $categoriesMembers['Diver'];
        $diver['external_id'] = $idxData;

        //Documents
        $i = 0;
        foreach($validFileFields as $idx => $fileField){
            $url = parse_url($valData[$fileField], PHP_URL_PATH);

            if(!empty($valData[$fileField])){
                $team["documents[$i]"] = curl_file_create('../'.$url);
                $i++;
            }
        }

        if($debug){
            echo "<pre>".var_export($team, true)."</pre>";
        }

        //Members of team
        $team['members'][] = $teamManager;
        $team['members'][] = $owner;
        $team['members'][] = $captain;
        $team['members'][] = $diver;
        $team['members'] = json_encode($team['members']);

        $response = $restClient->post('/joysail/teams', $team);

        toInfoLog("Team Insert/Update<br>");

        if($debug){
            echo "<pre>".var_export($response, true)."</pre>";
            toInfoLog("<pre>".var_export($response, true)."</pre>");
        }

        //Rib insert (zodiac)
        if(!empty($response['data']) && !empty($valData['bringownrib'])){
            $rib[$columns['namerib']] = $valData['namerib'];
            $rib[$columns['loarib']] = str_replace(",",".",$valData['loarib']);
            $rib[$columns['beamrib']] = str_replace(",",".",$valData['beamrib']);
            $rib[$columns['ribarrivalstp']] = date('Y-m-d', strtotime($valData['ribarrivalstp']));
            $rib[$columns['departureribmi']] = date('Y-m-d', strtotime($valData['departureribmi']));
            $rib['boat_id'] = $response['data']['id'];
            $rib['external_id'] = $idxData;
            $rib[$columns['boatsailnumber']] = $valData['boatsailnumber'].'_rib';

            $response = $restClient->post('/joysail/teams', $rib);

            toInfoLog("Rib Insert/Update<br>");
            if($debug){
                toInfoLog("<pre>".var_export($response, true)."</pre>");
            }
        }
    }

    if($currentAttendant == 'subscriber'){
        $attendant[$columnsAttendants['first_name']] = utf8_encode($valData['first_name']);
        $attendant[$columnsAttendants['last_name']] = utf8_encode($valData['last_name']);
        $attendant[$columnsAttendants['job-title']] = $valData['job-title'];
        $attendant[$columnsAttendants['nickname']] = $valData['nickname'];
        $attendant[$columnsAttendants['outlet']] = $valData['outlet'];
        $attendant[$columnsAttendants['positiontyp']] = $valData['positiontyp'];
        $attendant[$columnsAttendants['subphone']] = !empty($valData['subphone']) ? $valData['subphone'] : null;
        $attendant[$columnsAttendants['subs-category']] = $valData['subs-category'];
        $attendant[$columnsAttendants['typeofmagazine']] = $valData['typeofmagazine'];
        $attendant['type_id'] = $attendantsTypes[$valData['subs-category']];
        $attendant['external_id'] = $idxData;

        $response = $restClient->post('/joysail/attendants', $attendant);

        toInfoLog("Attendant Insert/Update<br>");

        if($debug){
            toInfoLog("<pre>".var_export($response, true)."</pre>");
        }
    }
}
