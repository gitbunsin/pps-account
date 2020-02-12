<!-- Modal -->
<div class="modal fade" id="zulu-success-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="vertical-alignment-helper">
  <div class="modal-dialog vertical-align-center" role="document" style="opacity:0.90;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel"><li class="fa fa-check-square-o fa-2x" style="color:#009900"></li> Thank you for opening account with PPS Social Trading.</h5>
      </div>
      <div class="modal-body">
<div class="row">    
  <link rel='stylesheet prefetch' href='https://storage.googleapis.com/code.getmdl.io/1.0.6/material.blue-indigo.min.css'>
  <link rel="stylesheet" href="./components/material-design-horizontal-stepper/css/style.css">
  
  <div class="mdl-stepper-horizontal-alternative">
    <div id="zulu-step1" class="mdl-stepper-step active-step">
      <div class="mdl-stepper-circle"><span>1</span></div>
      <div class="mdl-stepper-title">Request Form</div>
      <!--<div class="mdl-stepper-optional">PPS Forex</div>-->
      <div class="mdl-stepper-bar-left"></div>
      <div class="mdl-stepper-bar-right"></div>
    </div>
    <div id="zulu-step2" class="mdl-stepper-step">
      <div class="mdl-stepper-circle"><span>2</span></div>
      <div class="mdl-stepper-title">Account Funding</div>
      <!--<div class="mdl-stepper-optional">(Cash/Transfer)</div>-->
      <div class="mdl-stepper-bar-left"></div>
      <div class="mdl-stepper-bar-right"></div>
    </div>
    <div id="zulu-step3" class="mdl-stepper-step">
      <div class="mdl-stepper-circle"><span>3</span></div>
      <div class="mdl-stepper-title">Account Activating</div>
      <!--<div class="mdl-stepper-optional">(Cash/Transfer)</div>-->
      <div class="mdl-stepper-bar-left"></div>
      <div class="mdl-stepper-bar-right"></div>
    </div>
  </div>
  
  <div class="col-md-12">
    <p>Your trading account is almost done, Just 2 more steps to be ready.<br />
     <span class="fa fa-envelope"></span> <strong style="color:#069">We have sent an email to you about below info., please check your email!</strong>.</p>
    <p><strong>Zulutrade Account Opening Process:</strong></p>
    <ul style="font-size:14px; list-style:none; line-height:35px;">
      <li><span class="fa fa-check" style="color:#4267b2;"></span> <img src="./register/images/1done.png" width="24px" /> <span style="color:#009900;"><strong>Request Form</strong> <small>(You have done this step)</small></span>
      <p style="padding-left:30px;">PPS will create and send you the <strong>Zulutrade MT4</strong> detail to your registered email address.</p>
      </li>
      <li style="padding-left:18px;"><img src="./register/images/2.png" width="24px" /> <strong>Account Funding</strong> <a id="funding-option" style="cursor:pointer;"><span class="fa fa-question-circle" style="font-size:20px;"></span></a>
      <p style="padding-left:30px;">Fund your <strong>Zulutrade MT4</strong> before it can be used with <strong>Zulutrade Platform</strong>.</p>
      </li>
      <li style="padding-left:18px;"><img src="./register/images/3g.png" width="24px" /> <strong>Zulutrade Activation</strong> <a id="zulu-activation" style="cursor:pointer;"><span class="fa fa-question-circle" style="font-size:20px;"></span></a>
        <p style="padding-left:30px;">After funding, Zulutrade will send you an email regarding <strong>Zulutrade Account</strong> infomation for <strong>activating</strong></a> and starting social trading.</p>
      </li>
    </ul>
    <center>
    <p><i>Thank You!</i></p>
    <!--<a class="btn btn-primary" href="../open-zulu" target="_parent"> Done </a>-->
    </center>

  </div>
  <!-- ends col-6 -->
</div>
	</div>
      <div class="modal-footer text-center">
        <!--<a class="btn btn-primary modal-btn" href="../open-zulu" target="_blank">&nbsp;Okay</a>-->
                <button type="button" id="btn-msg-cancel" class="btn btn-primary modal-btn" data-dismiss="modal">OK</button>

      </div>
    </div>
  </div>
   </div>
</div>

<script>
	$("#funding-option, #zulu-step2").on('click', function(event) {
		//Show Msgbox
		window.parent.renderModal('#funding-option-modal');
	});
	$("#zulu-activation, #zulu-step3").on('click', function(event) {
		//Show Msgbox
		window.parent.renderModal('#zulu-activation-modal');
	});
</script>