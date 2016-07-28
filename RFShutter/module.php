<?
require_once(__DIR__ . DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."RF_Link_base.php"); 
//test
//test
class RFLinkShutter extends RFLinkBase
{
	
	public function Create()
	{
		parent::Create();
		$this->RegisterPropertyString("GeraeteTyp", "NewKaku");
		$this->RegisterPropertyString("Adresse", "0");
        $this->RegisterPropertyInteger("Taste", "0");

		$this->RegisterVariableInteger("Status", "Status", "~ShutterAction.ZWave");
		$this->EnableAction("Status");
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
	public function MoveUp()
	{
		$this->SendCommand("On");
		SetValue($this->GetIDForIdent("Status"), 2);
		$this->SetBuffer("LastComand","2");
		
	}
	public function MoveDown()
	{
		$this->SendCommand("Off");
		SetValue($this->GetIDForIdent("Status"), 1);
		$this->SetBuffer("LastComand","1");
	}

	public function MoveStop()
	{
		$LastComand = $this->GetBuffer("LastComand");
		if ($LastComand == 1)
			$this->SendCommand("Off");	
		elseif ($LastComand == 2)
			$this->SendCommand("On");
		SetValue($this->GetIDForIdent("Status"), 0);
	}
	public function SwitchState($value)
	{
		if ($value == 0 )
			$this->MoveStop();
		elseif ($value == 1) 
		$this->MoveDown();	
		elseif ($value == 2)
			$this->MoveUp();
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