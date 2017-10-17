<?php
class Base
{
    protected $dbResult;
    protected $filename;
	protected $resultType;
	protected $suppress = array();
	protected $local = false;
	protected $fileType;
	
	public function __construct(
	    $dbResult, 
	    $filename = 'download.csv', 
	    $options = array(
			'local' => false, 
			'supress' => null, 
			'headers' => true, 
			'delimiter' => ',', 
			 'encosure' => '"'
		)
	) {
		$this->setResultType($dbResult);
		$this->filename = $filename;
		if (isset($options['suppress'])) {
			$this->buildSuppressedArray($options['suppress']);
		}
		if (isset($options['local'])) {
			$this->local = $options['local'];
		}
	}
	
	protected function setResultType($result)
	{
		$type = get_class($result);
		if ($type == 'mysqli_result') {
			$this->resultType = 'mysqli';
		} elseif ($type == 'PDOStatement') {
			$this->resultType = 'pdo';
		} else {
			throw new \Exception ('Database result must be either mysqli_result or PDOStatement.');
		}
		$this->dbResult = $result;
	}
	
	protected function buildSuppressedArray($option)
	{
	    $colnames = explode(',', $option);
	    foreach ($colnames as $col) {
	        $this->suppress[] = trim($col);
	    }
	}
	
	protected function removeSuppressedColumns($row)
	{
		foreach ($this->suppress as $col) {
			if (array_key_exists($col, $row)) {
				unset($row[$col]);
			}
		}
		return $row;
	}
	
	protected function getRow()
	{
		if ($this->resultType == 'mysqli') {
			return $this->dbResult->fetch_assoc();
		} else {
			return $this->dbResult->fetch(\PDO::FETCH_ASSOC);
		}
	}
	
	protected function outputHeaders()
	{
		header('Content-Type: ' . $this->fileType);
		header('Content-Disposition: attachment; filename=' . $this->filename);
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');
	}
}
