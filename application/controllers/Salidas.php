<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salidas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		 $this->load->library(array('session'));
		$this->load->helper('url');
		$this->load->model('Modelo_main');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('tema.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function salidas()
	{
	  if($this->session->userdata('id')){
		try{

			/* Creamos el objeto */
			$crud = new grocery_CRUD();

			/* Seleccionamos el tema */
			$crud->set_theme('flexigrid');

			/* Seleccionmos el nombre de la tabla de nuestra base de datos*/
			$crud->set_table('salida');

			/* Le asignamos un nombre */
			$crud->set_subject('Salidas de productos');

			$crud->set_relation('producto','productos','nombre');
			$crud->set_relation('cliente','clientes','nombre');
			//$crud->display_as('proveedor','Proveedor');
			//$crud->set_subject('productos');
				

			/* Asignamos el idioma español */
			$crud->set_language('spanish');


			

			/* Aqui le decimos a grocery que estos campos son obligatorios */
			$crud->required_fields(
				'producto',
				'cantidad', 
				'cliente', 
				'folio', 
				'comentarios',
				'precio',
				'total'
			);

			/* Aqui le indicamos que campos deseamos mostrar */
			$crud->columns(
				'id',
				'producto',
				'cantidad', 
				'cliente', 
				'folio', 
				'comentarios',
				'precio',
				'total'
			);

			$crud->callback_column('precio',array($this,'valuePeso'));
			$crud->callback_column('total',array($this,'valuePeso'));

			 $crud->callback_before_insert(array($this,'checking_post_cantidad'));
			 $crud->unset_delete();
			  $crud->unset_edit();
			   $crud->unset_export();
			
			//$crud->add_action('Smileys', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', 'demo/action_smiley');
				
			//$crud->callback_edit_field('cantidad',array($this,'edit_field_callback_1'));
			//$crud->callback_add_field('cantidad',array($this,'edit_field_callback_2'));
			/* Generamos la tabla */
			$output = $crud->render();
			
			/* La cargamos en la vista situada en 
			/applications/views/productos/administracion.php */
			

			$this->_example_output($output);
			
		}catch(Exception $e){
			/* Si algo sale mal cachamos el error y lo mostramos */
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	  }else{
	  	redirect('Login');
	  }
	}

	public function edit_field_callback_1($value, $primary_key)
	{
	    return '<input type="text" id="cantidad_id"  value="'.$value.'" name="folio" style="width:462px; height: 40px !important;">';
	}

	public function edit_field_callback_2($value, $primary_key)
	{
	    return '<input type="text" id="cantidad_id" value="'.$value.'" name="folio" style="width:462px; height: 40px !important;">';
	}

	public function checking_post_cantidad($post_array)
   {
    //if(empty($post_array['cantidad']))
    //{
    	$producto = $this->Modelo_main->get_row_table('productos','id',$post_array['producto']);
    	$data['existencia'] = $producto->existencia - $post_array['cantidad'];
    	$this->Modelo_main->update_table_row('productos',$data,'id',$post_array['producto']);
    	//$post_array['id']
       // $post_array['postalCode'] = 'Not U.S.';
    //}
     return $post_array;
   }

   public function valuePeso($value, $row)
	{
	    return '$'.$value;
	}

	public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect('Login');
    }
	
}