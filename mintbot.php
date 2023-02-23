<?php
require 'db.php';
require 'webapi.php';
require 'logApi.php';
require 'forumapi.php';
require_once('simplevk-master/autoload.php');

use DigitalStar\vk_api\VK_api as vk_api; // Основной класс

const VK_KEY = "-";
const ACCESS_KEY = "-";
const VERSION = "5.126";


$vk = vk_api::create(VK_KEY, VERSION)->setConfirm(ACCESS_KEY);
$vk->initVars($peer_id, $message, $payload, $id, $type, $data);


// ---------- Переменные ----------

$chat_id = $peer_id - 2000000000;
$superuser = 482917726;
$logwarns = 2000000053;
$date = date("d.m.Y H:i");


// ---------- Сообщение ----------
$messages = explode(" ", $message);

$messagecmd = mb_strtolower($message);
$log = 2000000021;
$group_id = -190892131;
$is_admin = 482917726;
// ---------- Другое ----------

$chat_act = $data->object->action;
if (!R::testConnection()) {
  $vk->sendMessage($is_admin, "Проблема с базой данных.Проверь файл db.php.");
  exit;
}



$arizona_max = 25;
$rodina_max = 4;

$serversname = array(
    'Phoenix',
    'Tucson',
    'Scottdale',
    'Chandler',
    'Brainburg',
    'Saintrose',
    'Mesa',
    'Red-Rock',
    'Yuma',
    'Surprise',
    'Prescott',
    'Glendale',
    'Kingman',
    'Winslow',
    'Payson', 
    'Gilbert',
    'Show-Low',
    'Casa-Grande',
    'Page',
    'Sun-City',
    'Queen-Creek',
    'Sedona',
    'Mobile-1',
    'Mobile-2',
    'Mobile-3',
  );

  $serversnamerodina = array(
    'Центральный Округ',
    'Южный Округ',
    'Северный Округ',
    'Восточный Округ'
  );

$stickers = array('🦅', '⚔️', '☠️', '⚙️', '🦁', '🌹', '🌵', '🧗‍♂️', '🔫', '🎁', '🛡️', '🦜', '👑', '🌺', '🐉', '🎖️', '🕊', '🐻', '📄', '☀️', '👑' , '🏙️', '📱', '🎮', '☎');

$org_names_arizona = array('Не установлена','Полиция ЛС', 'РКШД', 'ФБР', 'Полиция СФ', 'Больница ЛС', 'Правительство', "ТСР", "Больница СФ", "Лицензеры", "Радио ЛС", "Grove", "Vagos", "Ballas", "Aztecas", "Rifa", "Русская мафия", "Якудза", "ЛКН", "Варлоки","Армия ЛС", "Центральный Банк", "Больница ЛВ", "Полиция ЛВ", "Радио ЛВ", "Ночные Волки", "Радио СФ", "Армия СФ", "Тёмное Братство","Страховая компания");
$org_names_rodina = array("Не установлена","Полиция Арзамаса", "Полиция Лыткарино", "Больница Арзамаса", "Правительство", "Автошкола", "Радиостанция Лыткарино", "Фантомасы", "Больница Эдово", "Черная Кошка", "Санитары", "Братва", "Русская Мафия", "Украинская Мафия", "Кавказская Мафия", "ФСБ", "Армия", "Центральный Банк", "Тюрьма Строгого Режима", "Больница Лыткарино", "Полиция Эдово", "Радиостанция Арзамас");


$headers_arizona = array(
  "👮 Мониторинг ЛСПД",
  "🚨 Мониторинг РКШД",
  "🕵️ Мониторинг ФБР",
  "🚓 Мониторинг СФПД",
  "🏥 Мониторинг Больницы Лос-Сантоса",
  "🇺🇸 Мониторинг Правительства",
  "🔒 Мониторинг Тюрьмы Строго Режима",
  "⚕️ Мониторинг Больницы Сан-Фиерро",
  "🚗 Мониторинг Автошколы",
  "📰 Мониторинг Радиостанции ЛС",
  "💚 Мониторинг Грувов",
  "💛 Мониторинг Вагосов",
  "💜 Мониторинг Балласов",
  "🤍 Мониторинг Ацтеков",
  "💙 Мониторинг Рифы",
  "🍷 Мониторинг Русской Мафии",
  "👹 Мониторинг Якудзы",
  "🗡️ Мониторинг ЛКН",
  "🏍️ Мониторинг Варлоков",
  "🎖️ Мониторинг Армии ЛС",
  "🏦 Мониторинг Центрального Банка",
  "💊 Мониторинг Больницы Лас-Вентураса",
  "🚔 Мониторинг ЛВПД",
  "📹 Мониторинг Радиостанции ЛВ",
  "🖤 Мониторинг Ночных Волков",
  "🎤 Мониторинг Радиостанции СФ",
  "🎖️ Мониторинг Армии СФ",
  "👹 Мониторинг Темного Братства",
  "🔧 Мониторинг Страховой Компании"
);

$headers_rodina = array(
  "👮 Мониторинг Полиции Арзамаса",
  "🚓 Мониторинг Полиции Лыткарино",
  "🏥 Мониторинг Больницы Арзамаса",
  "🇷🇺 Мониторинг Правительства",
  "🚗 Мониторинг Автошколы",
  "🎤 Мониторинг Радиостанции Лыткарино",
  "🖤 Мониторинг Фантомасов",
  "💊 Мониторинг Больницы Эдово",
  "💜 Мониторинг Черной Кошки",
  "🤍 Мониторинг Санитаров",
  "💛 Мониторинг Братвы",
  "🍷 Мониторинг Русской Мафии",
  "🐖 Мониторинг Украинской Мафии",
  "🔪 Мониторинг Кавказской Мафии",
  "🕵️ Мониторинг ФСБ",
  "🎖️ Мониторинг Армии",
  "🏦 Мониторинг Центрального Банка",
  "🔒 Мониторинг Тюрьмы Строгого Режима",
  "⚕️ Мониторинг Больницы Лыткарино",
  "🚨 Мониторинг Полиции Эдово",
  "📰 Мониторинг Радиостанции Арзамас"
);




