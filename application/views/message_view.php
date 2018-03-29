<html>
<head>
	<title></title>
</head>
<body>
<h1></h1>
<?php 
if (isset($query)){
	if ($query->num_rows() > 0) {
		
		echo $this->table->set_heading('ID', '姓名', '网址','标题', '内容','发表日期','留言处理');
		
		//遍历输出
		foreach ($query->result() as $row){
			
			//anchor http://codeigniter.org.cn/user_guide/helpers/url_helper.html
			$edit = anchor('message/edit/' . $row->id, '编辑') . ' ';
			$delete = anchor('message/delete/' . $row->id, '删除');
			
			//每次遍历输出一行
			$this->table->add_row($row->id, $row->name, $row->url, $row->title, $row->content, $row->date, $edit . $delete);
		}
		
		echo $this->table->generate();//输出一个表格
	   
		//输出分页
		echo $pagination;
	}
}

//echo validation_errors(); 
echo form_open('message/post');
echo '姓名：' . form_input('name', set_value('name')) . form_error('name');
echo '<br>网站：' . form_input('url', set_value('url')) . form_error('url');
echo '<br>标题：' . form_input('title', set_value('title')) . form_error('title');
echo '<br>内容：' . form_textarea('content', set_value('content')) . form_error('content');
echo form_submit('submit', '提交');

echo form_close();


?>
</body>
</html>