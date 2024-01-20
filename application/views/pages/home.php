<h1>
  <?php echo $title; ?>
</h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th>Time</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($documents as $key) { ?>
      <tr>
        <td>
          <a href="<?= base_url(); ?><?= $key['slug']; ?>" class="text-dark">
            <?= $key['firstname']; ?> <?= $key['lastname']; ?>
          </a>
        </td>
        <td>
          <div id="timer<?= $key['id']; ?>">00:00:00</div>
          <input type="text" id="inputTime<?= $key['id']; ?>" placeholder="Set initial time (hh:mm:ss)">
          <button type="button" class="btn btn-primary btn-sm set-time-btn" value="<?= $key['id']; ?>">Set Time</button>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteModal" value="<?= $key['id']; ?>">Delete</button>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<!-- Modal Timer -->
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
  <!-- <div class="modal-dialog" role="document"> -->
    <!-- <div class="modal-content"> -->
      <!-- <div class="modal-header"> -->
        <!-- <h5 class="modal-title" id="exampleModalLabel">Timer Expired</h5> -->
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
          <!-- <span aria-hidden="true">&times;</span> -->
        <!-- </button> -->
      <!-- </div> -->
      <!-- <div class="modal-body"> -->
        <!-- The timer has reached 00:00:00. -->
      <!-- </div> -->
      <!-- <div class="modal-footer"> -->
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      <!-- </div> -->
    <!-- </div> -->
  <!-- </div> -->
<!-- </div> -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel"> Are you sure you want to delete </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete-btn" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>






<script>
  $(document).ready(function() {
    $(document).on('click', '.delete-btn', function() {
      var id = $(this).val();
      console.log(id);

      // Set the value of the confirmation button to the document ID
      $('#deleteModal .delete-btn').val(id);

      // Show the modal
      $('#deleteModal').modal('show');
    });

    // Handle the modal's confirmation button click
    $(document).on('click', '#deleteModal .delete-btn', function() {
      var id = $(this).val();
      console.log(id);
      $.ajax({
        url: "<?php echo base_url('pages/delete'); ?>",
        method: "POST",
        data: {
          Oid: id
        },
        success: function(data) {
          console.log('Document deleted successfully');
          location.reload();
        }
      });
    });

    // Handle the modal's cancel button click
    $(document).on('click', 'button.cancel-btn', function() {
      location.reload();
    });
  });

   


  //timer 


  document.addEventListener('DOMContentLoaded', function() {
    var timers = {};

    // Function to start the timer
    function startTimer(id, durationInSeconds) {
      var timerElement = document.getElementById('timer' + id);
      var endTime = new Date().getTime() + durationInSeconds * 1000;

      function updateTimer() {
        var currentTime = new Date().getTime();
        var remainingTime = endTime - currentTime;

        if (remainingTime <= 0) {
          clearInterval(timers[id]);
          // Show modal when the timer is up
          $('#myModal').modal('show');
        } else {
          var formattedTime = formatTime(remainingTime);
          timerElement.innerText = formattedTime;
        }
      }

      // Initial update
      updateTimer();

      // Update the timer every second
      timers[id] = setInterval(updateTimer, 1000);
    }

    // Function to format time as hh:mm:ss
    function formatTime(milliseconds) {
      var seconds = Math.floor(milliseconds / 1000);
      var hours = Math.floor(seconds / 3600);
      var minutes = Math.floor((seconds % 3600) / 60);
      seconds = seconds % 60;

      return (
        pad(hours) + ':' +
        pad(minutes) + ':' +
        pad(seconds)
      );
    }

    // Function to pad single digits with leading zero
    function pad(num) {
      return (num < 10 ? '0' : '') + num;
    }

    // Set initial time button click event
    $('.set-time-btn').click(function() {
      var userId = $(this).val();
      var initialTime = $('#inputTime' + userId).val();
      var durationInSeconds = parseTimeToSeconds(initialTime);

      if (!isNaN(durationInSeconds)) {
        // Stop existing timer if any
        clearInterval(timers[userId]);

        // Start a new timer
        startTimer(userId, durationInSeconds);
      }
    });

    // Function to parse time input to seconds
    function parseTimeToSeconds(timeString) {
      var parts = timeString.split(':');
      var hours = parseInt(parts[0], 10) || 0;
      var minutes = parseInt(parts[1], 10) || 0;
      var seconds = parseInt(parts[2], 10) || 0;

      return hours * 3600 + minutes * 60 + seconds;
    }
  });

</script>