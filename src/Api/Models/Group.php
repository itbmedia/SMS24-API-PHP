<?php

namespace Sms24\Api\Models;

class Group implements \JsonSerializable {

	private $id;

	private $title;

	private $createdAt;

	private $contactCount;

	public function __construct($title = null) {
		$this->setTitle($title);
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
	private function setContactCount($contactCount) {
		$this->contactCount = $contactCount;
		return $this;
	}
	public function getContactCount() {
		return $this->contactCount;
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
		if (array_key_exists("contact_count", $data)) {
			$this->setContactCount($data['contact_count']);
		}
		if (array_key_exists("created_at", $data)) {
			$this->setCreatedAt(new \DateTime($data['created_at']));
		}
		if (array_key_exists("title", $data)) {
			$this->setTitle($data['title']);
		}
	}
	public function jsonSerialize() {
        return array(
        	"title" => $this->getTitle(),
        );
    }
}