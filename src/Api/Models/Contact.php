<?php

namespace Sms24\Api\Models;

class Contact implements \JsonSerializable {

	private $phone;

	private $country = 'SE';

	private $createdAt;

	public function __construct($phone = null, $country = null) {
		$this->setPhone($phone);
		if ($country) {
			$this->setCountry($country);
		}
	}
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}
	public function getPhone() {
		return $this->phone;
	}
	private function setCreatedAt(\DateTime $createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	public function getCreatedAt() {
		return $this->createdAt;
	}
	public function setCountry($country) {
		if (strlen($country) != 2) {
			throw new \Exception('Country code must be 2 letters');
		}
		$this->country = strtoupper($country);
		return $this;
	}
	public function getCountry() {
		return $this->country;
	}
	public function jsonUnserialize($data) {
		if (array_key_exists("created_at", $data)) {
			$this->setCreatedAt(new \DateTime($data['created_at']));
		}
		if (array_key_exists("phone", $data)) {
			$this->setPhone($data['phone']);
		}
		if (array_key_exists("country", $data)) {
			$this->setCountry($data['country']);
		}
	}
	public function jsonSerialize() {
        return array(
        	"phone" => $this->getPhone(),
        	"country" => $this->getCountry(),
        );
    }
}