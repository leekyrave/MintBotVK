<?php

class WebApi {
    private $arizonaToken;
    private $rodinaToken;
    private $userToken;
    private $arizonaFToken;
    function __construct($arizonaToken = 'R3ACTLAB-ARZ2=457350d822f33fe81852d455fb27d896', $rodinaToken = 'R3ACTLB=d16007d35d55ea0a0e5ae232cc1d4662', $arizonaFToken = 'R3ACTLAB-ARZ1=bfc51c3c10337be882bcbe423f73eed2',$userToken = null)
    {
        $this->arizonaToken = $arizonaToken;
        $this->rodinaToken = $rodinaToken;
        $this->arizonaFToken = $arizonaFToken;
        $this->userToken = $userToken;
    }

    public function getMembers($project,$server,$org)
    {
        if($project == 0)
        {
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
            
            $apiserver = $changeMobile[$server];
            
            $content = $this->curl_get_contents("https://backend.arizona-rp.com/fraction/get-players?serverId=$apiserver&fractionId=$org","https://arizona-rp.com/",1,false)[0];
            preg_match('/({.+})/',$content['html'],$matched);
            $content = json_decode($matched[0],true);

            $normalizedFromTwo = array();



            $contentAddon = $this->curl_get_contents("https://apitest.arizona-rp.com/mon/fraction/$apiserver/$org","https://apitest.arizona-rp.com/mon/fraction/$apiserver/$org",1,1,0)[0];

            $contentAddon = $contentAddon['html'];

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($contentAddon);
            libxml_clear_errors();
            $i = 1;
            $array = array();
            foreach($dom->getElementsByTagName('tr') as $node)
            {
                if ($i != 1) {
                    
                    preg_match_all('/\d+\s+(.+)\s+(.+)\s+(.+)/',$node->nodeValue,$foo);
                    $array[$i - 2] = array(
                        'name' => $foo[1][0],
                        'rank' => $foo[2][0],
                        'rankLabel' => 'Неизвестный ранг',
                        'isLeader' => $foo[2][0] == 'Лидер',
                        'isOnline' => $foo[3][0] == 'Сейчас играет',
                        'id' => 'Неизвестный ID'
                    );
                }
                $i++;
            }


            foreach($array as $key => $value) {
                foreach($content['items'] as $keys => $values) {
                    if($value['name'] == $values['name']) {
                        $array[$key]['id'] = $values['id'];
                        $array[$key]['rankLabel'] = $values['rankLabel'];
                        break;
                    }
                }
            }


            return $array;
        } else {
            $content = $this->curl_get_contents("https://rodina-rp.com/mon/fraction/$server/$org","https://rodina-rp.com/mon/fraction/$server/$org",1,1,1)[0];
        }

        $content = $content['html'];
        if (preg_match_all('/403 Forbidden/',$content)) {
            return null;
        }
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_clear_errors();
        $i = 1;
        $array = array();
        foreach($dom->getElementsByTagName('tr') as $node)
        {
            if ($i != 1) {
                
                preg_match_all('/\d+\s+(.+)\s+(.+)\s+(.+)/',$node->nodeValue,$foo);
                $array[$i - 2] = array(
                    'name' => $foo[1][0],
                    'rank' => $foo[2][0],
                    'isLeader' => $foo[2][0] == 'Лидер',
                    'isOnline' => $foo[3][0] == 'В сети',
                );
            }
            $i++;
        }
        if(count($array) == 0)
        {
            return array();
        }
        return $array;
    }

