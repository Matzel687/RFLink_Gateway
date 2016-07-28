<?
class RFL_Link_Base extends IPSModule
{
	public function Create()
	{
		parent::Create();
		$this->ConnectParent("{6DC3D946-0D31-450F-A8C6-C42DB8D7D4F1}");
	}
	public function ApplyChanges()
	{
		parent::ApplyChanges();
	}
	################## PRIVATE  ##################
	protected function GetAdress() // must overwrite 
	{
	}
	protected function SendMsg($GeraeteTyp, $Adresse,$Taste, $command) {
		$msg = "10;".$GeraeteTyp.";".$Adresse.";".$Taste.";".$command.";\n";
		$this->SendMsgToParent($msg);
	}
	
	protected function SendMsgToParent($msg) 
	{
		IPS_LogMessage("RF-LinkGateway", $msg);
	
		IPS_SendDataToParent(
			$this->InstanceID, 
			json_encode(Array(
					"DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}",
					"EventID" => 0,
					"Buffer" => utf8_encode($msg))));
	}
}
?>