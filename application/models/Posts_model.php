<?php

class Posts_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->load->library("");
    }

    public function get_posts()
    {

        $query = $this->db->query("SELECT * FROM blogs");
        //$query = $this->db->get("blogs");
        return $query->result_array();
    }

    public function get_posts_single($param)
    {

        $query = $this->db->query("SELECT * FROM blogs WHERE slug = '$param'");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function insert_post()
    {
        $fname = $this->input->post("fname");
        $lname = $this->input->post("lname");
        $full_name = $fname . ' ' . $lname; // Concatenating first name and last name with a space
        // "slug" => url_title($this->input->post("fname"), '-', $this->input->post("lname"), true)

        $data = array(
            "firstname" => $this->input->post("fname"),
            "lastname" => $this->input->post("lname"),
            "middlename" => $this->input->post("mname"),
            "date_published" => $this->input->post("dob"),
            "primary_address" => $this->input->post("primary_addrss"),
            "seconday_address" => $this->input->post("scnd_addrss"),
            "contact_no" => $this->input->post("contact_no"),
            "slug" => url_title($full_name, '-', true)
        );
        return $this->db->insert("blogs", $data);
    }
    // $contactnumber,$paddress,$saddress
    public function update_post($fname, $lname, $mname, $dob, $id, $contactnumber, $paddress, $saddress)
    {
        $data = array(
            'firstname' => $fname,
            'lastname' => $lname,
            'middlename' => $mname,
            'date_published' => $dob,
            'contact_no' => $contactnumber,
            'primary_address' => $paddress,
            'seconday_address' => $saddress



        );

        $query = $this->db->where('id', $id);
        return $this->db->update('blogs', $data);
    }


    public function delete_post($id)
    {
        // Assuming 'posts' is the table name where you want to delete the post
        $this->db->where('id', $id);
        $this->db->delete('blogs');

        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function save_image($id, $filename)
    {
        $data = array(
            'photo' => $filename
        );

        $this->db->where('id', $id);
        return $this->db->update('blogs', $data);
    }
}