    public function curl_get_contents($page_url, $base_url, $pause_time, $retry,$type = 0,$post_array = null) {
        $error_page = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36 OPR/38.0.2220.41");   
        curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        if($type == 0)
        {
            curl_setopt($ch, CURLOPT_COOKIE,$this->arizonaToken);
        } elseif ($type == 1) {
            curl_setopt($ch, CURLOPT_COOKIE,$this->rodinaToken); // rodina
        } elseif ($type == 3)
        {
            curl_setopt($ch, CURLOPT_COOKIE,$this->arizonaFToken);
        }
    
        if($type == 2 or $type == 3 or $type == 4)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
        }
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_REFERER, $base_url);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
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


    public function getToken($url = 'https://forum.arizona-rp.com/search/')
    {
        $html = $this->curl_get_contents($url,$url,1,1,3)[0]['html'];
        preg_match_all('/<input type="hidden" name="_xfToken" value="(.*)" \/>/',$html,$foo);
        return $foo[1][0];
    }

    public function flogin($login,$password,$lurl = 'https://forum.arizona-rp.com/login/login',$redirect = 'https://forum.arizona-rp.com/members/')
    {
        $token = $this->getToken();
        $html = $this->curl_get_contents($lurl,$lurl,1,1,3,array('login' => $login, 'password' => $password, 'remember' => 1, '_xfRedirect' => $redirect, '_xfToken' => $token))[0]['html'];
        return $html;
    }

    public function post_request($page_url,$post_array)
    {
        $html = $this->curl_get_contents($page_url,$page_url,1,1,3,$post_array);
        return $html;
    }

    public function getPage($page_url)
    {
        $html = $this->curl_get_contents($page_url,$page_url,1,1,3);
        return $html;
    }

    /*public function getPosts($id)
    {
        $resultarray = array();
        $url = $this->getRedirect('https://forum.arizona-rp.com/search/member?user_id='.$id);
        preg_match_all('/https:\/\/forum.arizona-rp.com\/search\/(\d+)\//',$url,$searchid);
        $searchid = $searchid[1][0];
        $resultarray = $this->recursiveparse('https://forum.arizona-rp.com/search/'.$searchid.'/?page=',$resultarray,$searchid);
        return $resultarray;
    }

    public function recursiveparse($url,$resultarray,$searchid)
    {
        $i = 1;
        do {
            $page = $this->getPage($url . $i)[0]['html'];
            $ik = $i + 1;
            preg_match_all('/<a href="\/profile-posts\/(\d+)\/">.*<\/a>/',$page,$foo);
            preg_match_all('/<a href="\/profile-posts\/comments\/(\d+)\/">.*<\/a>/',$page,$fok);
            preg_match_all('/<a href="\/threads\/\d+\/post-(\d+)">/',$page,$threads);
            $resultarray = array_merge($resultarray,$foo[1],$fok[1],$threads[1]);
            if(preg_match_all('/<a href="\/search\/(\d+)\/older\?before=(\d+)"/',$page))
            {
                preg_match_all('/<a href="\/search\/(\d+)\/older\?before=(\d+)"/',$page,$pageurl);
                // echo 'https://forum.arizona-rp.com/search/'.$pageurl[1][0].'/older?before='.$pageurl[2][0];
                $resultarray = array_merge(recursiveparse('https://forum.arizona-rp.com/search/'.$pageurl[1][0].'/older?before='.$pageurl[2][0],$resultarray,$pageurl[1][0]));
            } 
            $i++;
        } while (strpos($page,'<a href="/search/'.$searchid.'/?page='.$ik.'">'));
        
        return $resultarray;
        
    }

    public function sendMessage($id,$message,$type)
    {
        $token = $this->getToken();
        switch($type)
        {
            case 0: return $this->post_request('https://forum.arizona-rp.com/members/'.$id.'/post',array('message_html' => $message, 'last_date' => time(), 'last_known_date' => time(), '_xfToken' => $token, '_xfRequestUri' => '/members/'.$id.'/', '_xfWithData' => 1, '_xfToken' => $token, '_xfResponseType' => 'json')); break;
            case 1: return $this->post_request('https://forum.arizona-rp.com/threads/'.$id.'/add-reply',array('message_html' => $message, 'last_date' => time(), 'last_known_date' => time(), '_xfToken' => $token, '_xfRequestUri' => '/threads/'.$id.'/', '_xfWithData' => 1, '_xfToken' => $token, '_xfResponseType' => 'json')); break;
            default: return $this->post_request('https://forum.arizona-rp.com/members/'.$id.'/post',array('message_html' => $message, 'last_date' => time(), 'last_known_date' => time(), '_xfToken' => $token, '_xfRequestUri' => '/members/'.$id.'/', '_xfWithData' => 1, '_xfToken' => $token, '_xfResponseType' => 'json'));
        }
    }

    public function likeMessage($id,$reaction,$postid)
    {
        $token = $this->getToken();
        $response = $this->post_request('https://forum.arizona-rp.com/profile-posts/'.$postid.'/react?reaction_id='.$reaction,array('_xfRequestUri' => '/members/'.$id.'/', '_xfWithData' => 1, '_xfToken' => $token, '_xfResponseType' => 'json'))[0]['html'];
        return $response;
    }

    public function globalLike($reaction)
    {
        $token = $this->getToken();
        $response = $this->getPage("https://forum.arizona-rp.com/profile-posts/2007868/");
        $html = $response[0]['html'];
        preg_match_all('/\.com(.+)#/',$response[1],$redirect);
        $result = $this->post_request('https://forum.arizona-rp.com/profile-posts/2007868/react?reaction_id='.$reaction,array('_xfRequestUri' => $redirect[1][0], '_xfWithData' => 1, '_xfToken' => $token, '_xfResponseType' => 'json'))[0]['html'];
        if(preg_match_all('/Вы действительно хотите оставить эту реакцию?/',$result))
        {
            $result = $this->post_request('https://forum.arizona-rp.com/profile-posts/2007868/react',array('reaction_id' => $reaction, '_xfToken' => $token))[0]['html'];
        }
        return $html;

    }
    */
    
}

