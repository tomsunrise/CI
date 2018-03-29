<html>
<head>
	<title>使用  CI 制作简易留言板 -- IT不倒翁</title>
</head>
<body>
<h1>使用  CI 制作简易留言板 -- IT不倒翁</h1>
<?php 

$row = $query->row();// row() 返回结果集得第一行

//将查询到得结果放入要修改的位置上
echo form_open('message/update/' . $this->uri->segment(3));
echo '姓名：' . form_input('name', $row->name);
echo '<br>网站：' . form_input('url', $row->url);
echo '<br>标题：' . form_input('title', $row->title);
echo '<br>内容：' . form_textarea('content', $row->content);
echo form_submit('submit', '提交');

echo form_close();


?>
</body>
</html>