if ($data->type == 'message_new') {


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Переменные для кнопок
    $btn_leaders = $vk->buttonText('🇺🇸 Лидеры', 'white', ['command' => 'leaders']);
    $btn_monitoring = $vk->buttonText('🖥️ Мониторинг', 'white', ['command' => 'p_select']);
    $btn_settings = $vk->buttonText('⚙️ Настройки', 'blue', ['command' => 'settings']);
    $btn_help = $vk->buttonText(' ❓ Помощь ', 'green', ['command' => 'help']);
    $btn_stats = $vk->buttonText('&#4448;&#4448;&#4448;📈 Моя статистика&#4448;&#4448;&#4448; ', 'white', ['command' => 'my_stats']);
    
    $btn_clear_status = $vk->buttonText('      🧹 Удалить статус       ', 'red', ['command' => 'clear_status']);
    $btn_clear_nick = $vk->buttonText('         📛 Удалить ник         ', 'red', ['command' => 'clear_nick']);
    $btn_set_status = $vk->buttonText('     🧹 Установить статус     ', 'green', ['command' => 'set_status']);
    $btn_set_nick = $vk->buttonText('       📛 Установить ник        ', 'green', ['command' => 'set_nick']);

    $btns_profile = [[$btn_set_nick,$btn_clear_nick],[$btn_set_status,$btn_clear_status]];
    $btns_menu = [[$btn_leaders, $btn_monitoring], [$btn_stats], [$btn_settings, $btn_help]];
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    regUser($id);
    //payloads
    if (isset($data->object->payload)) {
        $payload = json_decode($data->object->payload, True);
      } else {
        $payload = null;
      }
    $payload = $payload['command'];

    if ($payload == 'help') {
      help();
    }




    if($payload == 'my_stats') {
      showStats($id);
    }

    if ($payload == 'leaders') {
        if(isPermission($id,1)) {
          $arz = $vk->buttonText('🌵 Аризона РП', 'red', ['command' => 'leaders:0']);
          $rodina = $vk->buttonText(' 🇷🇺 Родина РП ', 'blue', ['command' => 'leaders:1']);
          $buttons = [[$arz],[$rodina]];
          $vk->sendButton($peer_id, "📌 Выбор проекта", $buttons, true);
        }
        
    }

    if($payload == 'settings') {
      if(isPermission($id,1,$vk,$peer_id))
      $vk->sendButton($peer_id, "⚙️ Настройки", $btns_profile, true);
    }

    if($payload == 'clear_status') {
      $user = R::findone('users','user_id = ?', [$id]);
      if($user) {
        $user->status = "";
        R::store($user);
        $vk->SendMessage($peer_id,"✔️ Вы успешно удалили свой статус.");
      }
      exit;
    }

    if($payload == 'clear_nick') {
      $user = R::findone('users','user_id = ?', [$id]);
      if($user) {
        $user->nick = "";
        R::store($user);
        $vk->SendMessage($peer_id,"✔️ Вы успешно удалили свой ник.");
      }
      exit;
    }


    
    if($payload == 'set_nick') {
      if(isPermission($id,1,$vk,$peer_id))
      {
        $b = R::findone('buffer','user_id = ?',[$id]);
        if(!$b) {
        $b = R::dispense('buffer');
        $b->user_id = $id;
        $b->snbuffer = $id;
        R::store($b);
        $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id,$vk).'], введите ник,который вы хотите установить',['disable_mentions' => 1, 'dont_parse_links' => 1]);
      } else {
        $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
      }
    }
    exit;
    }
  
  
    if($payload == 'set_status') {
      if(isPermission($id,1,$vk,$peer_id))
      {
        $b = R::findone('buffer','user_id = ?',[$id]);
        if(!$b) {
          $b = R::dispense('buffer');
          $b->user_id = $id;
          $b->sstbuffer = $id;
          R::store($b);
          $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id,$vk).'], введите статус,который вы хотите установить.',['disable_mentions' => 1, 'dont_parse_links' => 1]);
        } else {
          $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
      }
    }
    exit;
    }

    if (preg_match_all('/leaders:(\d+)$/',$payload,$foo)) {
      if(isPermission($id,1)) {
        if($foo[1][0] == 0) {
          $b = R::findone('buffer','user_id = ?',[$id]);
          if(!$b) {
          $b = R::dispense('buffer');
          $b->user_id = $id;
          $b->leadbuffer = $id;
          R::store($b);
            $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id).'], введите номер или название сервера Аризоны,список лидеров которого хотите открыть.',['disable_mentions' => 1, 'dont_parse_links' => 1]);
          } else {
            $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
          }
        } elseif($foo[1][0] == 1)
        {
          $b = R::findone('buffer','user_id = ?',[$id]);
          if(!$b) {
          $b = R::dispense('buffer');
          $b->user_id = $id;
          $b->leadrodinabuffer = $id;
          R::store($b);
            $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id).'], введите номер или название сервера Родины, список лидеров которого хотите открыть.',['disable_mentions' => 1, 'dont_parse_links' => 1]);
          } else {
            $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
          }
        }
      }
      exit;
    }

    //monitoring
    if ($payload == 'p_select') {
        if(isPermission($id,1)) {
          $arz = $vk->buttonText('🌵 Аризона РП', 'red', ['command' => 'p:0']);
          $rodina = $vk->buttonText(' 🇷🇺 Родина РП ', 'blue', ['command' => 'p:1']);
          $buttons = [[$arz],[$rodina]];
          $vk->sendButton($peer_id, "📌 Выбор проекта", $buttons, true);
        }
    }

    if (preg_match_all('/p:(\d+)$/',$payload,$foo)) {
        if(isPermission($id,1)) {
          if($foo[1][0] == 0) {
            $b = R::findone('buffer','user_id = ?',[$id]);
            if(!$b) {
            $b = R::dispense('buffer');
            $b->user_id = $id;
            $b->mbuffer = $id;
            R::store($b);
              $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id).'], введите номер или название сервера Аризоны,мониторинг которого хотите открыть.',['disable_mentions' => 1, 'dont_parse_links' => 1]);
            } else {
              $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
            }
          } elseif($foo[1][0] == 1)
          {
            $b = R::findone('buffer','user_id = ?',[$id]);
            if(!$b) {
            $b = R::dispense('buffer');
            $b->user_id = $id;
            $b->mrodinabuffer = $id;
            R::store($b);
              $vk->SendMessage($peer_id,'⏱️ [id'.$id.'|'. getNick($id).'], введите номер или название сервера Родины,мониторинг которого хотите открыть.',['disable_mentions' => 1, 'dont_parse_links' => 1]);
            } else {
              $vk->SendMessage($peer_id,"❌ Вы не можете нажать на другую кнопку,пока не выполнили предыдущее действие.");
            }
          }
        }
        exit;
      }


      if (preg_match_all('/p:(\d+) s:(\d+) a:(\d+)$/',$payload,$foo)) {
          if(isPermission($id,1))
          {
              if($foo[1][0] == 0)
              {
                  switch ($foo[3][0]) {
                      case 0: 
                          $btn_gov = $vk->buttonText('         🇺🇸 Центральный Аппарат         ', 'blue', ['command' => $foo[0][0] . ' c:0']);
                          $btn_justice = $vk->buttonText('         🚓 Министерство Юстиции        ', 'blue', ['command' => $foo[0][0] . ' c:1']);
                          $btn_defence = $vk->buttonText('         🎖️ Министерство Обороны        ', 'blue', ['command' => $foo[0][0] . ' c:2']);
                          $btn_mc = $vk->buttonText('🏥 Министерство Здравоохранения ', 'blue', ['command' => $foo[0][0] . ' c:3']);
                          $btn_media = $vk->buttonText('📰 Средства Массовой Информации', 'blue', ['command' => $foo[0][0] . ' c:4']);
                          $buttons = [[$btn_gov],[$btn_justice],[$btn_defence],[$btn_mc],[$btn_media]];
                          $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг гос.структур | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                          break;
                    
                      case 1:
                          $btn_yakuza = $vk->buttonText('       👹 Yakuza        ', 'red', ['command' => $foo[0][0] . ' c:0 o:17']);
                          $btn_lcn = $vk->buttonText('🗡️ La Cosa Nostra', 'white', ['command' => $foo[0][0] . ' c:0 o:18']);
                          $btn_rm = $vk->buttonText(' 🍷 Russian Mafia ', 'blue', ['command' => $foo[0][0] . ' c:0 o:16']);
                          $btn_wmc = $vk->buttonText('   🏍️ Warlock MC   ', 'red', ['command' => $foo[0][0] . ' c:0 o:19']);
                          $btn_all = $vk->buttonText('😊 Общий список', 'white', ['command' => $foo[0][0] . ' c:0 o:0 a:'.json_encode(array(17,18,16,19))]);
                          $buttons = [[$btn_yakuza],[$btn_lcn],[$btn_rm],[$btn_wmc],[$btn_all]];
                          $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Преступных Синдикатов | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                          break;

                      case 2:
                          $btn_grove = $vk->buttonText('  💚 Grove  ', 'green', ['command' => $foo[0][0] . ' c:0 o:11']);
                          $btn_ballas = $vk->buttonText('💜 Ballas', 'white', ['command' => $foo[0][0] . ' c:0 o:13']);
                          $btn_vagos = $vk->buttonText('  💛 Vagos ', 'green', ['command' => $foo[0][0] . ' c:0 o:12']);
                          $btn_aztecas = $vk->buttonText('🤍 Aztecas', 'green', ['command' => $foo[0][0] . ' c:0 o:14']);
                          $btn_rifa = $vk->buttonText('  💙 Rifa  ', 'white', ['command' => $foo[0][0] . ' c:0 o:15']);
                          $btn_nw = $vk->buttonText('  🖤 NW   ', 'white', ['command' => $foo[0][0] . ' c:0 o:25']);
                          $btn_all = $vk->buttonText('       😊 Общий список        ', 'red', ['command' => $foo[0][0] . ' c:0 o:0 a:'.json_encode(array(11,13,12,14,15,25))]);
                          $buttons = [[$btn_grove,$btn_ballas],[$btn_aztecas,$btn_rifa],[$btn_vagos,$btn_nw],[$btn_all]];
                          $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Уличных Группировок | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                          break;
                      default:
                          $vk->SendMessage($peer_id,'🤔 Ой-ой! Произошла какая-то ошибка, такой сферы организаций не существует.');
                          break;
                }
            } elseif ($foo[1][0] == 1)
            {
              switch ($foo[3][0]) {
                case 0:
                    $btn_gov = $vk->buttonText('         🇷🇺 Центральный Аппарат         ', 'blue', ['command' => $foo[0][0] . ' c:0']);
                    $btn_justice = $vk->buttonText('       🚓 Министерство Юстиции        ', 'blue', ['command' => $foo[0][0] . ' c:1']);
                    $btn_defence = $vk->buttonText('       🎖️ Министерство Обороны       ', 'blue', ['command' => $foo[0][0] . ' c:2']);
                    $btn_mc = $vk->buttonText('🏥 Министерство Здравоохранения', 'blue', ['command' => $foo[0][0] . ' c:3']);
                    $btn_media = $vk->buttonText('📰 Средства Массовой Информации', 'blue', ['command' => $foo[0][0] . ' c:4']);
                    $buttons = [[$btn_gov],[$btn_justice],[$btn_defence],[$btn_mc],[$btn_media]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг гос.структур | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;
                  
                case 1:
                    $btn_rm = $vk->buttonText('   🍷 Русская Мафия    ', 'red', ['command' => $foo[0][0] . ' c:0 o:12']);
                    $btn_ua = $vk->buttonText('🐖 Украинская Мафия', 'white', ['command' => $foo[0][0] . ' c:0 o:13']);
                    $btn_kz = $vk->buttonText('🔪 Кавказская Мафия', 'blue', ['command' => $foo[0][0] . ' c:0 o:14']);
                    $btn_all = $vk->buttonText('    😊 Общий список     ', 'white', ['command' => $foo[0] . 'c:0 o:0 a:'.json_encode(array(12,13,14))]);
                    $buttons = [[$btn_rm],[$btn_ua],[$btn_kz],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг мафий | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;

                case 2:
                    $btn_sanitar = $vk->buttonText('🤍 Санитары', 'white', ['command' => $foo[0][0] . ' c:0 o:10']);
                    $btn_cat = $vk->buttonText('     💜 Кошка     ', 'white', ['command' => $foo[0][0] . ' c:0 o:9']);
                    $btn_brotherhood = $vk->buttonText('   💛 Братва   ', 'green', ['command' => $foo[0][0] . ' c:0 o:11']);
                    $btn_fantom = $vk->buttonText('🖤 Фантомасы', 'green', ['command' => $foo[0][0] . ' c:0 o:7']);
                    $btn_all = $vk->buttonText('        　　😊 Общий список　           ', 'red', ['command' => $foo[0][0] . ' c:0 o:0 a:'.json_encode(array(10,9,11,7))]);
                    $buttons = [[$btn_sanitar,$btn_cat],[$btn_brotherhood,$btn_fantom],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг ОПГ | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;

                default:
                    $vk->SendMessage($peer_id,'🤔 Ой-ой! Произошла какая-то ошибка, такой сферы организаций не существует.');
                    break;
              }

            }
        }
      } elseif(preg_match_all('/p:(\d+) s:(\d+) a:(\d+) c:(\d+)$/',$payload,$foo))
      {
          if(isPermission($id,1))
          {
            if($foo[1][0] == 0)
            {
                switch ($foo[4][0]) {
                    case 0:
                        $btn_gov = $vk->buttonText('     🇺🇸 Правительство      ', 'white', ['command' => $foo[0][0] . ' o:6']);
                        $btn_bank = $vk->buttonText('  🏦 Центральный Банк  ', 'green', ['command' => $foo[0][0] . ' o:21']);
                        $btn_license = $vk->buttonText('          🚗 Автошкола         ', 'red', ['command' => $foo[0][0] . ' o:9']);
                        $btn_insurance = $vk->buttonText('🔧 Страховая Компания', 'blue', ['command' => $foo[0][0] . ' o:29']);
                        $btn_all = $vk->buttonText('       😊 Общий список      ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(6,21,9,29))]);
                        $buttons = [[$btn_gov],[$btn_bank],[$btn_license],[$btn_insurance],[$btn_all]];
                        $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Центрального Аппарата | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                        break;
                    
                    case 1:
                        $btn_lspd = $vk->buttonText('👮 ЛСПД ', 'blue', ['command' => $foo[0][0] . ' o:1']);
                        $btn_sfpd = $vk->buttonText('🚓 СФПД', 'blue', ['command' => $foo[0][0] . ' o:4']);
                        $btn_rcsd = $vk->buttonText('🚨 РКШД', 'blue', ['command' => $foo[0][0] . ' o:2']);
                        $btn_lvpd = $vk->buttonText('🚔 ЛВПД', 'blue', ['command' => $foo[0][0] . ' o:23']);
                        $btn_fbi = $vk->buttonText('　  　　  🕵️ ФБР  　　　  ', 'blue', ['command' => $foo[0][0] . ' o:3']);
                        $btn_all = $vk->buttonText('　  😊 Общий Список   　','white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(1,4,2,23,3))]);
                        $buttons = [[$btn_lspd,$btn_sfpd],[$btn_rcsd,$btn_lvpd],[$btn_fbi],[$btn_all]];
                        $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Юстиции | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                        break;

                    case 2:
                        $btn_lsa = $vk->buttonText('    🎖️ Армия Лос-Сантоса    ', 'green', ['command' => $foo[0][0] . ' o:20']);
                        $btn_sfa = $vk->buttonText('    🎖️ Армия Сан-Фиерро     ', 'green', ['command' => $foo[0][0] . ' o:27']);
                        $btn_msp = $vk->buttonText('🔒 Тюрьма Строго Режима', 'green', ['command' => $foo[0][0] . ' o:7']);
                        $btn_all = $vk->buttonText('         😊 Общий список         ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(20,27,7))]);
                        $buttons = [[$btn_lsa],[$btn_sfa],[$btn_msp],[$btn_all]];
                        $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Обороны | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                        break;

                    case 3:
                        $btn_lsmc = $vk->buttonText('  🏥 Больница Лос-Сантоса  ', 'green', ['command' => $foo[0][0] . ' o:5']);
                        $btn_sfmc = $vk->buttonText('   ⚕️ Больница Сан-Фиерро  ', 'green', ['command' => $foo[0][0] . ' o:8']);
                        $btn_lvmc = $vk->buttonText('💊 Больница Лас-Вентураса', 'green', ['command' => $foo[0][0] . ' o:22']);
                        $btn_all = $vk->buttonText('          😊 Общий список          ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(5,8,22))]);
                        $buttons = [[$btn_lsmc],[$btn_sfmc],[$btn_lvmc],[$btn_all]];
                        $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Здравоохранения | ". $serversname[$foo[2][0] - 1] . " " . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                        break;

                    case 4:
                        $btn_rls = $vk->buttonText('  📰 Радиостанция Лос-Сантоса  ', 'green', ['command' => $foo[0][0] . ' o:10']);
                        $btn_rsf = $vk->buttonText('  🎤 Радиостанция Сан-Фиерро   ', 'green', ['command' => $foo[0][0] . ' o:26']);
                        $btn_rlv = $vk->buttonText('📹 Радиостанция Лас-Вентураса', 'green', ['command' => $foo[0][0] . ' o:24']);
                        $btn_all = $vk->buttonText('          　😊 Общий список　           ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(10,26,24))]);
                        $buttons = [[$btn_rls],[$btn_rsf],[$btn_rlv],[$btn_all]];
                        $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Средств Массовой Информации | ". $serversname[$foo[2][0] - 1] . ' ' . $stickers[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                        break;
                    default:
                        $vk->SendMessage($peer_id,'🤔 Ой-ой! Произошла какая-то ошибка, такого министерства не существует.');
                        break;
                }
            } elseif ($foo[1][0] == 1)
            {
              switch ($foo[4][0]) {
                case 0:
                    $btn_gov = $vk->buttonText('     🇷🇺 Правительство      ', 'blue', ['command' => $foo[0][0] . ' o:4']);
                    $btn_bank = $vk->buttonText('  🏦 Центральный Банк  ', 'green', ['command' => $foo[0][0] . ' o:17']);
                    $btn_all = $vk->buttonText('       😊 Общий список      ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(4,17))]);
                    $buttons = [[$btn_gov],[$btn_bank],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Центрального Аппарата | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;

                case 1:
                    $btn_arz = $vk->buttonText('👮 ПАРЗ', 'blue', ['command' => $foo[0][0] . ' o:1']);
                    $btn_lit = $vk->buttonText('🚓 ПЛЫТ', 'blue', ['command' => $foo[0][0] . ' o:2']);
                    $btn_ed =  $vk->buttonText('🚨 ПЭДО', 'blue', ['command' => $foo[0][0] . ' o:20']);
                    $btn_fsb = $vk->buttonText(' 🕵️ ФСБ ', 'blue', ['command' => $foo[0][0] . ' o:15']);
                    $btn_all = $vk->buttonText('　  😊 Общий список  　', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(1,2,20,15))]);
                    $buttons = [[$btn_arz,$btn_lit],[$btn_ed,$btn_fsb],[$btn_all]];

                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Юстиции | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;
                
                case 2:
                    $btn_army = $vk->buttonText('          🎖️ Армия округа          ', 'green', ['command' => $foo[0][0] . ' o:16']);
                    $btn_msp = $vk->buttonText('🔒 Тюрьма Строго Режима', 'green', ['command' => $foo[0][0] . ' o:18']);
                    $btn_all = $vk->buttonText('         😊 Общий список         ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(16,18))]);
                    $buttons = [[$btn_army],[$btn_msp],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Обороны | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;

                case 3:
                    $btn_arz = $vk->buttonText(' 🏥 Больница Арзамаса ', 'green', ['command' => $foo[0][0] . ' o:3']);
                    $btn_lit = $vk->buttonText('⚕️ Больница Лыткарино', 'green', ['command' => $foo[0][0] . ' o:19']);
                    $btn_ed = $vk->buttonText('     💊 Больница Эдово    ', 'green', ['command' => $foo[0][0] . ' o:8']);
                    $btn_all = $vk->buttonText('        😊 Общий список      ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(3,19,8))]);
                    $buttons = [[$btn_arz],[$btn_lit],[$btn_ed],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг Министерства Здравоохранения | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;

                case 4:
                    $btn_arz = $vk->buttonText('  📰 Радиостанция Арзамас   ', 'green', ['command' => $foo[0][0] . ' o:21']);
                    $btn_lit = $vk->buttonText('🎤 Радиостанция Лыткарино', 'green', ['command' => $foo[0][0] . ' o:6']);
                    $btn_all = $vk->buttonText('           😊 Общий список           ', 'white', ['command' => $foo[0][0] . ' o:0 a:'.json_encode(array(21,6))]);
                    $buttons = [[$btn_arz],[$btn_lit],[$btn_all]];
                    $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг СМИ | ". $serversnamerodina[$foo[2][0] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
                    break;
                default:
                  $vk->SendMessage($peer_id,'🤔 Ой-ой! Произошла какая-то ошибка, такого министерства не существует.');
                  break;
              }
            }
          }
      } elseif(preg_match_all('/p:(\d+) s:(\d+) a:(\d+) c:(\d+) o:(\d+)/',$payload,$foo))
      {
        if(isPermission($id,1))
        {
          if(timecmd($id,5))
          {
            if(preg_match_all('/p:(\d+) s:(\d+) a:(\d+) c:(\d+) o:(\d+) a:(.*)/',$payload,$foo_all) and $foo[5][0] == 0)
            {
              $msg = "";
              $array = json_decode($foo_all[6][0]);
              foreach ($array as $key => $value) {
                $msg .= getOrgMembers($foo_all[1][0],$foo_all[2][0],$value,1);
              }
              $vk->SendMessage($peer_id,"$msg",['disable_mentions' => 1, 'dont_parse_links' => 1]);
            } elseif($foo[5][0] != 0) {
              getOrgMembers($foo[1][0],$foo[2][0],$foo[5][0]);
            }
          }
        }
      }

      if(preg_match_all('/show_members_(\d+)_(\d+)_(\d+)/',$payload,$foo))
      {
          if(isPermission($id,1))
          {
            if(timecmd($id,5))
            {
              showMembers($foo[1][0],$foo[2][0],$foo[3][0]);
            }
          }
      }





    //buffers
    $b = R::findone('buffer','user_id = ?',[$id]);
    if($b)
    {
        if($b->mbuffer)
        { 
            $a = crossServer($message,$arizona_max,$serversname);
            if($a[0]) {
                $btn_state = $vk->buttonText('🇺🇸 Государственные структуры', 'blue', ['command' => 'p:0 s:'.$a[1].' a:0']);
                $btn_maf = $vk->buttonText('     🕵️ Преступные синдикаты    ', 'red', ['command' => 'p:0 s:'.$a[1].' a:1']);
                $btn_ghetto = $vk->buttonText('      🔫 Уличные группировки      ', 'green', ['command' => 'p:0 s:'.$a[1].' a:2']);
                $buttons = [[$btn_state],[$btn_maf],[$btn_ghetto]];
                $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг фракций | ". $serversname[$a[1] - 1] . ' ' . $stickers[$a[1] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
            } else {
                $vk->SendMessage($peer_id,"❌ [id$id|Вы] ввели неверное название или номер сервера,попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
            }
            clearBuffer($id);
        }

        if($b->mrodinabuffer)
        {
            $a = crossServer($message,$rodina_max,$serversnamerodina);
            if($a[0])
            {
                $btn_state = $vk->buttonText('🇷🇺 Гос.структуры', 'blue', ['command' => 'p:1 s:'.$a[1].' a:0']);
                $btn_maf = $vk->buttonText('       🕵️ Мафии       ', 'red', ['command' => 'p:1 s:'.$a[1].' a:1']);
                $btn_ghetto = $vk->buttonText('          🔫 ОПГ          ', 'green', ['command' => 'p:1 s:'.$a[1].' a:2']);
                $buttons = [[$btn_state],[$btn_maf],[$btn_ghetto]];
                $vk->sendButton($peer_id, "[id$id|🖥️] Мониторинг фракций | ". $serversnamerodina[$a[1] - 1],$buttons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);              
            } else {
                $vk->SendMessage($peer_id,"❌ [id$id|Вы] ввели неверное название или номер сервера,попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
            }
            clearBuffer($id);
        }

        if($b->leadbuffer) 
        {
          showLeaders(0,$message);
          clearBuffer($id);
        }

        if($b->leadrodinabuffer) 
        {
          showLeaders(1,$message);
          clearBuffer($id);
        }

        if($b->snbuffer) {
          setNickMe($message);
          clearBuffer($id);
        }

        if($b->sstbuffer) {
          setStatusMe($message);
          clearBuffer($id);
        }

        exit;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    if (mb_substr($messagecmd, 0, 5) == '+menu') {
        if (isPermission($id,1)) {
            if (timecmd($id,5)) {
                $vk->sendButton($peer_id, "Меню пользователя", $btns_menu, true);
            }
        }
        exit;
    }

    if(mb_substr($messagecmd,0,6) == '+mhelp')
    {
      if (isPermission($id, 1, $vk,$peer_id)) {
        if (timecmd($id,5)) {
            $vk->SendMessage($peer_id,"💚 Команды мониторинга:
            \n🌵 Arizona RP
            \n🇺🇸 Государственные структуры
            Центральный Аппарат(+state): +gov | +bank | +as | +insurance 
            Министерство Юстиции(+justice): +fbi | +lspd | +sfpd | +lvpd | +rcsd
            Министерство Обороны(+defence): +lsa | +sfa | +msp
            Министерство Здравоохранения(+health): +lsmc | +sfmc | +lvmc
            Средства Массовой Информации(+media): +rls | +rsf | +rlv
            \n🔫 Нелегальные организации\n
            Банды(+ghetto): +grove | +ballas | +vagos | +rifa | +aztec | +nw
            Мафии(+mafia): +wmc | +rm | +yakuza | +lcn | +brotherhood
            \n🇷🇺 Rodina RP
            \n🇷🇺 Государственные структуры
            Центральный Аппарат(+r_state): +ap | +rbank 
            Министерство Юстиции(+r_justice): +fsb | +arpd | +edpd | +ltpd
            Министерство Обороны(+r_defence): +army | +tsr
            Министерство Здравоохранения(+r_health): +armc | +ltmc | +edmc
            Средства Массовой Информации(+r_media): +rar | +rlt
            \n🔫 Нелегальные организации\n
            ОПГ(+r_edc): +fantom | +cat | +orderlies | +lads
            Мафии(+r_mafia): +rusmafia | +uamafia | +kavkazmafia");
          }
        }
        exit;
    }

    if(mb_substr($messagecmd,0,5) == '+help')
    {
      if(timecmd($id,5))
      {
        help();
      }
      exit;
    }

    if(mb_substr($messagecmd, 0, 12) == "+add_cracker") {
      if (isPermission($id, 4)) {
        if (timecmd($id, 1)) {
          if(preg_match("/^\+add_cracker (.+)/", $messagecmd, $foo)) {
            if(!R::findone('warningwords', 'word = ?', [$foo[1]])) {
              $newWord = R::dispense('warningwords');
              $newWord->word = $foo[1];
              $newWord->add_time = time();
              $newWord->creator = $id;
              R::store($newWord);
              $vk->SendMessage($peer_id, "✔️ Такое слово/предложение успешно было занесено в список слов, для передачи взлом-тем.");
              exit;
            } else {
              $vk->SendMessage($peer_id, "❌ Такое слово/предложение уже занесено в список.");
              exit;
            }
          } else {
            $vk->SendMessage($peer_id, "❌ Неверный синтаксис. \nИспользуйте: +add_cracker [Предложение/Слово]");
            exit;
          }
        }
      }
      exit;
    }

    if(mb_substr($messagecmd, 0, 13) == "+dell_cracker") {
      if (isPermission($id, 4)) {
        if (timecmd($id, 1)) {
          if(preg_match("/^\+dell_cracker (.+)/", $messagecmd, $foo)) {
            $findWord = R::findone('warningwords', 'word = ?', [$foo[1]]);
            if($findWord) {
              R::trash($findWord);
              $vk->SendMessage($peer_id, "✔️ Такое слово/предложение было успешно удалено из реестра.");
              exit;
            } else {
              $vk->SendMessage($peer_id, "❌ Такого слова/предложения не найдено.");
              exit;
            }
          } else {
            $vk->SendMessage($peer_id, "❌ Неверный синтаксис. \nИспользуйте: +dell_cracker [Предложение/Слово]");
            exit;
          }
        }
      }
      exit;
    }


    if(mb_substr($messagecmd, 0, 13) == "+list_cracker") {
      if (isPermission($id, 4)) {
        if (timecmd($id, 1)) {
          if(preg_match("/^\+list_cracker/", $messagecmd, $foo)) {
            $findWord = R::findall('warningwords');
            if($findWord) {
              $msgResult = "📝 Список взлом-продан-слов:\n\n";
              $i = 1;
              foreach ($findWord as $key => $value) {
                $msgResult .= $i . '. ' . $value['word'] . " | Добавил: " . getName($value['creator']) . "\n";
                $i++;
              }
              $vk->SendMessage($peer_id, "$msgResult");
            } else {
              $vk->SendMessage($peer_id, "❌ Кажется список взлом-продан-слов пуст.");
            }

          } else {
            $vk->SendMessage($peer_id, "❌ Неверный синтаксис. \nИспользуйте: +list_cracker");
          }
        }
      }
      exit;
    }

    if(mb_substr($messagecmd, 0, 13) == "+access_tools") {
      if (isToolsPermission($id, 2)) {
        if (timecmd($id, 1)) {
          if(preg_match("/^\+access_tools \[id(\d+)\|.+] (\d+)/", $messagecmd, $foo)) {
            $isFinded = R::Findone('accounts', 'vk_id = ?', [$foo[1]]);
            if($isFinded) {
              if($foo[2] < 0 and $foo[2] > 1) {
                $vk->SendMessage($peer_id, "❌ Неверный синтаксис. \nИспользуйте: +access_tools [Упоминание] [0/1]");
                exit;
              }

              if($isFinded->tester == $foo[2]) {
                $vk->SendMessage($peer_id, "❌ Такое значение доступа тестера уже установлено данному пользователю.");
                exit;
              }

              $isFinded->tester = $foo[2];
              R::store($isFinded);
              if ($foo[2] == 0) {
                $vk->SendMessage($peer_id, "✔️ Доступ тестера снят у [id". $isFinded->vk_id . "|" . getName($isFinded->vk_id) . "]");
              } else {
                $vk->SendMessage($peer_id, "✔️ Доступ тестера успешно выдан для [id". $isFinded->vk_id . "|" . getName($isFinded->vk_id) . "]");
              }
            } else {
              $vk->SendMessage($peer_id, "❌ Указанного пользователя не существует в БД Mint ID.");
            }
          } else {
            $vk->SendMessage($peer_id, "❌ Неверный синтаксис. \nИспользуйте: +access_tools [Упоминание] [0/1]");
          }
        }
      }
      exit;
    }

    if(mb_substr($messagecmd,0,5) == '+frac')
    {
      if(isPermission($id,1))
      {
        if(timecmd($id,5))
        {
          if(preg_match_all('/\+frac (\d+) (.+) (.+)/',$message,$foo))
          {
            if($foo[1][0] >= 0 && $foo[1][0] <= 1) {
              $a;
              if($foo[1][0] == 0) {
                $a = crossServer($foo[2][0],$arizona_max,$serversname);
              } elseif($foo[1][0] == 1) {
                $a = crossServer($foo[2][0],$rodina_max,$serversnamerodina);
              }

              if($a[0]) {
                $url = 'https://api.mint-plantation.com/player.php?p='.$foo[1][0].'&s='.$a[1].'&n='.$foo[3][0];
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: -"));
                $array = json_decode(curl_exec($curl),true);
                curl_close($curl);

                if($array['error'] == 0) {
                  if($array['isOnline']) {
                    $array['isOnline'] = 'В сети';
                  } else {
                    $array['isOnline'] = 'Не в сети';
                  }
                  if($foo[1][0] == 0) {
                    $vk->SendMessage($peer_id,'ℹ Информация по нику '.$array['name']." | ID: ".$array['id']."\nОрганизация: ".$org_names_arizona[$array['org']]."\nРанг: ".$array['rankLabel']." [".$array['rank']."]\nПодключение: ".$array['isOnline']);
                  } elseif($foo[1][0 == 1]) {
                    $vk->SendMessage($peer_id,'ℹ Информация по нику '.$array['name']."\nОрганизация: ".$org_names_rodina[$array['org']]."\nРанг: ".$array['rank']."\nПодключение: ".$array['isOnline']);
                  }
                  
                } elseif($array['error'] == 11) {
                  $vk->SendMessage($peer_id,"ℹ " . $foo[3][0] . " не найден в базе данных игроков состоящих в организациях!");
                } else {
                  $vk->SendMessage($peer_id,"❌ Произошла неизвестная ошибка, сообщите разработчику!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
                }

              } else {
                $vk->SendMessage($peer_id,"❌ [id$id|Вы] ввели неверное название или номер сервера,попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
                exit;
              }


            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +frac [0 - ARZ / 1 - Rodina] [№ / Название сервера] [Ник]");
            }

          } else {
            $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +frac [0 - ARZ / 1 - Rodina] [№ / Название] [Ник]");
          }
        }
      }
      exit;
    }


    if(mb_substr($messagecmd,0,5) == '+nick')
    {
      if(timecmd($id)) {
        if(preg_match('/\+nick (.+)/',$message,$foo)) {
          setNickMe($foo[1]);
        } else {
          $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +nick [Ник]");
        }
      }
      exit;
    }

    if(mb_substr($messagecmd,0,7) == '+status')
    {
      if(timecmd($id)) {
        if(preg_match('/\+status (.+)/',$message,$foo)) {
          setStatusMe($foo[1]);
        } else {
          $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +status [Статус]");
        }
      }
      exit;
    }

    if(mb_substr($messagecmd,0,8) == '+leaders')
    {
      if(isPermission($id,1))
      {
        if(timecmd($id,5))
        {
          if(preg_match_all('/\+leaders (\d+) (.+)/',$message,$foo))
          {
            showLeaders($foo[1][0],$foo[2][0]);
          } else {
            $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +leaders [0 - ARZ / 1 - Rodina] [№ / Название]");
          }
        }
      }
      exit;
    }

    if(mb_substr($messagecmd, 0, 6) == '+linfo') {
      if(isPermission($id, 3)) {
        if (timecmd($id,5)) {
          if(preg_match('/\+linfo (.+)/', $message, $foo)) {
            $logApi = new LogApi("dev.leekyraveofficial@gmail.com", "p2429twZssSv");
            $request = $logApi->getInfoNick($foo[1], 19);
            if($request[0]) {
              $vk->SendMessage($peer_id, "Информация по нику " . $foo[1]  . "[".$request[1]['id'] . "]\nУровень администрирования: " . $request[1]['alvl'] . "\nУровень хелперки: " . $request[1]['hlvl'] . "\nУровень аккаунта: " . $request[1]['lvl'] . "\nДеньги: " . $request[1]['money'] . "$\nДеньги(БАНК): " . $request[1]['bank'] . "$\nДепозит: " . $request[1]['deposit'] . "$\nДонат: " . $request[1]['donate'] . " az");
            } elseif ($request[1] == 'Not Found') {
              $vk->SendMessage($peer_id, "❌ Такого ника не найдено!");
            } elseif ($request[1] == "Error") {
              $vk->SendMessage($peer_id, "❌ Произошла неизвестная ошибочка, вероятно нету доступа к логам!");
            } elseif ($request[1] == "Accept") {
              $vk->SendMessage($peer_id, "❌ На почту, к которой привязан аккаунт логов пришло письмо подтверждения.");
            }

          } else {
            $vk->SendMesssage($peer_id, "❌ Неверный синтаксис.\nИспользуйте: +linfo [Nick_Name]");
          }
        }
      }
      exit;
    }


    if(mb_substr($messagecmd,0,9) == '+deputies')
    {
      if(isPermission($id,1))
      {
        if(timecmd($id,5))
        {
          if(preg_match_all('/\+deputies (\d+) (.+)/',$message,$foo))
          {
            showDeputies($foo[1][0],$foo[2][0]);
          } else {
            $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +deputies [0 - ARZ / 1 - Rodina] [№ / Название]");
          }
        }
      }
      exit;
    }

  
  


    if(mb_substr($messagecmd,0,5) == '+info') {
      if(preg_match_all('/\+info (.+)/',$message,$foo))
      {
        if(preg_match('/\[id(\d+)\|[a-zA-Zа-яА-Я\s*@\.\-\!\*\d*\_]+\]/',$foo[1][0],$matchedbyId)) {
          showStats($matchedbyId[1]);
        } else {
          $findNick = R::findone('users', 'nick = ?', [$foo[1][0]]);
          if($findNick) {
            showStats($findNick->user_id);
          } else {
            $vk->SendMessage($peer_id,"❌ Пользователя с таким ником не существует в нашей базе данных.");
          }
          
        }
      } else {
        $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +info [Ник/Упоминание]");
      }
      exit;
    }

    if(mb_substr($messagecmd,0,7) == '+access') {
      if(preg_match('/\+access \[id(\d+)\|[a-zA-Zа-яА-Я\s*@\.\-\!\*\d*\_]+\]/',$message,$matchedbyId)) {
        regUser($matchedbyId[1]);
        if(preg_match('')) {

        } else {
          $acces_1 = $vk->buttonText('1&#8419;', 'green', ['command' => 'access_1_'. $matchedbyId[1]]);
          $acces_2 = $vk->buttonText('2&#8419;', 'green', ['command' => 'access_2_'. $matchedbyId[1]]);
          $acces_3 = $vk->buttonText('3&#8419;', 'green', ['command' => 'access_3_'. $matchedbyId[1]]);
          $acces_4 = $vk->buttonText('4&#8419;', 'red', ['command' => 'access_4_'. $matchedbyId[1]]);
          $acces_5 = $vk->buttonText('5&#8419;', 'red', ['command' => 'access_5_'. $matchedbyId[1]]);
          $acces_6 = $vk->buttonText('6&#8419;', 'red', ['command' => 'access_6_'. $matchedbyId[1]]);
          
          $accessButtons = [[$acces_1,$acces_2,$acces_3],[$acces_4,$acces_5,$acces_6]];

          $vk->sendButton($peer_id, "💳 Выдача доступа [id".$matchedbyId[1]."|". getNick($matchedbyId[1])."]", $accessButtons, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
          
        }
      } else {
        $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +access [Упоминание] [Уровень доступа]");
      }
    }

    if(mb_substr($messagecmd,0,6) == '+tinfo') {
      if(preg_match_all('/\+tinfo (.+)/',$message,$foo))
      {
        if(preg_match('/\[id(\d+)\|[a-zA-Zа-яА-Я\s*@\.\-\!\*\d*\_]+\]/',$foo[1][0],$matchedbyId)) {
          showStatsTesters($matchedbyId[1]);
        } else {
          $findNick = R::findone('accounts', 'nick = ?', [$foo[1][0]]);
          if($findNick) {
            showStatsTesters($findNick->vk_id);
          } else {
            $vk->SendMessage($peer_id,"❌ Пользователя с таким ником не существует в БД тестеров.");
          }
          
        }
      } else {
        $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +tinfo [Ник/Упоминание]");
      }
      exit;
    }

    if(mb_substr($messagecmd,0,8) == '+checkip') {
      if(preg_match('/\+checkip (.+)/',$message,$foo))
      {
        if(preg_match_all('/(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/',$foo[1],$ipMatch)) {
          if($ipMatch[0][1]) {
            $url = 'https://api.mint-plantation.com/geoip.php?reg='.$ipMatch[0][0].'&last='.$ipMatch[0][1];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $ipArray = json_decode(curl_exec($curl),true);
            curl_close($curl);

            if($ipArray['error'] == 0) {
              $vk->SendMessage($peer_id,"✅ Запрос успешно выполнен.
              Первый IP: ". $ipMatch[0][0] ."
              Провайдер: ". $ipArray['reg']['provider'] ."
              Страна: ". $ipArray['reg']['country'] ."
              Город: ". $ipArray['reg']['city'] ."
              
              Второй IP: " . $ipMatch[0][1] ."
              Провайдер: ". $ipArray['last']['provider'] ."
              Страна: ". $ipArray['last']['country'] ."
              Город: ". $ipArray['last']['city'] ."
              
              Расстояние между IP ~".$ipArray['distance']."км");
            } else {
              $vk->SendMessage($peer_id,"❌ Произошла неизвестная ошибка, сообщите разработчику!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
            }
          } else {
            $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +checkip [IP] [2-IP]");
          }
        }
      } else {
        $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +checkip [IP] [2-IP]");
      }
      exit;
    }

    if(mb_substr($messagecmd,0,9) == '+settings')
    {
      if(isPermission($id,1))
      {
        if(timecmd($id,5))
        {
          $vk->sendButton($peer_id, "⚙️ Настройки", $btns_profile, true);
        }
      }
      exit;
    }

    if(mb_substr($messagecmd,0,17) == '+getconservations') {
      if(isPermission($id,2)) {
        $vk->SendMessage($peer_id,"[Инициализация] Инициализирую проверку бесед,в которых я состою.");
        $start = microtime(true);
        foreach(range(2000000001, 2000000370) as $peer_i){
          $chat_data = $vk->request('messages.getConversationsById', ['peer_ids' => $peer_i, 'extended' => 0]);
          $newchat_id = $peer_i - 2000000000;
          $title = $chat_data['items'][0]['chat_settings']['title'];
          $vk->SendMessage($peer_id,"Название: $title\n"."ID беседы: $newchat_id");
          sleep(0.1);
        }
       }
       exit;
    }
    if(mb_substr($messagecmd,0,6) == '+minfo') {
        showStats($id);
        exit;
      }

    if(mb_substr($messagecmd,0,8) == '+records')
    {
      if(isPermission($id,1))
      {
        if(timecmd($id,5))
        {
          if(preg_match_all('/\+records (.+)/',$message,$foo))
          {
            if($foo[1][0] == 'Sargon_Loud') {
              $vk->SendMessage($peer_id,"📝 Рекорды поставленные Sargon_Loud\n\nArizona — Найдено самое большое количество багов на Аризоне и за это ему выделено отдельные три строчки кода в боте.");
              exit;
            }
            $url = 'https://api.mint-plantation.com/records.php?n='.$foo[1][0];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: -"));
            $array = json_decode(curl_exec($curl),true);
            curl_close($curl);

            if($array['error'] == 0) {
              $msg = "";
              foreach($array['row'] as $key => $value) {
                preg_match_all('/(.+) .+/',$value['date'],$tfoo);
                $recordDate = preg_replace('/\./','-',$tfoo[1][0]);
                if($value['project'] == 0) {
                  $msg .=  'Arizona — ' . $serversname[$value['server'] - 1] . ' | ' . $org_names_arizona[$value['org']] . ' | ' . $value['record'] . ' чел. | ' . $recordDate . "\n";
                } elseif($value['project'] == 1) {
                  $msg .=  'Rodina — ' . $serversnamerodina[$value['server'] - 1] . ' | ' . $org_names_rodina[$value['org']] . ' | ' . $value['record'] . ' чел. | ' . $recordDate . "\n";
                }
              }
              $vk->SendMessage($peer_id,"📝 Рекорды поставленные ".$foo[1][0]."\n\n". $msg);
            } elseif($array['error'] == '14') {
              $vk->SendMessage($peer_id,'📝 Рекорды поставленные ' . $foo[1][0] . ' не найдены.');
            }
          } else {
            $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +records [Ник]");
          }
        }
      }
      exit;
    }

    $orgs_commands = array(
      'lspd',
      'rcsd',
      'fbi',
      'sfpd',
      'lsmc',
      'gov',
      'msp',
      'sfmc',
      'as',
      'rls',
      'grove',
      'vagos',
      'ballas',
      'aztec',
      'rifa',
      'rm',
      'yakuza',
      'lcn',
      'wmc',
      'lsa',
      'bank',
      'lvmc',
      'lvpd',
      'rlv',
      'nw',
      'rsf',
      'sfa',
      'brotherhood',
      'insurance',
      
      'arpd', // 1
      'ltpd', // 2
      'armc', // 3
      'ap', // 4
      'aschool', // 5
      'rlt', // 6
      'fantom', // 7
      'edmc', // 8
      'cat', // 9
      'orderlies', // 10
      'lads', // 11
      'rusmafia', // 12
      'uamafia', // 13
      'kavkazmafia', // 14
      'fsb', // 15
      'army', // 16
      'rbank', // 17
      'tsr', // 18
      'ltmc', // 19
      'edpd',  // 20
      'rar', // 21
    );

    if(preg_match_all('/\+(\w+)/',$messagecmd,$matched))
    {
      $flipped = array_flip($orgs_commands);
      if(array_key_exists($matched[1][0],$flipped))
      {
        if(isPermission($id,1))
        {
          if(timecmd($id,5))
          {
            if(preg_match_all('/\+(\w+)\s+(.*)/',$messagecmd,$foo))
            {
              if($flipped[$matched[1][0]] > 28)
              {
                $a = crossServer($foo[2][0], $rodina_max, $serversnamerodina);
                if($a[0])
                {
                  getOrgMembers(1,$a[1],$flipped[$matched[1][0]] - 28);
                } else {
                  $vk->SendMessage($peer_id,"[id$id|❌] Неверное название или номер сервера, попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
                }
              } elseif ($flipped[$matched[1][0]] <= 28)
              {
                $a = crossServer($foo[2][0], $arizona_max, $serversname);
                if($a[0])
                {
                  getOrgMembers(0,$a[1],$flipped[$matched[1][0]] + 1);
                } else {
                  $vk->SendMessage($peer_id,"[id$id|❌] Неверное название или номер сервера, попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
                }
              }
              
            } else {
              $vk->SendMessage($peer_id,"[id$id|❌] Неверный синтаксис! Используйте: +". $matched[1][0] ." [Номер / Название]", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
            }
          }
        }
        exit;
      }
    }

    $orgs_commands_all = array(
      'state' => array(6,21,9,29),
      'justice' => array(1,4,2,23,3),
      'defence' => array(20,27,7),
      'health' => array(5,8,22),
      'media' => array(10,26,24),
      'ghetto' => array(11,13,12,14,15,25),
      'mafia' => array(17,18,16,19),

      'r_state' => array(4,17),
      'r_justice' => array(1,2,20,15),
      'r_defence' => array(16,18),
      'r_health' => array(3,19,8),
      'r_media' => array(21,6),
      'r_edc' => array(10,9,11,7),
      'r_mafia' => array(12,13,14)
    );
    if(preg_match_all('/\+(\w+)/',$messagecmd,$matched))
    {
      if(array_key_exists($matched[1][0],$orgs_commands_all))
      {
        if(isPermission($id,1))
        {
          if(timecmd($id,5))
          {
            if(preg_match_all('/\+(\w+)\s+(.*)/',$messagecmd,$foo))
            {
              if(preg_match_all('/\+r_.*/',$messagecmd))
              {
                $a = crossServer($foo[2][0], $rodina_max, $serversnamerodina);
                if($a[0])
                {
                  $msg = '';
                  foreach ($orgs_commands_all[$matched[1][0]] as $key => $value) {
                    $msg .= getOrgMembers(1,$a[1],$value,1);
                  }
                  $vk->SendMessage($peer_id,$msg);
                }
              } else {
                $a = crossServer($foo[2][0], $arizona_max, $serversname);
                if($a[0])
                {
                  $msg = '';
                  foreach ($orgs_commands_all[$matched[1][0]] as $key => $value) {
                    $msg .= getOrgMembers(0,$a[1],$value,1);
                  }
                  $vk->SendMessage($peer_id,$msg);
                } else {
                  $vk->SendMessage($peer_id,"[id$id|❌] Неверное название или номер сервера, попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
                }
              }
            } else {
              $vk->SendMessage($peer_id,"[id$id|❌] Неверный синтаксис! Используйте: +". $matched[1][0] ." [Номер / Название]", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
            }
          }
        }
        exit;
      }
    }

    if(preg_match_all('/^\+stabing/', $messagecmd)) {
      $vk_test = vk_api::create("vk1.a.7pGyBdUOjKY8rTnZdj-8OH6_cPVTez59vCsffDzcdKRgjqwTAbW-PrSMggpF-nWpZQXqTgu22RdemC0vPH7KWaVLrK727pggPMxrWLFsNL5KbGPkbI00UU4EZe71bRVbPAeEHUB1URin4laJA1QBwvZTR_zIhex8e4KDKxGNtryuQKJ9oVHsDTZDHaW6zhhA", '5.126');
      
      while (true) {
        $unreadMessages = $vk_test->request('messages.getConversations',["filter" => "unread"]);
        $vk_test->request('status.set',['text' => "🤓 Непрочитанных сообщений: " . $unreadMessages['unread_count']]);
        sleep(60);
      }
      exit;
    }

    if($peer_id == 2000000595) {
      if(isPermission($id,1)) {
        
          if(mb_substr($messagecmd,0,4) == '+pin') {
            if(preg_match('/^\+pin https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$messagecmd, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->pinThread($foo[1]);
              if($request[0]) {
                $vk->SendMessage($peer_id, "✅ Тема успешно закреплена");
              } else {
                $vk->SendMessage($peer_id, "❌ " . $request[1]);
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +pin [URL]");
            }
            exit;
          }
  
          if(mb_substr($messagecmd,0,6) == '+unpin') {
            if(preg_match('/^\+unpin https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$messagecmd, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->unpinThread($foo[1]);
              if($request[0]) {
                $vk->SendMessage($peer_id, "✅ Тема успешно откреплена");
              } else {
                $vk->SendMessage($peer_id, "❌ " . $request[1]);
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +unpin [URL]");
            }
            exit;
          }
  
          if(mb_substr($messagecmd,0,6) == '+close') {
            if(preg_match('/^\+close https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$messagecmd, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->closeThread($foo[1]);
              if($request[0]) {
                $vk->SendMessage($peer_id, "✅ Тема успешно закрыта.");
              } else {
                $vk->SendMessage($peer_id, "❌ " . $request[1]);
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +close [URL]");
            }
            exit;
          }
  
          if(mb_substr($messagecmd,0,5) == '+open') {
            if(preg_match('/^\+open https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$messagecmd, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->openThread($foo[1]);
              if($request[0]) {
                $vk->SendMessage($peer_id, "✅ Тема успешно открыта.");
              } else {
                $vk->SendMessage($peer_id, "❌ " . $request[1]);
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +open [URL]");
            }
            exit;
          }

          if(mb_substr($messagecmd,0,10) == '+setprefix') {
            if(preg_match('/^\+setprefix https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*\s+(.+)/',$message, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->setPrefix($foo[1], $foo[2]);
              if($request[0]) {
                $vk->SendMessage($peer_id, '✅ Заданный тэг "'.$foo[2].'" для темы успешно установлен.');
              } else {
                $vk->SendMessage($peer_id, "❌ " . $request[1]);
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +setprefix [URL] [Префикс]");
            }
            exit;
          }


          if(mb_substr($messagecmd,0,11) == '+multiclose') {
            if(preg_match('/^\+multiclose https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$message, $foo)) {
              $forumapi = new ForumApi();
              $forumapi->flogin("leekyraveofficial@gmail.com", "p2429twZssSv");
              $request = $forumapi->setPrefix($foo[1], "Рассмотрено");
              $requestUnPin = $forumapi->unpinThread($foo[1]);
              $requestClose = $forumapi->closeThread($foo[1]);

              if($request[0]) {
                $vk->SendMessage($peer_id, '✅ Тема закрыта, префикс "Рассмотрено" установлен, тема откреплена.');
              } else {
                $vk->SendMessage($peer_id, '❌ Произошла ошибка, префикса "Рассмотрено" не существует в этом разделе.');
              }
            } else {
              $vk->SendMessage($peer_id,"❌ Неверный синтаксис. Используйте: +multiclose [URL] [Префикс]");
            }
            exit;
          }
        

      }

      

    }

    if(preg_match_all("/^\+peer_id/",$messagecmd)) {
      $vk->SendMessage($peer_id,"Conversation ID: $peer_id");
      exit;
    }

    if(preg_match_all('/^\+[[:alpha:]]/',$messagecmd))
    {
        $vk->SendMessage($peer_id,"[id$id|❌] Такой команды не существует!\n⚠️ Используйте: +help", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
        exit;
    }
}




function regUser($id) 
{
    global $vk;
    global $log;
    global $peer_id;
    $idgroup = mb_substr($id, 0, 1);
    if ($idgroup == "-") {
      exit;
    }
    $userInfo = $vk->request("users.get", ["user_ids" => $id]);
    $first_name = $userInfo[0]['first_name'];
    $last_name = $userInfo[0]['last_name'];
    $user = R::findOne('users', 'user_id = ?', [$id]);
    if (!$user) {
        $newUser = R::dispense("users"); // Выбрали таблицу
        $newUser->user_id = $id; // Столбец id пользователя вк
        $newUser->nick = ""; // Столбец для ник, для только пришедшего ставим его имя
        $newUser->name = $first_name . " " . $last_name;
        $newUser->dostyp = 1; // Столбец в котором можно будет поменять значение на 1 и использовать как проверку на админ доступ к боту
        $newUser->status = "";
        $newUser->lupdate = 0;
        $newUser->swarn = 0;
        $newUser->linkto = 0;
        $newUser->cooldown = 0;
        $newUser->regDate = date("d.m.Y, H:i:s"); // Столбец дата регистрации
        R::store($newUser); // Записали в базу


        $chat_data = $vk->request('messages.getConversationsById', ['peer_ids' => $peer_id, 'extended' => 0]);
        $title = $chat_data['items'][0]['chat_settings']['title'];
        $vk->sendMessage($log, "[id$id|$first_name $last_name] был добавлен в базу данных по отправке сообщения.\nИсточник: $title ($peer_id)", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
    }
}


/**
 * Get User Permission
 * @param int $id — user's vk id
 * @param int $lvl — compared value
 * @param object $vk - library
 * @param int $peer_id - conversation id
 * @return bool
 *
 */

function isPermission($id, $lvl,$variant = 1)
{
    global $vk;
    global $peer_id;

    $getdostyp = R::findone('users', 'user_id = ?', [$id]);
    $getdostyp = $getdostyp->dostyp;
    if ($getdostyp >= $lvl) {
        return true;
    } else {
    if($variant == 1) {
        $vk->sendMessage($peer_id, "Данная команда доступна с " . $lvl . " уровня доступа. У вас: " . $getdostyp . ".");
    }
        return false;
    }
}

function isToolsPermission($id, $lvl,$variant = 1)
{
    global $vk;
    global $peer_id;

    $getdostyp = R::findone('accounts', 'vk_id = ?', [$id]);
    $getdostyp = $getdostyp->access;
    if ($getdostyp >= $lvl) {
        return true;
    } else {
    if($variant == 1) {
        $vk->sendMessage($peer_id, "Данная команда доступна с " . $lvl . " уровня доступа Mint ID. У вас: " . $getdostyp . ".");
    }
        return false;
    }
}

function setNickMe($nick)
{
  global $id;
  global $vk;
  global $peer_id;
  if(isPermission($id,1)) {
    $user = R::findone('users','user_id = ?',[$id]);
    if($user) {
      if($user->nick == $nick) {
        $vk->SendMessage($peer_id,"❌ У вас уже установлен данный ник!");
      } else {
        $isReal = R::findone('users','nick = ?',[$nick]);
        if($isReal)
        {
          $vk->SendMessage($peer_id,"❌ Данный ник уже установлен для [id". $isReal->user_id . "|" . getName($s->user_id) . "]",['disable_mentions' => 1, 'dont_parse_links' => 1]);
        } else {
          $user->nick = $nick;
          R::store($user);
          $vk->SendMessage($peer_id,'✔️ Вы успешно установили "'.$nick.'" в качестве ник-нейма.');
          regUpdate($id,$id);
        }
      }
    }
  }
  clearBuffer($id);
}

function setStatusMe($status)
{
  global $id;
  global $vk;
  global $peer_id;
  if(isPermission($id,1)) {
    $user = R::findone('users','user_id = ?',[$id]);
    if($user) {
      $user->status = $status;
      R::store($user);
      $vk->SendMessage($peer_id,'✔️ Вы успешно установили "'.$status.'" в качестве статуса.');
      regUpdate($id,$id);
    }
  }
  clearBuffer($id);
}


/**
 * Get User Permission
 * @param int $id — user's vk id
 * @return int
 *
 */

function getPermission($id)
{
  $getdostyp = R::findone('users', 'user_id = ?', [$id]);
  if ($getdostyp) {
    return $getdostyp->dostyp;
  } else {
    return 1;
  }
}

function IsinBuffer($id)
{
    $b = R::findone('buffer','user_id = ?',[$id]);
    if($b)
    {
        return true;
    } else {
        return false;
    }
}

function clearBuffer($id)
{
  if(IsinBuffer($id))
  {
    $b = R::findone('buffer','user_id = ?',[$id]);
    R::trash($b);
  }
}



/**
 * Cooldown between cmds or sending text
 * @param int $id — user's vk id
 * @param object $vk — library
 * @param int $peer_id — user_id/conversation_id
 * @return bool
 *
 */

function timecmd($id,$cd = 5)
{
    global $vk;
    global $peer_id;
    $timecmd = R::findone('users', 'user_id = ?', [$id]);
    if ($timecmd) {
        $resultcd = time() - $timecmd->cooldown;
        if ($resultcd >= $cd) {
        $timecmd->cooldown = time();
        R::store($timecmd);
        return true;
        } else {
        $resultcd = $cd - $resultcd;
        
        $vk->sendMessage($peer_id, "Не так быстро, я могу перегреться!\nПодождите еще $resultcd ". numberof($resultcd, 'секун', array('ду', 'ды', 'д')) . ".");
        return false;
        }
    }
}


function getName($id)
{
    global $vk;
    if($id == 0) {
        return "Система";
    } else {
        $userInfo = $vk->request("users.get", ["user_ids" => $id]);
        $first_name = $userInfo[0]['first_name'];
        $last_name = $userInfo[0]['last_name'];
        $full_name = $first_name . " " . $last_name;
        return $full_name;
    }
}

function getNick($id)
{
    if(isLeader($id))
    {
        $i = R::findone('leaders','user_id = ?',[$id]);
        return $i->nick;
    } else {
        $i = R::findone('users','user_id = ?',[$id]);
        if($i->nick == "")
        {
            return getName($id);
        } else {
            return $i->nick;
        }
    }
}

function regUpdate($id,$updater)
{
    $l = R::findone('users','user_id = ?',[$id]);
    $l->lupdate = $updater;
    R::store($l);
}

function isLeader($id)
{
    $isl = R::findone('leaders','user_id = ?',[$id]);
    if($isl) {
        return true;
    } else {
        return false;
    }
}



function showStats($id)
{
  global $vk;
  global $peer_id;
  if(isPermission($id,1))
  {
    if(timecmd($id))
    {
      regUser($id);
      
      $user = R::findone('users', 'user_id = ?', [$id]);
      $nickUser;
      $statusUser;
      if(iconv_strlen($user->nick) == 0) {
        $nickUser = "Не установлен";
      } else {
        $nickUser = $user->nick;
      }

      if(iconv_strlen($user->status) == 0) {
        $statusUser = "Не установлен";
      } else {
        $statusUser = $user->status;
      }
      $pinnedBy;
      if($user->linkto == 0) {
        $pinnedBy = '📍 Не закреплен за сервером';
      } else {
        $pinnedBy = '📍 Закреплен за '.$user->linkto.' сервером';
      }

      $lupdate;
      if($user->lupdate == 0) {
        $lupdate = getName($user->lupdate);
      } else {
        $lupdate = "[id" . $user->lupdate . "|". getName($user->lupdate) . "]";
      }

      $vk->SendMessage($peer_id,"ℹ Информация о пользователе [id" . $id . "|" . getName($id) . "]\n📄 Ник-нейм: $nickUser\n🆔 ID в БД: " . $user->id . "\n📖 Статус пользователя: $statusUser\n$pinnedBy\n🔃 Последнее обновление: $lupdate", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
    }
  }
}


function showStatsTesters($idu)
{
  global $vk;
  global $peer_id;
  global $id;
  if(isToolsPermission($id,2))
  {
    if(timecmd($id))
    {
      regUser($id);
      
      $user = R::findone('accounts', 'vk_id = ?', [$idu]);
      $date = new DateTime();
      $date->setTimestamp($user->last_time);

      $vk->SendMessage($peer_id,"ℹ Информация о пользователе [id" . $idu . "|" . getName($idu) . "]\nЛогин: ". $user->login ."\nНик: " . $user->nick . "\nУровень доступа: " . $user->access . "\nReg IP: " . $user->reg_ip . "\nLast IP: " . $user->last_ip . "\nReg Serial: " . $user->reg_serial . "\nLast Serial: " . $user->last_serial . "\nLast login: " . $date->format('d.m.Y | H:i:s'), ['disable_mentions' => 1, 'dont_parse_links' => 1]);
    }
  }
}

/**
 * Склонение числительных
 * @param int $numberof — склоняемое число
 * @param string $value — первая часть слова (можно назвать корнем)
 * @param array $suffix — массив возможных окончаний слов
 * @return string
 *
 */

function numberof($numberof, $value, $suffix)
{
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $numberof % 100;
    $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];
     
    return $value . $suffix[$suffix_key];
}


function help()
{
  global $vk;
  global $id;
  global $peer_id;
  $permission = getPermission($id);
  if(isPermission($id,1))
  {
    $helpcmd = "📝 Список доступных команд:\n";
    if($permission >= 1)
    {
      $helpcmd .= "
      🌕 || +menu     - открыть меню пользователя
      🌕 || +settings - ваши настройки профиля
      🌕 || +nick     - устанавливает вам указанный ник глобально
      🌕 || +status   - устанавливает вам указанный статус
      🌕 || +info     - просмотреть информацию о пользователе
      🌕 || +minfo    - просмотреть информацию о себе
      🌕 || +mhelp    - посмотреть команды мониторинга
      🌕 || +leaders  - посмотреть список лидеров
      🌕 || +deputies - посмотреть список заместителей
      🌕 || +frac     - посмотреть в какой организации состоит игрок
      🌕 || +records  - посмотреть рекорды установленные игроком
      🌕 || +pin      - закрепить тему на форуме(доступно только администрации)
      🌕 || +unpin    - открепить тему на форуме(доступно только администрации)
      🌕 || +close    - закрыть тему на форуме(доступно только администрации)
      🌕 || +open     - открыть тему на форуме(доступно только администрации)
      🌕 || +setprefix - установить префикс теме на форуме(доступно только администрации)
      🌑 || +cset     - настройки беседы";
    }


    $helpcmd .= "
    
    Примечания к командам:
    - Если смайлик '🌑' - то на данный момент команда недоступна!
    - Если смайлик '⚠' - то команда доступна, но возможны баги!";

    $vk->SendMessage($peer_id,$helpcmd);
  }
}

function showLeaders($project,$server)
{
  global $vk;
  global $id;
  global $peer_id;
  global $arizona_max;
  global $serversnamerodina;
  global $rodina_max;
  global $org_names_arizona;
  global $org_names_rodina;
  global $serversname;

  if($project >= 0 && $project <= 1) {
    $a;
    if($project == 0) {
      $a = crossServer($server,$arizona_max,$serversname);
    } elseif($project == 1) {
      $a = crossServer($server,$rodina_max,$serversnamerodina);
    }

    if($a[0]) {
      $url = 'https://api.mint-plantation.com/leaders.php?p='.$project.'&s='.$a[1];
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: -"));
      $array = json_decode(curl_exec($curl),true);
      curl_close($curl);

      if($array['error'] == 0) {
        if($array['isOnline']) {
          $array['isOnline'] = 'В сети';
        } else {
          $array['isOnline'] = 'Не в сети';
        }
        $msg = "";
        foreach($array[0] as $key => $value) {
          $online;
          if($value['isOnline'])
          {
            $online = "🌝";
          } else {
            $online = "🌚";
          }

          if($project == 0) {
            $msg .= $value['name'] . "[".$value['rankLabel']."] — " . $org_names_arizona[$value['org']] ." | $online\n";
          } elseif($project == 1) {
            $msg .= $value['name'] . " — " . $org_names_rodina[$value['org']] ." | $online\n";
          }
        }

        if($project == 0) {
          $vk->SendMessage($peer_id,"📝 Список лидеров | " . $serversname[$a[1] - 1] . "\n\n$msg");
        } elseif($project == 1) {
          $vk->SendMessage($peer_id,"📝 Список лидеров | " . $serversnamerodina[$a[1] - 1] . "\n\n$msg");
        }
        

        
      } elseif($array['error'] == 13) {
        $vk->SendMessage($peer_id,"📝 На сервере " . $serversnamerodina[$a[1] - 1] . " не стоит ни один лидер!");
      } else {
        $vk->SendMessage($peer_id,"❌ Произошла неизвестная ошибка, сообщите разработчику!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
      }

    } else {
      $vk->SendMessage($peer_id,"❌ [id$id|Вы] ввели неверное название или номер сервера,попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
      exit;
    }


  } else {
    $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +leaders [0 - ARZ / 1 - Rodina] [№ / Название сервера]");
  }
  
}

function showDeputies($project,$server)
{
  global $vk;
  global $id;
  global $peer_id;
  global $arizona_max;
  global $serversnamerodina;
  global $rodina_max;
  global $org_names_arizona;
  global $org_names_rodina;
  global $serversname;

  if($project >= 0 && $project <= 1) {
    $a;
    if($project == 0) {
      $a = crossServer($server,$arizona_max,$serversname);
    } elseif($project == 1) {
      $a = crossServer($server,$rodina_max,$serversnamerodina);
    }

    if($a[0]) {
      $url = 'https://api.mint-plantation.com/deputies.php?p='.$project.'&s='.$a[1];
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: -"));
      $array = json_decode(curl_exec($curl),true);
      curl_close($curl);

      if((int)$array['error'] == 0) {
        if($array['isOnline']) {
          $array['isOnline'] = 'В сети';
        } else {
          $array['isOnline'] = 'Не в сети';
        }
        $msg = "";
        foreach($array[0] as $key => $value) {
          $online;
          if($value['isOnline'])
          {
            $online = "🌝";
          } else {
            $online = "🌚";
          }

          if((int)$project == 0) {
            $msg .= $value['name'] . "[".$value['rankLabel']."] — " . $org_names_arizona[$value['org']] ." | $online\n";
          } elseif((int)$project == 1) {
            $msg .= $value['name'] . " — " . $org_names_rodina[$value['org']] ." | $online\n";
          }
        }

        if((int)$project == 0) {
          $vk->SendMessage($peer_id,"📝 Список заместителей | " . $serversname[$a[1] - 1] . "\n\n$msg");
        } elseif((int)$project == 1) {
          $vk->SendMessage($peer_id,"📝 Список заместителей | " . $serversnamerodina[$a[1] - 1] . "\n\n$msg");
        }
        

        
      } elseif((int)$array['error'] == 13) {
        $vk->SendMessage($peer_id,"📝 На сервере " . $serversnamerodina[$a[1] - 1] . " не стоит ни один заместитель!");
      } else {
        $vk->SendMessage($peer_id,"❌ Произошла неизвестная ошибка, сообщите разработчику!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
      }

    } else {
      $vk->SendMessage($peer_id,"❌ [id$id|Вы] ввели неверное название или номер сервера,попробуйте еще раз!",['disable_mentions' => 1, 'dont_parse_links' => 1]);
      exit;
    }


  } else {
    $vk->SendMessage($peer_id,"❌ Неверный синтаксис.\nИспользуйте: +deputies [0 - ARZ / 1 - Rodina] [№ / Название сервера]");
  }
  
}


function crossServer($server,$maxServers,$array)
{
    $isreal = false;
    for($i = 1; $i <= $maxServers; $i++)
    {
      if($i == $server)
      {
        $isreal = true;
        break;
      } elseif(mb_strtolower($array[$i - 1]) == mb_strtolower($server)) {
        $isreal = true;
        break;
      }
    }
    return [$isreal,$i];
}


function getOrgMembers($project,$server,$org,$alllist = 0)
{
    global $vk;
    global $peer_id;
    global $serversnamerodina;
    global $serversname;
    global $headers_arizona;
    global $headers_rodina;
    global $stickers;

    $webapi = new WebApi();
    $data = $webapi->getMembers($project,$server,$org);


    if(!is_array($data))
    {
        $vk->SendMessage($peer_id,"🤔 Произошла ошибка, попробуйте позже!");
        exit;
    }
    $all_players = 0;
    $online_players = 0;
    $offline_players = 0;
    $nick_leader = "Не стоит";
    $prefix_leader = "";
    $online_deputies = 0;
    $deputies = 0;
    $list_deputies = "";

    foreach($data as $key => $value)
    {
      if($value['isLeader'])
      {
        $nick_leader = $value['name'];
        if($value['isOnline'])
        {
          $prefix_leader = "| 🌝";
        } else {
          $prefix_leader = "| 🌚";
        }
      }


      if($value['rank'] == 9)
      {
        $deputies++;
        if($value['isOnline'])
        {
          $online_deputies++;
          $deputy = R::findone('users','nick = ?',[$value['name']]);
          if($deputy && $deputy->dostyp >= 2)
          {
            $list_deputies .= "[id".$f->user_id."|🌝".$value['name']."]\n";
          } else {
            $list_deputies .= "🌝 ".$value['name']."\n";
          }
        } else {
          if($deputy && $deputy->dostyp >= 2)
          {
            $list_deputies .= "[id".$f->user_id."|🌚".$value['name']."]\n";
          } else {
            $list_deputies .= "🌚 ".$value['name']."\n";
          }
        }
      }

      if($value['isOnline'])
      {
        $online_players++;
        $all_players++;
      } else {
        $offline_players++;
        $all_players++;
      }
    }

    $record = 'Неизвестно';
    $recordNick = 'Неизвестно';
    $recordDate = 'Неизвестно';
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
          if($a->record < $online_players)
          {
              $leader_record_nick = $nick_leader;
              if ($nick_leader == "Не стоит") { $leader_record_nick = "Не стоял"; }

              $a->record = $online_players;
              $a->leader = $leader_record_nick;
              $a->date = date("d.m.Y H:i");
              R::store($a);
              $record = $online_players;
              preg_match_all('/(.+) .+/',$a->date,$foo);
              $recordDate = preg_replace('/\./','-',$foo[1][0]);
              $recordNick = $nick_leader;
              
          } else {
            $recordNick = $a->leader;
            $record = $a->record;
            preg_match_all('/(.+) .+/',$a->date,$foo);
            $recordDate = preg_replace('/\./','-',$foo[1][0]);
          }

      } else {
          $leader_record_nick = $nick_leader;
          if ($nick_leader == "Не стоит") { $leader_record_nick = "Не стоял"; }
          $b = R::dispense('records');
          $b->project = $project;
          $b->server = $changeMobile[$server];
          $b->org = $org; 
          $b->record = $online_players;
          $b->leader = $leader_record_nick;
          $b->date = date("d.m.Y H:i");
          R::store($b);
          $record = $online_players;
          $recordNick = $nick_leader;
          preg_match_all('/(.+) .+/',$a->date,$foo);
          $recordDate = preg_replace('/\./','-',$foo[1][0]);
      }

      if($project == 0) {
        $whereme = $serversname[$server - 1] . ' ' . $stickers[$server - 1];
        $headers = $headers_arizona[$org - 1];
      } elseif($project == 1)
      {
        $whereme = $serversnamerodina[$server - 1];
        $headers = $headers_rodina[$org - 1];
      }
      if($alllist == 1)
      {
        return $headers . ' | ' .$whereme . "\n— Онлайн организации: $online_players \n— Оффлайн организации: $offline_players\n— Всего во фракции: $all_players\n— Рекорд онлайна: $record | $recordNick | $recordDate\n\nЛидер организации - $nick_leader $prefix_leader\nЗаместителей в сети $online_deputies из $deputies:\n$list_deputies\n";
      } else {
        
        $memo = $vk->buttonText('📝 Показать список играющих', 'white', ['command' => 'show_members_'.$project.'_'.$server.'_'.$org]);
        $buttonslist = [[$memo]];
      
        $vk->SendButton($peer_id,$headers . ' | ' .$whereme. "\n— Онлайн организации: $online_players\n— Оффлайн организации: $offline_players\n— Всего во фракции: $all_players\n— Рекорд онлайна: $record | $recordNick | $recordDate\n\nЛидер организации - $nick_leader $prefix_leader\nЗаместителей в сети $online_deputies из $deputies:\n$list_deputies",$buttonslist, true, false, ['disable_mentions' => 1, 'dont_parse_links' => 1]);
      }
      exit;
}


function showMembers($project,$server,$org)
{
  global $vk;
  global $peer_id;
  global $serversname;
  global $serversnamerodina;
  global $stickers;
  global $headers_arizona;
  global $headers_rodina;
  
  $webapi = new WebApi();
  $data = $webapi->getMembers($project,$server,$org);
  
  if(!is_array($data))
  {
    $vk->SendMessage($peer_id,"🤔 Произошла ошибка, попробуйте позже!");
    exit;
  }

  $list_players = "";
  foreach($data as $key => $value)
  {
    if($value['isOnline'])
    {
      if($project) {
        $list_players .= "🌝 " . $value['name'] . '[' . $value['rank'] ."]\n";
      } else {
        $list_players .= "🌝 | " . $value['name'] . ' [ID: '.$value['id'].'] | ' . $value['rankLabel'] ." [".$value['rank']."]\n";
      }
      
    }
  }

  if($project == 0) {
    $whereme = $serversname[$server - 1] . ' ' . $stickers[$server - 1];
    $headers = $headers_arizona[$org - 1];
  } elseif($project == 1)
  {
    $whereme = $serversnamerodina[$server - 1];
    $headers = $headers_rodina[$org - 1];
  }

  if (strlen($list_players) <= 0) {
    $vk->SendMessage($peer_id,$headers . ' | ' .$whereme. "\n\n📝 Список играющих пуст.", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
    exit;
  }

  $vk->SendMessage($peer_id,$headers . ' | ' .$whereme. "\n\n📝 Список играющих\n$list_players", ['disable_mentions' => 1, 'dont_parse_links' => 1]);
}

if($chat_act->type == 'chat_kick_user'){
  if($from_id == $member_id) {
     $vk->request('messages.removeChatUser', ['chat_id' => $chat_id, 'member_id' => $chat_act->member_id]);
   }
}