<?php

class Snapi
{
    const USER_AGENT = 'Snapchat/9.10.0.0 Beta (A116; Android 4.4.2; gzip)';
    const URL = 'https://feelinsonice-hrd.appspot.com';
    const SECRET = 'iEk21fuwZApXlz93750dmW22pw389dPwOk';
    const STATIC_TOKEN = 'm198sOkJEn37DjqZ32lpRu76xmw288xSQ9';
    const HASH_PATTERN = '0001110111101110001111010101111011010001001110011000110001000110';

    private $google_email;
    private $google_password;
    private $google_auth_token;
    public $google_attestation;
    private $google_gcm_id;
    private $device_token_set;
    private $auth_token;

    public function __construct($google_email, $google_password, $google_auth_token = NULL, $google_attestation = NULL, $google_gcm_id = NULL, $device_token_set = NULL)
    {
        $this->google_email = $google_email;
        $this->google_password = $google_password;
        $this->google_auth_token = $google_auth_token;
        $this->google_attestation = $google_attestation;
        $this->google_gcm_id = $google_gcm_id;
        $this->device_token_set = $device_token_set;
    }

    private function getTimestamp()
	{
		return round(microtime(TRUE) * 1000);
	}

    private function getRequestToken($token, $timestamp)
    {
        $token = $this::SECRET . $token;
        $timestamp = $timestamp . $this::SECRET;

        $hash1 = hash("sha256", $token);
        $hash2 = hash("sha256", $timestamp);

        $return = "";

        for($i = 0; $i < strlen($this::HASH_PATTERN); $i++)
        {
            if(substr($this::HASH_PATTERN, $i, 1)) {
                $return .= $hash2[$i];
            } else {
                $return .= $hash1[$i];
            }
        }

        return $return;
    }

    private function getGoogleAuthToken()
    {
        if(!isset($this->google_device_id)) {
            $this->google_device_id = substr(md5(microtime()), 0, 16);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://android.clients.google.com/auth");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "device_country" => "us",
            "operatorCountry" => "us",
            "lang" => "en_US",
            "sdk_version" => 19,
            "google_play_services_version" => 7574036,
            "accountType" => "HOSTED_OR_GOOGLE",
            "service" => "audience:server:client_id:694893979329-l59f3phl42et9clpoo296d8raqoljl6p.apps.googleusercontent.com",
            "source" => "android",
            "androidId" => $this->google_device_id,
            "app" => "com.snapchat.android",
            "client_sig" => "49f6badb81d89a9e38d65de76f09355071bd67e7",
            "callerPkg" => "com.snapchat.android",
            "callerSig" => "49f6badb81d89a9e38d65de76f09355071bd67e7",
            "Email" => $this->google_email,
            "Passwd" => $this->google_password
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'User-Agent: GoogleAuth/1.4 (A116 _Quad KOT49H)',
            'app: com.snapchat.android',
            'device: ' . $this->google_device_id
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return(substr(explode("\n", $return)[1], 5));
    }

    private function getGoogleGCMId()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://android.clients.google.com/c2dm/register3");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "X-google.message_id" => "google.rpc1",
            "device" => 4343470343591528399,
            "sender" => 191410808405,
            "app_ver" => 686,
            "gcm_ver" => 7574036,
            "app" => "com.snapchat.android",
            "iat" => time(),
            "cert" => "49f6badb81d89a9e38d65de76f09355071bd67e7"
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'Accept-Language: en',
    		'Accept-Locale: en_US',
            'User-Agent: Android-GCM/1.5 (A116 _Quad KOT49H)',
            'app: com.snapchat.android',
            'Authorization: AidLogin 4343470343591528399:5885638743641649694',
            'Gcm-ver: 7574036'
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return substr($return, 6);
    }

