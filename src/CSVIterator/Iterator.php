<?php

namespace CsvIterator\CSVIterator;

class CsvFileIterator implements \Iterator{
    protected $in;
    protected $fp;
    protected $index;
    protected $current;
    public function __construct($in, $options = array()) {
      $this->in = $in;
      $this->options = array_merge(array(
          'column_separator' => ','
      ), $options);
  
      $this->rewind();
    }
    protected function read(){
      $this->index++;
      $this->current = fgetcsv($this->fp, 1000, $this->options['column_separator']);
    }
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current (){
      if ($this->index === -1){
        $this->next();
      }
      return $this->current;
    }
  
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next (){
      $this->read();
    }
  
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return scalar scalar on success, or <b>NULL</b> on failure.
     */
    public function key (){
      return $this->index;
    }
  
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function valid (){
      return $this->current() !== false;
    }
  
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind (){
      if ($this->fp){
        fclose($this->fp);
      }
              
      if (is_resource($this->in)){
        fseek($this->in, 0);
        $this->fp = $this->in;
      }
      if (is_string($this->in)){
        // as filename
        $this->fp = fopen($in, 'r');
      }
      
      $this->index = -1;
    }
  }
