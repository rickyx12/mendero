import flash.events.NetStatusEvent;
import flash.external.ExternalInterface;
import flash.media.Camera;
import flash.media.Microphone;
import flash.media.Video;
import flash.net.NetConnection;

import mx.controls.Alert;
import mx.core.Application;
import mx.core.FlexGlobals;
import mx.messaging.channels.StreamingAMFChannel;
import spark.components.Application;

private var netConnection:NetConnection;
public var remoteVideo:Video;
[Bindable] public var myConfig:Config = new Config();
public var microphone:Microphone;
public var camera:Camera;
[Bindable] public var myUser:User = new User();
[Bindable] public var hisUser:User = new User();
public var video:Video;
private var sendStream:NetStream;
private var recvStream:NetStream; 
public var netStreamSendClient:Object;

public function startChat(username:String, hisStratus:String):void {	
	hisUser.username = username;
	hisUser.idStratus = hisStratus;
	receiveStream();	
}
private function receiveStream():void {
	hisWebcam.visible = true;	
	recvStream = new NetStream(netConnection,  hisUser.idStratus);
	recvStream.addEventListener(NetStatusEvent.NET_STATUS, netStreamReceiveHandler);
	recvStream.client = this;	
	remoteVideo.attachNetStream(recvStream);	
	myUser.connectedWith = hisUser.username;
	recvStream.play(hisUser.idStratus);
}
private function netStreamReceiveHandler(event:NetStatusEvent):void	{
	debug("->netStreamReceiveHandler"+event.info.code);
	if (event.info.code == "NetStream.Play.Start") {
		myUser.connectedWithSomeOne = true;
	}
}

public function endChat():void {
	
}

private function init():void {
	ExternalInterface.addCallback("startChat" , startChat);
	ExternalInterface.addCallback("endChat" , endChat);
	
	myUser.username = FlexGlobals.topLevelApplication.parameters.username;
	remoteVideo = new Video(320 , 240);
	hisWebcam.addChild(remoteVideo);
	netConnection = new NetConnection();
	netConnection.addEventListener(NetStatusEvent.NET_STATUS , netConnectionHandler);
	netConnection.connect(myConfig.StratusAddress + "/" + myConfig.DeveloperKey);
	prepareWebcamAndMicro();
}
private function prepareWebcamAndMicro():void {
	microphone = Microphone.getMicrophone(myUser.microName);
	camera = Camera.getCamera(myUser.cameraName);
	if (camera == null) {
		Alert.show("Webcam not found");
		return;
	} else {
		if (camera.muted) {
			Security.showSettings(SecurityPanel.PRIVACY);
		}
		camera.setMode(320 , 240 , 15);
		camera.setQuality(0,90);
		//camera.addEventListener(StatusEvent.STATUS, camera_status);		
		video = new Video(myWebcam.width  , myWebcam.height);
		video.attachCamera(camera);
		video.cacheAsBitmap = true;
		myWebcam.addChild(video);
	}	
}



private function prepareStreams():void {
	myUser.idStratus = netConnection.nearID;
	if (myConfig.DEBUG) Alert.show("prepareStreams myUser.idStratus ="+myUser.idStratus);
	netStreamSendClient = {
		onPeerConnect: function(subscriber:NetStream):Boolean{
			debug("onPeerConnect");
			if (hisUser.idStratus == subscriber.farID) return true;
			hisUser = new User();
			hisUser.idStratus = subscriber.farID;
			receiveStream();
			return true;
		}
	}  	
	myUser.connected = true;
	sendStream = new NetStream(netConnection, NetStream.DIRECT_CONNECTIONS);
	sendStream.addEventListener(NetStatusEvent.NET_STATUS , netStreamSendHandler);
	sendStream.client = netStreamSendClient;
	
	if (microphone){
		sendStream.attachAudio(Microphone.getMicrophone());
	}
	if (camera) {
		sendStream.attachCamera(camera);
	}
	var timer:Timer = new Timer(50);
	timer.start();	
	sendStream.publish(myUser.idStratus);
	
}
private function netStreamSendHandler(event:NetStatusEvent):void	{
	debug("*** netStreamSendHandler event: " + event.info.code );
	if (event.info.code=="NetStream.Play.Start") {
		if (camera.muted) Security.showSettings(SecurityPanel.PRIVACY); 
		hisUser.username = "guest";
	}
}
private function netConnectionHandler(event:NetStatusEvent):void {
	debug("NetConnection event: " + event.info.code );
	switch (event.info.code){
		case "NetConnection.Connect.Success":
			myUser.idStratus = netConnection.nearID;
			ExternalInterface.call("connected" , myUser.username , myUser.idStratus );
			prepareStreams();
			break;
		
		case "NetConnection.Connect.Closed":
			myUser.connected = false;
			
			break;
		
		case "NetStream.Connect.Success":
			// we get this when other party connects to our control stream our outgoing stream
			debug("Connection from: " + event.info.stream.farID );
			myUser.connectedWithSomeOne = true;
			break;
		
		case "NetConnection.Connect.Failed":
			debug("Unable to connect\n");
			break;
		
		case "NetStream.Connect.Closed":
			resetStreams();
			myUser.connectedWithSomeOne = false;
			ExternalInterface.call("endChat");
			break;
	}
}
private function debug(txt:String):void {
	if(!myConfig.DEBUG) return;
	txt+="<br>";
	chat_txt.validateNow();
	chat_txt.htmlText+=txt;
	chat_txt.validateNow();
	chat_txt.verticalScrollPosition = chat_txt.maxVerticalScrollPosition;	
}
private function sendText():void {
	var txt:String = input_txt.text;
	txt = "<b>"+ myUser.username+"</b>:"+ txt;
	input_txt.text="";
	chat_txt.validateNow();
	
	sendStream.send("receiveText", txt , 0);
	txt = txt+"<br>";
	chat_txt.htmlText+=txt;
	
	chat_txt.validateNow();
	chat_txt.verticalScrollPosition = chat_txt.maxVerticalScrollPosition;
}
public function receiveText(txt:String, color:uint):void {
	chat_txt.htmlText+=txt;
	chat_txt.validateNow();
	chat_txt.verticalScrollPosition = chat_txt.maxVerticalScrollPosition;
}

public function resetStreams():void {
	var i:int;
	debug("reset STreams");
	if (sendStream!=null) {
		debug("sendStream.peerStreams.length="+sendStream.peerStreams.length);
		for ( i=0; i<sendStream.peerStreams.length;i++) {
			sendStream.peerStreams[i].close();
		}
	}
	if (recvStream==null) return;
	return;
}