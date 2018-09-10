<?php

namespace Sms24\Api\Models;

class Originator implements \JsonSerializable {

	private $id;

	private $title;

	private $type = 'alpha';

	private $smsCount;

	private $createdAt;

	public function __construct($title = null, $type = null) {
		$this->setTitle($title);
		if ($type) {
			$this->setType($type);
		}
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function getTitle() {
		return $this->title;
	}
	private function setCreatedAt(\DateTime $createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	public function getCreatedAt() {
		return $this->createdAt;
	}
	public function setType($type) {
		if (!in_array($type, array("alpha", "numeric", "shortcode"))) {
			throw new \Exception('Originator type must be one of {"alpha", "numeric", "shortcode"}');
		}
		$this->type = $type;
		return $this;
	}
	public function getType() {
		return $this->type;
	}
	private function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	private function setSmsCount($smsCount) {
		$this->smsCount = $smsCount;
		return $this;
	}
	public function getSmsCount() {
		return $this->smsCount;
	}
	public function jsonUnserialize($data) {
		if (array_key_exists("id", $data)) {
			$this->setId($data['id']);
		}
		if (array_key_exists("contact_count", $data)) {
			$this->setContactCount($data['contact_count']);
		}
		if (array_key_exists("created_at", $data)) {
			$this->setCreatedAt(new \DateTime($data['created_at']));
		}
		if (array_key_exists("sms_count", $data)) {
			$this->setSmsCount($data['sms_count']);
		}
		if (array_key_exists("title", $data)) {
			$this->setTitle($data['title']);
		}
	}
	public function jsonSerialize() {
        return array(
        	"title" => $this->getTitle(),
        	"type" => $this->getType(),
        );
    }
}