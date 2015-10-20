<?php
require "configurationitem.php";
function MessageCatalogue() {
	return false;
}
class UnitTest {
	public function __construct() {
		$this->total_tests = 0;
		$this->output = "";
	}
	public function Run($test,$result,$datatype) {
		if ($datatype == "bool") {
			
			if ($result) {
				$this->ShowResult($test,"Success");
			}
			else {
				$this->ShowResult($test,"Failed");
			}
		}
	}
	private function ShowResult($test,$result) {
		$this->total_tests++;
		$this->output .= "$test - $result<br />\n";
	}
	public function Result() {
		echo $this->output;
	}
}
$unittest = new UnitTest;

$ci = new ConfigurationItem;
/************************************ ADD CI - TEST 1 ***********************/
$ci->SetVar("ItemName","Storage");
$result = $ci->Add();
$unittest->Run("ADD CI",$result,"bool");
/************************************ EDIT CI - TEST 2 ***********************/
$ci->SetVar("ItemID","1");
$ci->SetVar("ItemName","Storage1");
$result = $ci->Edit();
$unittest->Run("EDIT CI",$result,"bool");
/************************************ DELETE CI - TEST 3 ***********************/
$ci->SetVar("ItemID","1");
$result = $ci->Delete();
$unittest->Run("DELETE CI",$result,"bool");
/************************************ CI - ADD DEPENDENCY TEST 4 ***********************/
$ci->SetVar("ItemName","Storage");
$result = $ci->Add();

$ci->SetVar("ItemName","PeopleSoft");
$ci->SetVar("DependencyID",1);
$result = $ci->Add();
$unittest->Run("CI - ADD DEPENDENCY",$result,"bool");

echo $unittest->Result();
?>