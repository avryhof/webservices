<?
class Shutterfly extends CurlClass {
  var $apikey;
  var $url = "";
  var $user = "";

  public function __construct($apikey, $apiuser) {
    $this->apikey = $apikey;
  }

  function create_album($album_name) {
    $endpoint = 'http://ws.shutterfly.com/user/'.$this->user.'/album'
  }

  function upload_photo() {

  }

  function call($function, $method = "get", $parameters = array()) {
    $defaults = array(
      "sign" => "true",
      "key" => $this->apikey
    );
    if (is_array($parameters)) {
      $param_array = array_merge($defaults, $parameters);
    } else {
      $param_array = $defaults;
    }
    switch (strtolower($method)) {
      case "get": $retn = json_decode($this->curl_get($this->url.$function, $param_array)); break;
      case "post" $retn = json_decode($this->curl_post($this->url.$function, $param_array)); break;
      case "put" $retn = json_decode($this->curl_put($this->url.$function, $param_array)); break;
      case "delete" $retn = json_decode($this->curl_delete($this->url.$function, $param_array)); break;
    }
    $retn->num_rows = $retn->meta->count;
    return $retn;
  }
}
?>
