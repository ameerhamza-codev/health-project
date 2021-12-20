@extends('layouts.front')
@section('content')
<style type="text/css">
	#local-video-container video {
		width: 120px;
		border: 3px solid #fff;
	    border-radius: 6px;
	}

	.my-video ul li video {
	    border: 3px solid #fff;
	    border-radius: 6px;
	}

	.chat-user {
		display: inline-block;
	}

	.chat-time { 
		display: inline-block;
	 }

	 #upload-file{
	    display:none
	}

	@media only screen and (max-width: 700.98px) {
		.message-view.chat-view {
			width: 100% !important;
    		display: flex !important;
		}

		.chat-sidebar {
			display: inline-block; !important;
	    	width: 100% !important;
		}
	}

</style>
<div class="page-wrapper-screen">
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-9 message-view chat-view">
                <div class="chat-window">
                    <div class="fixed-header">
						<div class="navbar">
                            <div class="user-details mr-auto">
                                <div class="float-left user-img m-r-10">
                                    <a href="profile.html" title="Mike Litorus"><img src="/assets/front/img/user.jpg" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                </div>
                                <div class="user-info float-left">
                                    <a href="profile.html" title="Mike Litorus"><span class="font-bold">{{$identity}}</span></a>
                                    <span class="last-seen">Online</span>
                                </div>
                            </div>
						</div>
                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="user-video" id="remote-video-container">
                                <img src="/assets/front/img/video-call.jpg" alt="">
                            </div>
                            <div class="my-video">
                                <ul>
                                    <li id="local-video-container">
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="call-icons">
                            <span class="call-duration">00:00</span>
                            <ul class="call-items">
                                <li class="call-item">
                                    <a href="" title="Enable Video" data-placement="top" data-toggle="tooltip">
                                        <i class="fa fa-video-camera camera"></i>
                                    </a>
                                </li>
                                <li class="call-item">
                                    <a href="javascript:;" title="Mute Audio" id="muteAudio" data-placement="top" data-toggle="tooltip">
                                        <i class="fa fa-microphone microphone"></i>
                                    </a>
                                </li>
                                @if($isPatient)
	                                <li class="call-item">
	                                    <a href="javascript:;" data-toggle="modal" data-target="#drag_files" title="Upload Images" id="uploadImages" data-placement="top" data-toggle="tooltip">
	                                        <i class="fa fa-upload "></i>
	                                    </a>
	                                </li>
                                @endif
                            </ul>
                            <div class="end-call">
                            	 @if($isPatient)
                            	 	<a href="/meeting/end">End Call</a>
                            	 @else
                                	<a href="/host/{{$room}}/end">End Call</a>
                            	 @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 message-view chat-sidebar" id="chat_sidebar">
                <div class="chat-window video-window">
                    <div class="fixed-header">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a class="nav-link" href="#chats_tab" data-toggle="tab">Chats</a></li>
                        </ul>
                    </div>
                    <div class="tab-content chat-contents">
                        <div class="content-full tab-pane active" id="chats_tab">
                            <div class="chat-window">
                                <div class="chat-contents">
                                    <div class="chat-content-wrap">
                                        <div class="chat-wrap-inner">
                                            <div class="chat-box">
                                                <div class="chats">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-footer">
                                    <div class="message-bar">
                                        <div class="message-inner">
                                        	<input id="upload-file" type="file"/>
                                            <a class="link attach-icon " id="upload_link" href="javascript:;"><img src="/assets/front/img/attachment.png" alt=""></a>
                                            <div class="message-area">
                                                <div class="input-group">
                                                    <textarea class="form-control send-text-message-box" placeholder="Type message..."></textarea>
                                                    <span class="input-group-append">
														<button class="btn btn-primary send-text-message" type="button"><i class="fa fa-send"></i></button>
													</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="drag_files" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Drag and drop your files upload</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            	<label>Front</label>
                <div class="upload-drop-zone dropzone" id="drop-zone-front">
                    <i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
                </div>
                <label>Back</label>
                <div class="upload-drop-zone dropzone" id="drop-zone-back">
                    <i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
                </div>
                <label>TestResult</label>
                <div class="upload-drop-zone dropzone" id="drop-zone-result">
                    <i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js-footer')
