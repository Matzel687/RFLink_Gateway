<?
require_once(__DIR__ . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."RF_Link_base.php"); 



class RFSwitch extends RFLinkBase
{
	
	public function Create()
	{
		parent::Create();
		$this->RegisterPropertyString("GeraeteTyp", "NewKaku");
		$this->RegisterPropertyString("Adresse", "0");
        $this->RegisterPropertyInteger("Taste", "0");

		$this->RegisterVariableBoolean("Status", "Status", "~Switch");
		$this->EnableAction("Status");
		
		/*$this->RegisterScript("SWITCHON",  "Switch On",  '<? ITSW_SwitchOn(IPS_GetParent($_IPS["SELF"])); ?>'); 
		$this->RegisterScript("SWITCHOFF", "Switch Off", '<? ITSW_SwitchOff(IPS_GetParent($_IPS["SELF"])); ?>'); */
	}
		public function RequestAction($Ident, $Value)
		{
			switch($Ident) {
				case "Status":
					$this->SwitchState($Value);
					break;
				default:
					throw new Exception("Invalid ident");
			}
		
		}
	
	public function ApplyChanges()
	{
		parent::ApplyChanges();
	}
	protected function GetAdress()
	{
		return $this->ReadPropertyString("GeraeteTyp") . $this->ReadPropertyString("Adresse") . $this->ReadPropertyInteger("Taste");
	}
	public function SwitchOn()
	{
		$this->SendCommand("On");
		SetValue($this->GetIDForIdent("Status"), true);
	}
	public function SwitchOff()
	{
		$this->SendCommand("Off");
		SetValue($this->GetIDForIdent("Status"), false);
	}
	public function SwitchState($value)
	{
		if ($value)
			$this->SwitchOn();
		else
			$this->SwitchOff();
	}
	protected function SendCommand($command)
	{
		parent::SendMsg($this->ReadPropertyString("GeraeteTyp"), 
		                $this->ReadPropertyString("Adresse"),
                        $this->ReadPropertyString("Taste"),
		                $command);
	}
}
?>