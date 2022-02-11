<?php
class curl_functions extends CI_Model{
    public function __construct()
        {
            $this->load->helper('cookie');
            $this->load->library('login_data2');
            $this->login_data2->get_authorization_data();
        }
    public function curl_get_html($url)
    {
        $postFields = array(
            'login'=>$_SESSION['login'],
            'password'=>$_SESSION['password'],
            'stay_signed'=>"0",
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_SESSION['domain_url'].$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
        $response = curl_exec($ch);
        curl_close($ch);
        set_cookie('logged_in',1,1800);
        return $response;
    }
    public function curl_get_html_when_logged($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_SESSION['domain_url'].$url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
?>