<script src="//sdk.twilio.com/js/video/releases/2.17.1/twilio-video.min.js"></script>
<script src="//media.twiliocdn.com/sdk/js/conversations/v2.0/twilio-conversations.min.js"></script>
<script src="//unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
	const Video = Twilio.Video;
	const start = Date.now();
	const muteAudio = $('#muteAudio');
	let client = Twilio.Conversations.Client;
	const identity = "{{$identity}}";
	Dropzone.autoDiscover = false;

	let myDropzoneFront = new Dropzone("div#drop-zone-front", { 
		url: "/meeting/save-records",
		dictDefaultMessage: '',
		init: function() {
            this.on("sending", function(file, xhr, formData){
                formData.append("room", "{{$room}}");
                formData.append("field", "front");
                formData.append("_token", "{{ csrf_token() }}");
            });
            this.on("success", function(file, responseText) {
	            if(responseText.code == 200) {
	            	alert(responseText.message);
	            }else{
	            	alert(responseText.message);	
	            }
	        });
        }
	});

	let myDropzoneBack = new Dropzone("div#drop-zone-back", { 
		url: "/meeting/save-records",
		dictDefaultMessage: '',
		init: function() {
            this.on("sending", function(file, xhr, formData){
                formData.append("room", "{{$room}}");
                formData.append("field", "back");
                formData.append("_token", "{{ csrf_token() }}");
            });
            this.on("success", function(file, responseText) {
	            if(responseText.code == 200) {
	            	alert(responseText.message);
	            }else{
	            	alert(responseText.message);	
	            }
	        });
        }
	});
	let myDropzoneResult = new Dropzone("div#drop-zone-result", { 
		url: "/meeting/save-records",
		dictDefaultMessage: '',
		init: function() {
            this.on("sending", function(file, xhr, formData){
                formData.append("room", "{{$room}}");
                formData.append("field", "result");
                formData.append("_token", "{{ csrf_token() }}");
            });
            this.on("success", function(file, responseText) {
	            if(responseText.code == 200) {
	            	alert(responseText.message);
	            }else{
	            	alert(responseText.message);	
	            }
	        });
        }
	});


	// Convert time format
	function formatAMPM(date) {
	    var strTime = '';
	    var hours = date.getHours();
	    var minutes = date.getMinutes();
	    var ampm = hours >= 12 ? 'PM' : 'AM';
	    hours = hours % 12;
	    hours = hours ? hours : 12; // the hour '0' should be '12'
	    minutes = minutes < 10 ? '0' + minutes : minutes;
	    if (!isToday(date)) {
	        strTime = strTime + date.toDateString() + ', ';
	    }
	    strTime = strTime + hours + ':' + minutes + ' ' + ampm;

	    return strTime;
	}

	function isToday(date) {
	    const today = new Date()
	    return date.getDate() == today.getDate() &&
	        date.getMonth() == today.getMonth() &&
	        date.getFullYear() == today.getFullYear();
	}

	var printMessage = async function(msg) {
		leftClass = "chat-left";
		if(msg.author != identity) {
			var leftClass = "";
		}

		var media_url = "";
		var media_name = "";
		var media_type = "";

		var content = "";
		if (msg.type === 'media') {
			await msg.media.getContentTemporaryUrl().then(function(url) {
	            media_url = url;
	        });
	        media_name = msg.media.filename;
	        media_type = msg.media.contentType;

	        if (((media_type == 'image/jpeg') || (media_type == 'image/jpg') || (media_type == 'image/png'))) {
	            content += `<ul class="attach-list">
                                <li class="img-file">
                                    <div class="attach-img-download"><a href="`+media_url+`">`+media_name+`</a></div>
                                    <div class="attach-img"><img src="`+media_url+`" alt=""></div>
                                </li>
                            </ul>`;;
	        } else {
	            content += `<ul class="attach-list">
                                <li class="img-file">
                                    <i class="fa fa-file"></i> <a href="`+media_url+`">`+media_name+`</a>
                                </li>
                            </ul>`;
	        }
		}else{
			content = `<p>`+msg.body+`</p>`;
		}	

		var message = `<div class="chat `+leftClass+`">
                            <div class="chat-avatar">
                                <a href="profile.html" class="avatar">
                                    <img alt="`+msg.author+`" src="/assets/front/img/user.jpg" class="img-fluid rounded-circle">
                                </a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-bubble">
                                    <div class="chat-content">
                                        <span class="chat-user">`+msg.author+`</span> <span class="chat-time">`+formatAMPM(msg.dateCreated)+`</span>
                                        `+content+`
                                    </div>
                                </div>
                            </div>
                        </div>`;
          $(".chats").append(message);
	}

	$("#upload_link").on('click', function(e){
        e.preventDefault();
        $("#upload-file:hidden").trigger('click');
    });


	client.create('{{$chatTokenString}}').then(client => {
	// Use client
		client.on("connectionStateChanged", (state) => {

		});
		
		chatclient = client.getConversationByUniqueName('{{$room}}').then(async function(channel) {
            //await setupChannel(channel, chatBoxes[code], code, isFirst);
        	channel.on('messageAdded', async function(message) {
		        console.log("messageAdded",message);
		        printMessage(message);
		    });

		    //set up the listener for the typing started Channel event
		    channel.on('typingStarted', function(member) {
		       console.log("typingStarted",member); 
		    });

		    //set  the listener for the typing ended Channel event
		    channel.on('typingEnded', function(member) {
		       console.log("typingEnded",member);  
		    });

		    $(document).on("click",".send-text-message",function(){
		    	var msg = $(".send-text-message-box").val();
		    	channel.sendMessage(msg);
		    	$(".send-text-message-box").val("");
		    });

		    $(document).on("change","#upload-file",function(e){
		    	var $this = $(this);
		    	const formData = new FormData();
		    	let file = $this[0].files[0];
		        if (typeof file !== undefined && file != null) {
		            formData.append('file', file);
		            channel.sendMessage(formData);
		        }
		    });

        }).catch(function(e) {
            console.log(e.message);
        });	

	});


	function checkTime(){
	  var timeDifference = Date.now() - start;
	  var formatted = convertTime(timeDifference);
	  $('.call-duration').html('' + formatted);
	}

	function convertTime(miliseconds) {
	  var totalSeconds = Math.floor(miliseconds/1000);
	  var minutes = Math.floor(totalSeconds/60);
	  var seconds = totalSeconds - minutes * 60;
	  if(String(seconds).length == 1) {
	  	seconds = "0"+seconds;
	  }
	  if(String(minutes).length == 1) {
	  	minutes = "0"+minutes;
	  }
	  return minutes + ':' + seconds;
	}

	//request local video tracks
	Video.createLocalTracks().then(function(localTracks) {
	  var localMediaContainer = document.getElementById('local-video-container');
	      storedLocalTracks = localTracks;
		  localTracks.forEach(function(track) {
		    localMediaContainer.appendChild(track.attach());
		  });
	});

	Video.connect('{{$tokenstring}}', { name:'{{$room}}' }).then(room => {
	  console.log(`Successfully joined a Room: ${room}`);
	  room.participants.forEach(participantConnected);
	  room.on('participantConnected', participantConnected);

	  room.on('participantDisconnected', participantDisconnected);
	  room.once('disconnected', error => room.participants.forEach(participantDisconnected));

	  muteAudio.on('click', (e) => {
	  		var $this = $(e.currentTarget);
	  		room.localParticipant.audioTracks.forEach(track => {
	  			if($this.hasClass("disable") === false) {
			    	track.track.disable();
			    	$this.addClass("disable");
			    	$this.find("i").removeClass("fa-microphone").addClass("fa-microphone-slash");
	  			}else{
	  				$this.removeClass("disable");
	  				track.track.attach();
	  				$this.find("i").removeClass("fa-microphone-slash").addClass("fa-microphone");
	  			}
		  	});
	  });
	}, error => {
	  console.error(`Unable to connect to Room: ${error.message}`);
	});

	function participantConnected(participant) {
	  const div = document.getElementById('remote-video-container');
	      div.innerHTML = '';
		  participant.on('trackSubscribed', track => trackSubscribed(div, track));
		  participant.on('trackUnsubscribed', trackUnsubscribed);

		  participant.tracks.forEach(publication => {
		    if (publication.isSubscribed) {
		      trackSubscribed(div, publication.track);
		    }
		  });

	  	window.setInterval(checkTime, 100);
	}

	function participantDisconnected(participant) {
	  console.log('Participant "%s" disconnected', participant.identity);
	  //document.getElementById(participant.sid).remove();
	}

	function trackSubscribed(div, track) {
		div.appendChild(track.attach());
	}

	function trackUnsubscribed(track) {
	  	track.detach().forEach(element => element.remove());
	 }

</script>
@endsection
@endsection