    public function getGoogleAttestation($username, $password, $timestamp, $endpoint = "/loq/login")
    {
        require_once 'pb_proto_snet_idle.php';

        $snetIdle = new SnetIdle();

        $dataContainer = new DataContainer();

        $dataContainer->setNonce(hex2bin(hash("sha256", "{$username}|{$password}|{$timestamp}|{$endpoint}")));
        $dataContainer->setApkPackageName("com.snapchat.android");
        $dataContainer->setApkCertificateDigestSha256("/\034\252\374\241\3550\320\264\343\210c\356\372\276\240\350\025q\037\244\317y\270\"Q\232\202Y\331ZX");
        $dataContainer->setApkDigestSha256("\0003H;\207\037\370\021\0356\362\370 l\026\032\331\3502\262X\246\325\327\030\264%s\231:\222\354");
        $dataContainer->setGmsVersion(7574036);

        $suExec = new SuExec();

        $suExec->setExecPath("/system/xbin/su");
        $suExec->setExecSignature("\030\376\004\001\316k\220\030Q\255\373lI\224\356\250\342qS\375A\343\231\215\226\363\035\357a\r2\365");

        $dataContainer->appendSuexec($suExec);

        $unknownData = new UnknownData();

        $unknownData->setUnknown1(1);
        $unknownData->setUnknown2(0);

        $dataContainer->setUnknowndata($unknownData);
        $dataContainer->setTimestamp($timestamp);

        $snetIdle->setDatacontainer($dataContainer);
        $snetIdle->setDroidGuard("CgaOua-Gt93YAQE4YRoWCI3r2rf8_____wEQ9di17Pr_____AaoBEQiPqNq7-P____8BEPrV9IcD6AGvmZuz-P____8B6AG6gf3eBThrOEsSzwq5bVaE-20651wLI3c_pvDXHsqQ2Q6o1Jl8-5oWDyQyDqAGH_1wE0zLTIg0EsqikaNI53TwxWQcB06LrJimJtGccRWgvET8NvEIdbUjaSqKK754444w2fZ3GBPJC26DLxgPpUtoreZwdagXdXDdh1Cr9C7wr4pcjY7cRUkdCUb4j_RI6w0Lcqt0P-wJm8E1y3LZGLfq4nmMMja5GX0uGmqpzVo3FvwAFR33j9NOEHjs1fnXKxyXzJzkfB74kpiKZVvdOUqKsAi3K8Z5yDsAJo9F8ziRku3RMgTetdNhGST4RoQfKfBvaooeyP5b7LPWaUydtRS4DkoyN8YvJC6pv-nd1zR4BzMYy0P3GhnloXFo7thYYnFQIiNiJ3jMrnDYTlH3wgutHARwSm_2SzLjRwURJndoTMXewB0gsfNnrbSuP4gIbFerqgjT-Z_-oQf3WPAvIiHBcXZp8Z6qBh_we34mMqKc5IYxV9V3uiCRtm5CfqViylHuQvZuh2EqDP7ZGmJn0Xzk-GhDxwTauM1jsuhB3U2KeisEnL3BGYP0rK27F5RSAeh-zv99wTR-ZaUYrojEE1539MqEDSQMRiFNPjUIgdAOMPg4f6IHypqTaECDL6Y9GnVLCjyjWqyemnIvvWkQbf_3PnMBpBAjUfxQTqYVbo4_lgo9rxk92Du2OmhiNGCFpLvqvfEycgzefPoSMAPB68xPBaBCSvzr0IjWM9O54XJZxzW5y2GDvtfCjLAORd_mAv_pzaXo0F_VjLj1fixFDl294t5dVdhUyNEWll3mzihRh2bDOY4Xn-WZqBhlczyzoN8_o3LwsuUq1vKA1ZRuTi3-MLQyxGY1i7BHj4C6mFDn1W7VfNL6F-aFp2xnAxcH8btkWgArtPqUN9mmRsMzJpk6gkQ90cheDmPuRtOLARam41JM3nKbli2TrJlhDxMngV0l4oeQgjHcouVnzJ0lBxryDe6Muz7gksRJcw6Cvj3b5tYJ4Tvab5ak7T7O-1bLdnCYI31ZXx1xjJFCuOyEP_Qps25pUFzH2K2Og8VvpLuItlYBgd6nItOjdQbCu7MlVzuh88YaWIMq4yWyiu5kWmyuoKYnKT08c7Frc7j15sFL4vcA2HN3mT14wCOKTzv-t3u__MdFKeyTuOLOpbwvlCDkNq1V_Igf4kZNhF8L9z2jxm5nYKcuRkEF2zmX89i8C4Et9fllx2yNdeXI83tnEHq3Vtoga-rLvQLNRPBpHM7-anu1Cedu-uvfAjMelNW90RWfD_YXwxHbGepuyCsJ34DmP_ZZnVtVCfyw0ghKrofwpuoNXNT3WJ6Ep8X8a3NYy6Bq3nqReKLsZ3T3vq81l-9Zad-wOLXhhnQYi_JLXVaCcOfCFvxgCHykApZNdsl9yNy_DoPn_8HYaRJ_bxTAIUNetZ9Ovy-wKHKZ5U3BhVzGOqPDKKjSyTjs-XFBnW7rZc2hn00I4gFs59Mk61l-nfSNXw2MeSg8N1nTErwCTizBrwBOyn4dAhePAzbrO4RfxB2tHSWCH65YO1ujRdVhn3O_EIwHbD_LomLDTw18JJO-L-7wVJSeAhYbuud66azOUNv5KaDDsSi9l2ZH64q_o6sdPo7Nl_fPWI4IMLhYDqGW6t_vqhJdN6b1pAjnsQW0FnxiYjQeizV_3hTAKXyjR_a4VkEv1bpABGHDRDOswXJ45GpWm6xc45Z5AVhSpQjMkKDLVGaD_CJeq0_pVBlgeprE_dGMcuiKVMph_KWxKoDzWpnRiF9qtk2CVyU6ryiHnXZDnZGt433SFrIAR4-KlTZF9HFlemAb9KlW6Ok");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/androidcheck/v1/attestations/attest?alt=JSON&key=AIzaSyDqVnJBjE5ymo--oBJt3On7HQx9xNm1RHA");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $snetIdle->serializeToString());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'User-Agent: SafetyNet/7574000 (A116 _Quad KOT49H); gzip',
            'content-type: application/x-protobuf'
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return json_decode($return)->signedAttestation;
    }

