<?php
require 'ApiCore.php';
require 'webapi.php';

$webApi = new WebApi();

$core = new ApiCore();

$ipUser = $core->ipUser;
$core->isBlocked();

//$orgarray = array('Не установлена','Полиция ЛС', 'РКШД', 'ФБР', 'Полиция СФ', 'Больница ЛС', 'Правительство', "ТСР", "Больница СФ", "Лицензеры", "Радио ЛС", "Grove", "Vagos", "Ballas", "Aztecas", "Rifa", "Русская мафия", "Якудза", "ЛКН", "Варлоки","Армия ЛС", "Центральный Банк", "Больница ЛВ", "Полиция ЛВ", "Радио ЛВ", "Ночные Волки", "Радио СФ", "Армия СФ", "Тёмное Братство","Страховая компания");
//$orgarray_rodina = array("Не установлена","Полиция Арзамаса", "Полиция Лыткарино", "Больница Арзамаса", "Правительство", "Автошкола", "Радиостанция Лыткарино", "Фантомасы", "Больница Эдово", "Черная Кошка", "Санитары", "Братва", "Русская Мафия", "Украинская Мафия", "Кавказская Мафия", "ФСБ", "Армия", "Центральный Банк", "Тюрьма Строгого Режима", "Больница Лыткарино", "Полиция Эдово", "Радиостанция Арзамас");
$headers = array_change_key_case(getallheaders());
if(isset($_GET['p'], $_GET['s'], $_GET['o'], $headers['authorization'])) {
    $token = R::findone('oatokens','token = ?', [$headers['authorization']]);
    if($token) {
        if($token->status) {
            switch ((int)$_GET['p']) {
                case (int)0: 
                    if((int)$_GET['s'] <= 25 and (int)$_GET['s'] > 0) {
                        if((int)$_GET['o'] <= 29 and (int)$_GET['o'] > 0) {
                            $a = R::findone('records','server = ? AND project = ? AND org = ?', [$_GET['s'],$_GET['p'],$_GET['o']]);
                            $record = array('leader' => '', 'online' => '', 'date' => '');
                            if($a) {
                                preg_match_all('/(.+) .+/',$a->date,$foo);
                                $record['leader'] = $a->leader; 
                                $record['online'] = $a->record;
                                $record['date'] = preg_replace('/\./','-',$foo[1][0]);
                            }
                            $result_array = array(
                                'error' => 0,
                                'record' => $record,
                                'row' => $webApi->getMembers($_GET['p'],$_GET['s'],$_GET['o'])
                            );
                            exit(json_encode($result_array,JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES));
                        } else {
                            $core->reportError($core::ERROR_UNDEFINED_ORG, 'Undefined Organisation');
                        }
                    } else {
                        $core->reportError($core::ERROR_UNDEFINED_SERVER, 'Undefined Server');
                    }
                    break;
                case 1: 
                    if((int)$_GET['s'] <= 4 and (int)$_GET['s'] > 0) {
                        if((int)$_GET['o'] <= 21 and (int)$_GET['o'] > 0) {
                            $a = R::findone('records','server = ? AND project = ? AND org = ?', [$_GET['s'],$_GET['p'],$_GET['o']]);
                            $record = array('leader' => '', 'online' => '', 'date' => '');
                            if($a) {
                                preg_match_all('/(.+) .+/',$a->date,$foo);
                                $record['leader'] = $a->leader; 
                                $record['online'] = $a->record;
                                $record['date'] = preg_replace('/\./','-',$foo[1][0]);
                            }
                            $result_array = array(
                                'error' => 0,
                                'record' => $record,
                                'row' => $webApi->getMembers($_GET['p'],$_GET['s'],$_GET['o'])
                            );
                            exit(json_encode($result_array,JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES));
                        } else {
                            $core->reportError($core::ERROR_UNDEFINED_ORG, 'Undefined Organisation');
                        }
                    } else {
                        $core->reportError($core::ERROR_UNDEFINED_SERVER, 'Undefined Server');
                    }
                    break;
        
                default:
                    $core->reportError($core::ERROR_UNDEFINED_PROJECT,'Undefined Project');
                    break;
            }
        } else {
            $core->reportError($core::ERROR_UNACCEPTED_TOKEN,'Unaccepted Token');
        }

    } else {
        $core->reportError($core::ERROR_UNREGISTERED_TOKEN, 'Unregistered token');
    }
} else {
    $core->reportError($core::ERROR_NOT_ALL_PARAMS,'Not all params');
}