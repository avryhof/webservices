<?
    Class issuu extends CurlClass {
        var $apikey, $apisecret;
        var $url = "http://api.issuu.com/1_0/";

        public function __construct($apikey, $apisecret) {
            $this->apikey = $apikey;
            $this->apisecret = $apisecret;
        }

        function documentList($params = array()) {
            $defaults = array(
                "format"    => "json"
            );
            foreach($params as $param_key => $param_value) {
                $defaults[$param_key] = $param_value;
            }
            $data = $this->call("issuu.documents.list",$defaults);
            return (object)array(
                "num_rows" => $data->rsp->_content->result->totalCount,
                "result" => $data->rsp->_content->result->_content
            );
        }

        function getEmbed($documentid, $opts = array()) {
            $defaults = array(
                "documentId" => $documentid,
                "readerStartPage" => 1,
                "width" => 525,
                "height" => 865,
                "format" => "json"
            );
            foreach($opts as $opt_key => $opt_val) {
                $defaults[$opt_key] = $opt_val;
            }
            $embed_data = $this->call("issuu.document_embed.add", $defaults);
            $embed_html = array(
                "embedId" => $embed_data->rsp->_content->documentEmbed->id
            );
            $html = $this->call("issuu.document_embed.get_html_code", $embed_html);
            if (empty($html)) {
                echo "<pre>" . $this->curl_url . "\n" . $this->curlerror . "</pre>";
            } else {
                return $html;
            }
        }

        function foldersList($params = array()) {
            return $this->call("issuu.folders.list");
        }

        function signature($items) {
            ksort($items);
            $sig_string = $this->apisecret;
            foreach($items as $item_key => $item_val) {
                $sig_string .= $item_key.$item_val;
            }
            return md5($sig_string);
        }

        function call($function, $parameters = array()) {
            $defaults = array(
                "action"    => $function,
                "sign"      => "true",
                "apiKey"    => $this->apikey
            );
            if (is_array($parameters)) {
                $param_array = array_merge($defaults, $parameters);
            } else {
                $param_array = $defaults;
            }
            $param_array['signature'] = $this->signature($param_array);
            if ($parameters['format'] == "json") {
                $retn = json_decode($this->curl_get($this->url.$function, $param_array));
            } else {
                $retn = $this->curl_get($this->url.$function, $param_array);
            }
            // $retn->num_rows = $retn->meta->count;
            return $retn;
        }
    }
?>