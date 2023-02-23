<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class ForumApi {
    private $email;
    private $password;

    function __construct($email = "", $password = "", $token = "R3ACTLAB-ARZ1=bfc51c3c10337be882bcbe423f73eed2")
    {
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }


    public function infoThread($url) {
        $page = $this->getPage($url)[0]['html'];
        $isClosed = false;
        $isPinned = false;
        preg_match('/https:\/\/forum\.arizona-rp.com\/threads\/(\d+)[\/]*/',$page, $idThread);
        if($idThread) {

            if(preg_match('/<span class="u\-srOnly">Автор темы<\/span>/',$page)) {
                preg_match('/<a href="\/members\/(\d+)\/" class="username  u\-concealed" dir="auto" data\-user\-id="\d+" data\-xf\-init="member\-tooltip">(.+)<\/a>/', $page, $matched);
    
                preg_match('/data-time="(\d+)"/',$page, $matchedDate);
    
                if(preg_match("/blockStatus-message blockStatus-message--locked/", $page)) {
                    $isClosed = true;
                }
    
                $pageLastMessage = $this->getPage('https://forum.arizona-rp.com/threads/'.$idThread[1].'/page-100000000')[0]['html'];
                preg_match_all('/<a href="\/members\/(\d+)\/" class="username " dir="auto" data-user-id="\d+" data-xf-init="member-tooltip" itemprop="name">(.+)<\/a>/', $pageLastMessage, $lastMessage);
                preg_match_all('/data-time="(\d+)"/',$pageLastMessage, $matchedDateLast);
                preg_match_all('/<a href="\/forums\/(\d+)\/" itemprop="item">/',$page, $category);
                $pageIsPinned = $this->getPage('https://forum.arizona-rp.com/forums/'.end($category[1]))[0]['html'];

                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($pageIsPinned);
                libxml_clear_errors();
                
                foreach($dom->getElementsByTagName('div') as $node) {
                    if(preg_match('/threadListItem-' . $idThread[1] .'/',$node->getAttribute('class'))) {
                        if(preg_match('/Закреплено/',$node->nodeValue)) {
                            $isPinned = true;
                        }    
                    }
                }

                $domServer = new DOMDocument();
                libxml_use_internal_errors(true);
                $domServer->loadHTML($page);
                libxml_clear_errors();

                $isPrescott = false;
                foreach($domServer->getElementsByTagName('span') as $node) {
                    if($node->getAttribute('itemprop') == 'name') {
                        if(preg_match("/Сервер №11 \[Prescott\]/", $node->nodeValue)) {
                            $isPrescott = true;
                        }
                    }
                }

                if(!$isPrescott) {
                    return [false, "Фиксик, не на тот сервер лезешь"];
                }
                $resultArray = array(
                    "id" => $idThread[1],
                    "authorId" => 'https://forum.arizona-rp.com/members/'.$matched[1],
                    "authorNick" => $matched[2],
                    "createDate" => $matchedDate[1],
                    'lastId' => 'https://forum.arizona-rp.com/members/'.end($lastMessage[1]),
                    'lastNick' => end($lastMessage[2]),
                    'lastDate' => end($matchedDateLast[1]),
                    "isClosed" => $isClosed,
                    "isPinned" => $isPinned,
                );
                return [true, $resultArray];
            }
        } else {
            return [false, "Error, undefined type of URL"];
        }

    }

    public function curl_get_contents($page_url, $base_url, $pause_time, $retry, $type = 0, $post_array = null) {
        $error_page = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36 OPR/38.0.2220.41");   
        curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        
        curl_setopt($ch, CURLOPT_COOKIE,$this->token);

        if($type == 2)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
        }
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_REFERER, $base_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $response['html'] = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($info['http_code'] != 200 && $info['http_code'] != 404) {
            $error_page[] = array(1, $page_url, $info['http_code']);
            if($retry) {
                sleep($pause_time);
                $response['html'] = curl_exec($ch);
                $info = curl_getinfo($ch);
                if($info['http_code'] != 200 && $info['http_code'] != 404)
                    $error_page[] = array(2, $page_url, $info['http_code']);
            }
        }
        $response['code'] = $info['http_code'];
        $response['errors'] = $error_page;
        $redirectURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return [$response,$redirectURL];
    }


    public function post_request($page_url,$post_array)
    {
        $html = $this->curl_get_contents($page_url,$page_url,1,1,2,$post_array);
        return $html;
    }

    public function getPage($page_url)
    {
        $html = $this->curl_get_contents($page_url,$page_url,1,1,3);
        return $html;
    }

    public function getToken($url = 'https://forum.arizona-rp.com/search/')
    {
        $html = $this->curl_get_contents($url,$url,1,1,3)[0]['html'];

        preg_match_all('/<input type="hidden" name="_xfToken" value="(.*)" \/>/',$html,$foo);
        return $foo[1][0];
    }

    public function flogin($login,$password,$lurl = 'https://forum.arizona-rp.com/login/login',$redirect = 'https://forum.arizona-rp.com/members/')
    {
        $token = $this->getToken();
        $html = $this->curl_get_contents($lurl,$lurl,1,1,2,array('login' => $login, 'password' => $password, 'remember' => 1, '_xfRedirect' => $redirect, '_xfToken' => $token))[0]['html'];
        return $html;
    }

    public function getPrefixes($thread) {
        $token = $this->getToken();
        $html = $this->curl_get_contents("https://forum.arizona-rp.com/threads/$thread/edit?_xfRequestUri=/threads/".$thread."&_xfWithData=1&_xfToken=".$token."&_xfResponseType=json", "https://forum.arizona-rp.com", 1, 1)[0]['html'];
        $decodedJson = json_decode($html, true);

        if($decodedJson['status'] == 'ok') {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($decodedJson['html']['content'], 'HTML-ENTITIES', 'utf-8'));
            libxml_clear_errors();
            $arrayPrefixes = array();
            foreach($dom->getElementsByTagName('option') as $node) {
                if($node->hasAttribute('data-prefix-class')) {
                    if(!array_key_exists($node->nodeValue,$arrayPrefixes)) {    
                        $arrayPrefixes[$node->nodeValue] = array("selected" => $node->hasAttribute("selected"), "number" => $node->getAttribute("value"));
                    }
                }

            }
            return [true, $arrayPrefixes];
        } else {
            return [false, "Неизвестная ошибка при получении информации о префиксах."];
        }
        
    }


    public function pinThread($thread) { 
        $infoThread = $this->infoThread("https://forum.arizona-rp.com/threads/".$thread);
        if($infoThread[0]) {
            if(!$infoThread[1]['isPinned']) {
                $arraySend = array(
                    "_xfRequestUri" => "/threads/". $thread . "/",
                    "_xfWithData" => "1",
                    "_xfToken" => $this->getToken(),
                    "_xfResponseType" => "json",
                );
                $pinRequest = $this->curl_get_contents("https://forum.arizona-rp.com/threads/".$thread . "/quick-stick", "https://forum.arizona-rp.com/", 1, 1, 2, $arraySend)[0]['html'];
                $pinRequest = json_decode($pinRequest, true);
                if ($pinRequest['status'] == "ok") {
                    return [true];
                } else {
                    return [false, "Произошла неизвестная ошибка."];
                }

            } else {
                return [false, "Тема уже закреплена."];
            }
        } else {
            return [false, $infoThread[1]];
        }

    }

    public function unpinThread($thread) { 
        $infoThread = $this->infoThread("https://forum.arizona-rp.com/threads/".$thread);
        if($infoThread[0]) {
            if($infoThread[1]['isPinned']) {
                $arraySend = array(
                    "_xfRequestUri" => "/threads/". $thread . "/",
                    "_xfWithData" => "1",
                    "_xfToken" => $this->getToken(),
                    "_xfResponseType" => "json",
                );
                $pinRequest = $this->curl_get_contents("https://forum.arizona-rp.com/threads/".$thread . "/quick-stick", "https://forum.arizona-rp.com/", 1, 1, 2, $arraySend)[0]['html'];
                $pinRequest = json_decode($pinRequest, true);
                if ($pinRequest['status'] == "ok") {
                    return [true];
                } else {
                    return [false, "Произошла неизвестная ошибка."];
                }

            } else {
                return [false, "Тема уже откреплена."];
            }
        } else {
            return [false, $infoThread[1]];
        }

    }



    public function closeThread($thread) { 
        $infoThread = $this->infoThread("https://forum.arizona-rp.com/threads/".$thread);
        if($infoThread[0]) {
            if(!$infoThread[1]['isClosed']) {
                $arraySend = array(
                    "_xfRequestUri" => "/threads/". $thread . "/",
                    "_xfWithData" => "1",
                    "_xfToken" => $this->getToken(),
                    "_xfResponseType" => "json",
                );
                $pinRequest = $this->curl_get_contents("https://forum.arizona-rp.com/threads/".$thread . "/quick-close", "https://forum.arizona-rp.com/", 1, 1, 2, $arraySend)[0]['html'];
                $pinRequest = json_decode($pinRequest, true);
                if ($pinRequest['status'] == "ok") {
                    return [true];
                } else {
                    return [false, "Произошла неизвестная ошибка."];
                }

            } else {
                return [false, "Тема уже закрыта."];
            }
        } else {
            return [false, $infoThread[1]];
        }

    }

    public function openThread($thread) { 
        $infoThread = $this->infoThread("https://forum.arizona-rp.com/threads/".$thread);
        if($infoThread[0]) {
            if($infoThread[1]['isClosed']) {
                $arraySend = array(
                    "_xfRequestUri" => "/threads/". $thread . "/",
                    "_xfWithData" => "1",
                    "_xfToken" => $this->getToken(),
                    "_xfResponseType" => "json",
                );
                $pinRequest = $this->curl_get_contents("https://forum.arizona-rp.com/threads/".$thread . "/quick-close", "https://forum.arizona-rp.com/", 1, 1, 2, $arraySend)[0]['html'];
                $pinRequest = json_decode($pinRequest, true);
                if ($pinRequest['status'] == "ok") {
                    return [true];
                } else {
                    return [false, "Произошла неизвестная ошибка."];
                }

            } else {
                return [false, "Тема уже открыта."];
            }
        } else {
            return [false, $infoThread[1]];
        }

    }

    public function setPrefix($thread, $prefix) {
        $infoThread = $this->infoThread("https://forum.arizona-rp.com/threads/".$thread);
        if($infoThread[0]) { 
            $prefixes = $this->getPrefixes($thread);
            if($prefixes[0]) {
                if(array_key_exists($prefix, $prefixes[1])) {
                    $arrayPrefix = array(
                        "prefix_id" => $prefixes[1][$prefix]['number'],
                        "ids[]" => $thread,
                        "type" => "thread",
                        "action" => "apply_prefix",
                        "confirmed" => 1,
                        "_xfRedirect" => "https://forum.arizona-rp.com/threads/$thread",
                        "_xfToken" => $this->getToken(),
                        "_xfToken" => $this->getToken(),
                        "_xfReponseType" => "json"
                    );
                    $prefixRequest = $this->curl_get_contents("https://forum.arizona-rp.com/inline-mod/", "https://forum.arizona-rp.com/", 1, 1, 2, $arrayPrefix)[0]['html'];
                    return [true];
                } else {
                    $stringPrefixes = "";
                    foreach($prefixes[1] as $key => $value) {
                        if($value['selected']) {
                            $stringPrefixes .= "👉 $key | Сейчас активен\n";
                        } else {
                            $stringPrefixes .= "👉 $key\n";
                        }
                        
                    }
                    return [false, "Такого префикса не существует.\n✅ Доступные префиксы:\n$stringPrefixes"];
                }
            } else {
                return [false, $prefixes[1]];
            }
        } else {
            return [false, $infoThread[1]];
        }

    }


}

