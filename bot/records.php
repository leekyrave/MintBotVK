<?php
require 'ApiCore.php';


$core = new ApiCore();

$ipUser = $core->ipUser;
$core->isBlocked();

//$orgarray = array('Не установлена','Полиция ЛС', 'РКШД', 'ФБР', 'Полиция СФ', 'Больница ЛС', 'Правительство', "ТСР", "Больница СФ", "Лицензеры", "Радио ЛС", "Grove", "Vagos", "Ballas", "Aztecas", "Rifa", "Русская мафия", "Якудза", "ЛКН", "Варлоки","Армия ЛС", "Центральный Банк", "Больница ЛВ", "Полиция ЛВ", "Радио ЛВ", "Ночные Волки", "Радио СФ", "Армия СФ", "Тёмное Братство","Страховая компания");
//$orgarray_rodina = array("Не установлена","Полиция Арзамаса", "Полиция Лыткарино", "Больница Арзамаса", "Правительство", "Автошкола", "Радиостанция Лыткарино", "Фантомасы", "Больница Эдово", "Черная Кошка", "Санитары", "Братва", "Русская Мафия", "Украинская Мафия", "Кавказская Мафия", "ФСБ", "Армия", "Центральный Банк", "Тюрьма Строгого Режима", "Больница Лыткарино", "Полиция Эдово", "Радиостанция Арзамас");
$headers = array_change_key_case(getallheaders());
if(isset($_GET['n'], $headers['authorization'])) {
    $token = R::findone('oatokens','token = ?', [$headers['authorization']]);
    if($token) {
        if($token->status) {
            $records = R::findall('records','leader = ?', [$_GET['n']]);
            if($records) {
                $result_array = array(
                    'error' => '0',
                    'row' => $records,
                );
                exit(json_encode($result_array,JSON_UNESCAPED_UNICODE));
            } else {
                $core->reportError($core::ERROR_NO_RECORDS,'No Records');
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