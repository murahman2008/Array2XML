# Array2XML
A simple php class to convert a php array to XML

This class can accept an associative array or a normal array and will try to convert it into a XML.

 --- A sample array ---

$input = array('students' => array(array('~name~' => 'student', '~value~' => array('id' => 1, 'name' => 'ab', 'email' => 'a@b.com')), 
									   array('~name~' => 'student', '~value~' => array('id' => 2, 'name' => 'cd', 'email' => 'c@d.com')),
									   'fasdfsdfsdf'	
								),
				   'total_students' => 2
			);
			
 --- XML ---
 <?xml version="1.0"?>
<student_info>
	<students>
		<student>
			<id>1</id>
			<name>ab</name>
			<email>a@b.com</email>
		</student>
		<student>
			<id>2</id>
			<name>cd</name>
			<email>c@d.com</email>
		</student>
		<2>fasdfsdfsdf</2>
	</students>
	<total_students>2</total_students>
</student_info>
			
