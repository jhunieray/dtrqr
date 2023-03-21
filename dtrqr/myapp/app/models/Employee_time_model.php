<?php
/* 
 * Generated by CRUDigniter v3.4 
 * www.crudigniter.com
 */
 
class Employee_time_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get employee_time by id
     */
    function get_employee_time($id)
    {
        return $this->db->get_where('employee_time',array('id'=>$id))->row();
    }
    
    /*
     * Get all employee_time count
     */
    function get_all_employee_time_count()
    {
        $this->db->from('employee_time');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all employee_time
     */
    function get_all_employee_time($params = array())
    {
        $this->db->order_by('id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('employee_time')->result();
    }
        
    /*
     * function to add new employee_time
     */
    function add_employee_time($params)
    {
        $this->db->insert('employee_time',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update employee_time
     */
    function update_employee_time($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('employee_time',$params);
    }
    
    /*
     * function to delete employee_time
     */
    function delete_employee_time($id)
    {
        return $this->db->delete('employee_time',array('id'=>$id));
    }

    function employee_time_search($limit,$start,$search)
    {
        $this->db->join('employee','employee.id=employee_time.employee_id')->like('employee.id',$search)
                ->or_like('first_name',$search)
                ->or_like('last_name',$search);
        if($limit > -1) {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get('employee_time');
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function employee_time_search_count($search)
    {
        $query = $this->db->join('employee','employee.id=employee_time.employee_id')->like('employee.id',$search)
                ->or_like('first_name',$search)
                ->or_like('last_name',$search)
                ->get('employee_time');
    
        return $query->num_rows();
    }
}
