<?php

namespace Sms24\Api;

class Client {

	private $apiKey;

	//private $baseUrl = 'http://www.sms24.se/api';
	private $baseUrl = 'http://127.0.0.1:8000/api';

	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
	}
	public function listContacts() {
		$result = $this->makeCurlRequest('GET', '/contacts.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\Contact();
			$result[$key]->jsonUnserialize($value);
		}

		return $result;
	}
	public function createContact(\Sms24\Api\Models\Contact $contact) {
		$data = $this->convertToArray($contact);
		$result = $this->makeCurlRequest('POST', '/contacts.json', $data);

		$contact = new \Sms24\Api\Models\Contact();
		$contact->jsonUnserialize($result);

		return $contact;
	}
	public function listGroups() {
		$result = $this->makeCurlRequest('GET', '/groups.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\Group();
			$result[$key]->jsonUnserialize($value);
		}
		
		return $result;
	}
	public function createGroup(\Sms24\Api\Models\Group $group) {
		$data = $this->convertToArray($group);
		$result = $this->makeCurlRequest('POST', '/groups.json', $data);

		$group = new \Sms24\Api\Models\Group();
		$group->jsonUnserialize($result);

		return $group;
	}
	public function listGroupContacts($groupId) {
		$result = $this->makeCurlRequest('GET', '/groups/'.$groupId.'/contacts.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\Contact();
			$result[$key]->jsonUnserialize($value);
		}
		
		return $result;
	}
	public function createGroupContact(\Sms24\Api\Models\Contact $contact, $groupId) {
		$data = $this->convertToArray($contact);
		$result = $this->makeCurlRequest('POST', '/groups/'.$groupId.'/contacts.json', $data);

		$contact = new \Sms24\Api\Models\Contact();
		$contact->jsonUnserialize($result);
		
		return $contact;
	}
	public function listOriginators() {
		$result = $this->makeCurlRequest('GET', '/originators.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\Originator();
			$result[$key]->jsonUnserialize($value);
		}
		
		return $result;
	}
	public function listSmsResult($smsId) {
		$result = $this->makeCurlRequest('GET', '/sms/'.$smsId.'/delivery_report.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\SmsResult();
			$result[$key]->jsonUnserialize($value);
		}
		
		return $result;
	}
	public function listSms() {
		$result = $this->makeCurlRequest('GET', '/sms.json');

		foreach ($result as $key => $value) {
			$result[$key] = new \Sms24\Api\Models\Sms();
			$result[$key]->jsonUnserialize($value);
		}
		
		return $result;
	}
	public function sendSms(\Sms24\Api\Models\Sms $sms) {
		if (!$sms->getOriginator()) {
			throw new \Exception('Missing originator');
		}
		if (!$sms->getMessage()) {
			throw new \Exception('Missing message');
		}
		if (count($sms->getContacts()) < 1) {
			throw new \Exception('At least 1 contact is required');
		}
		$data = $this->convertToArray($sms);
		$result = $this->makeCurlRequest('POST', '/sms/send.json', $data);

		$sms = new \Sms24\Api\Models\Sms();
		$sms->jsonUnserialize($result);
		return $sms;
	}
	public function sendSmsToGroup(\Sms24\Api\Models\Sms $sms, $groupId) {
		if (!$sms->getOriginator()) {
			throw new \Exception('Missing originator');
		}
		if (!$sms->getMessage()) {
			throw new \Exception('Missing message');
		}
		$data = $this->convertToArray($sms);
		$result = $this->makeCurlRequest('POST', '/groups/'.$groupId.'/send.json', $data);

		$sms = new \Sms24\Api\Models\Sms();
		$sms->jsonUnserialize($result);
		return $sms;
	}
	private function convertToArray($object) {
		return $object->jsonSerialize();
	}
	private function makeCurlRequest($method, $path, $data = array()) {
        $method = strtoupper($method);

        $url = $this->baseUrl.$path;
        if (in_array($method, array('GET','DELETE')) && !empty($data)) {
            if (is_array($data)) $data = http_build_query($data);
            $url .= "?".ltrim($data, "?");
        }

        $url .= ((strstr($url, "?")) ? '&':'?').http_build_query(array("key" => $this->apiKey));

        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SMS24 PHP Api v0.1');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/json',
        ));

        if (in_array($method, array('POST','PUT')) && !empty($data)) {
            if (is_array($data)) {
                curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            ELSE {
                curl_setopt ($ch, CURLOPT_POSTFIELDS, ltrim($data, "?"));
            }
        }

        $res = curl_exec($ch);

        $response = json_decode($res, true);

        if (!is_array($response)) {
        	throw new \Exception('Invalid response from server');
        }
        if (array_key_exists("error", $response)) {
			//throw new \Exception($response['error']['message'], $response['error']['code']);
		}

        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        return $response;
    }
}