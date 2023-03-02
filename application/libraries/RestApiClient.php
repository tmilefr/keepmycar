<?php

class RestApiClient {
  private $apiUrl;
  private $apiKey;

  public function __construct($apiUrl, $apiKey) {
    $this->apiUrl = $apiUrl;
    $this->apiKey = $apiKey;
  }

  public function get($path, $queryParams = array()) {
    return $this->request('GET', $path, $queryParams);
  }

  public function post($path, $postData = array()) {
    return $this->request('POST', $path, $postData);
  }

  public function put($path, $putData = array()) {
    return $this->request('PUT', $path, $putData);
  }

  public function delete($path, $deleteData = array()) {
    return $this->request('DELETE', $path, $deleteData);
  }

  private function request($method, $path, $data = array()) {
    $url = $this->apiUrl . $path;
    $headers = array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $this->apiKey
    );

    $options = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_CUSTOMREQUEST => $method
    );

    if ($method == 'GET' && count($data) > 0) {
      $url .= '?' . http_build_query($data);
    } else if ($method == 'POST' || $method == 'PUT' || $method == 'DELETE') {
      $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);
  }
}

?>