<?php
function to_csv($data = [], $filename = 'export')
{
	$delimiter = ",";
	$filename = $filename . "_" . date('Y-m-d') . ".csv";

	//create a file pointer
	$f = fopen('php://memory', 'w');

	//set column headers
	$fields = array();
	foreach ($data as $row) {
		foreach ($row as $key => $val) {
			if (!in_array($key, $fields)) {
				$fields[] = ucwords($key);
			}
		}
	}
	fputcsv($f, $fields, $delimiter);

	//output each row of the data, format line as csv and write to file pointer
	foreach ($data as $row) {
		fputcsv($f, $row, $delimiter);
	}

	//move back to beginning of file
	fseek($f, 0);

	//set headers to download file rather than displayed
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="' . $filename . '";');

	//output all remaining data on a file pointer
	fpassthru($f);
}
