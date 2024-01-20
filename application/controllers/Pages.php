<?php

class Pages extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->helper('url');
        $this->load->library('upload');
    }

    public function view($param = null)
    {

        if ($param == null) {
            $page = 'home';
            if (file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                //



                $data['title'] = 'Information';
                $data['documents'] = $this->Posts_model->get_posts();
                // print_r($data['documents']); 

                $this->load->view('templates/header');
                $this->load->view('pages/' . $page, $data);

                $this->load->view('templates/footer');
            } else {
                // Custom handling for non-existent file
                // You can display a different error message or redirect to another page
                // For example, redirect to the homepage:
                show_404();
            }
        } else {

            $page = 'single';

            if (file_exists(APPPATH . 'views/pages/' . $page . '.php')) {

                if (($param)) {

                    $data['posts'] = $this->Posts_model->get_posts_single($param);

                    $jsonData = json_encode($data);
                    $data = json_decode($jsonData, true);

                    foreach ($data as $ke1y) {
                        foreach ($ke1y as $key) {

                            //print_r($key);
                            $key['id'];
                            $key['firstname'];
                            $key['lastname'];
                            $key['middlename'];
                            $key['date_published'];
                            $key['primary_address'];
                            $key['primary_address'];
                            $key['seconday_address'];
                            $key['contact_no'];
                            $key['photo'];
                        }
                    }

                    if ($data['posts']) {

                        $this->load->view('templates/header');
                        $this->load->view('pages/' . $page, $key);
                        $this->load->view('templates/footer');
                    } else {
                        show_404();
                    }
                } else {
                    show_404();
                }
            } else {
                show_404();
            }
        }
    }
    public function add()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'Firstname', 'required');
        $this->form_validation->set_rules('lname', 'lastname', 'required');
        $this->form_validation->set_rules('mname', 'Middlename', 'required');
        $this->form_validation->set_rules('dob', 'Date of birth', 'required');
        $this->form_validation->set_rules('primary_addrss', 'Primary address', 'required');
        $this->form_validation->set_rules('scnd_addrss', 'Secondary address', 'required');
        $this->form_validation->set_rules('contact_no', 'Contact number', 'required');
        $this->form_validation->set_rules('dob', 'Date of birth', 'required');

        if ($this->form_validation->run() == FALSE) {
            $page = 'add';

            if (file_exists(APPPATH . 'views/pages/' . $page . '.php')) {

                $data['title'] = 'Add New';

                $this->load->view('templates/header');
                $this->load->view('pages/' . $page, $data);
                $this->load->view('templates/footer');
            } else {
                show_404();
            }
        } else {
            $this->Posts_model->insert_post();
            $this->session->set_flashdata('Post Added', 'Already Add');
            redirect(base_url());
        }
    }

    public function update()
    {
        $input = $this->input->post();
        $fname = $input['Ofname'];
        $lname = $input['Olname'];
        $mname = $input['Omname'];
        $dob = $input['Odob'];
        $id = $input['Oid'];
        $contactnumber = $input['Ocontactno'];
        $paddress = $input['Opaddress'];
        $saddress = $input['Osaddress'];

        // Add your model function here
        $result = $this->Posts_model->update_post($fname, $lname, $mname, $dob, $id, $contactnumber, $paddress, $saddress);

        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Data updated successfully!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to update data.';
        }

        echo json_encode($response);
    }
    public function delete()
    {

        //echo 'pasok sa delete function';
        $id = $this->input->post('Oid');
        if ($this->Posts_model->delete_post($id)) {
            echo 'success';
        } else {
            echo 'error';
        }
    }


    // public function upload_image()
    // {
    //     $config['upload_path'] = './assets/images/'; // change this line
    //     $config['allowed_types'] = 'gif|jpg|png';
    //     $config['max_size'] = 2000;
    //     $config['max_width'] = 1500;
    //     $config['max_height'] = 1500;

    //     $this->upload->initialize($config);

    //     if (!$this->upload->do_upload('image')) {
    //         $error = array('error' => $this->upload->display_errors());
    //         echo json_encode($error);
    //     } else {
    //         $data = array('upload_data' => $this->upload->data());
    //         echo json_encode($data);
    //     }
    // }

    public function upload_image()
    {
        $config['upload_path'] = './assets/images/'; // change this line
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
            $response = array('filename' => $filename);
            echo json_encode($response);
        }
    }

    public function save_image()
    {
        // Get the data from the AJAX request

        // $data = $this->input->post();
        // print_r($data);

        $input = $this->input->post();
        $id = $input['Uid'];
        $imgname = $input['imgflname'];
        // Validate the data
        if (empty($id) || empty($imgname)) {
            // Return an error response if the data is invalid
            $response = array('success' => false, 'message' => 'Invalid data');
            echo json_encode($response);
            return;
        }

        // Save the filename to the database
        // (Assuming you have a model that handles database operations)
        //$this->load->model('Posts_model');
        $result = $this->Posts_model->save_image($id, $imgname);

        // Return a success or error response based on the result
        if ($result) {
            $response = array('success' => true, 'message' => 'Image saved to database');
        } else {
            $response = array('success' => false, 'message' => 'Error saving image to database');
        }

        echo json_encode($response);
    }
}
