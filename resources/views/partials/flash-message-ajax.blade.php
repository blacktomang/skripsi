<div class="alert alert-success" id="success" style="
    position:fixed; 
    top: 0px; 
    left: 0px; 
    width: 100%;
    z-index:9999; 
    border-radius:10px;
    display:none">
  {{-- <button type="button" class="close" data-dismiss="alert" onclick="hideMessage()">×</button>     --}}
  <strong id="message"> It's success! </strong>
</div>

<div class="alert alert-danger" id="error" style="
    position:fixed; 
    top: 0px; 
    left: 0px; 
    width: 100%;
    z-index:9999; 
    border-radius:10px;
    display:none">
  {{-- <button type="button" class="close" data-dismiss="alert" onclick="hideMessage()">×</button>     --}}
  <strong id="messageErr"> It's error! </strong>
</div>



<script>
  // Show success message
  let showSuccessMessage = (message) => {
    $("#message").text(message)
    $('#success').fadeIn()
    setTimeout(function() {
      $('#success').fadeOut('slow');
    }, 3000); // <-- time in milliseconds
  };
  let showErrorMessage = (message) => {
    $("#messageErr").text(message)
    $('#error').fadeIn()
    setTimeout(function() {
      $('#error').fadeOut('slow');
    }, 3000); // <-- time in milliseconds
  };
</script>