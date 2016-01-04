<?php
/**

 **/
class Modelo_main extends CI_Model{

    /**

     **/
    public function __construct()
    {
        parent::__construct();
    }
	
	public function save_register($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /*
    * metodo para editar una fila de una tabla.
    * autor: jalomo <jalomo@hotmail.es>
    */
    public function update_table_row($tabla,$data,$id_table,$id){
        $this->db->update($tabla, $data, array($id_table=>$id));
    }


    /*
    * metodo para ver una fila de una tabla.
    * autor: jalomo <jalomo@hotmail.es>
    */
    public function get_row_table($tabla,$id_tabla,$id){
        $this->db->where($id_tabla,$id);
        $data = $this->db->get($tabla);
        if ($data->num_rows() > 0){
            return $data->row();
        } else {
            return 0;
        }   
    }



    public function count_results_users($user, $pass)
    {
        $this->db->where('adminUsername', $user);
        $this->db->where('adminPassword', $pass);
        $total = $this->db->count_all_results('admin');
        return $total;
    }
    
    /*
    *
    */
    public function get_all_data_users_specific($username, $pass)
    {
        $this->db->where('adminUsername', $username);
        $this->db->where('adminPassword', $pass);
        $data = $this->db->get('admin');
        return $data->row();
    }
}