    public function verifyGoogleAttestation($attestation)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/androidcheck/v1/attestations/verify?key=AIzaSyDqVnJBjE5ymo--oBJt3On7HQx9xNm1RHA");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("signedAttestation" => $attestation)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        curl_close($ch);

        return json_decode($return)->isValidSignature;
    }

    private function getDeviceTokenSet()
	{
		$timestamp = $this->getTimestamp();

        if(!isset($this->google_auth_token)) {
            $this->google_auth_token = $this->getGoogleAuthToken();
        }

        if(!$this->google_auth_token) {
            return false;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this::URL . "/loq/device_id");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "req_token" => $this->getRequestToken($this::STATIC_TOKEN, $timestamp),
            "timestamp" => $timestamp
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'Accept-Language: en',
    		'Accept-Locale: en_US',
            'User-Agent: ' . $this::USER_AGENT,
            'X-Snapchat-Client-Auth-Token: Bearer ' . $this->google_auth_token,
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return json_decode($return);
	}

    public function login($username, $password)
    {
        $timestamp = $this->getTimestamp();

        if(!isset($this->google_auth_token)) {
            $this->google_auth_token = $this->getGoogleAuthToken();
        }

        if(!isset($this->google_attestation)) {
            $this->google_attestation = $this->getGoogleAttestation($username, $password, $timestamp);
        }

        if(!isset($this->google_gcm_id)) {
            $this->google_gcm_id = $this->getGoogleGCMId();
        }

        if(!isset($this->device_token_set)) {
            $this->device_token_set = $this->getDeviceTokenSet();
        }

        if(!$this->google_auth_token || !$this->google_attestation || !$this->google_gcm_id || !$this->device_token_set) {
            return false;
        }

        $req_token = $this->getRequestToken($this::STATIC_TOKEN, $timestamp);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this::URL . "/loq/login");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "application_id" => "com.snapchat.android",
            "attestation" => $this->google_attestation,
            "dsig" => substr(hash_hmac('sha256', $username . "|" . $password . "|" . $timestamp . "|" . $req_token, $this->device_token_set->dtoken1v), 0, 20),
            "dtoken1i" => $this->device_token_set->dtoken1i,
            "height" => 1280,
            "width" => 720,
            "max_video_height" => 640,
            "max_video_width" => 480,
            "ptoken" => $this->google_gcm_id,
            "username" => $username,
            "password" => $password,
            "sflag" => 1,
            "req_token" => $req_token,
            "timestamp" => $timestamp
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'Accept-Language: en',
    		'Accept-Locale: en_US',
            'User-Agent: ' . $this::USER_AGENT,
            'X-Snapchat-Client-Auth-Token: Bearer ' . $this->google_auth_token,
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        $return = json_decode($return);

        $this->username = $username;

        if(!isset($return->updates_response)) {
            return $return;
        }

        $this->auth_token = $return->updates_response->auth_token;
        $this->qr_path = $return->updates_response->qr_path;

        $this->postDeviceToken();

        return $return;
    }

    public function getSnapTag()
    {
        $timestamp = $this->getTimestamp();
        $req_token = $this->getRequestToken($this->auth_token, $timestamp);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this::URL . "/bq/snaptag_download");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "image" => $this->qr_path,
            "username" => $this->username,
            "req_token" => $req_token,
            "timestamp" => $timestamp
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'Accept-Language: en',
    		'Accept-Locale: en_US',
            'User-Agent: ' . $this::USER_AGENT,
            'X-Snapchat-Client-Auth-Token: Bearer ' . $this->google_auth_token,
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return base64_encode($return);
    }

    private function postDeviceToken()
    {
        $timestamp = $this->getTimestamp();
        $req_token = $this->getRequestToken($this->auth_token, $timestamp);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this::URL . "/ph/device");
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "application_id" => "com.snapchat.android",
            "device_token" => $this->google_gcm_id,
            "type" => "android",
            "username" => $this->username,
            "req_token" => $req_token,
            "timestamp" => $timestamp
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Accept:',
    		'Expect:',
            'Accept-Language: en',
    		'Accept-Locale: en_US',
            'User-Agent: ' . $this::USER_AGENT,
            'X-Snapchat-Client-Auth-Token: Bearer ' . $this->google_auth_token,
        ));
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");

        $return = curl_exec($ch);

        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            return false;
        }

        curl_close($ch);

        return true;
    }
}

?>
