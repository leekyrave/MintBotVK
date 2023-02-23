<?php
require 'ApiCore.php';


$core = new ApiCore();

$ipUser = $core->ipUser;
$core->isBlocked();

//$orgarray = array('Не установлена','Полиция ЛС', 'РКШД', 'ФБР', 'Полиция СФ', 'Больница ЛС', 'Правительство', "ТСР", "Больница СФ", "Лицензеры", "Радио ЛС", "Grove", "Vagos", "Ballas", "Aztecas", "Rifa", "Русская мафия", "Якудза", "ЛКН", "Варлоки","Армия ЛС", "Центральный Банк", "Больница ЛВ", "Полиция ЛВ", "Радио ЛВ", "Ночные Волки", "Радио СФ", "Армия СФ", "Тёмное Братство","Страховая компания");
//$orgarray_rodina = array("Полиция Арзамаса", "Полиция Лыткарино", "Больница Арзамаса", "Правительство", "Автошкола", "Радиостанция Лыткарино", "Фантомасы", "Больница Эдово", "Черная Кошка", "Санитары", "Братва", "Русская Мафия", "Украинская Мафия", "Кавказская Мафия", "ФСБ", "Армия", "Центральный Банк", "Тюрьма Строгого Режима", "Больница Лыткарино", "Полиция Эдово", "Радиостанция Арзамас");

$headers = array_change_key_case(getallheaders());
if(isset($_GET['p'], $_GET['s'], $headers['authorization'])) {
    $token = R::findone('oatokens','token = ?', [$headers['authorization']]);
    if($token) {
        if($token->status) {
            switch ((int)$_GET['p']) {
                case 0: 
                    if((int)$_GET['s'] <= 25 and (int)$_GET['s'] > 0) {
                        $data = json_decode(file_get_contents('/home/admin/web/api.mint-plantation.com/public_html/monitoring/arizonam_'.$_GET['s'].'.json'),true);
                        $result_array = array('error' => 0, 'project' => $_GET['p'], 'server' => $_GET['s'],array());
                        foreach ($data as $key => $value) {
                            foreach($value as $second_key => $second_value) {
                                if($second_value['isLeader']) {
                                    array_push($result_array[0], array(
                                        'id' => $second_value['id'],
                                        'name' => $second_value['name'],
                                        'org' => $key + 1,
                                        'rank' => $second_value['rank'],
                                        'rankLabel' => $second_value['rankLabel'],
                                        'isOnline' => $second_value['isOnline'],
                                    ));
                                    
                                }
                            }
                        }
                        if(count($result_array[0]) > 0) {
                            exit(json_encode($result_array,JSON_UNESCAPED_UNICODE));
                        } else {
                            $core->reportError($core::ERROR_NO_LEADERS,'No leaders');
                        }  
                    } else {
                        $core->reportError($core::ERROR_UNDEFINED_SERVER, 'Undefined Server');
                    }
                    break;
                case 1: 
                    if((int)$_GET['s'] <= 4 and (int)$_GET['s'] > 0) {
                        $data = json_decode(file_get_contents('/home/admin/web/api.mint-plantation.com/public_html/monitoring/rodinam_'.$_GET['s'].'.json'),true);
                        $result_array = array('error' => 0, 'project' => $_GET['p'], 'server' => $_GET['s'], array());
                        foreach ($data as $key => $value) {
                            foreach($value as $second_key => $second_value) {
                                if($second_value['isLeader']) {
                                    array_push($result_array[0], array(
                                        'project' => $_GET['p'],
                                        'server' => $_GET['s'],
                                        'name' => $second_value['name'],
                                        'org' => $key + 1,
                                        'rank' => $second_value['rank'],
                                        'isOnline' => $second_value['isOnline'],
                                    ));
                                    
                                }
                            }
                        }
                        if(count($result_array[0]) > 0) {
                            exit(json_encode($result_array,JSON_UNESCAPED_UNICODE));
                        } else {
                            $core->reportError($core::ERROR_NO_LEADERS,'No leaders');
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