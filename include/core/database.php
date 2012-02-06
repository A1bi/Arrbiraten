<?php
/**
 * PVshowcase
 *
 * database class
 */
class database {

	private $db;
	private $queries = 0;

	/**
	 * initiates database from file
	 * in case there is no db created it will take the default file and copy it
	 */
	function __construct() {

		// authentication
		global $_config;

		// initiate and connect to db
		try {
			$this->db = new PDO("mysql:dbname=" . $_config['db']['name'] . ";host=" . $_config['db']['host'], $_config['db']['user'], $_config['db']['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		// some error occurred
		} catch (PDOException $exc) {
			echo "Fehler beim Verbinden mit Datenbank: " . $exc->getMessage();
		}

    }

	/**
	 *
	 * @param string $query
	 * @param array $inserts
	 * @return PDOStatement
	 */
	function query($query, $inserts = array()) {

		// prepare query so we can replace possible ? while executing
		$sql = $this->db->prepare($query);

		if ($sql == null) {
			// error
			echo "Datenbank-Fehler: &quot;" . $query . "&quot;";
			return false;
		}

		// replace ? with inserts and execute
		$sql->execute($inserts);
		// increase query counter
		$this->queries++;
		// return statement
		return $sql;
	}

	/**
	 * returns current result in an array
	 *
	 * @param PDOStatement $result
	 * @return array gibt array mit ergebnissen zurück
	 */
	function fetchAssoc($result) {
		return $result->fetch();
	}

	/**
	 * returns all rows in an array indexed by $index or the first column as default
	 *
	 * @param sql $sql
	 * @param string $index
	 * @return array
	 */
	function fetchAll($sql, $index = 0) {
		$rows = array();
		while ($row = $sql->fetch()) {
			$rows[$row[$index]] = $row;
		}
		return $rows;
	}

	/**
	 * returns last saved id
	 *
	 * @return int
	 */
	function id() {
		return $this->db->lastInsertId();
	}

	/**
	 * returns the number of changed rows by the last query
	 *
	 * @return int
	 */
	function changes($sql) {
		return $sql->rowCount();
	}

	/**
	 * returns number of rows given by a SELECT query
	 * is needed because rowCount() does not work with SELECT queries
	 *
	 * @param sql $sql
	 * @return int
	 */
	function rows($sql) {
		// filter out table and where term
		if (preg_match("#^SELECT ([a-zA-Z0-9\*_-]*) FROM ([a-zA-Z0-9_-]*) ?(WHERE (.*))?#s", $sql->queryString, $result) > 0) {
			// create new query
			$count = self::query('SELECT COUNT(*) as count FROM ' . $result[2] . ((!empty($result[3])) ? ' WHERE ' . $result[4] : ''))->fetch();
			return $count['count'];
		}
	}

}
?>