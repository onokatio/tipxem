<?php
require_once ("./NEMUtil.php");
function array_key_exists_r($keys, $search_r) {
    $keys_r = explode('|', $keys);
    foreach ($keys_r as $key) if (!array_key_exists($key, $search_r)) return false;
    return true;
}
class TransactionBuilder {
    private $type = null;
    private $version = null;
    private $signerlen = null;
    private $signer = null;
    private $fee = null;
    private $recipientlen = null;
    private $recipient = null;
    private $amount = null;
    private $timestamp = 0;
    private $deadline = 0;
    private $binary = "";
    private $message = array("payload" => "", "type" => 1);
    public function __construct($input) {
        if (is_array($input)) {
            $this->setFromArray($input);
        }
    }
    public function setFromArray($input) {
        if (is_array($input) && array_key_exists_r('type|version|signer|recipient|amount', $input)) {
            $this->type = $input["type"];
            $this->version = $input["version"];
            $this->signer = $input["signer"];
            $this->recipient = $input["recipient"];
            $this->amount = $input["amount"];
            if (array_key_exists('timestamp', $input)) {
                $this->timestamp = $input["timestamp"];
            }
            if (array_key_exists('deadline', $input)) {
                $this->deadline = $input["deadline"];
            }
            if (array_key_exists('fee', $input)) {
                $this->fee = $input["fee"];
            }
            if (array_key_exists('message', $input) && array_key_exists_r('type|payload', $input['message'])) {
                $this->message = $input["message"];
            }
            return true;
        } else {
            return false;
        }
    }
    private function build() {
        if (isset($this->type, $this->version, $this->signer, $this->recipient, $this->amount)) {
            if (!$this->fee) {
                $this->fee = calcFeeTransfer($this->amount);
                if ($this->message['payload'] && !($decodedMessage = hex2bin($this->message['payload']))) {
                    $this->fee += calcFeeMessage($decodedMessage);
                }
            }
            $this->binary = int2binary($this->type) . //Transaction type
            int2binary($this->version) . //Transaction version
            int2binary($this->timestamp) . //TimeStamp
            int2binary(strlen(hex2bin($this->signer))) . //Signer pubkey length ( always 32 )
            hex2bin($this->signer) . //Signer (sender) pubkey
            long2binary($this->fee) . //Transaction fee ( micro XEM )
            int2binary($this->deadline) . //Deadline
            int2binary(strlen($this->recipient)) . //Recipient address length ( always 40 )
            $this->recipient . //Recipient address
            long2binary($this->amount);
            if ($this->message['payload'] && $decodedMessage = hex2bin($this->message['payload'])) {
                $this->binary.= int2binary(8 + strlen($this->message['payload']) / 2) . int2binary($this->message['type']) . int2binary(strlen($this->message['payload']) / 2) . $decodedMessage;
            }else{
              $this->binary.= int2binary(0);
            }
        }
    }
    public function getBinary() {
        $this->build();
        return $this->binary;
    }
    public function getHex() {
        $this->build();
        return bin2hex($this->binary);
    }
}
