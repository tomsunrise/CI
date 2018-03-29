<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {

	//查询整个数据表
	function show($limit, $offset, $table = 'message') {
		if (!$limit) {
			return $this->db->get($table);
		} else {	
			$this->db->limit($limit, $offset);
			return $this->db->get($table);
		}
	}
	
	//当  id 为 $id $this->db->get() 不能用 array()，必须用 where
	function show_where($id, $table = 'message') {
		
		$this->db->where('id', $id);
		
		return $this->db->get($table);
	}
	
	//查询表的记录，分页类
	function count_table($table = 'message') {
		return $this->db->count_all($table);
	}	
	
	//向数据表插入数据 $data 数组或者对象
	function insert($table = 'message') {
		$data = array(
			'id' => '',
			'name' => $this->input->post('name'),
			'url' => $this->input->post('url'),
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'date' => date('Y-m-d H:i:s')//这里是因为修改了数据库的 date 字段类型，改为 datetime
			);			
		
		return $this->db->insert($table, $data); 
	}
	
	//更新 id 为 $id 的记录
	function update($id, $table = 'message') {
		$data = array(
			'name' => $this->input->post('name'),
			'url' => $this->input->post('url'),
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content')
			);
		$this->db->where('id', $id);
		return $this->db->update($table, $data);
	}
	
	//删除 id 为 $id 的记录
	function delete($id, $table = 'message') {
		
		$this->db->where('id', $id);
		return $this->db->delete($table);
	}
}