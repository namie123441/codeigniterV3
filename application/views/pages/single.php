<table class="container mt-4">
  <tr>
    <td class="form-group" colspan="2">
      <div id="uploaded_image">
        <img src="assets/images/<?= htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>" id="<?= htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>" width="200" height="200">
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <label for="input4">Upload Profile Picture</label>
    </td>
    <td>
      <input type="file" class="form-control" id="image" name="image"><br>
    </td>
  </tr>
  <tr>
    <td>
      <label for="input1">Firstname</label>
      <input type="hidden" class="form-control id" id="<?= $id; ?>" name="<?= $id; ?>" value="<?= $id; ?>">
    </td>
    <td>
      <input type="text" class="form-control firstname" id="<?= $id; ?>" name="<?= $firstname; ?>" placeholder="<?= $firstname; ?>" value="<?= $firstname; ?>">
    </td>
  </tr>
  <tr>
    <td>
      <label for="input2">Lastname</label>
    </td>
    <td>
      <input type="text" class="form-control lastname" id="<?= $id; ?>" name="<?= $lastname; ?>" placeholder="<?= $lastname; ?>" value="<?= $lastname; ?>">
    </td>
  </tr>
  <tr>
    <td>
      <label for="input3">Middlename</label>
    </td>
    <td>
      <input type="text" class="form-control middlename" id="<?= $id ?>" name="<?= $middlename; ?>" placeholder="<?= $middlename; ?>" value="<?= $middlename; ?>">
    </td>
  </tr>
  <tr>
    <td>
      <label for="input3">Primary Address</label>
    </td>
    <td>
      <input type="text" class="form-control primary_address" id="<?= $id; ?>" name="<?= $primary_address; ?>" placeholder="<?= $primary_address; ?>" value="<?= $primary_address; ?>">
    </td>
  </tr>
  <tr>
    <td>
      <label for="input3">Secondary Address</label>
    </td>
    <td>
      <input type="text" class="form-control seconday_address" id="<?= $id; ?>" name="<?= $seconday_address; ?>" placeholder="<?= $seconday_address; ?>" value="<?= $seconday_address; ?>">
    </td>
  </tr>
  <tr>
    <td>
      <label for="input4">Date of birth</label>
    </td>
    <td>
      <input type="text" class="form-control date_published" id="<?= $id ?>" name="<?= $date_published; ?>" placeholder="<?= $date_published; ?>" value="<?= $date_published; ?>"><br>
    </td>
  </tr>
  <tr>
    <td>
      <label for="input4">Contact No.</label>
    </td>
    <td>
      <input type="text" class="form-control contactno" id="<?= $id; ?>" name="<?= $contact_no; ?>" placeholder="<?= $contact_no; ?>" value="<?= $contact_no; ?>"><br>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <button type="submit" id="updateButton" class="btn btn-primary">Update</button>
    </td>
  </tr>
</table>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#updateButton').click(function() {

      var $firstname = $('input.firstname').val();
      var $lastname = $('input.lastname').val();
      var $middlename = $('input.middlename').val();
      var $date_published = $('input.date_published').val();
      var $paddress = $('input.primary_address').val();
      var $saddress = $('input.seconday_address').val();
      var $contactno = $('input.contactno').val();
      var $id = $('input.id').val();




      var Odata = {};
      Odata.Ofname = $firstname;
      Odata.Olname = $lastname;
      Odata.Omname = $middlename;
      Odata.Odob = $date_published;
      Odata.Oid = $id;
      Odata.Ocontactno = $contactno;
      Odata.Opaddress = $paddress;
      Odata.Osaddress = $saddress

      console.log(Odata);

      // Your AJAX call
      $.ajax({
        url: "<?php echo base_url('pages/update'); ?>",
        method: "POST",
        dataType: "json",
        data: Odata,
        success: function(response) {
          if (response.success) {
            // Handle success
            console.log('Data updated successfully!');
            window.location.href = "<?php echo base_url('view'); ?>";
          } else {
            // Handle failure
            console.log('Failed to update data.');
          }
        },
        error: function(xhr, status, error) {
          // Handle error
          console.error(error);
        }
      });

    });
  });



  $(document).ready(function() {

   // var $imgFileName = $photo;

   // print_r($imgFileName);
     
    function displayImage(imgFileName) {
      var img_url = './assets/images/' + '<?=$photo;?>'
      //$('#uploaded_image').html('<img src="' + img_url + '" id="output_image" width="200" height="200" />');
       $('#uploaded_image').html('<img src="' + img_url + '" id="<?=$photo;?>" width="200" height="200" />');

      // Extracting the filename from the img_url
      var filename = img_url.substring(img_url.lastIndexOf('/') + 1);

      // console.log(filename);
    }
    // Function to handle errors in displaying image
    function handleImageError() {
      // You can display a default image or show an error message here
      $('#uploaded_image').html('<p>Image not found</p>');
    }

    // Check if there's a stored image in the local storage
   // var storedImage = localStorage.getItem('uploaded_image');

  //  if (storedImage) {
      // Retrieve the stored image file name and pass it to the displayImage function
  //    displayImage(storedImage);
  //  } else {
 //     handleImageError(); // Handle scenario when no image is found in local storage
  //  }

    $('#image').change(function() {
      var file_data = $('#image').prop('files')[0];
      var form_data = new FormData();
      form_data.append('image', file_data);

      $.ajax({
        url: "<?php echo base_url('pages/upload_image'); ?>",
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data) {
         // console.log(data.filename);
        //  console.log(data);

          if (data && data.filename) {
            var uploadedFileName = data.filename;

            // Store the uploaded image file name in local storage
            localStorage.setItem('uploaded_image', uploadedFileName);

            // Display the uploaded image
            displayImage(uploadedFileName);

            // Save the filename to the database
            saveImageToDatabase(1, uploadedFileName);
          } else {
            handleImageError();
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          handleImageError();
        }
      });
    });


    function saveImageToDatabase(id, uploadedFileName) {
      // Send an AJAX request to save the filename to the database
      var $id = $('input.id').val();
      var Odata = {};
      Odata.Uid = $id;
      Odata.imgflname = uploadedFileName;
      //console.log(Odata);
      $.ajax({
        url: "<?php echo base_url('pages/save_image') ?>", // Assuming you have a route for this
        type: 'post',
        data: Odata,
        success: function(response) {
          console.log('Image saved to database:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error saving image to database:', errorThrown);
        }
      });
    }
  });
</script>