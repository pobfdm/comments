<?php
/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE as published 
 * by the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU LESSER GENERAL PUBLIC LICENSE for more details.
 * 
 * You should have received a copy of the GNU LESSER GENERAL PUBLIC LICENSE
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 */






class sPDO
{
//--Edit to fit your needs
//var $DSN =  'pgsql:host=localhost;dbname=test0' ;  
var $DSN =  ''  ;
var $DBUSER = '';
var $DBPASS = '';
//---------------------------------
 
 
 
//You can access, if you will, to the normal structures of PDO using these members
var $dbh;  //connection handler
var $sql;  //sql string
var $stmt; //statement 
var $row;  //output row
 
var $nrows; //number of rows affected by select;
var $error; // a string for errors
 
 
 
function connect()
{
	try
	{
		$this->dbh = new PDO($this->DSN, $this->DBUSER, $this->DBPASS);
 
        //Verbosity errors level
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
 
	catch (PDOException $myerror)
	{
		print "Problemi nella connessione al database: <br>" . $myerror->getMessage() . "<br/>";
		$this->error=$myerror->getMessage();
	}
}
 
function execute($sql)
{
	$this->sql=$sql;
 
	$this->stmt = $this->dbh->prepare($this->sql);
 
	//Run query
    $state = $this->stmt->execute();
 
    //Update the variable containing the number of records affected by the last select
	if ($this->isSelect($this->sql))
	{
		$this->nrows=0;
		while ($this->row = $this->stmt->fetch(PDO::FETCH_BOUND)) $this->nrows++ ;
    }
    
    return $state;
}
 
function quote($sql)
{
	return $this->dbh->quote($sql);
}
 
 
function isSelect($sql)
{
	$a=explode(" ",$sql);
	$res = FALSE;
	for($i=0; $i<=count($a); $i++)
	{
		if(!empty($a[$i]))
		{
			if (strcasecmp($a[$i], "select")==0 )
			{
				 $res = TRUE;
				 continue;
			} 
		}
	}
	
	//if (strcasecmp($a[0], "select")==0 ) $res = TRUE;
	return $res;
}
 
 
function nrows()
{
	return $this->nrows;
}
 
 
function read($i, $coloumn)
{
	 $c=0;
	 foreach ($this->dbh->query($this->sql) as $this->row) 
	 {
            $c++;
	    if ($c==$i)	return $this->row[$coloumn];
         }
}
 
 
function lastInsertId()
{
	return $this->dbh->lastInsertId();
}
 
function GetDriverName()
{
	 //$res=split(":", $this->DSN, 2);
	 $res=explode(":",$this->DSN,2);
	 return $res[0];
}
 
function addslashes($str)
{
	if ($this->GetDriverName()=="sqlite") $res=SQLite3::escapeString($str);
	if ($this->GetDriverName()=="sqlite2") $res=sqlite_escape_string($str);
	if ($this->GetDriverName()=="sqlite3") $res=SQLite3::escapeString($str);
	if ($this->GetDriverName()=="mysql") $res=addslashes($str);
	if ($this->GetDriverName()=="mysqli") $res=addslashes($str);
    //if ($this->GetDriverName()=="mysql") $res= mysql_real_escape_string($str);
	//if ($this->GetDriverName()=="mysqli") $res= mysql_real_escape_string($str);
    if ($this->GetDriverName()=="pgsql") $res=pg_escape_string($str);
	return $res;
}
 
 
function countRecordFromTable($table)
{
	$count = current($this->dbh->query("select count(*) from $table")->fetch());
	return $count;
}
 
 
 
function disconnect()
{
	$this->dbh=null;
	$this->nrows=0;
	$this->row=null;
	$this->stmt=null;
	$this->error="";
}
 
 
}//class
 
?>
