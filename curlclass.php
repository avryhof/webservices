<?
/*
 * These are copied from the notes under curl_exec in the PHP manual online,
 * and only modified for formatting, and class compatibility.
 */
    class CurlClass {
        var $curl_url, $curlerror;

        function curl_get($url, array $get = NULL, array $options = array()) {
            $this->curl_url = $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get);
            $defaults = array(
                CURLOPT_URL => $this->curl_url,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 4
            );

            $ch = curl_init();
            curl_setopt_array($ch, ($options + $defaults));
            if( ! $result = curl_exec($ch)) {
                $this->curlerror = curl_error($ch);
                trigger_error(curl_error($ch));
            }
            curl_close($ch);
            return $result;
        }

        function curl_post($url, array $post = NULL, array $options = array()) {
            $this->curl_url = $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($post);
            $defaults = array(
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $url,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POSTFIELDS => http_build_query($post)
            );

            $ch = curl_init();
            curl_setopt_array($ch, ($options + $defaults));
            if( ! $result = curl_exec($ch)) {
                $this->curlerror = curl_error($ch);
                trigger_error(curl_error($ch));
            }
            curl_close($ch);
            return $result;
        }
    }

?>