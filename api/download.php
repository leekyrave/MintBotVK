<?php
function curl_get_contents($page_url, $base_url, $pause_time, $retry, $img) {
        $error_page = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36 OPR/38.0.2220.41");   
        curl_setopt($ch, CURLOPT_COOKIEJAR, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, str_replace("\\", "/", getcwd()).'/cookie.txt'); 
        curl_setopt($ch, CURLOPT_COOKIE,"R3ACTLAB-ARZ=96b48b60e5e5af2b2d5017fdbff2cad5");
    

        $fp = fopen($img, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_URL, $page_url);
        curl_setopt($ch, CURLOPT_REFERER, $base_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
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
        fclose($fp);
        return [$response,$redirectURL];
}

$normCounter = 453;
for ($i=3546; $i <= 3558; $i++) { 
   print_r(curl_get_contents("https://arizona-rp.com/images/inventory-items/$i.png", "https://arizona-rp.com/", 1, 1, "$normCounter.png"));
   $normCounter++;
}