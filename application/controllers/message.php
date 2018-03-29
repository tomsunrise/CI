<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 html refresh
<meta http-equiv="refresh" content="2;url=http://itbdw.tk/">
 * */
class Message extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//设置全局编码
		header('Content-Type: text/html; charset=utf-8');
		
		//这些内容也可以在 autoload 文件中加载，
		$this->load->helper(array('form', 'url'));
		$this->load->model('Message_model');
		$this->load->database();
		$this->load->library(array('table', 'pagination', 'form_validation'));
		date_default_timezone_set('PRC');//设置默认时区
		
		echo anchor('', '首页') . '<br>';
	}
	
	function index($offset = '') {
		
		//设置分页的行数，当为假时，即设为 '' 或者 0 ，或者 NULL 则不分页
		$limit = NULL;
		
		$config['base_url'] = site_url('message/index');
		$config['total_rows'] = $this->Message_model->count_table();//count_table() 有默参数
		$config['per_page'] = $limit;
		
		//这几行为可选设置
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['num_links'] = 2;//放在你当前页码的前面和后面的“数字”链接的数量。
		
		$this->pagination->initialize($config); 
		
		//放到数组中，传给视图
		$data['pagination'] = $this->pagination->create_links();
		$data['query'] = $this->Message_model->show($limit, $offset);//对模型的调用，应该写在控制器中，控制器起到中间人的作用，

		$this->load->view('message_view', $data);
	}
	
	//发布留言
	function post(){
/*
 * 表单验证
 */
		/*
		 * 表单的验证
		 * http://codeigniter.org.cn/user_guide/libraries/form_validation.html
		 * 任何PHP自身接收一个参数的函数都可以被用作一个规则，比如 htmlspecialchars, trim, MD5
		 * Cascading Rules
		 */
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('url', 'Password', 'required|min_length[4]');
		$this->form_validation->set_rules('title', 'Title', 'required|min_length[4]');
		$this->form_validation->set_rules('content', 'Content', 'required|min_length[4]');
		
		if (!$this->form_validation->run()) {
			$this->load->view('message_view');
		} else {

			header('refresh:5; url=' . site_url());
			
			if ($this->Message_model->insert()) {
				echo '留言发表成功！5秒之后自动返回。';
			} else {
				echo '发表失败，请重新填写！';
			}
			
			echo anchor('', '立即返回');
		}
	}
	
	//载入编辑视图
	function edit($id) {
		$data['query'] = $this->Message_model->show_where($id);//应该写在控制器中
		$this->load->view('edit_view', $data);
	}
	
	//更新留言
	function update($id) {
			

		
		if ($this->Message_model->update($id)) {
			header('refresh:5; url=' . site_url());
			echo '更新成功！5秒之后自动返回。';
			echo anchor('', '立即返回');
		} else {
			header('refresh:5; url=' . site_url('message/edit' . $id));
			echo '更新失败，请重试！';
			echo anchor('message/edit' . $id, '立刻编辑');
		}
	}
	
	//删除特定的记录
	function delete($id) {
		header('refresh:5; url=' . site_url());
				
		if ($this->Message_model->delete($id)){
			echo '删除成功！5秒之后自动返回。';
		} else {
			echo '删除失败';
		}
		
		echo anchor('', '立即返回');
	}

}
