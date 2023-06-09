<?php
/* 
 * Generated by CRUDigniter v3.4 
 * www.crudigniter.com
 */
 
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function user_search($limit,$start,$search)
    {
        $this->db->like('id',$search)
                ->or_like('user_name',$search);
        if($limit > -1) {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get('user');
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function user_search_count($search)
    {
        $query = $this->db->like('id',$search)
                ->or_like('user_name',$search)
                ->get('user');
    
        return $query->num_rows();
    }
    
    /*
     * Get user by id
     */
    function get_user($id)
    {
        return $this->db->get_where('user',array('id'=>$id))->row();
    }
    
    /*
     * Get all users count
     */
    function get_all_users_count()
    {
        $this->db->from('user');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all users
     */
    function get_all_users($params = array())
    {
        $this->db->order_by('id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('user')->result();
    }
        
    /*
     * function to add new user
     */
    function add_user($params)
    {
        $this->db->insert('user',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update user
     */
    function update_user($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('user',$params);
    }
    
    /*
     * function to delete user
     */
    function delete_user($id)
    {
        return $this->db->delete('user',array('id'=>$id));
    }

    public function login()
    {
        $uname = $this->input->post('user_name');
        $pword = $this->input->post('user_password');

        $query = $this->db->select('id,user_name,user_password,user_type')->get_where('user', array('user_name' => $uname));
        $user = $query->row();

        if(!empty($user)) {
            return password_verify($pword, $user->user_password) ? $user : '';
        }

        return '';
    }
}
