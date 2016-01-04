<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		 $this->load->library(array('session'));
		$this->load->helper('url');

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

	function productos()
	{	
	  if($this->session->userdata('id')){
		try{

			/* Creamos el objeto */
			$crud = new grocery_CRUD();

			/* Seleccionamos el tema */
			$crud->set_theme('flexigrid');

			/* Seleccionmos el nombre de la tabla de nuestra base de datos*/
			$crud->set_table('productos');

			/* Le asignamos un nombre */
			$crud->set_subject('Productos');

			$crud->set_relation('proveedor','proveedores','nombre');
			//$crud->display_as('proveedor','Proveedor');
			//$crud->set_subject('productos');

			/* Asignamos el idioma español */
			$crud->set_language('spanish');


			

			/* Aqui le decimos a grocery que estos campos son obligatorios */
			$crud->required_fields(
				'id',
				'nombre', 
				'descripcion', 
				'precio_venta', 
				'existencia'
			);

			/* Aqui le indicamos que campos deseamos mostrar */
			$crud->columns(
				'id',
				'nombre',
				'descripcion', 
				'proveedor',
				'precio_compra', 
				'precio_venta', 
				'existencia'
			);

			$crud->callback_column('precio_compra',array($this,'valuePeso'));
			$crud->callback_column('precio_venta',array($this,'valuePeso'));
			
			//$crud->add_action('Smileys', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', 'demo/action_smiley');
			$crud->unset_export();
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