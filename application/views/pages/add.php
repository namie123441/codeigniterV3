<h1>
  <?= $title; ?>
</h1>
<div class="container mt-4">

  <?= validation_errors(); ?>


  <?= form_open('add'); ?>
  <div class="form-group">

    <label for="input1">Firstname</label>
    <input type="text" class="form-control" id="" name="fname" placeholder="" value="<?= set_value('fname') ?>"><br>

    <label for="input2">Lastname</label>
    <input type="text" class="form-control" id="" name="lname" placeholder="" value="<?= set_value('lname') ?>"><br>

    <label for="input3">Middlename</label>
    <input type="text" class="form-control" id="" name="mname" placeholder="" value="<?= set_value('mname') ?>"><br>
    <label for="input4">Date of Birth</label>
    <input type="date" id="" class="form-control" name="dob" value="<?= set_value('dob') ?>"><br>

    <label for="input5">Primary Address</label>
    <input type="text" class="form-control" id="" name="primary_addrss" placeholder="" value="<?= set_value('primary_addrss') ?>"><br>

    <label for="input6">Secondary  Address</label>
    <input type="text" class="form-control" id="" name="scnd_addrss" placeholder="" value="<?= set_value('scnd_addrss') ?>"><br>
    
    <label for="input6">Contact No.</label>
    <input type="text" class="form-control" id="" name="contact_no" placeholder="" value="<?= set_value('contact_no') ?>"><br>



    <button type="submit" class="btn btn-success">Add New </button>

  </div>


</div>