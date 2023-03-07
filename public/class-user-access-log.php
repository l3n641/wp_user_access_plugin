<?php


class User_Access_Log
{
    const VERSION = '1';
    protected $domain_api;

    public function __construct($domain_api)
    {
        $this->domain_api = $domain_api;
    }

    public function load_access_log_js()
    {

        $page_type = $this->get_current_page_type();
        $data = [
            "domain" => $_SERVER['HTTP_HOST'],
            "uri" => $_SERVER['REQUEST_URI'],
            "permalink" => $_SERVER['REQUEST_URI'],
            "referer" => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "",
            "page_type" => $page_type,

        ];

        wp_enqueue_script("access_log", plugin_dir_url(__FILE__) . 'js/log.js', array('jquery'), self::VERSION, true);
        wp_localize_script('access_log', 'var_access_log', $data);
    }


    protected function get_current_page_type()
    {
        if (is_home() || is_front_page()) {
            return "home";
        }

        if (is_product_category()) {
            return "category";
        }

        if (is_product_tag()) {
            return "tag";
        }

        if (is_product()) {
            return "singular";
        }

        if (is_cart()) {
            return "cart";
        }

        if (is_checkout()) {
            return "checkout";
        }
        if (is_account_page()) {
            return "account";
        }

        return "undefined";


    }

    // 获取客户端的ip
    protected function get_client_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $online_ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $online_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $online_ip = $_SERVER['HTTP_X_REAL_IP'];
        } else {
            $online_ip = $_SERVER['REMOTE_ADDR'];
        }
        return $online_ip;
    }


    public function send_access_log()
    {
        $api_uri = "/api/user_access_log";
        $url = $this->domain_api . $api_uri;
        $post_data = $_POST['data'];
        $data = [
            "session_id" => session_id(),
            "domain" => $post_data["domain"],
            "client_ip" => $this->get_client_ip(),
            "uri" => $post_data["uri"],
            "page_type" => $post_data["page_type"],
            "referer" => $post_data["referer"],
            "user_agent" => $_SERVER["HTTP_USER_AGENT"],
        ];
        $response = wp_remote_post($url, array(
                'timeout' => 30,
                'redirection' => 5,
                'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
                'body' => json_encode($data),
                'method' => 'POST',
                'data_format' => 'body',
            )
        );

        echo json_encode($data);

    }


}
