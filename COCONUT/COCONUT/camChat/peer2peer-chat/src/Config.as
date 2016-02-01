package   {
	[Bindable] public class Config {
	public const DeveloperKey:String = "40f799e0cc8aa547e5c772c8-1e4256247000";	
	public const StratusAddress:String = "rtmfp://p2p.rtmfp.net/" + DeveloperKey;
	
	public var DEBUG:Boolean = false;
		
		
		public function Config():void {	
			if (DEBUG) {
			}
		}
	}
}