<?php

namespace Sms24\Api\Models;

class SmsResult implements \JsonSerializable {

	private $id;

	private $status;

	private $createdAt;

	private $updatedAt;

	private $phone;

	private function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getStatus($status) {
		return $this->status;
	}
	private function setPhone($phone) {
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
	private function setUpdatedAt(\DateTime $updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	private function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	public function jsonUnserialize($data) {
		if (array_key_exists("id", $data)) {
			$this->setId($data['id']);
		}
		if (array_key_exists("updated_at", $data)) {
			$this->setUpdatedAt(new \DateTime($data['updated_at']));
		}
		if (array_key_exists("created_at", $data)) {
			$this->setCreatedAt(new \DateTime($data['created_at']));
		}
		if (array_key_exists("status", $data)) {
			$this->setStatus($data['status']);
		}
		if (array_key_exists("phone", $data)) {
			$this->setPhone($data['phone']);
		}
	}
	public function jsonSerialize() {
        return array(
        	"status" => $this->getStatus(),
        	"phone" => $this->getPhone(),
        );
    }
}