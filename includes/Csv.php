<?php
class Csv extends Base
{
    protected $filename = 'download.csv';
	protected $columnHeaders = true;
	protected $delimiter = ',';
	protected $enclosure = '"';
	protected $fileType = 'text/csv';
	public function __construct(
	    $dbResult,
	    $filename = 'download.csv',
		$options = array(
		    'local' => false,
		    'suppress' => null,
		    'headers' => true,
			'delimiter' => ',',
			'enclosure' => '"'
	    )
	) {
		parent::__construct($dbResult, $filename, $options);
		$this->filename = $filename;
		if (isset($options['headers'])) {
		    $this->columnHeaders = $options['headers'];
		}
		if (isset($options['delimiter'])) {
			if (strlen($options['delimiter']) != 1) {
				throw new \Exception('The delimiter must be a single character ("\t" counts as a single tab character).');
			}
		    $this->delimiter = $options['delimiter'];
		}
		if (isset($options['enclosure'])) {
			if (strlen($options['enclosure']) != 1) {
				throw new \Exception('The enclosure must be a single character.');
			}
		    $this->enclosure = $options['enclosure'];
		}
		$this->generate();
	}
	protected function generate()
	{
		if (!$this->local) {
	        $this->outputHeaders();
	        $csvoutput = fopen('php://output', 'w');
		} else {
		    $csvoutput = @fopen($this->filename, 'w');
		    if (!$csvoutput) {
		        throw new \Exception('Cannot write to ' . $this->filename);
		    }
		}
		if ($this->columnHeaders) {
	        $row = $this->getRow();
			if ($this->suppress) {
				$row = $this->removeSuppressedColumns($row);
			}
	        $headers = array_keys($row);
	        fputcsv($csvoutput, $headers, $this->delimiter, $this->enclosure);
			fputcsv($csvoutput, $row, $this->delimiter, $this->enclosure);
		}
	    while ($row = $this->getRow()) {
			if ($this->suppress) {
				$row = $this->removeSuppressedColumns($row);
			}
		    fputcsv($csvoutput, $row, $this->delimiter, $this->enclosure);
		}
	    $done = fclose($csvoutput);
	    if ($this->local) {
	        return $done;
	    }
	    exit;
	}
	
}