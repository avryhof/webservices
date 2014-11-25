func<?
    class Meetup extends CurlClass {
        var $apikey;
        var $groupname;
        var $url = "http://api.meetup.com/2/";

        public function __construct($apikey) {
            $this->apikey = $apikey;
        }

        function getOpenEvents($groupname, $opts = array()) {
            $defaults = array(
                "offset" => 0,
                "photo-host" => "public",
                "format" => "json",
                "page" => 1,
                "fields" => ""
            );

            foreach($opts as $opt_key => $opt_val) {
                $defaults[$opt_key] = $opt_val;
            }

            return $this->call("events", array_merge($defaults));
        }

        function getEvents($groupname, $opts = array()) {
            $defaults = array(
                "group_urlname" => $groupname,
                "order" => "time",
                "limited_events" => "False",
                "desc" => "true",
                "offset" => 0,
                "photo-host" => "public",
                "format" => "json",
                "page" => 1,
                "fields" => ""
            );

            foreach($opts as $opt_key => $opt_val) {
                $defaults[$opt_key] = $opt_val;
            }

            $retn = $this->call("events", array_merge($defaults));
            return $retn;
        }

        function getVenues() {

        }

        function createVenue() {

        }

        function createEvent() {
        }

        function call($function, $parameters = array()) {
            $defaults = array(
                "sign" => "true",
                "key" => $this->apikey
            );
            if (is_array($parameters)) {
                $param_array = array_merge($defaults, $parameters);
            } else {
                $param_array = $defaults;
            }
            $retn = json_decode($this->curl_get($this->url.$function, $param_array));
            $retn->num_rows = $retn->meta->count;
            return $retn;
        }

        function get_timestamp($microtime = null) {
            $microtime = explode(' ', ($microtime ? $microtime : microtime()));
            if (count($microtime) != 2) return false;
            $microtime[0] = $microtime[0] * 1000000;
            $format = str_replace('u', $microtime[0], $format);
            return $microtime[1];
        }

    }
?>
