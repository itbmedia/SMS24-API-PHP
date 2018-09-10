<?php

namespace Sms24\Api\Models;

class Sms implements \JsonSerializable {

	private $id;

	private $message;

	private $groups = array();

	private $contacts = array(); 

	private $createdAt;

	private $originator;

	public function __construct($message = null) {
		$this->setMessage($message);
	}

	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}
	public function getMessage() {
		return $this->message;
	}
	public function addContact(\Sms24\Api\Models\Contact $contact) {
		$this->contacts[] = $contact;
	}
	public function getContacts() {
		return $this->contacts;
	}
	public function addGroup(\Sms24\Api\Models\Group $group) {
		$this->groups[] = $group;
	}
	public function getGroups() {
		return $this->groups;
	}
	public function setOriginator(\Sms24\Api\Models\Originator $originator) {
		$this->originator = $originator;
	}
	public function getOriginator() {
		return $this->originator;
	}
	private function setCreatedAt(\DateTime $createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}
	public function getCreatedAt() {
		return $this->createdAt;
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
		if (array_key_exists("message", $data)) {
			$this->setMessage($data['message']);
		}
		if (array_key_exists("created_at", $data)) {
			$this->setCreatedAt(new \DateTime($data['created_at']));
		}
		if (array_key_exists("groups", $data)) {
			foreach ($data['groups'] as $info) {
				$group = new \Sms24\Api\Models\Group();
				$group->jsonUnserialize($info);

				$this->addGroup($group);
			}
		}
		if (array_key_exists("contacts", $data)) {
			foreach ($data['contacts'] as $info) {
				$contact = new \Sms24\Api\Models\Contact();
				$contact->jsonUnserialize($info);

				$this->addContact($contact);
			}
		}
		if ((array_key_exists("originator", $data)) && (is_array($data['originator']))) {
			$originator = new \Sms24\Api\Models\Originator();
			$originator->jsonUnserialize($data['originator']);

			$this->setOriginator($originator);
		}
	}
	public function jsonSerialize() {
        return array(
        	"message" => $this->getMessage(),
        	"groups" => $this->getGroups(),
        	"contacts" => $this->getContacts(),
        	"originator" => $this->getOriginator(),
        );
    }
}